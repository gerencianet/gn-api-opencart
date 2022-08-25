function validationForm(optionSelected, event) {

    switch (optionSelected) {
        case 'billet':
            validationBillet(event);
            break;
        case 'credit':
            validationCredit(event);
            break;
        case 'pix':
            validationPix(event);
            break;

        default:
            break;
    }

}

function validationBillet(event) {
    let erros = 0;
    $('.text-danger').remove();
    $('.form-payment-gerencianet input').css('border-color', 'rgb(204, 204, 204)');
    $('.form-payment-gerencianet select').css('border-color', 'rgb(204, 204, 204)');
    let documentClientBillet = $('#documentClientBillet').val().replaceAll('.', '').replace('-', '').replace('/', '');
    let clientEmailBillet = $('#emailBillet').val();
    let telephoneBillet = $('#billetTelefone').val().replace('(', '').replace(')', '').replace(' ', '').replace('-', '');
    let nomeCompleto = $('#nameBillet').val().split(' ').length >1 ? $('#nameBillet').val().split(' ')[$('#nameBillet').val().split(' ').length - 1]:'';
    let nameClient = {
        'value': nomeCompleto,
        'nome': 'Nome/Razão Social',
        'input': '#nameBillet'
    };
    if (documentClientBillet.length == 11) {
        if (!verifyCPF(documentClientBillet)) {
            event.preventDefault();
            erros++;

            $('#documentClientBillet').after('<p class="text-danger"> <strong>CPF inválido.</strong></p>');
            $('#documentClientBillet').css('border-color', '#a94442');
        }

    } else if (documentClientBillet.length == 14) {
        if (!verifyCNPJ(documentClientBillet)) {
            event.preventDefault();
            erros++;
            $('#documentClientBillet').after('<p class="text-danger"> <strong>CNPJ inválido.</strong></p>');
            $('#documentClientBillet').css('border-color', '#a94442');

        }
    } else {
        event.preventDefault();
        erros++;
        $('#documentClientBillet').after('<p class="text-danger"> <strong>Campo obrigatório.</strong></p>');
        $('#documentClientBillet').css('border-color', '#a94442');
    }
    if (clientEmailBillet.length > 0) {
        if (!verifyEmail(clientEmailBillet)) {
            event.preventDefault();
            erros++;
            $('#emailBillet').after('<p class="text-danger"><strong> Email inválido.</strong></p>');
            $('#emailBillet').css('border-color', '#a94442');
        }
    }
    if (telephoneBillet.length > 0) {
        if (!verifyPhone(telephoneBillet) || telephoneBillet.length < 10) {
            event.preventDefault();
            erros++;
            $('#billetTelefone').after('<p class="text-danger"><strong> Telefone inválido.</strong></p>');
            $('#billetTelefone').css('border-color', '#a94442');

        }
    }
    if (verifyInputsEmpty(nameClient).length > 0) {
        event.preventDefault();
        erros++;
    }
    if (erros == 0) {
        $('.form-payment-gerencianet :submit').prop('disabled',true);
    }
    



}

function validationCredit(event) {
    let erros = 0;
    $('.text-danger').remove();
    $('.form-payment-gerencianet input').css('border-color', 'rgb(204, 204, 204)');
    $('.form-payment-gerencianet select').css('border-color', 'rgb(204, 204, 204)');
    $('.form-payment-gerencianet select').css('border-color', 'rgb(204, 204, 204)');
    let documentClientCredit = $('#documentClientCredit').val().replaceAll('.', '').replace('-', '').replace('/', '');
    let clientEmailCredit = $('#emailCard').val();
    let telephoneCredit = $('#creditTelefone').val().replace('(', '').replace(')', '').replace(' ', '').replace('-', '');
    let birthDate = $('#data-nascimento').val();
    let cep = $('#creditAddCEP').val();
    
    let nameClient =  $('#nameCard').val().split(' ').length >1 ? $('#nameCard').val().split(' ')[$('#nameCard').val().split(' ').length - 1]:'';
    let rua = $('#creditAddRua').val();
    let numero = $('#creditAddNum').val();
    let bairro = $('#creditAddBairro').val();
    let cidade = $('#creditAddCidade').val();
    let numCartao = $('#creditAddNumCartao').val();
    let codSeguranca = $('#codSeguranca').val();
    let vencimeno = $('#creditValidadeCartao').val().length == 5?$('#creditValidadeCartao').val():'';
    
    let parcela = $('#parcelas option:selected').val();
    let estadoCliente = $("#creditAddEstado option:selected").val();

    let inputsEmpty = verifyInputsEmpty({
        'value': nameClient,
        'nome': 'Nome/Razão Social',
        'input': '#nameCard'
    }, {
        'value': rua,
        'nome': 'Rua',
        'input': '#creditAddRua'
    }, {
        'value': numero,
        'nome': 'Número',
        'input': '#creditAddNum'
    }, {
        'value': bairro,
        'nome': 'Bairro',
        'input': '#creditAddBairro'
    }, {
        'value': cidade,
        'nome': 'Cidade',
        'input': '#creditAddCidade'
    }, {
        'value': numCartao,
        'nome': 'Número do cartão',
        'input': '#creditAddNumCartao'
    }, {
        'value': codSeguranca,
        'nome': 'CVV',
        'input': '#codSeguranca'
    }, {
        'value': estadoCliente,
        'nome': 'Estado',
        'input': '#creditAddEstado'
    }, {
        'value': vencimeno,
        'nome': 'Data',
        'input': '#creditValidadeCartao'
    }, {
        'value': parcela,
        'nome': 'Parcelas',
        'input': '#parcelas'
    });

    if (inputsEmpty.length > 0) {
        event.preventDefault();
        erros++;
    }
    if (documentClientCredit.length == 11) {
        if (!verifyCPF(documentClientCredit)) {
            event.preventDefault();
            erros++;
            $('#documentClientCredit').after('<p class="text-danger"> <strong>CPF inválido.</strong></p>');
            $('#documentClientCredit').css('border-color', '#a94442');
        }

    } else if (documentClientCredit.length == 14) {
        if (!verifyCNPJ(documentClientCredit)) {
            event.preventDefault();
            erros++;
            $('#documentClientCredit').after('<p class="text-danger"><strong> CNPJ inválido.</strong> </p>');
            $('#documentClientCredit').css('border-color', '#a94442');
        }
    } else {
        event.preventDefault();
        erros++;
        $('#documentClientCredit').after('<p class="text-danger"><strong> Campo obrigatório.</strong></p>');
        $('#documentClientCredit').css('border-color', '#a94442');
    }
    if (!verifyEmail(clientEmailCredit)) {
        event.preventDefault();
        erros++;
        $('#emailCard').after('<p class="text-danger"><strong> Email inválido.</strong></p>');
        $('#emailCard').css('border-color', '#a94442');
    }
    if (!verifyPhone(telephoneCredit) || telephoneCredit.length < 10) {
        event.preventDefault();
        erros++;
        $('#creditTelefone').after('<p class="text-danger"><strong> Telefone inválido.</strong> </p>');
        $('#creditTelefone').css('border-color', '#a94442');

    }
    if (!verifyBirthDate(birthDate)) {
        event.preventDefault();
        erros++;
        $('.date').after('<p class="text-danger"><strong> Data de Nacimento invalida.</strong></p>');
        $('#data-nascimento').css('border-color', '#a94442');

    }
    if (!verifyZipCode(cep)) {
        event.preventDefault();
        erros++;
        $('#creditAddCEP').after('<p class="text-danger"><strong> CEP inválido.</strong></p>');
        $('#creditAddCEP').css('border-color', '#a94442');
    }
    if (erros == 0) {
        $('.form-payment-gerencianet :submit').prop('disabled',true);  
    }
    


}

function validationPix(event) {
    let erros = 0;
    $('.text-danger').remove();
    $('.form-payment-gerencianet input').css('border-color', 'rgb(204, 204, 204)');
    $('.form-payment-gerencianet select').css('border-color', 'rgb(204, 204, 204)');
    let valueName = $('#namePix').val().split(' ').length >1 ? $('#namePix').val().split(' ')[$('#namePix').val().split(' ').length - 1]:'';
    let documentClientPix = $('#documentClientPix').val().replaceAll('.', '').replace('-', '').replace('/', '');
    let nameClient = { 'value': valueName, 'nome': 'Nome/Razão Social', 'input': '#namePix' };
    if (documentClientPix.length == 11) {
        if (!verifyCPF(documentClientPix)) {
            event.preventDefault();
            erros++;
            $('#documentClientPix').after('<p class="text-danger"> <strong>CPF inválido.</strong></p>');
            $('#documentClientPix').css('border-color', '#a94442');
        }

    } else if (documentClientPix.length == 14) {
        if (!verifyCNPJ(documentClientPix)) {
            event.preventDefault();
            erros++;
            $('#documentClientPix').after('<p class="text-danger"><strong> CNPJ inválido.</strong> </p>');
            $('#documentClientPix').css('border-color', '#a94442');
        }
    } else {
        event.preventDefault();
        erros++;
        $('#documentClientPix').after('<p class="text-danger"><strong> Campo obrigatório.</strong></p>');
        $('#documentClientPix').css('border-color', '#a94442');
    }
    if (verifyInputsEmpty(nameClient).length > 0) {
        event.preventDefault();
        erros++;
    }
    if (erros == 0) {
        $('.form-payment-gerencianet :submit').prop('disabled',true);
    }
    
}

function verifyInputsEmpty(...inputs) {
    let verify = [];
    for (let index = 0; index < inputs.length; index++) {

        let element = inputs[index].value;
        if (element == '') {
            verify.push(1);
            $(inputs[index].input).after(`<p class="text-danger"><strong> ${inputs[index].nome} obrigatório.</strong></p>`);
            $(inputs[index].input).css('border-color', '#a94442');

        }
    }
    return verify;
}

function verifyCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');

    if (cpf == '' || cpf.length != 11)
        return false;



    var resto;
    var soma = 0;

    if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999" || cpf == "12345678909")
        return false;



    for (i = 1; i <= 9; i++)
        soma = soma + parseInt(cpf.substring(i - 1, i)) * (11 - i);



    resto = (soma * 10) % 11;

    if ((resto == 10) || (resto == 11))
        resto = 0;



    if (resto != parseInt(cpf.substring(9, 10)))
        return false;



    soma = 0;
    for (i = 1; i <= 10; i++)
        soma = soma + parseInt(cpf.substring(i - 1, i)) * (12 - i);



    resto = (soma * 10) % 11;

    if ((resto == 10) || (resto == 11))
        resto = 0;



    if (resto != parseInt(cpf.substring(10, 11)))
        return false;



    return true;
}

function verifyCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '' || cnpj.length != 14)
        return false;



    if (cnpj == "00000000000000" || cnpj == "11111111111111" || cnpj == "22222222222222" || cnpj == "33333333333333" || cnpj == "44444444444444" || cnpj == "55555555555555" || cnpj == "66666666666666" || cnpj == "77777777777777" || cnpj == "88888888888888" || cnpj == "99999999999999")
        return false;



    var tamanho = cnpj.length - 2
    var numeros = cnpj.substring(0, tamanho);
    var digitos = cnpj.substring(tamanho);
    var soma = 0;
    var pos = tamanho - 7;

    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;



    }

    var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    if (resultado != digitos.charAt(0))
        return false;



    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;

    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;



    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    if (resultado != digitos.charAt(1))
        return false;



    return true;
}

function verifyPhone(phone_number) {
    var pattern = new RegExp(/^[1-9]{2}9?[0-9]{8}$/);
    if (pattern.test(phone_number.replace(/[^\d]+/g, ''))) {
        return true;
    } else {
        return false;
    }

}

function verifyEmail(email) {
    var pattern = new RegExp(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/);
    return pattern.test(email);
}

function verifyZipCode(zipCode) {
    var objER = /^[0-9]{2}.[0-9]{3}-[0-9]{3}$/;

    if (zipCode.length > 0) {
        if (objER.test(zipCode))
            return true;
        else
            return false;



    } else
        return false;



}

function verifyBirthDate(birthDate) {
    var dataAtual = new Date();
    var anoAtual = dataAtual.getFullYear();
    var anoNascParts = birthDate.split('/');
    var diaNasc = anoNascParts[0];
    var mesNasc = anoNascParts[1];
    var anoNasc = anoNascParts[2];
    var idade = (anoNasc == "") ? 0 : anoAtual - anoNasc;
    var mesAtual = dataAtual.getMonth() + 1;
    // Se mes atual for menor que o nascimento, nao fez aniversario ainda;
    if (mesAtual < mesNasc) {
        idade--;
    } else { // Se estiver no mes do nascimento, verificar o dia
        if (mesAtual == mesNasc) {
            if (new Date().getDate() < diaNasc) { // Se a data atual for menor que o dia de nascimento ele ainda nao fez aniversario
                idade--;
            }
        }
    }
    if (idade >= 18) {
        return true;

    } else {
        return false;
    }
}

function scrollTop() {
    $(".form-payment-gerencianet").animate({ scrollTop: 0 }, 800)
}