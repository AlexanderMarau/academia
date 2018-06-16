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

    // ROTINA PARA ESTORNAR PAGAMENTO:
    $('.estornar-pagamento').on("click", function () {

        let idmensalidade = $(this).attr('idmensalidade');
        let idalunos_cliente = $(this).attr('idalunos_cliente');
        let dados = {callback: "estornar-mensalidade", idmensalidade: idmensalidade, idalunos_cliente: idalunos_cliente}
        $.ajax({
            url: "Controllers/controller.mensalidade.php",
            data: dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if(data.error){
                    alert(data.error);
                }
                if(data.a_sucesso){
                    alert(data.a_sucesso);
                    $('html').find("td[id='ultimo_pag" + idmensalidade + "']").text(data.a_dt_paga);
                    $('html').find("td[id='proximo_pag" + idmensalidade + "']").text(data.a_dt_vencimento);
                }
                if(data.a_Vencido){
                    $('html').find("td[id='status" + idmensalidade + "']").text('Vencido').removeClass('blue orange').addClass('red');
                }
                if(data.a_EmAberto){
                    $('html').find("td[id='status" + idmensalidade + "']").text('Em Aberto').removeClass('red orange').addClass('blue');
                }
                if(data.sucesso){
                    alert(data.sucesso);
                    $('html').find("td[id='proximo_pag" + idmensalidade + "']").text('nenhuma');
                    $('html').find("td[id='status" + idmensalidade + "']").text('Vencido').removeClass('blue orange').addClass('red');
                }
                if(data.primeiro){
                    $('html').find("td[id='ultimo_pag" + idmensalidade + "']").text('');
                }
            }
        });
        
    });

    // Rotina para verificar e atualizar status das mensalidades:
    function statusMensalidade() {

        let dados = { callback: "verificar-status", status: true };
        $.ajax({
            url: "Controllers/controller.mensalidade.php",
            data: dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                console.log(data);
            }
        });
    }
    statusMensalidade();
    // Algoritmo para chamar a cada hora a rotina que atualiza o status das mensalidade: statusMensalidade()
    setInterval(() => {

        statusMensalidade();

    }, ((1000 * 60) * 60));

});