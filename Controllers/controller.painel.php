<?php

//IMPORTA O ARQUIVO DE CONFIGURAÇÃO:
require '../_app/Config.inc.php';

//Query de Consulta de alunos Ativos:
$AlunosAtivos = new Read;
$AlunosAtivos->FullRead("select idalunos_cliente FROM alunos_cliente WHERE status_aluno = 'Ativo'");
$AlunosAtivos->getResult();

//Query de Consulta de alunos Inativos:

$AlunosInativos = new Read;
$AlunosInativos->FullRead("select idalunos_cliente FROM alunos_cliente WHERE status_aluno = 'Inativo'");
$AlunosInativos->getResult();
