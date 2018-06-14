$(function () {

    // ROTINA PARA GERAR PAGAMENTO:
    $('.gerar-pagamento').click(function () {
        var idmensalidade = $(this).attr('j-id-mensalidade');
        var gerar = confirm("Deseja mesmo gerar o pagamento?");
        if (gerar) {
            var dados = { callback: 'pagar-mensalidade', idmensalidade: idmensalidade };
            $.ajax({
                url: "Controllers/controller.mensalidade.php",
                data: dados,
                type: 'POST',
                dataType: 'json',
                beforeSend: function (xhr) {

                },
                success: function (data) {

                    if (data.sucesso) {
                        let comprovante = confirm("Mensalidade Paga! deseja imprimir o comprovante agora?");
                        if (comprovante) {
                            window.open("http://localhost/academia/Views/view.mensalidade.comprovante.php?idhist_pag=" + data.idHistorico);
                        }
                    }
                    if (data.novaDataMensalidade) {
                        //alterar data na view (Vencimento) com este dado (data.novaDataMensalidade).
                        $('html').find("td[id='proximo_pag" + idmensalidade + "']").text(data.novaDataMensalidade);
                        $('html').find("td[id='status" + idmensalidade + "']").text("Em Aberto").removeClass('red').removeClass('orange').addClass('blue');
                    }
                    if (data.ultimoPagamento) {
                        $('html').find("td[id='ultimo_pag" + idmensalidade + "']").text(data.ultimoPagamento);
                    }

                }
            });
        } else {
            alert('cancelada');
        }
    });

    // Rotina para verificar e atualizar status das mensalidades:
    function statusMensalidade () {
        
    }

    statusMensalidade();

    // Algoritmo para chamar a cada hora a rotina que atualiza o status das mensalidade: statusMensalidade()
    setInterval(()=>{

        statusMensalidade();

    }, ((1000 * 60) * 60));

});