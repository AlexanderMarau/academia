$(function () {

    //ROTINA PARA EDITAR MENSALIDADE:

    //Evento quando o botão editar mensalidade é clicado:
    $('html').on('click', '.j-open-modal-update-mensalidade', function(){
        let idmensalidade = $(this).attr('idmensalidade');
        let form = $(".j-form-update-mensalidade");
        form.find("input[name='idmensalidade']").val(idmensalidade);
        let dados = {callback: "consultar-dados-mensalidade", idmensalidade: idmensalidade};
        $.ajax({
            url: "Controllers/controller.mensalidade.php",
            data: dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if(data.dados_mensalidade){
                    let dados = data.dados_mensalidade;
                    form.find("select[name='idplano']").val(dados.idplano);
                    form.find("input[name='data_mens_pag']").val(dados.data_mens_pag);
                }
            }
        });
    });

    //Evento ao formulário de edição de mensalidade ser submetido:
    $(".j-form-update-mensalidade").submit(function(){
        let form = $(this);
        let dados = form.serialize();
        $.ajax({
            url: "Controllers/controller.mensalidade.php",
            data: dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if(data.sucesso){
                    alert(data.sucesso);
                    $('html').find("td[id='proximo_pag" + data.idmensalidade + "']").text(data.dt_vencimento);
                }
                if(data.error){
                    alert(data.error);
                }
            }
        });
        return false //Evita que o formulário faça uma nova requisição http.
    });


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
    $('html').on("click", '.estornar-pagamento', function () {

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