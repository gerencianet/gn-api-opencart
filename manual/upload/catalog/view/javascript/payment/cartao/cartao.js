$gn.ready(function (checkout) {
    $('#creditAddNumCartao').blur(() => {
        let numCartao = $('#creditAddNumCartao').val().replaceAll(' ', '');
        let bandeira = brandOption($('#creditAddNumCartao'));
        let totalPedido = parseFloat($('#totalPedido').val().replace(',','.'))* 100;
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
                   
                    if ($("#parcelas option:selected").val() == 1 || $("#parcelas option:selected").val() == '' || $("#parcelas option:selected").val() == 'Insira os dados do seu cartão...'  ) {
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
let brandOption = (element) => {
    var numCartao = element.val().replaceAll(' ', '');
    let brand = '';
    if (numCartao.length >= 8) { // MASTERCARD
        var regexMastercard = /^((5(([1-2]|[4-5])[0-9]{8}|0((1|6)([0-9]{7}))|3(0(4((0|[2-9])[0-9]{5})|([0-3]|[5-9])[0-9]{6})|[1-9][0-9]{7})))|((508116)\\d{4,10})|((502121)\\d{4,10})|((589916)\\d{4,10})|(2[0-9]{15})|(67[0-9]{14})|(506387)\\d{4,10})/;
        var resMastercard = regexMastercard.exec(numCartao);
        if (resMastercard) {
            clearBrand()
            $("#masterCard").css({ "filter": "grayscale(0)" })
            brand = 'mastercard';
        }
        // ELO
        var regexELO = /^4011(78|79)|^43(1274|8935)|^45(1416|7393|763(1|2))|^50(4175|6699|67[0-6][0-9]|677[0-8]|9[0-8][0-9]{2}|99[0-8][0-9]|999[0-9])|^627780|^63(6297|6368|6369)|^65(0(0(3([1-3]|[5-9])|4([0-9])|5[0-1])|4(0[5-9]|[1-3][0-9]|8[5-9]|9[0-9])|5([0-2][0-9]|3[0-8]|4[1-9]|[5-8][0-9]|9[0-8])|7(0[0-9]|1[0-8]|2[0-7])|9(0[1-9]|[1-6][0-9]|7[0-8]))|16(5[2-9]|[6-7][0-9])|50(0[0-9]|1[0-9]|2[1-9]|[3-4][0-9]|5[0-8]))/;
        var resELO = regexELO.exec(numCartao);
        if (resELO) {
            clearBrand()
            $("#elo").css({ "filter": "grayscale(0)" })
            brand = 'elo';
        }
        // AMEX
        var regexAmex = /^3[47][0-9]{13}$/;
        var resAmex = regexAmex.exec(numCartao);
        if (resAmex) {
            clearBrand()
            $("#americanExpress").css({ "filter": "grayscale(0)" })
            brand = 'amex';
        }

        // Hipercard
        var regexHipercard = /^606282|^3841(?:[0|4|6]{1})0/;
        var resHipercard = regexHipercard.exec(numCartao);
        if (resHipercard) {
            clearBrand()
            $("#hiperCard").css({ "filter": "grayscale(0)" })
            brand = 'hipercard';
        }

        // Visa
        var regexVisa = /^4[0-9]{15}$/;
        var resVisa = regexVisa.exec(numCartao);
        if (resVisa) {
            clearBrand()
            $("#visa").css({ "filter": "grayscale(0)" })
            brand = 'visa'
        }

    } else {
        clearBrand();
    }
    return brand;
}
function formatValue(value) {
    return Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' }).format(value);
}
