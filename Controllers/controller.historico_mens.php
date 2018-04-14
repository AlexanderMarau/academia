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
    $getPost = array_keys($getPost);
    /* A $queryPesquisa RECEBE O TERMO DA PESQUISA QUE FOI ARMAZENADO NO ÍNDICE '0' DA VARIAVEL $getQuery.
     * CASO O VALOR EM '$getQuery[0]' SEJA DO TIPO 'string' É RETIRADO OS '_' E SUBSTIUIDO POR ' ' UTILIZANDO A FUNÇÃO 'str_replace'
     * E FEITOA PREVENÇÃO CONTRA SCRIPTS  MALICIOSOS UTILIZANDO O 'strip_tags'. CASO 'getQuery[0]' SEJA DO TIPO 'int' NÃO É EFETUADO O TRATAMENTO: 
     */
    $queryPesquisa = (is_int($getQuery[0]) ? $getQuery[0] : strip_tags(str_replace('_', ' ', $getQuery[0])));
    //CRIA UM NOVO OBJETO PARA CONSULTAR NO BANCO DE DADOS O RESULTADO DA PESQUISA REFERENTE AO TERMO QUE FOI COLOCADO NA VARIAVEL $queryPesquisa:
    $buscarHist = new Read;

    //CONDIÇÃO PARA VERIFICAR SE O TERMO DE PESQUISA É int, CASO SEJA SERÁ REALIZADO UMA CONSULTA NO BANCO DE DADOS PELO ID OU CASO SEJA string SERÁ FEITA A CONSULTA PELO NOME DO ALUNO:
    if ($queryPesquisa >= 1):
        //Faz a busca de um dados pelo ID do Histórico registrado, pois o termos da pesquisa é um número
        $buscarHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                "FROM historicos_mensalidades " .
                "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano " .
                "WHERE historicos_mensalidades.idhist_pag = {$queryPesquisa}");
        $jSon = $buscarHist->getResult();
        
        elseif($queryPesquisa === 0):
        //Caso o usuário não tenha digitado nada no campo de pesquisa o resultado será todos os históricos.
        $buscarHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
        "FROM historicos_mensalidades " .
        "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
        "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano");
        $jSon = $buscarHist->getResult();
        
        elseif(is_string($queryPesquisa)):
            //Faz uma busca pelo nome, pois o que foi digitado foi uma STRING e não um número ou campos vazio:
            $buscarHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                "FROM historicos_mensalidades " .
                "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano " .
                "WHERE alunos_cliente.nome_aluno LIKE '%{$queryPesquisa}%'");
                $jSon = $buscarHist->getResult();
    endif;
else:

endif;

//USANDO O ECHO OS GATILHOS VOLTAM VIA AJAX UTILIZANDO JSON PARA O ARQUIVO 'JS' E LÁ SERÁ INTERPRETADO:
echo json_encode($jSon);
