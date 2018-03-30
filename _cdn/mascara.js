$(document).ready(function(){
        $('.input-peso-anamnese').mask('000.00', {reverse: true});
        $('.input-decimal').mask('00.00', {reverse: true});
        $('.nascimento').mask('00/00/0000');
        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('.telefoneC').mask('(00) 0 0000-0000');
        $('.telefoneR').mask('(00) 0000-0000');
        $('.moeda').mask('000.000.000.000.000,00', {reverse: true});
        $('.peso').mask('00,000', {reverse: true});
        $('.altura').mask('0.00', {reverse: true});
        $('.salario').mask('000.000.000.000.000,00', {reverse: true});
        $('.numero-series').mask('000 X 0000');
        });