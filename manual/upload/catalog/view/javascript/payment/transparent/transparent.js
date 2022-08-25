if ($("#gerencianetBoleto").length > 0) {
    $("#gerencianetBoleto").attr('checked', true);
} else if ($("#gerencianetCartao").length > 0) {
    $("#gerencianetCartao").attr('checked', true);
} else {
    $("#gerencianetPix").attr('checked', true);
}
$("#gerencianetCartao_click").click(() => {
    $('#creditAddNumCartao').val('');
    $("#gerencianetCartao").prop('checked', true);
    $("#billetSelected").fadeOut(0);
    $("#pixSelected").fadeOut(0);
    $("#creditSelected").show(700);
    verifyMinimumValue()

});
$("#gerencianetBoleto_click").click(() => {
    $('.form-payment-gerencianet :submit').removeAttr('disabled');
    verifyMinimumValue()
    $("#gerencianetBoleto").prop('checked', true);
    $("#creditSelected").fadeOut(0);
    $("#pixSelected").fadeOut(0);
    $("#billetSelected").show(700);

});
$("#gerencianetPix_click").click(() => {
    $('.form-payment-gerencianet :submit').removeAttr('disabled');

    $("#gerencianetPix").prop('checked', true);
    $("#creditSelected").fadeOut(0);
    $("#billetSelected").fadeOut(0);
    $("#pixSelected").show(700);

});
$("#creditSelected").css('display', 'none');
$("#pixSelected").css('display', 'none');
setTimeout(function () {


    $(".input-group.date").datepicker({ language: 'pt-BR' });
    $("#data-nascimento").datepicker({ language: 'pt-BR' });


    $('[data-toggle="tooltip"]').tooltip()
    maskDocumentInputsGerencianet(['#documentClientBillet', '#documentClientCredit', '#documentClientPix']);
    maskCreditCartInputGerencianet();
    maskTelefoneInputGerencianet(['#billetTelefone', '#creditTelefone']);
}, 1000);

function maskDocumentInputsGerencianet(masksDocument) {
    masksDocument.forEach((element) => {
        $(element).keydown(function () {
            try {
                $(element).unmask();
            } catch (e) { }

            var tamanho = $(element).val().length;

            if (tamanho < 13) {
                $(element).mask("999.999.999-999999");
            } else {
                $(element).mask("99.999.999/9999-99");
            }

            // ajustando foco
            var elem = this;
            setTimeout(function () { // mudo a posição do seletor
                elem.selectionStart = elem.selectionEnd = 10000;
            }, 0);
            // reaplico o valor para mudar o foco
            var currentValue = $(this).val();
            $(this).val('');
            $(this).val(currentValue);
        });
        $(element).on('paste', (e) => {
            try {
                $(element).unmask();
            } catch (e) { }

            var tamanho = e.originalEvent.clipboardData.getData('text').replaceAll('.', '').replaceAll('-', '').length;
            if (tamanho <= 11) {
                $(element).mask("999.999.999-99");
            } else {
                $(element).mask("99.999.999/9999-99");
            }

            // ajustando foco
            var elem = this;
            setTimeout(function () {
                // mudo a posição do seletor
                elem.selectionStart = elem.selectionEnd = 10000;
            }, 0);
            // reaplico o valor para mudar o foco
            var currentValue = $(this).val();
            $(this).val('');
            $(this).val(currentValue);
        })

    })
}

function maskCreditCartInputGerencianet() {
    $("#creditAddNumCartao").mask("0000 0000 0000 0000");
    $("#creditValidadeCartao").mask("00/00");
    $("#creditAddCEP").mask("99.999-999");
    $("#data-nascimento").mask("99/99/9999");

}

function maskTelefoneInputGerencianet(masksTelefone) {
    masksTelefone.forEach((element) => {
        $(element).mask("(00) 0000-00009");
    })
}


//        Máscaras do cartão


function tooltipHidePressKey(iputs) {

    $.each(iputs, function (index, input) {
        $(input.id).keyup(() => {
            $(input.id).tooltip('hide');
        });
        if (input.brand == true) {
            brandOption($(input.id));
        }
    });


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

function clearBrand() {
    $(".option-credit").each((indice, element) => {
        $(element).css({ "filter": "grayscale(1)" })
    })
}




$('.form-payment-gerencianet').submit((event) => {

    if ((verifyActivation('gerencianetBoleto')) ? document.getElementById('gerencianetBoleto').checked : false) {
        validationForm('billet', event)
    } else if ((verifyActivation('gerencianetPix')) ? document.getElementById('gerencianetPix').checked : false) {
        validationForm('pix', event)
    } else {
        validationForm('credit', event)
    }
})

function verifyActivation(name) {
    return document.getElementById(name) != null;
}

function verifyMinimumValue() {
    if ($('#totalPedido').val().replace(',', '.') < 5) {
        $('#billetSelected').html('<h4 class="text-justify   payment-description-title"><strong>Valor mínimo de compra para boleto: <span class="text-danger">R$5,00</span></strong></h4>');

        $('#creditSelected').html('<h4 class="text-justify   payment-description-title">	<strong>Valor mínimo de compra para cartão: <span class="text-danger">R$5,00</span></strong></h4>');
        $('.form-payment-gerencianet :submit').prop('disabled', true);

    } else {
        if ($('#gerencianetBoleto_click').length == 0) {
            $('#billetSelected').remove();
            $('#creditSelected').show();
        }
        if ($('#gerencianetCartao_click').length == 0) {
            $('#creditSelected').remove();
            $('#pixSelected').show();
        }
    }
    if ($('#gerencianetPix_click').length == 0) {
        $('#pixSelected').remove();
    }
}
verifyMinimumValue()
tooltipHidePressKey([{ id: "#creditAddNumCartao", brand: true }, { id: "#codSeguranca", brand:false }, { id: "#creditValidadeCartao", brand:false }])

