$(function () {
    
    //    AÇÃO PADRÃO DE FORMULÁRIO DE LOGIN:
    $('.pf_form').submit(function () {
        var Form = $(this);
        var Action = Form.find('input[name="callback"]').val();
        var Data = Form.serialize();
        
        $.ajax({
            url: "Controllers/controller.verificar_login.php",
            data: Data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                Form.find(".pf_load").fadeIn();
            },
            success: function (data) {
                if (data.result === false) {
                    $(".resultado_login").html(data.trigger);
                    $(".resultado_login").fadeIn();
                    setTimeout(function () {
                        $('.resultado_login').fadeOut();
                    }, 5000);
                }
                Form.find(".pf_load").fadeOut();
                if (data.result === true){
                    window.location.replace("http://localhost/academia/index");
                }
            }
        });
        return false;
   });
  
    $('.jwc_return').fadeOut();
    
    
    
});