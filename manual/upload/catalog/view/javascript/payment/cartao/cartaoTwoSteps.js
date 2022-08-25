$gn.ready(function (checkout) {
    $('#creditAddNumCartao').blur(() => {
        let numCartao = $('#creditAddNumCartao').val().replaceAll(' ', '');
        let bandeira = brandOption($('#creditAddNumCartao'));
        let totalPedido = parseFloat($('#totalPedido').val().replace(',','.')) * 100;
        if (brandOption($('#creditAddNumCartao')) != '' && brandOption($('#creditAddNumCartao')) != undefined && brandOption($('#creditAddNumCartao')) != null && numCartao.length >= 13) {
            checkout.getInstallments(Math.round(totalPedido), bandeira, function (error, response) {
                if (error) {
                    console.log(error)
                } else {
                    let installmentsOptions;
                    for (let i = 0; i < response.data.installments.length; i++) {
                        let juros = (((response.data.installments[i].value / 100) - 0.01) * (i + 1)) > parseFloat($('#totalPedido').val().replace(',','.'))? 'com juros' : 'sem juros';
                        installmentsOptions += `<option valor=${response.data.installments[i].value} value="${i + 1}">${i + 1}x de R$${response.data.installments[i].currency} ${juros}</option> `;
                    }
                    
                    if ($("#parcelas option:selected").val() == 1 || $("#parcelas option:selected").val() == '' || $("#parcelas option:selected").val() == 'Insira os dados do seu cartão...' ) {
                        $('#parcelas').html(installmentsOptions);
                        
                    }
                    
                    verifyPaymentToken(checkout);
                }
            })
        } else {
            $('#parcelas').html('<option>Insira os dados do seu cartão...</option>');
        }

    })
    

    $('#codSeguranca').keyup(() => {
        if ($('#codSeguranca').val().length == 3) {
            verifyPaymentToken(checkout);
        }

    });
    $('#creditValidadeCartao').keyup(() => {
        if ($('#creditValidadeCartao').val().length == 5) {
            verifyPaymentToken(checkout);
        }

    });

});




function verifyPaymentToken(checkout) {
    $('.payment_token').each((i, element) => {
        $(element).remove();
    })
    $('.card_invalid p').remove();
    $('#creditAddNumCartao').css('border-color', 'rgb(204, 204, 204)');
    var numCartao = $('#creditAddNumCartao').val().replaceAll(' ', '');
    let optionBrand = brandOption($('#creditAddNumCartao'));
    let brandOptionVerify = optionBrand != '' && optionBrand != undefined && optionBrand != null && numCartao.length >= 13;
    let codSeguranca = $('#codSeguranca').val().length >= 3;
    let mesVencimento = $('#creditValidadeCartao').val().split('/')[0].length == 2;
    let anoVencimento = $('#creditValidadeCartao').val().split('/').length > 1 ? $('#creditValidadeCartao').val().split('/')[1].length == 2 : false;
    let numParcelas = $('#parcelas').val().length > 0;
    if (brandOptionVerify && codSeguranca && mesVencimento && anoVencimento && numParcelas) {
        checkout.getPaymentToken({
            brand: optionBrand,
            number: $('#creditAddNumCartao').val().replaceAll(' ', ''),
            cvv: $('#codSeguranca').val(),
            expiration_month: $('#creditValidadeCartao').val().split('/')[0],
            expiration_year: $('#creditValidadeCartao').val().split('/')[1]
        }, (err, res) => {
            if (err == null) {
                var input = '';
                input = $("<input />", {
                    value: res.data.payment_token,
                    type: 'hidden',
                    name: 'payment_token',
                    class: 'payment_token'
                });
                $(".form-payment-gerencianet").append(input);
                $('.form-payment-gerencianet :submit').removeAttr('disabled');
            } else {
                $('#creditAddNumCartao').after(`<p class="text-danger"><strong> Número do cartão inválido.</strong></p>`);
                $('#creditAddNumCartao').css('border-color', '#a94442');
                $('.form-payment-gerencianet :submit').prop('disabled',true);
                
            }

        })
    }


}
function formatValue(value) {
    return Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' }).format(value);
}
