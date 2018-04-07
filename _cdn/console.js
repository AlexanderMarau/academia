$(function(){
    //FORMULÁRIO DA ANAMNESE
    $('#novo-anamnese').click(function(){
        $('.anamnese-div').fadeIn(1000);
        $('#fechar-novo-anamnese').fadeIn(0);
        $('#novo-anamnese').fadeOut(0);
    });
    
    $('#fechar-novo-anamnese').click(function(){
       $('.anamnese-div').fadeOut(1000); 
       $('#fechar-novo-anamnese').fadeOut(0);
       $('#novo-anamnese').fadeIn(0);
    });
    //FORMULÁRIO DO ALUNO
    $('#novo-aluno').click(function(){
        $('.aluno-div').fadeIn(0);
        $('#fechar-aluno').fadeIn(0);
        $('#novo-aluno').fadeOut(0);
        $('#relatorio-aluno').fadeOut(0);
        $('.table-aluno').fadeOut(0);
    });
    
    $('#fechar-aluno').click(function(){
       $('.aluno-div').fadeOut(0); 
       $('#fechar-aluno').fadeOut(0);
       $('#novo-aluno').fadeIn(0);
       $('#relatorio-aluno').fadeIn(0);
       $('.table-aluno').fadeIn(0);
    });
    
    $('html').on('click', '.jedit-aluno', function(){
        $('.aluno-editar-div').fadeIn(0);
        $('#novo-aluno').fadeOut(0);
        $('#relatorio-aluno').fadeOut(0);
        $('#fechar-aluno-editar').fadeIn(0);
        $('.table-aluno').fadeOut(0);
    });
    
    $('#fechar-aluno-editar').click(function(){
       $('.aluno-editar-div').fadeOut(0);
       $('#novo-aluno').fadeIn(0);
       $('#relatorio-aluno').fadeIn(0);
       $('#fechar-aluno-editar').fadeOut(0);
       $('.table-aluno').fadeIn(0);
       $('.form-update').trigger('reset');
    });

    //FORMULÁRIO DE FUNCIONÁRIO
    $('#novo-funcionario').click(function(){
      $('.funcionario-div').fadeIn(1000);
      $('#fechar-funcionario').fadeIn(0);
      $('#novo-funcionario').fadeOut(0);
    });

    $('#fechar-funcionario').click(function(){
      $('.funcionario-div').fadeOut(1000);
      $('#fechar-funcionario').fadeOut(0);
      $('#novo-funcionario').fadeIn(0);
    });
    
    //FORMULÁRIO DE MENSALIDADES
    $('#nova-mensalidade').click(function(){
       $('.mensalidade-div').fadeIn(1000);
       $('#fechar-mensalidade').fadeIn(0);
       $('#nova-mensalidade').fadeOut(0);
    });
    
    $('#fechar-mensalidade').click(function(){
        $('.mensalidade-div').fadeOut(1000);
        $('#fechar-mensalidade').fadeOut(0);
        $('#nova-mensalidade').fadeIn(0);
    });
    
    //FORMULÁRIO DE TREINO
    $('#novo-treino').click(function(){
       $('.treino-div').fadeIn(1000);
       $('#fechar-treino').fadeIn(0);
       $('#novo-treino').fadeOut(0);
    });
    
    $('#fechar-treino').click(function(){
       $('.treino-div').fadeOut(1000);
       $('#fechar-treino').fadeOut(0);
       $('#novo-treino').fadeIn(0);
    });
    
    //FORMULÁRIO DE EQUIPAMENTOS
    $('#novo-equipamento').click(function(){
       $('.equipamento-div').fadeIn(1000);
       $('#fechar-equipamento').fadeIn(0);
       $('#novo-equipamento').fadeOut(0);
    });
    
    $('#fechar-equipamento').click(function(){
       $('.equipamento-div').fadeOut(1000);
       $('#fechar-equipamento').fadeOut(0);
       $('#novo-equipamento').fadeIn(0);
    });
    
    //FORMULÁRIO DE USUARIOS
    $('#novo-usuario').click(function(){
       $('.usuario-div').fadeIn(1000);
       $('#fechar-usuario').fadeIn(0);
       $('#novo-usuario').fadeOut(0);
    });
    
    $('#fechar-usuario').click(function(){
       $('.usuario-div').fadeOut(1000);
       $('#fechar-usuario').fadeOut(0);
       $('#novo-usuario').fadeIn(0);
    });
    
    //FORMULÁRIO DE PRODUTOS
    $('#novo-produto').click(function(){
       $('.produto-div').fadeIn(1000);
       $('#fechar-produto').fadeIn(0);
       $('#novo-produto').fadeOut(0);
    });
    
    $('#fechar-produto').click(function(){
       $('.produto-div').fadeOut(1000);
       $('#fechar-produto').fadeOut(0);
       $('#novo-produto').fadeIn(0);
    });
    
    //FORMULÁRIO DE FORNECEDORES
    $('#novo-fornecedor').click(function(){
       $('.fornecedor-div').fadeIn(1000);
       $('#fechar-fornecedor').fadeIn(0);
       $('#novo-fornecedor').fadeOut(0);
    });
    
    $('#fechar-fornecedor').click(function(){
       $('.fornecedor-div').fadeOut(1000);
       $('#fechar-fornecedor').fadeOut(0);
       $('#novo-fornecedor').fadeIn(0);
    });
    
    //FORMULÁRIO DE VENDAS
    $('#nova-venda').click(function(){
       $('.venda-div').fadeIn(0);
       $('#fechar-venda').fadeIn(0);
       $('#nova-venda').fadeOut(0);
       $('.venda-pesquisa').fadeOut(0);
       $('.venda-relatorio').fadeOut(0);
       $('.venda-lista').fadeOut(0);
    });
    
    $('#fechar-venda').click(function(){
       $('.venda-div').fadeOut(0);
       $('#fechar-venda').fadeOut(0);
       $('#nova-venda').fadeIn(0);
       $('.venda-pesquisa').fadeIn(0);
       $('.venda-relatorio').fadeIn(0);
       $('.venda-lista').fadeIn(0);
    });
});

