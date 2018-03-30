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

    $buscarTreino = new Read;

    if ($queryPesquisa >= 1):
        $buscarTreino->FullRead("SELECT treinos.idtreino, treinos.nome_treino, treinos.sigla_treino, exercicios.descricao_exe "
                . "FROM treinos "
                . "INNER JOIN exercicios ON treinos.idexercicio = exercicios.idexercicios "
                . "WHERE treinos.idtreino = $queryPesquisa");
        $jSon = $buscarTreino->getResult();

    elseif ($queryPesquisa === 0):
        $buscarTreino->FullRead("SELECT treinos.idtreino, treinos.nome_treino, treinos.sigla_treino, exercicios.descricao_exe "
                . "FROM treinos "
                . "INNER JOIN exercicios ON treinos.idexercicio = exercicios.idexercicios");
        $jSon = $buscarTreino->getResult();

    elseif (is_string($queryPesquisa)):
        $buscarTreino->FullRead("SELECT treinos.idtreino, treinos.nome_treino, treinos.sigla_treino, exercicios.descricao_exe "
                . "FROM treinos "
                . "INNER JOIN exercicios ON treinos.idexercicio = exercicios.idexercicios "
                . "WHERE treinos.nome_treino LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarTreino->getResult();

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

//        CONDIÇÃO  'treino' ATENDIDA:
            case 'create-treino':

//            CRIAÇÃO DE UMA VARIÁVEL RESPONSÁVEL POR RECEBER  O NOME DA TABELA QUE SERÁ INSERIDA OS DADOS NO BANCO:
                $Tabela = "treinos";

//            INSERIR A CLASSE DA MODEL RESPONSÁVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.treino.create.php';

//            INSTÂNCIA DO OBJETO DA CLASSE TREINO RESPONSÁVEL POR CADASTRAR NOVOS TREINOS NO BANCO DE DADOS:
                $CadastrarTreino = new TreinoCreate;

//            MÉTODO DA CLASSE TREINO RESPONSÁVEL POR CADASTRAR NOVOS TREINOS NO BANCO DE DADOS:
                $CadastrarTreino->novoTreino($Tabela, $Post);

//            CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UM NOVO TREINO, UTILIZANDO UM MÉTODO DA CLASSE TREINO:
                if ($CadastrarTreino->getResult()):
                    $idNovoTreino = $CadastrarTreino->getResult();
                    $treinoCadastrado = new Read;
                    $treinoCadastrado->FullRead("SELECT treinos.idtreino, treinos.nome_treino, treinos.sigla_treino ,exercicios.descricao_exe, equipamentos.nome_equip " .
                            "FROM treinos " .
                            "INNER JOIN exercicios ON treinos.idexercicio = exercicios.idexercicios " .
                            "INNER JOIN equipamentos ON treinos.idequipamentos = equipamentos.idequipamentos " .
                            "WHERE treinos.idtreino = :idtreino", " idtreino={$idNovoTreino}");

                    if ($treinoCadastrado->getResult()):
                        $novoTreino = $treinoCadastrado->getResult();
                        $jSon['novotreino'] = $novoTreino[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;

                    endif;
                endif;

                break;

            case 'povoar-edit':
                $DadosTreino = new Read;
                $DadosTreino->FullRead("SELECT * FROM treinos WHERE treinos.idtreino = :idtreino", "idtreino={$Post['idtreino']}");
                if ($DadosTreino->getResult()):
                    foreach ($DadosTreino->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

            case 'update-treino':
                require '../Models/model.treino.update.php';
                $updateTreino = new AtualizarTreino;
                $updateTreino->atualizarTreino('treinos', $Post, "WHERE treinos.idtreino = :idtreino", "idtreino={$Post['idtreino']}");
                if ($updateTreino->getResult()):
                    $ReadTreino = new Read;
                    $ReadTreino->FullRead("SELECT treinos.idtreino, treinos.nome_treino, treinos.sigla_treino ,exercicios.descricao_exe, equipamentos.nome_equip " .
                            "FROM treinos " .
                            "INNER JOIN exercicios ON treinos.idexercicio = exercicios.idexercicios " .
                            "INNER JOIN equipamentos ON treinos.idequipamentos = equipamentos.idequipamentos " .
                            "WHERE treinos.idtreino = :idtreino", " idtreino={$Post['idtreino']}");
                    $treinoAtualizado = $ReadTreino->getResult();
                    $jSon['sucesso'] = ['true'];
                    $jSon['clear'] = ['true'];
                    $jSon['content']['idtreino'] = $Post['idtreino'];
                    $jSon['content']['nome_treino'] = $Post['nome_treino'];
                    $jSon['content']['sigla_treino'] = $treinoAtualizado[0]['sigla_treino'];
                    $jSon['content']['descricao_exe'] = $treinoAtualizado[0]['descricao_exe'];
                endif;

                break;

            case 'delete-treino':
                require '../Models/model.treino.delete.php';
                $deletarTreino = new DeletarTreino;
                $deletarTreino->ExeDelete('treinos', "WHERE treinos.idtreino = :idtreino", "idtreino={$Post['idtreino']}");
                if ($deletarTreino->getResult()):
                    $jSon['delete'] = true;
                    $jSon['idtreino'] = $Post['idtreino'];
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

