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
        $buscarAnamnese->FullRead("SELECT anamneses.idanamneses, anamneses.idalunos_cliente, alunos_cliente.nome_aluno "
                . "FROM anamneses "
                . "LEFT JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "WHERE anamneses.idalunos_cliente = {$queryPesquisa}");
        $jSon = $buscarAnamnese->getResult();
    elseif ($queryPesquisa === 0):
        $buscarAnamnese->FullRead("SELECT anamneses.idanamneses, anamneses.idalunos_cliente, alunos_cliente.nome_aluno "
                . "FROM anamneses "
                . "LEFT JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente");
        $jSon = $buscarAnamnese->getResult();
    elseif (is_string($queryPesquisa)):
        $buscarAnamnese->FullRead("SELECT anamneses.idanamneses, anamneses.idalunos_cliente, alunos_cliente.nome_aluno "
                . "FROM anamneses "
                . "LEFT JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente "
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
            case 'create-anamnese':
                //CRIAÇÃO DE UMA VARIAVEL REPONSAVEL POR RECEBER O NOME DA TABELA QUE SERPA INSERIDA OS DADOS
                $Tabela = "anamneses";

                //INSERIR A CLASSE DA MODEL RESPONSAVEL PELA INTERAÇÃO COM O BANCO DE DADOS:
                require '../Models/model.anamnese.create.php';

                //INSTANCIA DO OBJETO DA CLASSE ANAMNESE RESPONSAVEL POR CADASTRAR NOVAS ANAMNESES:
                $CadastrarAnamnese = new Anamnese;

                //METODO DA CLASSE ANAMNESE REPONSAVEL POR CADASTRAR NOVAS ANAMNESES:
                $CadastrarAnamnese->novoAnamnese($Tabela, $Post);

                //CONDIÇÃO PARA VERIFICAR SE FOI CADASTRADO UMA NOVA ANAMNESE, UTILIZANDO UM METODO DA CLASSE ANAMNESE:
                if ($CadastrarAnamnese->getResult()):
                    $idNovaAnamnese = $CadastrarAnamnese->getResult();
                    $anamneseCadastrada = new Read;
                    $anamneseCadastrada->FullRead("SELECT anamneses.idanamneses, anamneses.idalunos_cliente, alunos_cliente.nome_aluno FROM anamneses INNER JOIN alunos_cliente ON alunos_cliente.idalunos_cliente = anamneses.idalunos_cliente WHERE anamneses.idanamneses = :idanamnese", "idanamnese={$idNovaAnamnese}");
                    if ($anamneseCadastrada->getResult()):
                        $novaAnamnese = $anamneseCadastrada->getResult();
                        $jSon['novaanamnese'] = $novaAnamnese[0];
                        //CONFIGURANDO UM GATILHO DE SUCESSO AO EXECUTAR O CADASTRO, TAL GATILHO SERÁ INTERPRETADO PELO JS:
                        $jSon['sucesso'] = true;
                        //GATILHO QUE SERÁ INTERPRETADO PELO ARQUIVO JS PARA LIMPAR OS CAMPOS DO FORMULÁRIO APÓS CADASTRO:
                        $jSon['clear'] = true;
                    endif;
                endif;

                break;

            case 'povoar-edit':
                $DadosAnamnese = new Read;
                $DadosAnamnese->FullRead("SELECT * FROM anamneses WHERE anamneses.idanamneses = :idanamneses", "idanamneses={$Post['idanamneses']}");
                if ($DadosAnamnese->getResult()):
                    foreach ($DadosAnamnese->getResult() as $e):
                        $Resultado = $e;
                    endforeach;
                    $jSon = $Resultado;
                endif;

                break;

            case 'update-anamnese':
                require '../Models/model.anamnese.update.php';
                $updateAnamnese = new AtualizarAnamnese;
                $updateAnamnese->atualizarAnamnese('anamneses', $Post, "WHERE anamneses.idanamneses = :idanamneses", "idanamneses={$Post['idanamneses']}");
                if ($updateAnamnese->getResult()):
                    $readNameAnamnese = new Read;
                    $readNameAnamnese->FullRead("SELECT alunos_cliente.nome_aluno "
                            . "FROM alunos_cliente "
                            . "INNER JOIN anamneses ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente "
                            . "WHERE anamneses.idalunos_cliente = :idalunos_cliente", "idalunos_cliente={$Post['idalunos_cliente']}");
                    $nameAlunoAnamneseUpdated = $readNameAnamnese->getResult();
                    $jSon['sucesso'] = ['true'];
                    $jSon['clear'] = ['true'];
                    $jSon['content']['idanamneses'] = $Post['idanamneses'];
                    $jSon['content']['idalunos_cliente'] = $Post['idalunos_cliente'];
                    $jSon['content']['nome_aluno'] = $nameAlunoAnamneseUpdated[0]['nome_aluno'];
                endif;

                break;

            case 'delete-anamnese':
                require '../Models/model.anamnese.delete.php';
                $deletarAnamnese = new DeletarAnamnese;
                $deletarAnamnese->ExeDelete('anamneses', "WHERE anamneses.idanamneses = :idanamneses", "idanamneses={$Post['idanamneses']}");
                if($deletarAnamnese->getResult()):
                    $jSon['delete'] = true;
                    $jSon['idanamneses'] = $Post['idanamneses'];
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
