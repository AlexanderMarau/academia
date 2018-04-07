<?php
//IMPORTA O ARQUIVO DE CONFIGURAÇÃO:
require '../_app/Config.inc.php';
//A VARIAVEL "$jSon" É UM ARRAY DE DADOS QUE SERÁ CONVERTIDO EM OBJETO JSON POSTERIORMENTE:
$jSon = array();
//A VARIÁVEL "$getPost" RECUPERA OS DADOS (COMO ARRAY) ENVIADOS VIA POST PELO script.js NO ARQUIVO PHP:
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//CONDIÇÃO PARA VERIFICAR SE O INPUT 'callback' (QUE FICA OCULTO NO FORMULÁRIO NO FRONT-END) TEM UM VALOR CONFIGURADO, ESSE VALOR É O QUE VAI DEFINIR O QUE O AJAX IRÁ FAZER, NESSE CASO: "verificar_login".
if (empty($getPost['callback'])):
    $jSon['trigger'] = AjaxErro("<span class='icon-cross al_center ds_block'>Uma ação não foi selecionada no formulário.</span>", E_USER_ERROR);
else:
    //CASO TENHA TENTATIVA DE "SQL INJECTION" ESTA FUNÇÃO DO PHP IRÁ RETIRAR TAIS STRINGS, EXEMPLO DAS TAGS QUE SERÃO RETIRADAS: ', <?php, <script> E ETC...
    $Post = array_map("strip_tags", $getPost);
    $Action = $Post['callback'];
    unset($Post['callback']);
    $Read = new Read;
//
    switch ($Action):
        case 'verificar_login':
            //VERIFICA SE HÁ CAMPOS EM BRANCO:
            if (in_array('', $Post)):
                $jSon['result'] = false;
                $jSon['trigger'] = AjaxErro("<span class='trigger warning'>Ops! Parece que há algum campo em branco, por favor preencha os dados corretamente!</span>"
                    , E_USER_WARNING);
                break;
            //VERIFICA SE O E-MAIL É UM E-MAIL VÁLIDO:    
            elseif (!Check::Email($Post['email_usuario'])):
                $jSon['result'] = false;
                $jSon['trigger'] = AjaxErro("<span class='icon-warning al_center ds_block'>Digite um e-mail válido!</span>", E_USER_WARNING);
                break;
            else:    
                //QUERY PARA VERIFICAR SE O EMAIL E SENHA DIGITADOS ESTÃO CADASTRADOS NO BANCO E SE CONFEREM:
                $Read->FullRead("SELECT idusuario, nome_usuario, perfil_usuario FROM usuario WHERE email_usuario = :email AND senha_usuario = :password", "email={$Post['email_usuario']}&password={$Post['senha_usuario']}");
                //CONDIÇÕES DE ACORDO COM A CONSULTA NO BANCO DE DADOS:
                if($Read->getRowCount()):
                    $jSon['result'] = true;
                    $jSon['trigger'] = "Seja bem Vindo(a)!";
                    session_start();
                    $_SESSION['logado'] = true;
                    foreach ($Read->getResult() as $ResultadoUsuario):
                        extract($ResultadoUsuario);
                    endforeach;
                    $_SESSION['idusuario'] = $ResultadoUsuario['idusuario'];
                    $_SESSION['nome_usuario'] = $ResultadoUsuario['nome_usuario'];
                    $_SESSION['perfil_usuario'] = $ResultadoUsuario['perfil_usuario'];
                else:
                    $jSon['result'] = false;
                    $jSon['trigger'] = "Ops! parece que o email ou senha digitados não estão corretos!";
                endif;
                
                break;
        endif;
        
        //SETA UM ERRO CASO O INPUT DE CALLBACK NÃO SEJA RECONHECIDO PELA FUNÇÃO DE CONDIÇÃO DO PHP, O 'CASE':
        default:
            $jSon['result'] = false;
            $jSon['trigger'] = AjaxErro("Ops ação não reconhecida.", E_USER_ERROR);
            break;

    endswitch;
endif;
//OBJETO JSON QUE SERÁ RETORNARDO PARA O ARQUIVOS "script.js":
sleep(2);
echo json_encode($jSon);
