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
            case 'pagar-mensalidade':
                $dataHoje = date('Y-m-d');
                $ConsultaMensalidade = new Read;
                $ConsultaMensalidade->ExeRead('mensalidades', "WHERE idmensalidade = :idmensalidade", "idmensalidade={$Post['idmensalidade']}");
                $DadosMensalidade = $ConsultaMensalidade->getResult();
                $ConsultaPlano = new Read;
                $ConsultaPlano->FullRead("SELECT tipo_plano, valor_plano FROM planos WHERE idplano = {$DadosMensalidade[0]['idplano']}");
                $DadosPlano = $ConsultaPlano->getResult();
                // Criando Array para cadastrar o histórico do pagamento:
                $NovoHistorico = array();
                $NovoHistorico['idalunos_cliente'] = $DadosMensalidade[0]['idalunos_cliente'];
                $NovoHistorico['idplano'] = $DadosMensalidade[0]['idplano'];
                $NovoHistorico['data_mens_pag'] = $dataHoje;
                $NovoHistorico['valor_pag'] = $DadosPlano[0]['valor_plano'];
                // Definindo a quantidade de tempo até a cobrança da próxima mensalidade:
                $somaData = null;
                switch ($DadosPlano[0]['tipo_plano']) {
                    case '7':
                        $somaData = '+7 days';
                        break;

                    case '30':
                        $somaData = '+1 month';
                        break;
                    
                    case '60':
                        $somaData = '+2 month';
                        break;   
                    
                    case '90':
                        $somaData = '+3 month';
                        break;    
                    
                    default:
                        $jSon['trigger'] = "Error nenhuma tipo de plano foi escolhido";
                        break;
                }
                //Essa variável $DataNovaMensalidade é importante pois ela vai ser a data da próxima cobrança. 
                if(strtotime($dataHoje) > strtotime($DadosMensalidade[0]['data_mens_pag'])):
                    //Caso a mensalidade esteja vencida, será gerada a nova mensalidade baseada na data de HOJE (data do pagamento) + a quantidade de dias do plano cadastrado no banco.
                    $DataNovaMensalidade = date('Y-m-d', strtotime($somaData, strtotime($dataHoje)));
                else:
                    //Caso a mensalidade não esteja vencida, será gerada uma a nova mensalidade baseada na data de cobrança da mensalidade cadastrada no banco.
                    $DataNovaMensalidade = date('Y-m-d', strtotime($somaData, strtotime($DadosMensalidade[0]['data_mens_pag'])));
                endif;
                // Model Responsável por gerar novo Histórico:
                $GerarHistorico = new Create;
                $GerarHistorico->ExeCreate('historicos_mensalidades', $NovoHistorico);
                // Atualizando os dados da próxima mensalidade:
                if($GerarHistorico->getResult()):
                    $NovosDadosMensalidade = array();
                    $NovosDadosMensalidade['data_mens_pag'] =  $DataNovaMensalidade;
                    $NovosDadosMensalidade['status_mens'] = 'Em Aberto';
                    $NovaMensalidade = new Update;
                    $NovaMensalidade->ExeUpdate('mensalidades', $NovosDadosMensalidade, "WHERE idmensalidade = :idmensalidade", "idmensalidade={$DadosMensalidade[0]['idmensalidade']}");
                    if($NovaMensalidade->getResult()):
                        $jSon['sucesso'] = true;
                        $jSon['idHistorico'] = $GerarHistorico->getResult();
                        $jSon['novaDataMensalidade'] = Check::DataBrasil($NovosDadosMensalidade['data_mens_pag']);
                        $jSon['ultimoPagamento'] = Check::DataBrasil($dataHoje);
                    endif;    
                else: 
                    $jSon['trigger'] = "Não foi possível gerar o histórico de pagamento";
                endif;
                // Nessa linha dar um update na mensalidade para a próxima data de acordo com a quantidades de dia do plano
                
                break;
            
            case 'verificar-status':
                //Confere e altera o status da mensalidade baseado na data de vencimento da mensalidade.
                $hoje = date('Y-m-d');
                $diferenca = date('Y-m-d', strtotime("+5 days", strtotime($hoje)));
                $atrasadas = new Read();
                $atrasadas->FullRead("SELECT idmensalidade FROM mensalidades WHERE data_mens_pag < '{$hoje}'");
                if($atrasadas->getResult()):
                    $atualizarAtrasadas = new Update;
                    $novoStatus = array();
                    $novoStatus['status_mens'] = 'Vencido';
                    foreach ($atrasadas->getResult() as $e):
                        extract($e);
                        $atualizarAtrasadas->ExeUpdate("mensalidades", $novoStatus, "WHERE idmensalidade = :id", "id={$idmensalidade}");                    
                    endforeach;
                    $jSon['vencidasUpdate'] = true;    
                endif;   
                $atencao = new Read();
                $atencao->FullRead("SELECT idmensalidade FROM mensalidades WHERE data_mens_pag >= '{$hoje}' AND data_mens_pag <= '{$diferenca}'");
                if($atencao->getResult()):
                    $atualizarAtencao = new Update;
                    $novoStatus = array();
                    $novoStatus['status_mens'] = 'Atencao';
                    foreach ($atencao->getResult() as $e):
                        extract($e);
                        $atualizarAtencao->ExeUpdate("mensalidades", $novoStatus, "WHERE idmensalidade = :id", "id={$idmensalidade}");                    
                    endforeach;
                    $jSon['atencaoUpdate'] = true;    
                endif;
                $emAbertas = new Read();
                $emAbertas->FullRead("SELECT idmensalidade FROM mensalidades WHERE data_mens_pag > '{$diferenca}'");
                if($emAbertas->getResult()):
                    $atualizarEmAbertas = new Update;
                    $novoStatus = array();
                    $novoStatus['status_mens'] = 'Em Aberto';
                    foreach ($emAbertas->getResult() as $e):
                        extract($e);
                        $atualizarEmAbertas->ExeUpdate("mensalidades", $novoStatus, "WHERE idmensalidade = :id", "id={$idmensalidade}");                    
                    endforeach;
                    $jSon['emAbertasUpdate'] = true;
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