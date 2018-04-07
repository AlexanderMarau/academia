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

    $buscarExercicio = new Read;

    if ($queryPesquisa >= 1):
        $buscarExercicio->FullRead("SELECT * FROM exercicios "
                . "WHERE exercicios.idexercicios = $queryPesquisa");
        $jSon = $buscarExercicio->getResult();

    elseif ($queryPesquisa === 0):
        $buscarExercicio->FullRead("SELECT * FROM exercicios");
        $jSon = $buscarExercicio->getResult();

    elseif (is_string($queryPesquisa)):
        $buscarExercicio->FullRead("SELECT * FROM exercicios "
                . "WHERE exercicios.descricao_exe LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarExercicio->getResult();

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

//        CONDIÇÃO  'create_exercicio' ATENDIDA:
            case 'create-exercicio':

//            CRIAÇÃO DE UMA VARIÁVEL RESPONSÁVEL POR RECEBER  O NOME DA TABELA QUE SERÁ INSERIDA OS DADOS NO BANCO:
                $Tabela = "exercicios";

//            INSERIR A CLASSE DA MODEL RESPONSÁVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.exercicio.create.php';

//            INSTÂNCIA DO OBJETO DA CLASSE EXERCICIO RESPONSÁVEL POR CADASTRAR NOVOS EXERCICIOS NO BANCO DE DADOS:
                $CadastrarExercicio = new ExercicioCreate;

//            MÉTODO DA CLASSE EXERCICIO RESPONSÁVEL POR CADASTRAR NOVOS EXERCICIOS NO BANCO DE DADOS:
                $CadastrarExercicio->novoExercicio($Tabela, $Post);

//            CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UM NOVO EXERCICIO, UTILIZANDO UM MÉTODO DA CLASSE CREATE_EXERCICIO:
                if ($CadastrarExercicio->getResult()):
                    $idNovoExercicio = $CadastrarExercicio->getResult();
                    $exercicioCadastrado = new Read;
                    $exercicioCadastrado->FullRead("SELECT * FROM exercicios " .
                            "WHERE exercicios.idexercicios = :idexercicios", " idexercicios={$idNovoExercicio}");

                    if ($exercicioCadastrado->getResult()):
                        $novoExercicio = $exercicioCadastrado->getResult();
                        $jSon['novoexercicio'] = $novoExercicio[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;

                    endif;
                endif;

                break;

            case 'povoar-edit':
                $DadosExercicio = new Read;
                $DadosExercicio->FullRead("SELECT * FROM exercicios WHERE exercicios.idexercicios = :idexercicios", "idexercicios={$Post['idexercicios']}");
                if ($DadosExercicio->getResult()):
                    foreach ($DadosExercicio->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

            case 'update-exercicio':
                require '../Models/model.exercicio.update.php';
                $updateExercicio = new AtualizarExercicio;
                $updateExercicio->atualizarExercicio('exercicios', $Post, "WHERE exercicios.idexercicios = :idexercicios", "idexercicios={$Post['idexercicios']}");
                if ($updateExercicio->getResult()):
                    $ReadExercicio = new Read;
                    $ReadExercicio->FullRead("SELECT * FROM exercicios "
                            . "WHERE exercicios.idexercicios = :idexercicios", " idexercicios={$Post['idexercicios']}");
                    $exercicioAtualizado = $ReadExercicio->getResult();
                    $jSon['sucesso'] = ['true'];
                    $jSon['clear'] = ['true'];
                    $jSon['content']['idexercicios'] = $Post['idexercicios'];
                    $jSon['content']['descricao_exe'] = $Post['descricao_exe'];
                    $jSon['content']['grupo_muscular_exe'] = $exercicioAtualizado[0]['grupo_muscular_exe'];
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

