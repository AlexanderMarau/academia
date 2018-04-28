<?php

//IMPORTA O ARQUIVO DE CONFIGURAÇÃO:
require '../_app/Config.inc.php';

$jSon = array();

$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($getPost['callback'])):
    $jSon['trigger'] = "<div>Erro!</div>";
else:
    $Post = array_map("strip_tags", $getPost);
    $Action = $Post['callback'];
    unset($Post['callback']);

    switch ($Action):
        //CASO CALLBACK SEJÁ create-registro EXECUTA-SE A FUNÇÃO DE CADASTRO
        case 'create-registro':

            $dataHora = array();
            $dataHora['data_registro'] = $Post['data_registro'];
            $dataHora['hr_entrada_catraca'] = $Post['hr_entrada_catraca'];
            $dataHora['hr_saida_catraca'] = $Post['hr_saida_catraca'];
            unset($Post['data_registro']);
            unset($Post['hr_entrada_catraca']);
            unset($Post['hr_saida_catraca']);

            date_default_timezone_set('America/Sao_Paulo');
            $Post['data_registro'] = date("Y-m-d");
            $Post['hr_entrada_catraca'] = date("H:i:s");
            $Post['hr_saida_catraca'] = "00:00:00";

            $Tabela = "registros_catraca";

            require '../_app/Conn/Create.class.php';

            $idaluno_clientes = $Post['idaluno_clientes'];
            //CONSULTA O STATUS DA MENSALIDADE DO ALUNO ESCOLHIDO:
            $ConsultaStatus = new Read;
            $ConsultaStatus->FullRead("SELECT mensalidades.idalunos_cliente, mensalidades.status_mens "
                    . "FROM mensalidades WHERE idalunos_cliente = {$idaluno_clientes}");
            //OBTENDO O ID DO REGISTRO ENCONTRADO:
            $ResultStatus = $ConsultaStatus->getResult();
            $status_mens = $ResultStatus[0]['status_mens'];

            //CONSULTANDO SE EXISTE UM REGISTRO DO ALUNO COM O HORÁRIO DE SAIDA VAZIO.
            $consultaRegistro = new Read;
            $consultaRegistro->FullRead("SELECT * FROM registros_catraca WHERE idaluno_clientes = {$idaluno_clientes} AND hr_saida_catraca = '00:00:00';");
            //OBTENDO O ID DO REGISTRO ENCONTRADO: 
            $resultConsulta = $consultaRegistro->getResult();
            $idregistros_catraca = $resultConsulta[0]['idregistros_catraca'];
            $hr_saida_catraca = $resultConsulta[0]['hr_saida_catraca'];
            
            //CASO O STATUS DA MENSALIDADE ESTEJA EM ABERTO A CATRACA LIBERA O ACESSO E CADASTRA UM NOVO REGISTRO:
            if ($status_mens == 'Em aberto' && $hr_saida_catraca != '00:00:00'):

                $CadastrarRegistro = new Create;
                $CadastrarRegistro->ExeCreate($Tabela, $Post);

                if ($CadastrarRegistro->getResult()):
                    $idNovoRegistro = $CadastrarRegistro->getResult();

                    $registroCadastrado = new Read;
                    $registroCadastrado->FullRead("SELECT alunos_cliente.nome_aluno, registros_catraca.idregistros_catraca, registros_catraca.hr_entrada_catraca, registros_catraca.hr_saida_catraca, registros_catraca.data_registro " .
                            "FROM registros_catraca " .
                            "INNER JOIN alunos_cliente ON registros_catraca.idaluno_clientes = alunos_cliente.idalunos_cliente " .
                            "WHERE registros_catraca.idregistros_catraca = :idregistros_catraca", "idregistros_catraca={$idNovoRegistro}");

                    if ($registroCadastrado->getResult()):
                        $novoRegistro = $registroCadastrado->getResult();
                        $jSon['novoregistro'] = $novoRegistro[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;
                    endif;

                endif;
            //CASO O STATUS DA MENSALIDADE ESTEJÁ EM ABERTO PORÉM O ALUNO JÁ TENHA ENTRADO:    
            elseif ($status_mens == 'Em aberto' && $hr_saida_catraca == '00:00:00'):
                echo "ERRO! Aluno já está dentro da academia.";
                
            //CASO O STATUS DA MENSALIDADE ESTEJÁ VENCIDA A CATRACA BLOQUEIA O ACESSO:    
            elseif ($status_mens == 'Vencido'):
                $jSon['erro'] = true;

                $jSon['clear'] = true;

            //CASO O STATUS DA MENSALIDADE ESTEJA PENDENTE A CATRACA LIBERA O ACESSO E CADASTRA UM NOVO REGISTRO, PORÉM ALERTA AO ALUNO:
            elseif ($status_mens == 'Pendente'):
                $CadastrarRegistro = new Create;
                $CadastrarRegistro->ExeCreate($Tabela, $Post);

                if ($CadastrarRegistro->getResult()):
                    $idNovoRegistro = $CadastrarRegistro->getResult();

                    $registroCadastrado = new Read;
                    $registroCadastrado->FullRead("SELECT alunos_cliente.nome_aluno, registros_catraca.idregistros_catraca, registros_catraca.hr_entrada_catraca, registros_catraca.hr_saida_catraca, registros_catraca.data_registro " .
                            "FROM registros_catraca " .
                            "INNER JOIN alunos_cliente ON registros_catraca.idaluno_clientes = alunos_cliente.idalunos_cliente " .
                            "WHERE registros_catraca.idregistros_catraca = :idregistros_catraca", "idregistros_catraca={$idNovoRegistro}");

                    if ($registroCadastrado->getResult()):
                        $novoRegistro = $registroCadastrado->getResult();
                        $jSon['novoregistro'] = $novoRegistro[0];

                        $jSon['alerta'] = true;

                        $jSon['clear'] = true;
                    endif;
                endif;
            elseif ($status_mens == null):
                echo "ERRO!";
            endif;

            break;

        //CASO O CALLBACK SEJÁ sair-catraca EXECUTA-SE A FUNÇÃO PARA ATUALIZAR DADOS
        case 'sair-catraca':

            $updateRegistro = array();
            $updateRegistro['idaluno_clientes'] = $Post['idaluno_clientes'];
            $updateRegistro['hr_saida_catraca'] = $Post['hr_saida_catraca'];
            unset($Post['hr_saida_catraca']);

            //ATRIBUINDO A HORA ATUAL A VARIAVEL.
            date_default_timezone_set('America/Sao_Paulo');
            $Post['hr_saida_catraca'] = date("H:i:s");

            //CONSULTANDO SE EXISTE UM REGISTRO DO ALUNO COM O HORÁRIO DE SAIDA VAZIO.
            $idaluno_clientes = $Post['idaluno_clientes'];
            $consultaRegistro = new Read;
            $consultaRegistro->FullRead("SELECT * FROM registros_catraca WHERE idaluno_clientes = {$idaluno_clientes} AND hr_saida_catraca = '00:00:00';");

            if ($consultaRegistro->getResult()):
                //OBTENDO O ID DO REGISTRO ENCONTRADO. 
                $resultConsulta = $consultaRegistro->getResult();
                $idregistros_catraca = $resultConsulta[0]['idregistros_catraca'];
                $Tabela = "registros_catraca";
                $sairCatraca = new Update;
                $sairCatraca->ExeUpdate($Tabela, $Post, "WHERE idregistros_catraca = :idregistros_catraca", "idregistros_catraca={$idregistros_catraca}");
            else:
                echo "ERRO aluno não está dentro da academia.";
            endif;



            break;
    endswitch;
endif;
echo json_encode($jSon);
