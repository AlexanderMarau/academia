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

            $Tabela = "registros_catraca";

            require '../_app/Conn/Create.class.php';

            $idaluno_clientes = $Post['idaluno_clientes'];

            $ConsultaStatus = new Read;

            $ConsultaStatus->FullRead("SELECT mensalidades.idalunos_cliente, mensalidades.status_mens "
                    . "FROM mensalidades WHERE idalunos_cliente = {$idaluno_clientes}");

            $ResultStatus = $ConsultaStatus->getResult();
            $status_mens = $ResultStatus[0]['status_mens'];

            //CASO O STATUS DA MENSALIDADE ESTEJA EM ABERTO A CATRACA LIBERA O ACESSO E CADASTRA UM NOVO REGISTRO:
            if ($status_mens == 'Em aberto'):
                
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
            $Tabela = "registros_catraca";

            require '../_app/Conn/Update.class.php';
            
            $updateCatraca = new Update;
            $updateCatraca->ExeUpdate($Tabela, $Post, "WHERE idregistros_catraca = :idregistros_catraca", "idregistros_catraca={$Post['idregistros_catraca']}");
            if($updateCatraca->getResult()):
                echo "OK";
            endif;
            
            break;
    endswitch;
endif;
echo json_encode($jSon);
