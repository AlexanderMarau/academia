$(function () {

    // ROTINA PARA GERAR PAGAMENTO:
    $('.gerar-pagamento').click(function(){
        var gerar = confirm("Deseja mesmo gerar o pagamento?");
        if(gerar){
            var idmensalidade = $(this).attr('j-id-mensalidade');
            var dados = {callback: 'pagar-mensalidade', idmensalidade: idmensalidade};
            $.ajax({
                url: "Controllers/controller.mensalidade.php",
                data: dados,
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr) {

                },
                success: function (data) {
                    if(data.sucesso){
                        alert(data.sucesso);
                    }
                }
            });
        }else{
            alert('cancelada');
        }
    });
});