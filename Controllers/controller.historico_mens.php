<?php

//IMPORTA O ARQUIVO DE CONFIGURAÇÃO
require '../_app/Config.inc.php';

//A VARIAVEL $jSon É CRIADA COMO ARRAY PARA QUE NO FINAL DO CODIGO ELA SEJA A VARIAVEL DE RESPOSTA DA CONTROLLER:
$jSon = array();

//$getPost É A VARIAVEL QUE RECEBE OS DADOS ENVIADOS DO ARQUIVO JS:
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);

/*
 * VERIFICA SE OS DADOS VINDOS DO ARQUIVO 'JS' SÃO REFERENTES A FUNÇÃO PESQUISAR POR HISTORICO. CASO O TAMANHO DO ARRAY
 * SEJA IGUAL A 1 É REFERENTE A PESQUISA. CASO O ARRAY SEJA MAIOR QUE 1 SIGNIFICA QUE SÃO DADOS PARA REALIZAR O CRUD.
 */
if (count($getPost) == 1):
    //PASSA O VALOR DO INDICE(key) PARA A VARIAVEL E NÃO O VALOR QUE ESTÁ ARAMAZENADO NAQUELE ÍNDICE, MAS SIM O ÍNDICE EM SI:
    $getQuery = array_keys($getPost);

    $queryPesquisa = (is_int($getQuery[0]) ? $getQuery[0] : strip_tags(str_replace('_', ' ', $getQuery[0])));
    if ($queryPesquisa >= 1):
        $buscarHistM = new Read;
        $buscarHistM->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                "FROM historicos_mensalidades " .
                "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano ".
                "WHERE historicos_mensalidades.idhist_pag = {$queryPesquisa}");
               
        $jSon = $buscarHistM->getResult();
    elseif ($queryPesquisa === 0):
        $buscarHistM = new Read;
        $buscarHistM->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                "FROM historicos_mensalidades " .
                "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano");
        $jSon = $buscarHistM->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarHistM = new Read;
        $buscarHistM->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                "FROM historicos_mensalidades " .
                "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano ".
                "WHERE alunos_cliente.nome_aluno LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarHistM->getResult();
    endif;
else:
    if (empty($getPost['callback'])):
        $jSon['trigger'] = "<div class='alert alert-warning'>Ação não selecionada!</div>";

    else:
        $Post = array_map("strip_tags", $getPost);

        $Action = $Post['callback'];

        unset($Post['callback']);

        switch ($Action):

            case 'pesquisa-data':
                $DadosConsulta = array();
                $DadosConsulta['data-inicio'] = $Post['data-inicio'];
                $DadosConsulta['data-fim'] = $Post['data-fim'];
                unset($Post['data-inicio']);
                unset($Post['data-fim']);

                $FiltroData = new Read;
                $FiltroData->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag "
                        . "FROM historicos_mensalidades INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                        . "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano "
                        . "WHERE data_mens_pag BETWEEN('{$DadosConsulta['data-inicio']}') AND ('{$DadosConsulta['data-fim']}')");

                if ($FiltroData->getResult()):

                    $jSon = $FiltroData->getResult();
                    //$jSon['clear'] = true;
                elseif (!($FiltroData->getResult())):

                    $jSon['vazio'] = true;
                    //$jSon['clear'] = true;
                endif;

                break;

        endswitch;
    endif;
endif;

//USANDO O ECHO OS GATILHOS VOLTAM VIA AJAX UTILIZANDO JSON PARA O ARQUIVO 'JS' E LÁ SERÁ INTERPRETADO:
echo json_encode($jSon);
