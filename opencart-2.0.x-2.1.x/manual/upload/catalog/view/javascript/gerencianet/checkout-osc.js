jQuery(document).ready(function($){
    if (billetActive=="1") {
        $('#collapse-payment-card').hide();
        $('#collapse-payment-billet').show();
        $('#paymentMethodBilletRadio').prop('checked', true);
        $('#paymentMethodCardRadio').prop('checked', false);
        $("#gn-billet-payment-option").removeClass('gn-osc-payment-option-unselected');
        $("#gn-billet-payment-option").addClass('gn-osc-payment-option-selected');
        $("#gn-card-payment-option").removeClass('gn-osc-payment-option-selected');
        $("#gn-card-payment-option").addClass('gn-osc-payment-option-unselected');
    } else if (billetActive=="0" && cardActive=="1") {
        $('#collapse-payment-card').show();
        $('#collapse-payment-billet').hide();
        $('#paymentMethodBilletRadio').prop('checked', false);
        $('#paymentMethodCardRadio').prop('checked', true);
        $("#gn-billet-payment-option").removeClass('gn-osc-payment-option-selected');
        $("#gn-billet-payment-option").addClass('gn-osc-payment-option-unselected');
        $("#gn-card-payment-option").removeClass('gn-osc-payment-option-unselected');
        $("#gn-card-payment-option").addClass('gn-osc-payment-option-selected');
    }

    if ($('#gn_billet_full_name').val()=="")  {
        if (typeof $('#billing_first_name').val() != "undefined")
            $('#gn_billet_full_name').val($('#billing_first_name').val());
        if (typeof $('#billing_last_name').val() != "undefined")
            $('#gn_billet_full_name').val($('#gn_billet_full_name').val() + " " + $('#billing_last_name').val());
    }
    if ($('#gn_billet_email').val()=="")
        $('#gn_billet_email').val($('#billing_email').val());
    if ($('#gn_billet_phone_number').val()=="")    
        $('#gn_billet_phone_number').val($('#billing_phone').val());
    if ($('#gn_billet_cpf').val()=="")
        $('#gn_billet_cpf').val($('#billing_cpf').val());
    if ($('#gn_billet_corporate_name').val()=="")
        $('#gn_billet_corporate_name').val($('#billing_company').val());
    if ($('#gn_billet_cnpj').val()=="")
        $('#gn_billet_cnpj').val($('#billing_cnpj').val());

    if ($('#gn_card_full_name').val()=="") {
        if (typeof $('#billing_first_name').val() != "undefined")
            $('#gn_card_full_name').val($('#billing_first_name').val());
        if (typeof $('#billing_last_name').val() != "undefined")
            $('#gn_card_full_name').val($('#gn_card_full_name').val() + " " + $('#billing_last_name').val());
    }

    if ($('#gn_card_email').val()=="")
        $('#gn_card_email').val($('#billing_email').val());
    if ($('#gn_card_phone_number').val()=="")    
        $('#gn_card_phone_number').val($('#billing_phone').val());
    if ($('#gn_card_cpf').val()=="")
        $('#gn_card_cpf').val($('#billing_cpf').val());
    if ($('#gn_card_corporate_name').val()=="")
        $('#gn_card_corporate_name').val($('#billing_company').val());
    if ($('#gn_card_cnpj').val()=="")
        $('#gn_card_cnpj').val($('#billing_cnpj').val());
    if ($('#gn_card_birth').val()=="")
        $('#gn_card_birth').val($('#billing_birthdate').val());
    if ($('#gn_card_street').val()=="")
        $('#gn_card_street').val($('#billing_address_1').val());
    if ($('#gn_card_street_number').val()=="")
        $('#gn_card_street_number').val($('#billing_number').val());
    if ($('#gn_card_neighborhood').val()=="")
        $('#gn_card_neighborhood').val($('#billing_neighborhood').val());
    if ($('#gn_card_complement').val()=="")
        $('#gn_card_complement').val($('#billing_address_2').val());
    if ($('#gn_card_zipcode').val()=="")
        $('#gn_card_zipcode').val($('#billing_postcode').val());
    if ($('#gn_card_city').val()=="")
        $('#gn_card_city').val($('#billing_city').val());
    if ($('#gn_card_state').val()=="")
        $('#gn_card_state').val($('#billing_state').val());

    validateBilletCustomerData();
    validateCardCustomerData();

    $('#billing_first_name').change(function() {
        $('#gn_billet_full_name').val($('#billing_first_name').val() + " " + $('#billing_last_name').val());
        $('#gn_card_full_name').val($('#billing_first_name').val() + " " + $('#billing_last_name').val());
    });

    $('#billing_last_name').change(function() {
        $('#gn_billet_full_name').val($('#billing_first_name').val() + " " + $('#billing_last_name').val());
        $('#gn_card_full_name').val($('#billing_first_name').val() + " " + $('#billing_last_name').val());
    });

    $('#billing_email').change(function() {
        $('#gn_billet_email').val($('#billing_email').val());
        $('#gn_card_email').val($('#billing_email').val());
    });

    $('#billing_phone').change(function() {
        $('#gn_billet_phone_number').val($('#billing_phone').val());
        $('#gn_card_phone_number').val($('#billing_phone').val());
    });

    $('#billing_cpf').change(function() {
        $('#gn_billet_cpf').val($('#billing_cpf').val());
        $('#gn_card_cpf').val($('#billing_cpf').val());
    });

    $('#billing_company').change(function() {
        $('#gn_billet_corporate_name').val($('#billing_company').val());
        $('#gn_card_corporate_name').val($('#billing_company').val());
    });

    $('#billing_cnpj').change(function() {
        $('#gn_billet_cnpj').val($('#billing_cnpj').val());
        $('#gn_card_cnpj').val($('#billing_cnpj').val());
    });

    $('#billing_birthdate').change(function() {
        $('#gn_card_birth').val($('#billing_birthdate').val());
    });

    $('#billing_address_1').change(function() {
        $('#gn_card_street').val($('#billing_address_1').val());
    });

    $('#billing_number').change(function() {
        $('#gn_card_street_number').val($('#billing_number').val());
    });

    $('#billing_neighborhood').change(function() {
        $('#gn_card_neighborhood').val($('#billing_neighborhood').val());
    });

    $('#billing_address_2').change(function() {
        $('#gn_card_complement').val($('#billing_address_2').val());
    });

    $('#billing_postcode').change(function() {
        $('#gn_card_zipcode').val($('#billing_postcode').val());
    });

    $('#billing_city').change(function() {
        $('#gn_card_city').val($('#billing_city').val());
    });

    $('#billing_state').change(function() {
        $('#gn_card_state').val($('#billing_state').val());
    });

    $('#gn-pay-billet-button').click(function(event){
        if($('#paymentMethodBilletRadio').is(':checked')) {
            $('#gn-pay-billet-button').prop("disabled",true);
            if (billetValidateFields()) {
                if (id_charge!=0) {
                    payBilletCharge();
                } else {
                    createCharge('billet');
                }
            } else {
                showError("Preencha corretamente os campos informados.");
                $('#gn-pay-billet-button').prop("disabled",false);
            }
        }
    });

    $('#gn-pay-card-button').click(function(event){
        if($('#paymentMethodCardRadio').is(':checked')) {
            $('#gn-pay-card-button').prop("disabled",true);
            if (cardValidateFields()) {
                if (id_charge!=0) {
                    payCardCharge();
                } else {
                    createCharge('card');
                }
            } else {
                showError("Preencha corretamente os campos informados.");
                $('#gn-pay-card-button').prop("disabled",false);
            }
        }
    });


    function createCharge(paymentType) {
        $('.gn-loading-request').fadeIn();

        var order_id = jQuery('input[name="wc_order_id"]').val(),
        data = {
            action: "create_charge",
            order_id: order_id
        };
        
        jQuery.ajax({
            url: 'index.php?route=payment/gerencianet/create_charge',
            type: 'POST',
            data: data,
            success: function(response) {
                var obj = $.parseJSON(response);
                if (obj.code==200) {
                    id_charge = obj.data.charge_id;
                    if (paymentType=='billet') {
                        payBilletCharge();
                    } else {
                        payCardCharge();
                    }
                } else {
                    $('#gn-pay-billet-button').prop("disabled",false);
                    //$('#gn-pay-billet-button').removeClass("gn-osc-button-disabled");
                    $('#gn-pay-card-button').prop("disabled",false);
                    //$('#gn-pay-card-button').removeClass("gn-osc-button-disabled");
                    $('.gn-loading-request').fadeOut();
                    showError('Ocorreu um erro ao tentar gerar a cobrança: <b>' + obj.message + '</b>');
                }
                
            },
            error: function(){
                alert("error ocurred");
            }
        });

        return false;
    }

    function payBilletCharge() {
        $('.gn-loading-request').fadeIn();

        var juridical;
        if($('#pay_billet_with_cnpj').attr('checked')) {
            juridical="1";
        } else {
            juridical="0";
        }

        var data = {
            action: "pay_billet",
            id_charge: id_charge,
            order_id: '',
            name: jQuery('#gn_billet_full_name').val(),
            cpf: jQuery('#gn_billet_cpf').val().replace(/[^\d]+/g,''),
            phone_number: jQuery('#gn_billet_phone_number').val().replace(/[^\d]+/g,''),
            cnpj: jQuery('#gn_billet_cnpj').val().replace(/[^\d]+/g,''),
            corporate_name: jQuery('#gn_billet_corporate_name').val(),
            pay_billet_with_cnpj: juridical
        };
        
        jQuery.ajax({
            url: 'index.php?route=payment/gerencianet/pay_billet',
            type: 'POST',
            data: data,
            success: function(response) {
                var obj = $.parseJSON(response);
                if (obj.code==200) {
                    var url = encodeURIComponent(obj.data.link);
                    var redirect = $('<form action="' + success_url + "&payment=billet&order=" + actual_order_id + "&charge=" + obj.data.charge_id + '" method="post">' +
                      '<input type="text" name="billet" value="' + url + '" />' +
                      '</form>');
                    $('body').append(redirect);
                    redirect.submit();
                } else {
                    $('#gn-pay-billet-button').prop("disabled",false);
                    //$('#gn-pay-billet-button').removeClass("gn-osc-button-disabled");
                    $('.form-group').show();
                    $('.gn-loading-request').fadeOut();
                    showError(obj.message);
                }
            },
            error: function(){
                alert("error ocurred");
            }
        });

        return false;

    }

    function payCardCharge() {

        $('.gn-loading-request').fadeIn();

        $('#gn-pay-card-button').prop("disabled",true);

        card_brand = $('input[name=gn_card_brand]:checked').val()
        card_number = $("#gn_card_number_card").val();
        card_cvv = $("#gn_card_cvv").val();
        expiration_month = $("#gn_card_expiration_month").val();
        expiration_year = $("#gn_card_expiration_year").val();

        var callback = function(error, response) {
          if(error) {
            
            showError("Os dados do cartão digitados são inválidos. Tente novamente.");
            $('#gn-pay-card-button').prop("disabled",false);
            //$('#gn-pay-card-button').removeClass("gn-osc-button-disabled");

            $('.gn-loading-request').fadeOut();

          } else {
            var dateBirth = $('#gn_card_birth').val().split("/");

            var juridical;
            if($('#pay_card_with_cnpj').attr('checked')) {
                juridical="1";
            } else {
                juridical="0";
            }

            var data = {
                action: "pay_card",
                id_charge: id_charge,
                name: jQuery('#gn_card_full_name').val(),
                cpf: jQuery('#gn_card_cpf').val().replace(/[^\d]+/g,''),
                phone_number: jQuery('#gn_card_phone_number').val().replace(/[^\d]+/g,''),
                cnpj: jQuery('#gn_card_cnpj').val().replace(/[^\d]+/g,''),
                corporate_name: jQuery('#gn_card_corporate_name').val(),
                pay_card_with_cnpj: juridical,
                payment_token: response.data.payment_token,
                birth: dateBirth[2] + "-" + dateBirth[1] + "-" + dateBirth[0],
                email: $('#gn_card_email').val(),
                street: $('#gn_card_street').val(),
                number: $('#gn_card_street_number').val(),
                neighborhood: $('#gn_card_neighborhood').val(),
                complement: $('#gn_card_complement').val(),
                zipcode: $('#gn_card_zipcode').val().replace(/[^\d]+/g,''),
                city: $('#gn_card_city').val(),
                state: $('#gn_card_state').val(),
                installments: $('#gn_card_installments').val()
            };
            
            jQuery.ajax({
                url: 'index.php?route=payment/gerencianet/pay_card',
                type: 'POST',
                data: data,
                success: function(response) {
                    var obj = $.parseJSON(response);
                    if (obj.code==200) {
                        window.location.href = success_url + "&payment=card&order=" + actual_order_id + "&charge=" + obj.data.charge_id;
                    } else {
                        $('#gn-pay-card-button').prop("disabled",false);
                       // $('#gn-pay-card-button').removeClass("gn-osc-button-disabled");
                        showError(obj.message);
                        $('.form-group').show();
                        $('.gn-loading-request').fadeOut();
                    }
                    
                },
                error: function(){
                    alert("error ocurred");
                }
            });
            return false;
          }
        };

        getPaymentToken({
          brand: card_brand,
          number: card_number,
          cvv: card_cvv,
          expiration_month: expiration_month,
          expiration_year: expiration_year
        }, callback);
    }



    $('#gn_billet_cnpj').change(function() {
        if (verifyCNPJ($('#gn_billet_cnpj').val())) {
            $('#gn_billet_cnpj').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_billet_cnpj').addClass("gn-inputs-error");
            showError("CNPJ inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_billet_corporate_name').change(function() {
        if (validateName($('#gn_billet_corporate_name').val())) {
            $('#gn_billet_corporate_name').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_billet_corporate_name').addClass("gn-inputs-error");
            showError("Razão Social inválida. Por favor, digite novamente.");
        }
    });

    $('#gn_billet_full_name').change(function() {
        if (validateName($('#gn_billet_full_name').val())) {
            $('#gn_billet_full_name').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_billet_full_name').addClass("gn-inputs-error");
            showError("Nome inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_billet_email').change(function() {
        if (validateEmail($('#gn_billet_email').val())) {
            $('#gn_billet_email').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_billet_email').addClass("gn-inputs-error");
            showError("Email inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_billet_cpf').change(function() {
        if (verifyCPF($('#gn_billet_cpf').val())) {
            $('#gn_billet_cpf').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_billet_cpf').addClass("gn-inputs-error");
            showError("CPF inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_billet_phone_number').change(function() {
        if (validatePhone($('#gn_billet_phone_number').val())) {
            $('#gn_billet_phone_number').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_billet_phone_number').addClass("gn-inputs-error");
            showError("Telefone inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_cnpj').change(function() {
        if (verifyCNPJ($('#gn_card_cnpj').val())) {
            $('#gn_card_cnpj').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_cnpj').addClass("gn-inputs-error");
            showError("CNPJ inválido. Por favor, digite novamente.");
        }
    });

     $('#gn_card_corporate_name').change(function() {
        if (validateName($('#gn_card_corporate_name').val())) {
            $('#gn_card_corporate_name').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_corporate_name').addClass("gn-inputs-error");
            showError("Razão Social inválida. Por favor, digite novamente.");
        }
    });

    $('#gn_card_full_name').change(function() {
        if (validateName($('#gn_card_full_name').val())) {
            $('#gn_card_full_name').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_full_name').addClass("gn-inputs-error");
            showError("Nome inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_email').change(function() {
        if (validateEmail($('#gn_card_email').val())) {
            $('#gn_card_email').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_email').addClass("gn-inputs-error");
            showError("Email inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_cpf').change(function() {
        if (verifyCPF($('#gn_card_cpf').val())) {
            $('#gn_card_cpf').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_cpf').addClass("gn-inputs-error");
            showError("CPF inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_phone_number').change(function() {
        if (validatePhone($('#gn_card_phone_number').val())) {
            $('#gn_card_phone_number').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_phone_number').addClass("gn-inputs-error");
            showError("Telefone inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_birth').change(function() {
        if (validateBirth($('#gn_card_birth').val())) {
            $('#gn_card_birth').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_birth').addClass("gn-inputs-error");
            showError("Data de nascimento inválida. Por favor, digite novamente.");
        }
    });

    $('#gn_card_street').change(function() {
        if (validateStreet($('#gn_card_street').val())) {
            $('#gn_card_street').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_street').addClass("gn-inputs-error");
            showError("Endereço inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_street_number').change(function() {
        if (validateStreetNumber($('#gn_card_street_number').val())) {
            $('#gn_card_street_number').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_street_number').addClass("gn-inputs-error");
            showError("Número do endereço inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_neighborhood').change(function() {
        if (validateNeighborhood($('#gn_card_neighborhood').val())) {
            $('#gn_card_neighborhood').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_neighborhood').addClass("gn-inputs-error");
            showError("Bairro inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_complement').change(function() {
        if (validateComplement($('#gn_card_complement').val())) {
            $('#gn_card_complement').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_complement').addClass("gn-inputs-error");
            showError("Complemento do endereço inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_city').change(function() {
        if (validateCity($('#gn_card_city').val())) {
            $('#gn_card_city').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_city').addClass("gn-inputs-error");
            showError("Cidade inválida. Por favor, digite novamente.");
        }
    });

    $('#gn_card_zipcode').change(function() {
        if (validateZipcode($('#gn_card_zipcode').val())) {
            $('#gn_card_zipcode').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_zipcode').addClass("gn-inputs-error");
            showError("CEP inválido. Por favor, digite novamente.");
        }
    });

    $('#gn_card_state').change(function() {
        if (validateState($('#gn_card_state').val())) {
            $('#gn_card_state').removeClass("gn-inputs-error");
            hideError();
        } else {
            $('#gn_card_state').addClass("gn-inputs-error");
            showError("Estado inválido. Por favor, selecione novamente.");
        }
    });


    function billetValidateFields() {
        errorMessage = "";

        if ($("#pay_billet_with_cnpj").is(':checked')) {
            if (verifyCNPJ($('#gn_billet_cnpj').val())) {
                $('#gn_billet_cnpj').removeClass("gn-inputs-error");
            } else {
                $('#gn_billet_cnpj').addClass("gn-inputs-error");
                errorMessage = "CNPJ inválido. Por favor, digite novamente.";
            }

            if (validateName($('#gn_billet_corporate_name').val())) {
                $('#gn_billet_corporate_name').removeClass("gn-inputs-error");
            } else {
                $('#gn_billet_corporate_name').addClass("gn-inputs-error");
                errorMessage = "Razão Social inválida. Por favor, digite novamente.";
            }
        }

        if (validateName($('#gn_billet_full_name').val())) {
            $('#gn_billet_full_name').removeClass("gn-inputs-error");
        } else {
            $('#gn_billet_full_name').addClass("gn-inputs-error");
            errorMessage = "Nome inválido. Por favor, digite novamente.";
        }

        if (validateEmail($('#gn_billet_email').val())) {
            $('#gn_billet_email').removeClass("gn-inputs-error");
        } else {
            $('#gn_billet_email').addClass("gn-inputs-error");
            errorMessage = "Email inválido. Por favor, digite novamente.";
        }

        if (verifyCPF($('#gn_billet_cpf').val())) {
            $('#gn_billet_cpf').removeClass("gn-inputs-error");
        } else {
            $('#gn_billet_cpf').addClass("gn-inputs-error");
            errorMessage = "CPF inválido. Por favor, digite novamente.";
        }

        if (validatePhone($('#gn_billet_phone_number').val())) {
            $('#gn_billet_phone_number').removeClass("gn-inputs-error");
        } else {
            $('#gn_billet_phone_number').addClass("gn-inputs-error");
            errorMessage = "Telefone inválido. Por favor, digite novamente.";
        }

        if (errorMessage!="") {
            showError(errorMessage);
            return false;
        } else {
            hideError();
            return true;
        }
    }

    function cardValidateFields() {
        errorMessage = "";

        if ($("#pay_card_with_cnpj").is(':checked')) {
            if (verifyCNPJ($('#gn_card_cnpj').val())) {
                $('#gn_card_cnpj').removeClass("gn-inputs-error");
            } else {
                $('#gn_card_cnpj').addClass("gn-inputs-error");
                errorMessage = "CNPJ inválido. Por favor, digite novamente.";
            }

            if (validateName($('#gn_card_corporate_name').val())) {
                $('#gn_card_corporate_name').removeClass("gn-inputs-error");
            } else {
                $('#gn_card_corporate_name').addClass("gn-inputs-error");
                errorMessage = "Razão Social inválida. Por favor, digite novamente.";
            }
        }

        if (validateName($('#gn_card_full_name').val())) {
            $('#gn_card_full_name').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_full_name').addClass("gn-inputs-error");
            errorMessage = "Nome inválido. Por favor, digite novamente.";
        }

        if (validateEmail($('#gn_card_email').val())) {
            $('#gn_card_email').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_email').addClass("gn-inputs-error");
            errorMessage = "Email inválido. Por favor, digite novamente.";
        }

        if (verifyCPF($('#gn_card_cpf').val())) {
            $('#gn_card_cpf').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_cpf').addClass("gn-inputs-error");
            errorMessage = "CPF inválido. Por favor, digite novamente.";
        }

        if (validatePhone($('#gn_card_phone_number').val())) {
            $('#gn_card_phone_number').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_phone_number').addClass("gn-inputs-error");
            errorMessage = "Telefone inválido. Por favor, digite novamente.";
        }

        if (validateBirth($('#gn_card_birth').val())) {
            $('#gn_card_birth').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_birth').addClass("gn-inputs-error");
            errorMessage = "Data de nascimento inválida. Por favor, digite novamente.";
        }

        if (validateStreet($('#gn_card_street').val())) {
            $('#gn_card_street').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_street').addClass("gn-inputs-error");
            errorMessage = "Endereço inválido. Por favor, digite novamente.";
        }

        if (validateStreetNumber($('#gn_card_street_number').val())) {
            $('#gn_card_street_number').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_street_number').addClass("gn-inputs-error");
            errorMessage = "Número do endereço inválido. Por favor, digite novamente.";
        }

        if (validateNeighborhood($('#gn_card_neighborhood').val())) {
            $('#gn_card_neighborhood').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_neighborhood').addClass("gn-inputs-error");
            errorMessage = "Bairro inválido. Por favor, digite novamente.";
        }

        if (validateCity($('#gn_card_city').val())) {
            $('#gn_card_city').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_city').addClass("gn-inputs-error");
            errorMessage = "Cidade inválida. Por favor, digite novamente.";
        }

        if (validateZipcode($('#gn_card_zipcode').val())) {
            $('#gn_card_zipcode').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_zipcode').addClass("gn-inputs-error");
            errorMessage = "CEP inválido. Por favor, digite novamente.";
        }

        if (validateState($('#gn_card_state').val())) {
            $('#gn_card_state').removeClass("gn-inputs-error");
        } else {
            $('#gn_card_state').addClass("gn-inputs-error");
            errorMessage = "Estado inválido. Por favor, selecione novamente.";
        }

        if (errorMessage!="") {
            showError(errorMessage);
            return false;
        } else {
            hideError();
            return true;
        }

    }

    function validateBilletCustomerData() {
        if (validateName($('#gn_billet_full_name').val())) {
            $('#gn_name_row').hide();
        } else {
            $('#gn_name_row').show();
        }

        if (validateEmail($('#gn_billet_email').val())) {
            $('#gn_email_row').hide();
        } else {
            $('#gn_email_row').show();
        }

        if (verifyCPF($('#gn_billet_cpf').val()) && validatePhone($('#gn_billet_phone_number').val())) {
            $('#gn_cpf_phone_row').hide();
        } else {
            $('#gn_cpf_phone_row').show();
        }
    }

    function validateCardCustomerData() {
        if (validateName($('#gn_card_full_name').val())) {
            $('#gn_card_name_row').hide();
        } else {
            $('#gn_card_name_row').show();
        }

        if (validateEmail($('#gn_card_email').val())) {
            $('#gn_card_email_row').hide();
        } else {
            $('#gn_card_email_row').show();
        }

        if (verifyCPF($('#gn_card_cpf').val()) && validatePhone($('#gn_card_phone_number').val())) {
            $('#gn_card_cpf_phone_row').hide();
        } else {
            $('#gn_card_cpf_phone_row').show();
        }

        if (validateBirth($('#gn_card_birth').val())) {
            $('#gn_card_birth_row').hide();
        } else {
            $('#gn_card_birth_row').show();
        }

        if (validateStreet($('#gn_card_street').val()) && validateStreetNumber($('#gn_card_street_number').val())) {
            $('#gn_card_street_number_row').hide();
        } else {
            $('#gn_card_street_number_row').show();
        }

        if (validateNeighborhood($('#gn_card_neighborhood').val()) ) {
            $('#gn_card_neighborhood_row').hide();
        } else {
            $('#gn_card_neighborhood_row').show();
        }

        if (validateCity($('#gn_card_city').val()) && validateZipcode($('#gn_card_zipcode').val())) {
            $('#gn_card_city_zipcode_row').hide();
        } else {
            $('#gn_card_city_zipcode_row').show();
        }

        if (validateState($('#gn_card_state').val())) {
            $('#gn_card_state_row').hide();
        } else {
            $('#gn_card_state_row').show();
        }

        if (validateStreet($('#gn_card_street').val()) && validateStreetNumber($('#gn_card_street_number').val()) && validateNeighborhood($('#gn_card_neighborhood').val()) && validateCity($('#gn_card_city').val()) && validateZipcode($('#gn_card_zipcode').val()) && validateState($('#gn_card_state').val())) {
            $('#billing-adress').hide();
        } else {
            $('#billing-adress').show();
        }

    }

    if ($('#billing_persontype').val()=="2") {
        $('#pay_cnpj').show();
        $('#pay_cnpj_card').show();
        $('#pay_billet_with_cnpj').prop( "checked", true );
        $('#pay_card_with_cnpj').prop( "checked", true );
    } else {
        $('#pay_cnpj').hide();
        $('#pay_cnpj_card').hide();
        $('#pay_billet_with_cnpj').prop( "checked", false );
        $('#pay_card_with_cnpj').prop( "checked", false );
    }

    $('#billing_persontype').on('change', function() {
        if (this.value==2) {
            $('#pay_cnpj').show();
            $('#pay_cnpj_card').show();
            $('#pay_billet_with_cnpj').prop( "checked", true );
            $('#pay_card_with_cnpj').prop( "checked", true );
        } else {
            $('#pay_cnpj').hide();
            $('#pay_cnpj_card').hide();
            $('#pay_billet_with_cnpj').prop( "checked", false );
            $('#pay_card_with_cnpj').prop( "checked", false );
        }
    });

    $('#pay_billet_with_cnpj').click(function() {
        if ($(this).is(':checked')) {
            $('#pay_cnpj').slideDown();
        } else {
            $('#pay_cnpj').slideUp();
        }
    });

    $('#pay_card_with_cnpj').click(function() {
        if ($(this).is(':checked')) {
            $('#pay_cnpj_card').slideDown();
        } else {
            $('#pay_cnpj_card').slideUp();
        }
    });

    $('input[type=radio][name=gn_card_brand]').change(function() {
        getInstallments(this.value);
    });

    function getInstallments(card_brand) {
        $('#gn_card_installments').html('<option value="">Aguarde, carregando...</option>').show();
        $.ajax({
            url: 'index.php?route=payment/gerencianet/get_installments',
            type: 'POST',
            data: 'brand=' + card_brand,
            success: function(response) {
                var obj = $.parseJSON(response);
                if (obj.code==200) {
                    var options = ''; 
                    for (var i = 0; i < obj.data.installments.length; i++) {
                        options += '<option value="' + obj.data.installments[i].installment + '">' + obj.data.installments[i].installment + 'x de R$' + obj.data.installments[i].currency + '</option>';
                    }   
                    $('#gn_card_installments').html(options).show();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    jQuery('#gn-billet-payment-option').click(function(e){
        $('#collapse-payment-card').hide();
        $('#collapse-payment-billet').show();
        $('#paymentMethodBilletRadio').prop('checked', true);
        $('#paymentMethodCardRadio').prop('checked', false);
        $("#gn-billet-payment-option").removeClass('gn-osc-payment-option-unselected');
        $("#gn-billet-payment-option").addClass('gn-osc-payment-option-selected');
        $("#gn-card-payment-option").removeClass('gn-osc-payment-option-selected');
        $("#gn-card-payment-option").addClass('gn-osc-payment-option-unselected');
    });

    jQuery('#gn-card-payment-option').click(function(e){
        $('#collapse-payment-card').show();
        $('#collapse-payment-billet').hide();
        $('#paymentMethodBilletRadio').prop('checked', false);
        $('#paymentMethodCardRadio').prop('checked', true);
        $("#gn-billet-payment-option").removeClass('gn-osc-payment-option-selected');
        $("#gn-billet-payment-option").addClass('gn-osc-payment-option-unselected');
        $("#gn-card-payment-option").removeClass('gn-osc-payment-option-unselected');
        $("#gn-card-payment-option").addClass('gn-osc-payment-option-selected');
    });

    if(jQuery.mask) {
        $(".cpf-mask").mask("999.999.999-99",{
            completed:function(){ 
                if (!verifyCPF(this.val())) {
                    showError('CPF inválido. Digite novamente.');
                } else {
                    hideError();
                }
            },placeholder:"___.___.___-__"});

        $(".cnpj-mask").mask("99.999.999/9999-99",{
            completed:function(){ 
                if (!verifyCNPJ(this.val())) {
                    showError('CNPJ inválido. Digite novamente.');
                } else {
                    hideError();
                }
            },placeholder:"__.___.___/____-__"});

        $(".phone-mask").focusout(function(){
            $(".phone-mask").unmask();
                var phone = $(".phone-mask").val().replace(/[^\d]+/g,'');
                if(phone.length > 10) {
                    $(".phone-mask").mask("(99) 99999-999?9");
                } else {
                    $(".phone-mask").mask("(99) 9999-9999?9");
                }
            }).trigger("focusout");

        $('.birth-mask').mask("99/99/9999",{
            completed:function(){ 
                if (!validateBirth(this.val())) {
                    showError('Data de nascimento inválida. Digite novamente.');
                } else {
                    hideError();
                }
            },placeholder:"__/__/____"});

        $('#input-payment-card-number').mask('9999999999999999?999',{placeholder:""});
        $('#input-payment-card-cvv').mask('999?99',{placeholder:""});

    }

    function validateName(data) {
        if (data) {
            if (data.length > 3) {
                return true;
            } else {
                return false;
            }
        }
    }

    function validateEmail(email) {
        if (email) {
            var pattern = new RegExp(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/);
            return pattern.test(email);
        } else {
            return false;
        }
    }

    function validatePhone(phone_number) {
        if (phone_number) {
            if (phone_number.length < 10) {
                return false; 
            } else {
                var pattern = new RegExp(/^[1-9]{2}9?[0-9]{8}$/);
                if (pattern.test(phone_number.replace(/[^\d]+/g,''))) {
                    return true; 
                } else {
                    return false; 
                }
            }
        }
    }

    function validateStreet(data) {
        if (data) {
            if (data.length<1 || data.length>200) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function validateStreetNumber(data) {
        if (data) {
            if (data.length<1 || data.length>55) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function validateNeighborhood(data) {
        if (data) {
            if (data.length<1 || data.length>255) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function validateComplement(data) {
        if (data) {
            if (data.length>55) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function validateState(data) {
        if (data) {
            var pattern = new RegExp(/^(?:A[CLPM]|BA|CE|DF|ES|GO|M[ATSG]|P[RBAEI]|R[JNSOR]|S[CEP]|TO)$/);
            if (!pattern.test(data)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function validateZipcode(data) {
        if (data) {
            if (data.replace(/[^\d]+/g,'').length!=8) {
                return false;
            } else {
                return true;
            }
        }
    }

    function validateCity(data) {
        if (data) {
            if (data.length<1 || data.length>255) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function verifyCPF(cpf) {
        if (cpf) {
            cpf = cpf.replace(/[^\d]+/g,'');
            
            if(cpf == '' || cpf.length != 11) return false;
            
            var resto;
            var soma = 0;
            
            if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999" || cpf == "12345678909") return false;
            
            for (i=1; i<=9; i++) soma = soma + parseInt(cpf.substring(i-1, i)) * (11 - i);
            resto = (soma * 10) % 11;
            
            if ((resto == 10) || (resto == 11))  resto = 0;
            if (resto != parseInt(cpf.substring(9, 10)) ) return false;
            
            soma = 0;
            for (i = 1; i <= 10; i++) soma = soma + parseInt(cpf.substring(i-1, i)) * (12 - i);
            resto = (soma * 10) % 11;
            
            if ((resto == 10) || (resto == 11))  resto = 0;
            if (resto != parseInt(cpf.substring(10, 11) ) ) return false;
            return true;
        } else {
            return false;
        }
    }

    function verifyCNPJ(cnpj) {
        if (cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g,'');

            if(cnpj == '' || cnpj.length != 14) return false;

            if (cnpj == "00000000000000" || cnpj == "11111111111111" || cnpj == "22222222222222" || cnpj == "33333333333333" || cnpj == "44444444444444" || cnpj == "55555555555555" || cnpj == "66666666666666" || cnpj == "77777777777777" || cnpj == "88888888888888" || cnpj == "99999999999999") return false;

            var tamanho = cnpj.length - 2
            var numeros = cnpj.substring(0,tamanho);
            var digitos = cnpj.substring(tamanho);
            var soma = 0;
            var pos = tamanho - 7;
            
            for (i = tamanho; i >= 1; i--) {
              soma += numeros.charAt(tamanho - i) * pos--;
              if (pos < 2)
                    pos = 9;
            }
            
            var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            
            if (resultado != digitos.charAt(0)) return false;

            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            
            for (i = tamanho; i >= 1; i--) {
              soma += numeros.charAt(tamanho - i) * pos--;
              if (pos < 2) pos = 9;
            }
            
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            
            if (resultado != digitos.charAt(1)) return false;

            return true; 
        } else {
            return false;
        }
    }

    function verifyPhone(phone_number) {
        if (phone_number) {
            if (phone_number.length < 14) {
                showError("O telefone informado é inválido.");
                return false; 
            } else {
                var pattern = new RegExp(/^[1-9]{2}9?[0-9]{8}$/);
                if (pattern.test(phone_number.replace(/[^\d]+/g,''))) {
                    hideError();
                    return true; 
                } else {
                    return false; 
                }
            }
        } else {
            return false;
        }
    }

    function validateBirth(birth) {
        if (birth) {
            var pattern = new RegExp(/^[12][0-9]{3}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12][0-9]|3[01])$/);
            var date = birth.split("/");
            return pattern.test(date[2] + "-" + date[1] + "-" + date[0]);
        } else {
            return false;
        }
    }

    function scrollToTop() {
        $("html, body").animate({ scrollTop: $("#wc-gerencianet-messages").offset().top-80 }, "slow");
    }

    function showError(message) {
        if (!$('.gn-osc-warning-payment').is(":visible")) {
            $('.gn-osc-warning-payment').slideDown();
        }
        scrollToTop();
        jQuery("#wc-gerencianet-messages").html( message )
    }

    function hideError() {
        $('.gn-osc-warning-payment').slideUp();
    }

    $( window ).resize(function() {
        fixScreenSize();
    });

    function fixScreenSize() {
        if($( "#gerencianet-container" ).width()<600) {
            $( "#gerencianet-container" ).addClass("gerencianet-container-fix-size");
        } else {
            $( "#gerencianet-container" ).removeClass("gerencianet-container-fix-size");
        }
    }
    fixScreenSize();

});
