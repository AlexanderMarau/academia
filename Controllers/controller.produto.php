<?php

//IMPORTA O ARQUIVO DE CONFIGURAÇÃO:
require '../_app/Config.inc.php';
//A VARIAVEL $JSON É CRIADA COMO ARRAY PARA QUE NO FINAL DO CODIGO ELA SEJPA A VARIAVEL DE  RESPOSTA DA CONTROLLER:
$jSon = array();
//$getPost É A VARIAVEL QUE RECEBE OS DADOS ENVIADOS DO ARQUIVO JS:
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//VERIFICA SE OS DADOS VINDOS DO ARQUIVO JS SÃO REFERENTES A FUNÇÃO PESQUISA POR PRODUTO.
//CASO O TAMANHO DO ARRAY SEJA IGUAL A 1 É REFERENTE A PESQUISA . CASO O ARRAY SEJA MAIOR
//QUE 1 SIGNIFICA QUE SÃO DADOS PARA REALIZAR O crud.
if (count($getPost) == 1):
    $getQuery = array_keys($getPost);
    $queryPesquisa = (is_int($getQuery[0]) ? $getQuery[0] : strip_tags(str_replace('_', ' ', $getQuery[0])));
    $buscarProduto = new Read;
    if ($queryPesquisa >= 1):
        $buscarProduto->FullRead("SELECT produtos.idprodutos, cat_produto.descricao, fornecedores.nome_forn, produtos.nome_prod, estoq_prod.quant_estoque "
                . "FROM produtos "
                . "INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto "
                . "INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores "
                . "INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos "
                . "WHERE produtos.idprodutos = {$queryPesquisa}");
        $jSon = $buscarProduto->getResult();

    elseif ($queryPesquisa === 0):
        $buscarProduto->FullRead("SELECT produtos.idprodutos, cat_produto.descricao, fornecedores.nome_forn, produtos.nome_prod, estoq_prod.quant_estoque "
                . "FROM produtos "
                . "INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto "
                . "INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores "
                . "INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos ");
        $jSon = $buscarProduto->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarProduto->FullRead("SELECT produtos.idprodutos, cat_produto.descricao, fornecedores.nome_forn, produtos.nome_prod, estoq_prod.quant_estoque "
                . "FROM produtos "
                . "INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto "
                . "INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores "
                . "INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos "
                . "WHERE produtos.nome_prod LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarProduto->getResult();
    endif;
else:
    $Post = array_map("strip_tags", $getPost);
    $Action = $Post['callback'];
    unset($Post['callback']);
    switch ($Action):
        case 'create-produto':
            require '../Models/model.produto.create.php';
            $CadEstoque = array();
            $CadEstoque['quant_estoque'] = $Post['quant_estoque'];
            unset($Post['quant_estoque']);
            $CadProduto = new CreateProduto;
            $CadProduto->novoProduto('produtos', $Post);
            if ($CadProduto->getResult()):
                $CadEstoque['idprodutos'] = $CadProduto->getResult();
                $produtoEstoque = new CreateProduto;
                $produtoEstoque->inserirProdutoEstoque('estoq_prod', $CadEstoque);
                if ($produtoEstoque->getResult()):
                    $produtoInserido = new Read;
                    $produtoInserido->FullRead("SELECT produtos.idprodutos, cat_produto.descricao, fornecedores.nome_forn, produtos.nome_prod, estoq_prod.quant_estoque "
                            . "FROM produtos "
                            . "INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto "
                            . "INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores "
                            . "INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos "
                            . "WHERE produtos.idprodutos = :idprodutos", "idprodutos={$CadProduto->getResult()}");
                    if ($produtoInserido->getResult()):
                        $dadosProdutoNovo = $produtoInserido->getResult();
                        $jSon['novoproduto'] = $dadosProdutoNovo[0];
                        $jSon['sucesso'] = true;
                        $jSon['clear'] = true;
                    endif;
                endif;
            endif;
            break;
        case 'povoar-edit-produto':
            $DadosProduto = new Read;
            $DadosProduto->FullRead("SELECT produtos.*, estoq_prod.quant_estoque FROM produtos INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos WHERE produtos.idprodutos = :idprodutos", "idprodutos={$Post['idprodutos']}");
            if ($DadosProduto->getResult()):
                $Resultado = $DadosProduto->getResult();
                $jSon = $Resultado[0];
            endif;
            break;
            
            
        case 'update-produto':
            require '../Models/model.produto.update.php';
            $idProduto = $Post['idprodutos'];
            $alterEstoque = array();
            $alterEstoque['quant_estoque'] = $Post['quant_estoque'];
            unset($Post['idprodutos']);
            unset($Post['quant_estoque']);
            $updateProduto = new AtualizarProduto;
            $updateEstoque = new AtualizarProduto;
            $updateProduto->atualizarProduto('produtos', $Post, "WHERE produtos.idprodutos = :idprodutos", "idprodutos={$idProduto}");
            if ($updateProduto->getResult()):
                $updateEstoque->atualizarQtdProduto('estoq_prod', $alterEstoque, "WHERE estoq_prod.idprodutos = :idprodutos", "idprodutos={$idProduto}");
                if ($updateEstoque->getResult()):
                    $produtoAtualizado = new Read;
                    $produtoAtualizado->FullRead("SELECT produtos.idprodutos, cat_produto.descricao, fornecedores.nome_forn, produtos.nome_prod, estoq_prod.quant_estoque "
                            . "FROM produtos "
                            . "INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto "
                            . "INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores "
                            . "INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos "
                            . "WHERE produtos.idprodutos = {$idProduto}");
                    if ($produtoAtualizado->getResult()):
                        $DadosProdutoAtualizado = $produtoAtualizado->getResult();
                        $jSon['sucesso'] = ['true'];
                        $jSon['clear'] = ['true'];
                        $jSon['content'] = $DadosProdutoAtualizado[0];
                    endif;
                endif;
            endif;
            break;
            
    endswitch;
endif;
echo json_encode($jSon);
