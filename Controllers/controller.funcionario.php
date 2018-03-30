<?php

//IMPORTA O ARQUIVO DE CONFIGURAÇÃO:
require '../_app/Config.inc.php';

//A VARIÁVEL $JSON É CRIADA COMO ARRAY PARA QUE NO FINAL DO CODIGO ELA SERÁ A VARIAVEL DE RESPOSTA DA CONTROLER:
$jSon = array();

//$getPost É A VARIÁVEL QUE RECEBE OS DADOS ENVIADOS DO ARQUIVO JS:
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (count($getPost) == 1):
    $getQuery = array_keys($getPost);

    $queryPesquisa = (is_int($getQuery[0]) ? $getQuery[0] : strip_tags(str_replace('_', ' ', $getQuery[0])));

    $buscarFun = new Read;

    if ($queryPesquisa >= 1):
        $buscarFun->FullRead("SELECT idfuncionarios, nome_func, cargo_func, status_func FROM funcionarios WHERE idfuncionarios = {$queryPesquisa}");
        $jSon = $buscarFun->getResult();
    elseif ($queryPesquisa === 0):
        $buscarFun->FullRead("SELECT idfuncionarios, nome_func, cargo_func, status_func FROM funcionarios");
        $jSon = $buscarFun->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarFun->FullRead("SELECT idfuncionarios, nome_func, cargo_func, status_func FROM funcionarios WHERE nome_func LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarFun->getResult();
    endif;

else:
//PRIMEIRA CONDIÇÃO - NESSA CONDIÇÃO VERIFICA SE O INDICE CALLBACK FOI PREENCHIDO:
    if (empty($getPost['callback'])):
//    CASO NÃO HAJA O INDICE CALLBACK UM GATILHO DE ERRO (TRIGGER) É CRIADO NO ARRAY $jSon:
        $jSon['trigger'] = "<div class='alert alert-warning'>Ação não selecionada!</div>";
    else:
//    CASO O CALLBACK ESTEJA CORRETO A FUNÇÃO ARRAY_MAP INICIA A 'LIMPEZA' DOS VALORES DE CADA INDICE RETIRANDO TAGS DE SQL INJECTION E OUTRAS AMEAÇAS:
        $Post = array_map("strip_tags", $getPost);

//A VARIAVEL $Action É CRIADA PARA RECEBER O ACTION DO ARRAY QUE VEIO DO JS:
        $Action = $Post['callback'];
        
        unset($Post['callback']);

//    SWITCH SERÁ AS CONDIÇÕES VERIFICADAS E USADAS PARA TOMAR AÇÕES DE ACORDO COM CADA CALLBACK:
        switch ($Action):
//            CONDIÇÃO 'validar-cpf' ATENDIDA, RESPONSÁVEL POR UTILIZAR UM MÉTODO DA CLASSE 'Check' [ESTÁTICA] E VALIDAR OU NÃO UM CPF.            
            case 'validar-cpf':
                if(Check::CPF($Post['cpf'])):
                    $jSon['sucesso'] = true;
                else:
                    $jSon['trigger'] = true;
                endif;
                break;
//        CONDIÇÃO  'funcionario' ATENDIDA:
            case 'create-funcionario':

                $EnderecoFun = array();
                $EnderecoFun['idcidade'] = $Post['idcidade'];
                $EnderecoFun['idestado'] = $Post['idestado'];
                $EnderecoFun['complementos_fun'] = $Post['complementos_fun'];
                unset($Post['idcidade']);
                unset($Post['idestado']);
                unset($Post['complementos_fun']);

//            CRIAÇÃO DE UMA VARIÁVEL RESPONSÁVEL POR RECEBER  O NOME DA TABELA QUE SERÁ INSERIDA OS DADOS NO BANCO:
                $Tabela = "funcionarios";

//            INSERIR A CLASSE DA MODEL RESPONSÁVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.funcionario.php';

//            INSTÂNCIA DO OBJETO DA CLASSE FUNCIONARIO RESPONSÁVEL POR CADASTRAR NOVOS FUNCIONARIOS NO BANCO DE DADOS:
                $CadEndFun = new Funcionario;
                $CadEndFun->novoEnderecoFun("endereco_fun", $EnderecoFun);
                $IdEnderecoFunc = $CadEndFun->getResult();

                $Post['idendereco_func'] = $IdEnderecoFunc;

                $CadastrarFun = new Funcionario;

//            MÉTODO DA CLASSE FUNCIONARIO RESPONSÁVEL POR CADASTRAR NOVOS FUNCIONARIOS NO BANCO DE DADOS:
                $CadastrarFun->novoFuncionario($Tabela, $Post);

//            CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UM NOVO FUNCIONARIO, UTILIZANDO UM MÉTODO DA CLASSE FUNCIONARIO:
                if ($CadastrarFun->getResult()):
                    $idNovoFunc = $CadEndFun->getResult();
                    $funCadastrado = new Read;
                    $funCadastrado->FullRead("SELECT idfuncionarios, nome_func, cargo_func, status_func FROM funcionarios WHERE idfuncionarios = :idfuncionarios", " idfuncionarios={$idNovoFunc}");

                    if ($funCadastrado->getResult()):
                        $novoFun = $funCadastrado->getResult();
                        $jSon['novofunc'] = $novoFun[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;
                    endif;
                endif;

                break;
                
                case 'povoar-edit':
                $DadosFunc = new Read;
                $DadosFunc->FullRead("SELECT funcionarios.*, endereco_fun.idcidade, endereco_fun.idestado, endereco_fun.complementos_fun  "
                        . "FROM funcionarios "
                        . "INNER JOIN endereco_fun "
                        . "ON funcionarios.idendereco_func = endereco_fun.idendereco_fun "
                        . "WHERE funcionarios.idfuncionarios = :idfuncionarios", "idfuncionarios={$Post['idfuncionarios']}");
                if ($DadosFunc->getResult()):
                    foreach ($DadosFunc->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

//        CASO O CALLBACK NÃO SEJA ATENDIDO O DEFAULT SETA O GATILHO DE ERRO (TRIGGER) RESPONSÁVEL POR RETORNAR O ERRO AO JS:
            default:
                $jSon['trigger'] = "<div class='alert alert-warning'>Ação não selecionada!</div>";
                break;
        endswitch;

    endif;
endif;
//USANDO O ECHO OS GATILHOS VOLTA VIA AJAX UTILIZANDO JSON PARA O ARQUIVO JS E LÁ SERÁ INTERPRETADO:
echo json_encode($jSon);

