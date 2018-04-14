//INICIAR JQUERY
$(function () {
    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP:
    $('.pesquisar-hist').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO REPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO USUÁRIO:
    $('.pesquisar-hist').keyup(function () {
        var termo = $(".pesquisar-hist").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.historico_mens.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $('.j-result-historico').html('');
                $(data).each(function (index, value) {
                    $('.j-result-historico').append(
                            "<tr id='" + value.idhist_pag + "'>" +
                            "<td>" + value.idhist_pag + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td>" + value.nome_plano + "</td>" +
                            "<td>" + value.data_mens_pag + "</td>" +
                            "<td>" + value.valor_pag + "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });
});


