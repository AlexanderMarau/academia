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

    $buscarForn = new Read;

    if ($queryPesquisa >= 1):
        $buscarForn->FullRead("SELECT idfornecedores, nome_forn, nome_fantasia_forn, telefone_forn FROM fornecedores WHERE idfornecedores = {$queryPesquisa}");
        $jSon = $buscarForn->getResult();
    elseif ($queryPesquisa === 0):
        $buscarForn->FullRead("SELECT idfornecedores, nome_forn, nome_fantasia_forn, telefone_forn FROM fornecedores");
        $jSon = $buscarForn->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarForn->FullRead("SELECT idfornecedores, nome_forn, nome_fantasia_forn, telefone_forn FROM fornecedores WHERE nome_forn LIKE '%{$queryPesquisa}%';");
        $jSon = $buscarForn->getResult();
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

//    O INDICE 'CALLBACK' E O SEU RESPECTIVO VALOR SÃO DESMEMBRADOS DA VARIAVEL POST, ISSO É NECESSÁRIO PARA ENVIAR PARA O BANCO APENAS OS DADOS NECESSÁRIOS:
        unset($Post['callback']);

//    SWITCH SERÁ AS CONDIÇÕES VERIFICADAS E USADAS PARA TOMAR AÇÕES DE ACORDO COM CADA CALLBACK:
        switch ($Action):

//            CONDIÇÃO 'validar-cpf' ATENDIDA, RESPONSÁVEL POR UTILIZAR UM MÉTODO DA CLASSE 'Check' [ESTÁTICA] E VALIDAR OU NÃO UM CPF.            
            case 'validar-cnpj':
                if(Check::CNPJ($Post['cnpj'])):
                    $jSon['sucesso'] = true;
                else:
                    $jSon['trigger'] = true;
                endif;
                break;
            
//        CONDIÇÃO  'fornecedor' ATENDIDA:
            case 'create-fornecedor':

                $EnderecoForn = array();
                $EnderecoForn['idcidade'] = $Post['idcidade'];
                $EnderecoForn['idestado'] = $Post['idestado'];
                $EnderecoForn['complementos_forn'] = $Post['complementos_forn'];
                unset($Post['idcidade']);
                unset($Post['idestado']);
                unset($Post['complementos_forn']);

//            CRIAÇÃO DE UMA VARIÁVEL RESPONSÁVEL POR RECEBER  O NOME DA TABELA QUE SERÁ INSERIDA OS DADOS NO BANCO:
                $Tabela = "fornecedores";

//            INSERIR A CLASSE DA MODEL RESPONSÁVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.fornecedor.php';

                $CadEndForn = new Fornecedor;
                $CadEndForn->novoEnderecoForn("endereco_fornecedor", $EnderecoForn);
                $idEnderecoForn = $CadEndForn->getResult();

                $Post['idendereco_forn'] = $idEnderecoForn;

//            INSTÂNCIA DO OBJETO DA CLASSE FORNECEDOR RESPONSÁVEL POR CADASTRAR NOVOS FORNECEDORES NO BANCO DE DADOS:
                $CadastrarFornecedor = new Fornecedor;

//            MÉTODO DA CLASSE FORNECEDOR RESPONSÁVEL POR CADASTRAR NOVOS FORNECEDORES NO BANCO DE DADOS:
                $CadastrarFornecedor->novoFornecedor($Tabela, $Post);

//            CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UM NOVO FORNECEDOR, UTILIZANDO UM MÉTODO DA CLASSE FORNECEDOR:
                if ($CadastrarFornecedor->getResult()):
                    $idNovoForn = $CadastrarFornecedor->getResult();
                    $fornCadastrado = new Read;
                    $fornCadastrado->FullRead("SELECT idfornecedores, nome_forn, nome_fantasia_forn, telefone_forn "
                            . "FROM fornecedores "
                            . "WHERE idfornecedores = :idfornecedores", " idfornecedores={$idNovoForn}");

                    if ($fornCadastrado->getResult()):
                        $novoForn = $fornCadastrado->getResult();
                        $jSon['novoforn'] = $novoForn[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;
                    endif;
                endif;

                break;

            case 'povoar-edit':
                $DadosForn = new Read;
                $DadosForn->FullRead("SELECT fornecedores.*, endereco_fornecedor.idcidade, endereco_fornecedor.idestado, endereco_fornecedor.complementos_forn  "
                        . "FROM fornecedores "
                        . "INNER JOIN endereco_fornecedor "
                        . "ON fornecedores.idendereco_forn = endereco_fornecedor.idendereco_forn "
                        . "WHERE fornecedores.idfornecedores = :idfornecedores", "idfornecedores={$Post['idfornecedores']}");
                if ($DadosForn->getResult()):
                    foreach ($DadosForn->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

            case 'update-fornecedor':

                //ATUALIZAR O ENDEREÇO DO FORNECEDOR SELECIONADO:
                $novoEndereco = array();
                $novoEndereco['idendereco_forn'] = $Post['idendereco_forn'];
                $novoEndereco['idestado'] = $Post['idestado'];
                $novoEndereco['idcidade'] = $Post['idcidade'];
                $novoEndereco['complementos_forn'] = $Post['complementos_forn'];

                unset($Post['idendereco_forn']);
                unset($Post['idestado']);
                unset($Post['idcidade']);
                unset($Post['complementos_forn']);

                require '../Models/model.fornecedor.update.php';
                //O MÉTODO NA MODEL: 'AtualizarFornecedor' É RESPONSÁVEL POR ATUALIZAR OS DADOS (INCLUINDO SEU ENDEREÇO) DO FORNECEDOR NO BANCO DE DADOS:
                $updateEndereco = new AtualizarFornecedor;
                //ATUALIZA O ENDEREÇO DO FORNECEDOR :
                $updateEndereco->atualizarEnderecoForn('endereco_fornecedor', $novoEndereco, "WHERE idendereco_forn = :idendereco", ":idendereco={$novoEndereco['idendereco_forn']}");
                if ($updateEndereco->getResult()):
                    //ATUALIZA OS DADOS DO FORNECDOR:
                    $updateFornecedor = new AtualizarFornecedor;
                    $updateFornecedor->atualizarFornecedor('fornecedores', $Post, "WHERE idfornecedores = :idforn", "idforn={$Post['idfornecedores']}");
                    if ($updateFornecedor->getResult()):
                        
                        $readForncedor = new Read;
                        $readForncedor->FullRead("SELECT idfornecedores, nome_forn, nome_fantasia_forn, telefone_forn "
                            . "FROM fornecedores "
                            . "WHERE idfornecedores = :idfornecedores", " idfornecedores={$Post['idfornecedores']}");
                        $DadosFornecedor = $readForncedor->getResult();
                    
                        $jSon['sucesso'] = ['true'];
                        $jSon['clear'] = ['true'];
                        $jSon['content']['idfornecedores'] = $Post['idfornecedores'];
                        $jSon['content']['nome_forn'] = $Post['nome_forn'];
                        $jSon['content']['idendereco_forn'] = $novoEndereco['idendereco_forn'];
                        $jSon['content']['nome_fantasia_forn'] = $DadosFornecedor[0]['nome_fantasia_forn'];
                        $jSon['content']['telefone_forn'] = $DadosFornecedor[0]['telefone_forn'];
                    endif;
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

