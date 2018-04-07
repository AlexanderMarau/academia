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

    $buscarMensalidade = new Read;

    if ($queryPesquisa >= 1):
        $buscarMensalidade->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.valor_mensalidades, mensalidades.data_mens_pag, mensalidades.status_mensalidades "
                . "FROM mensalidades "
                . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "WHERE alunos_cliente.idalunos_cliente = {$queryPesquisa}");
        $jSon = $buscarMensalidade->getResult();
    elseif ($queryPesquisa === 0):
        $buscarMensalidade->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.valor_mensalidades, mensalidades.data_mens_pag, mensalidades.status_mensalidades "
                . "FROM mensalidades "
                . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente");
        $jSon = $buscarMensalidade->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarMensalidade->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.valor_mensalidades, mensalidades.data_mens_pag, mensalidades.status_mensalidades "
                . "FROM mensalidades "
                . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "WHERE alunos_cliente.nome_aluno LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarMensalidade->getResult();
    endif;
else:
    if (empty($getPost['callback'])):
        $jSon['trigger'] = "<div class='alert alert-warning'>Ação não selecionada!</div>";
    else:

        $Post = array_map("strip_tags", $getPost);
        $Action = $Post['callback'];
        unset($Post['callback']);

        switch ($Action):
            case 'create-mensalidade':

                $Tabela = 'mensalidades';

                require '../Models/model.mensalidade.create.php';

                $CadMensalidade = new Mensalidade;
                $CadMensalidade->novoMensalidade($Tabela, $Post);

                if ($CadMensalidade->getResult()):
                    $idNovaMens = $CadMensalidade->getResult();
                    $mensCadastrada = new Read;
                    $mensCadastrada->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.valor_mensalidades, mensalidades.data_mens_pag, mensalidades.status_mensalidades "
                            . "FROM mensalidades "
                            . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                            . "WHERE mensalidades.idmensalidades = :idmensalidades", "idmensalidades={$idNovaMens}");

                    if ($mensCadastrada->getResult()):
                        $novaMens = $mensCadastrada->getResult();
                        $jSon['novamens'] = $novaMens[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;
                    endif;
                endif;

                break;

            case 'povoar-edit':
                $DadosMensalidade = new Read;
                $DadosMensalidade->FullRead("SELECT * FROM mensalidades WHERE mensalidades.idmensalidades = :idmensalidades", "idmensalidades={$Post['idmensalidades']}");
                if ($DadosMensalidade->getResult()):
                    foreach ($DadosMensalidade->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

            case 'update-mensalidade':
                require '../Models/model.mensalidade.update.php';
                $updateMensalidade = new AtualizarMensalidade;
                $updateMensalidade->atualizarMensalidade('mensalidades', $Post, "WHERE mensalidades.idmensalidades = :idmensalidades", "idmensalidades={$Post['idmensalidades']}");
                if ($updateMensalidade->getResult()):

                    $readMensalidade = new Read;
                    $readMensalidade->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.valor_mensalidades, mensalidades.data_mens_pag, mensalidades.status_mensalidades "
                            . "FROM mensalidades "
                            . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                            . "WHERE mensalidades.idmensalidades = :idmensalidades", " idmensalidades={$Post['idmensalidades']}");

                    $DadosMensalidadesEditada = $readMensalidade->getResult();

                    $jSon['sucesso'] = ['true'];
                    $jSon['clear'] = ['true'];
                    $jSon['content']['idmensalidades'] = $Post['idmensalidades'];
                    $jSon['content']['nome_aluno'] = $DadosMensalidadesEditada[0]['nome_aluno'];
                    $jSon['content']['valor_mensalidades'] = $DadosMensalidadesEditada[0]['valor_mensalidades'];
                    $jSon['content']['data_mens_pag'] = $DadosMensalidadesEditada[0]['data_mens_pag'];
                    $jSon['content']['status_mensalidades'] = $DadosMensalidadesEditada[0]['status_mensalidades'];
                endif;

                break;

            default :
                $jSon['trigger'] = "<div class='alert alert-warning'>Ação não selecionada!</div>";
                break;
        endswitch;
    endif;
endif;
//USANDO O ECHO OS GATILHOS VOLTA VIA AJAX UTILIZANDO JSON PARA O ARQUIVO JS E LÁ SERÁ INTERPRETADO:
echo json_encode($jSon);

