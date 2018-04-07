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

    $buscarEquip = new Read;

    if ($queryPesquisa >= 1):
        $buscarEquip->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.marca_equip, fornecedores.nome_forn "
                . "FROM equipamentos "
                . "INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores "
                . "WHERE equipamentos.idequipamentos = {$queryPesquisa}");
        $jSon = $buscarEquip->getResult();
    elseif ($queryPesquisa === 0):
        $buscarEquip->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.marca_equip, fornecedores.nome_forn "
                . "FROM equipamentos "
                . "INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores ");
        $jSon = $buscarEquip->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarEquip->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.marca_equip, fornecedores.nome_forn "
                . "FROM equipamentos "
                . "INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores "
                . "WHERE equipamentos.nome_equip LIKE '%{$queryPesquisa}%'");
        $jSon = $buscarEquip->getResult();
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

//        CONDIÇÃO  'equipamento' ATENDIDA:
            case 'create-equipamento':

//            CRIAÇÃO DE UMA VARIÁVEL RESPONSÁVEL POR RECEBER  O NOME DA TABELA QUE SERÁ INSERIDA OS DADOS NO BANCO:
                $Tabela = "equipamentos";

//            INSERIR A CLASSE DA MODEL RESPONSÁVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.equipamento.php';

//            INSTÂNCIA DO OBJETO DA CLASSE EQUIPAMENTO RESPONSÁVEL POR CADASTRAR NOVOS EQUIPAMENTOS NO BANCO DE DADOS:
                $CadastrarEquip = new Equipamento;

//            MÉTODO DA CLASSE EQUIPAMENTO RESPONSÁVEL POR CADASTRAR NOVOS EQUIPAMENTOS NO BANCO DE DADOS:
                $CadastrarEquip->novoEquipamento($Tabela, $Post);

//            CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UM NOVO EQUIPAMENTO, UTILIZANDO UM MÉTODO DA CLASSE EQUIPAMENTO:
                if ($CadastrarEquip->getResult()):
                    $idNovoEquip = $CadastrarEquip->getResult();
                    $equipCadastrado = new Read;
                    $equipCadastrado->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.marca_equip, fornecedores.nome_forn "
                            . "FROM equipamentos "
                            . "INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores "
                            . "WHERE equipamentos.idequipamentos = :idequipamentos", " idequipamentos={$idNovoEquip}");

                    if ($equipCadastrado->getResult()):
                        $novoEquip = $equipCadastrado->getResult();
                        $jSon['novoequip'] = $novoEquip[0];

                        $jSon['sucesso'] = true;

                        $jSon['clear'] = true;
                    endif;
                endif;

                break;

            case 'povoar-edit':
                $DadosEquipamento = new Read;
                $DadosEquipamento->FullRead("SELECT * FROM equipamentos WHERE equipamentos.idequipamentos = :idequipamentos", "idequipamentos={$Post['idequipamentos']}");
                if ($DadosEquipamento->getResult()):
                    foreach ($DadosEquipamento->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

            case 'update-equipamento':

                require '../Models/model.equipamento.update.php';
                
                $updateEquipamento = new AtualizarEquipamento;
               $updateEquipamento->atualizarEquipamento('equipamentos', $Post, "WHERE equipamentos.idequipamentos = :idequipamentos", "idequipamentos={$Post['idequipamentos']}");
                if ($updateEquipamento->getResult()):
                    $readEquipamento = new Read;
                    $readEquipamento->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.marca_equip, fornecedores.nome_forn "
                            . "FROM equipamentos "
                            . "INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores "
                            . "WHERE equipamentos.idequipamentos = :idequipamentos", " idequipamentos={$Post['idequipamentos']}");
                    $DadosEquipamentoEditado = $readEquipamento->getResult();
                        $jSon['sucesso'] = ['true'];
                        $jSon['clear'] = ['true'];
                        $jSon['content']['idequipamentos'] = $Post['idequipamentos'];
                        $jSon['content']['nome_equip'] = $Post['nome_equip'];
                        $jSon['content']['marca_equip'] = $DadosEquipamentoEditado[0]['marca_equip'];
                        $jSon['content']['nome_forn'] = $DadosEquipamentoEditado[0]['nome_forn'];
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

