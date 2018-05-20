$(function (){
    //Botão de 'novo' registro ao cliclado executa essas funções
    $('html').on('click', '.open-modal-create', function(){
        $('.modal-create').fadeIn(0);
        $('.close-modal-create').fadeIn(0);
        $('.pesquisar').fadeOut(0);
        $('.open-modal-create').fadeOut(0);
        $('.relatorio-geral').fadeOut(0);
        $('.modal-table').fadeOut(0);
        $('.modal-select').fadeOut(0);
    });
    
    //Botão de 'fechar formulário' de INSERT ao clicado executa essas funções
    $('html').on('click', '.close-modal-create',function(){
       $('.modal-select').fadeIn(0); 
       $('.pesquisar').fadeIn(0);
       $('.open-modal-create').fadeIn(0);
       $('.relatorio-geral').fadeIn(0);
       $('.modal-table').fadeIn(0);
       $('.modal-create').fadeOut(0);
       $('.close-modal-create').fadeOut(0);
    });
    
    //Botão de 'editar' ao clicado executa essas funções
    $('html').on('click', '.open-modal-update', function(){
       $('.modal-update').fadeIn(0);
       $('.close-modal-update').fadeIn(0);
       $('.pesquisar').fadeOut(0);
       $('.open-modal-create').fadeOut(0);
       $('.relatorio-geral').fadeOut(0);
       $('.modal-table').fadeOut(0);
       $('.modal-select').fadeOut(0);
    });
    
    //Botão de 'fechar formulário' de UPDATE ao clicado executa essas funções
    $('html').on('click', '.close-modal-update', function(){
       $('.modal-select').fadeIn(0); 
       $('.pesquisar').fadeIn(0);
       $('.open-modal-create').fadeIn(0);
       $('.relatorio-geral').fadeIn(0);
       $('.modal-table').fadeIn(0);
       $('.close-modal-update').fadeOut(0);
       $('.modal-update').fadeOut(0);
    });
    
});