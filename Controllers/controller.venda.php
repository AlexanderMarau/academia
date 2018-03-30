<?php

//IMPORTA O ARQUIVO DE CONFIGURAÇÃO:
require '../_app/Config.inc.php';

//A VARIAVEL $JSON É CRIADA COMO ARRAY PARA QUE NO FINAL DO CODIGO ELA SEJA A VARIAVEL DE RESPOSTA DA CONTROLLER:
$jSon = array();

//$getPost É A VARIAVEL QUE RECEBE OS DADOS ENVIADOS DO ARQUIVO JS:
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//Verifica se os dados vindos do arquivo js são referentes a função pesquisa por anamnese. Caso o tamanho do array seja igual a 1 é referente a pesquisa. Caso o array seja maior que 1 significa que são dados para realizar o CRUD.
if (count($getPost) == 1):

    $getQuery = array_keys($getPost);

    $queryPesquisa = (is_int($getQuery[0]) ? $getQuery[0] : strip_tags(str_replace('_', ' ', $getQuery[0])));

    $buscarAnamnese = new Read;

    if ($queryPesquisa >= 1):
        $buscarAnamnese->FullRead("SELECT vendas.idvendas, vendas.data_venda, usuario.nome_usuario, alunos_cliente.nome_aluno, vendas.itens_total, vendas.valor_total "
                . "FROM vendas "
                . "INNER JOIN usuario ON vendas.idusuario = usuario.idusuario "
                . "INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "WHERE vendas.idvendas = {$queryPesquisa}");
        $jSon = $buscarAnamnese->getResult();
    elseif ($queryPesquisa === 0):
        $buscarAnamnese->FullRead("SELECT vendas.idvendas, vendas.data_venda, usuario.nome_usuario, alunos_cliente.nome_aluno, vendas.itens_total, vendas.valor_total "
                . "FROM vendas "
                . "INNER JOIN usuario ON vendas.idusuario = usuario.idusuario "
                . "INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "ORDER BY vendas.idvendas DESC");
        $jSon = $buscarAnamnese->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarAnamnese->FullRead("SELECT vendas.idvendas, vendas.data_venda, usuario.nome_usuario, alunos_cliente.nome_aluno, vendas.itens_total, vendas.valor_total "
                . "FROM vendas "
                . "INNER JOIN usuario ON vendas.idusuario = usuario.idusuario "
                . "INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "WHERE alunos_cliente.nome_aluno LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarAnamnese->getResult();
    endif;
else:

//PRIMEIRA CONDIÇÃO  - NESSA CONDIÇÃO VERIFICA, SE O INDICE CALLBACK FOI PREENCHIDO:
    if (empty($getPost['callback'])):
        //CASO NÃO HAJA O INDICE CALLBACK UM GATILHO DE ERRO (TRIGGER) É CRIADO NO ARRAY $jSon:
        $jSon['trigger'] = "<div class 'alert alert warning'>Ação não selecionada 1!</div>";
    else:

        //CASO O CALLBACK ESTEJA CORRETO A FUNÇÃO ARRAY_MAP INICIA A 'LIMPEZA' DOS VALORES DE CADA INDICE RETIRANDO TAGS DE SQL INJECTION E OUTRAS AMEAÇAS:
        $Post = array_map("strip_tags", $getPost);

        //A VARIAVEL $Action É CRIADA PARA RECEBER O ACTION DO ARRAY QUE VEIO DO JS:
        $Action = $Post['callback'];

        //O INDICE 'CALLBACK' E O SEU RESPECTIVO VALOR SÃO DESMEMBRADOS DA VARIAVEL POST, ISSO É NECESSÁRIO PARA ENVIAR PARA O BANCO APENAS OS DADOS NECESSÁRIOS:
        unset($Post['callback']);

        //SWITCH SERÁ AS CONDIÇÕES VERIFICADAS E USADAS PARA TOMAR AÇÕES DE ACORDO COM CADA CALLBACK:
        switch ($Action):
            //CONDIÇÃO 'anamnese' ATENDIDA:
            case 'buscar-estoque-produto':
                session_start();
                if (array_key_exists("itens_vendas", $_SESSION) && array_key_exists("{$Post['idprodutos']}", $_SESSION['itens_vendas'])):
                    $jSon['trigger'] = "Ops! Você não pode adicionar este produto, pois ele já está no seu carrinho.";
                else:
                    $LerEstoque = new Read;
                    $LerEstoque->FullRead("SELECT estoq_prod.idestoques, estoq_prod.quant_estoque, produtos.valor_prod "
                            . "FROM estoq_prod "
                            . "INNER JOIN produtos ON estoq_prod.idprodutos = produtos.idprodutos "
                            . "WHERE estoq_prod.idprodutos = :idprodutos", "idprodutos={$Post['idprodutos']}");
                    if ($LerEstoque->getResult()):
                        $idEstoque = $LerEstoque->getResult();
                        $jSon = $idEstoque[0];
                    endif;
                endif;
                break;

            case 'adicionar-carrinho';
                if (!array_key_exists('idprodutos', $Post)):
                    $jSon['trigger'] = "Atenção é preciso selecionar um Produto para ser adicionado ao carrinho";
                elseif (empty($Post['qt_vendas'])):
                    $jSon['trigger'] = "Atenção é preciso inserir a quantidade itens a serem adicionados ao carrinho";
                else:
                    session_start();
                    $idProduto = $Post['idprodutos'];
                    $LerNomeProduto = new Read;
                    $LerNomeProduto->FullRead("SELECT produtos.nome_prod FROM produtos WHERE produtos.idprodutos = :idprodutos", "idprodutos={$idProduto}");
                    if ($LerNomeProduto->getResult()):
                        $NameProduto = $LerNomeProduto->getResult();
                        $Post['nome_prod'] = $NameProduto[0]['nome_prod'];
                        $_SESSION['itens_vendas']["{$idProduto}"] = $Post;
                        $ti = (int) 0;
                        $i = (float) 0;
                        foreach ($_SESSION['itens_vendas'] as $e):
                            extract($e);
                            $ti += $qt_vendas;
                            $i += $valor_vendas;
                        endforeach;
                        $_SESSION['itens_total'] = $ti;
                        $_SESSION['valor_total'] = $i;
                        $jSon['valor_total'] = $i;
                        $jSon['item_info'] = $Post;
                        $jSon['sucesso'] = true;
                    endif;
                endif;
                break;

            case 'cancelar-venda':
                session_start();
                if (array_key_exists("itens_vendas", $_SESSION) && array_key_exists("itens_total", $_SESSION) && array_key_exists("valor_total", $_SESSION)):
                    unset($_SESSION['itens_vendas'], $_SESSION['valor_total'], $_SESSION['itens_total']);
                    if (!array_key_exists("itens_vendas", $_SESSION) && !array_key_exists("itens_total", $_SESSION) && !array_key_exists("valor_total", $_SESSION)):
                        $jSon['sucesso'] = true;
                        $jSon['content'] = "A Venda Foi Cancelada Com Sucesso!";
                    endif;
                else:
                    $jSon['trigger'] = "Não existem produtos no carrinho atual para cancelar a venda.";
                endif;
                break;

            case 'cadastrar-venda':
                session_start();
                if (!array_key_exists("itens_vendas", $_SESSION)): //VERIFICA SE HÁ ITENS NO CARRINHO PARA CADASTRAR A VENDA.
                    $jSon['trigger'] = "Você precisa ter itens no carrinho para concluir uma venda";
                elseif (!array_key_exists("idalunos_cliente", $Post)): //VERIFICA SE O CLIENTE FOI SELECIONADO PARA CADASTRAR A VENDA.
                    $jSon['trigger'] = "Selecione um Cliente antes de concluir a venda.";
                else:
                    $estoqOk = null;
                    $checkEstoq = new Read;
                    foreach ($_SESSION['itens_vendas'] as $u):
                        $checkEstoq->FullRead("SELECT estoq_prod.quant_estoque FROM estoq_prod WHERE estoq_prod.idprodutos = :idprodutos", "idprodutos={$u['idprodutos']}");
                        $totalEstoq = $checkEstoq->getResult();
                        $atualEstoque = (int) $totalEstoq[0]['quant_estoque'];
                        $u['qt_vendas'] = (int) $u['qt_vendas'];
                        if ($u['qt_vendas'] > $atualEstoque)://VERIFICA SE O ESTOQUE POSSUI A QUANTIDADE SUFICIENTE PARA SUBTRAÇÃO:
                            $jSon['trigger'] = "Ops! O item: {$u['nome_prod']} possui: {$atualEstoque} unidade(s), por isso não é possível vender {$u['qt_vendas']} unidade(s). Venda Não Realizada!";
                            $estoqOk = false;
                            break;
                        else:
                            $estoqOk = true;
                        endif;
                    endforeach;
                    if ($estoqOk == true):
                        $novaVenda = array();
                        $novaVenda['idalunos_cliente'] = $Post['idalunos_cliente'];
                        $novaVenda['idusuario'] = $_SESSION['idusuario'];
                        $novaVenda['data_venda'] = date('Y-m-d H:i:s');
                        $novaVenda['valor_total'] = $_SESSION['valor_total'];
                        $novaVenda['itens_total'] = $_SESSION['itens_total'];
                        require '../Models/model.venda.create.php';
                        $realizarVenda = new Venda;
                        $realizarVenda->novaVenda('vendas', $novaVenda);
                        if ($realizarVenda->getResult()): //VERIFICA SE A VENDA FOI CADASTRADA NA TABELA 'vendas'
                            $idvendas = $realizarVenda->getResult(); //RECUPERA O ID DA NOVA VENDA CADASTRADA
                            require '../Models/model.estoque.update.php';
                            require '../Models/model.itensvendas.create.php';
                            $upEstoque = new AtualizarEstoque;
                            $novoItem = new ItensVendas;
                            foreach ($_SESSION['itens_vendas'] as $e):
                                //CRIANDO OBJETO PARA LER A QUANTIDADE DO ESTOQUE ATUAL PARA USAR COMO REFERÊNCIA PARA A SUBTRAÇÃO NO ESTOQUE
                                $checkEstoq->FullRead("SELECT estoq_prod.quant_estoque FROM estoq_prod WHERE estoq_prod.idprodutos = :idprodutos", "idprodutos={$e['idprodutos']}");
                                $totalEstoq = $checkEstoq->getResult();
                                $atualEstoque = (int) $totalEstoq[0]['quant_estoque'];
                                //ATUALIZANDO ITENS NA TABELA 'estoq_prod':
                                $novoEstoque['quant_estoque'] = ($atualEstoque - $e['qt_vendas']);
                                $upEstoque->atualizarEstoque('estoq_prod', $novoEstoque, "WHERE estoq_prod.idprodutos = :idprodutos", "idprodutos={$e['idprodutos']}");
                                if ($upEstoque->getRowCount() == 1):
                                    //CADASTRANDO ITENS NA TABELA 'itens_vendas':
                                    $e['idvendas'] = $idvendas;
                                    unset($e['nome_prod']);
                                    $novoItem->novoItem('itens_vendas', $e);
                                    if (!$novoItem->getResult()):
                                        $jSon['trigger'] = 'Não foi possível cadastrar o produto de ID: ' . $e['idprodutos'];
                                        $itemCadastrado = false;
                                    else:
                                        $itemCadastrado = true;
                                    endif;
                                else:
                                    $jSon['trigger'] = "Ops, Algo deu errado ao atualizar o estoque.";
                                endif;
                            endforeach;
                            if ($itemCadastrado):
                                $dadosVenda = new Read;
                                $dadosVenda->ExeRead('vendas', "WHERE vendas.idvendas = :idvendas", "idvendas={$idvendas}");
                                if ($dadosVenda->getResult()):
                                    $vendaFeita = $dadosVenda->getResult();
                                    $jSon['content'] = $vendaFeita[0];
                                    $jSon['content']['data_venda'] = date('d/m/Y - H:i:s', strtotime($vendaFeita[0]['data_venda']));
                                    $jSon['sucesso'] = true;
                                    $jSon['mensagem'] = "Venda Realizada com Sucesso!";
                                    unset($_SESSION['itens_vendas'], $_SESSION['valor_total'], $_SESSION['itens_total']);
                                else:
                                    $jSon['trigger'] = "A venda foi realizada, mas não foi possível recuperar os dadados da venda feita";
                                endif;
                            endif;
                        else:
                            $jSon['trigger'] = "Não possível cadastrar a venda, recarregue e tente novamente";
                        endif;
                    endif;

                endif;
                break;

            //CASO O CALLBACK NÃO SEJA ATENDIDO O DEFAULT SETA O GATILHO DE ERRO (TRIGGER) RESPONSAVEL POR RETORNAR O ERRO AO JS:
            default :
                $jSon['trigger'] = "<div class='alert alert-warning'>Ação não selecionada 2!</div>";
                break;
        endswitch;

    endif;
endif;
echo json_encode($jSon);
