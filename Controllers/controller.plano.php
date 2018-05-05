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

    $buscarPlano = new Read;

    if ($queryPesquisa >= 1):
        $buscarPlano->FullRead("SELECT * FROM planos "
                . "WHERE planos.idplano = $queryPesquisa");
        $jSon = $buscarPlano->getResult();

    elseif ($queryPesquisa === 0):
        $buscarPlano->FullRead("SELECT * FROM planos");
        $jSon = $buscarPlano->getResult();

    elseif (is_string($queryPesquisa)):
        $buscarPlano->FullRead("SELECT * FROM planos "
                . "WHERE planos.nome_plano LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarPlano->getResult();

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

//        CONDIÇÃO  'create_plano' ATENDIDA:
            case 'create-plano':

//            CRIAÇÃO DE UMA VARIÁVEL RESPONSÁVEL POR RECEBER  O NOME DA TABELA QUE SERÁ INSERIDA OS DADOS NO BANCO:
                $Tabela = "planos";

//            INSERIR A CLASSE DA MODEL RESPONSÁVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.plano.create.php';

//            INSTÂNCIA DO OBJETO DA CLASSE PLANO RESPONSÁVEL POR CADASTRAR NOVOS PLANOS NO BANCO DE DADOS:
                $CadastrarPlano = new PlanoCreate;

//            MÉTODO DA CLASSE PLANO RESPONSÁVEL POR CADASTRAR NOVOS PLANOS NO BANCO DE DADOS:
                $CadastrarPlano->novoPlano($Tabela, $Post);

//            CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UM NOVO PLANO, UTILIZANDO UM MÉTODO DA CLASSE CREATE_PLANO:
                if ($CadastrarPlano->getResult()):
                    $idNovoPlano = $CadastrarPlano->getResult();
                    $planoCadastrado = new Read;
                    $planoCadastrado->FullRead("SELECT * FROM planos " .
                            "WHERE planos.idplano = :idplano", " idplano={$idNovoPlano}");

                    if ($planoCadastrado->getResult()):
                        $novoPlano = $planoCadastrado->getResult();
                        $jSon['novoplano'] = $novoPlano[0];

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

