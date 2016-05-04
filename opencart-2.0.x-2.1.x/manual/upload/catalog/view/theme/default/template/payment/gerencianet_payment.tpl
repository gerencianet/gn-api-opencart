<?php echo $header; ?>
<?php echo $scriptPaymentToken; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger" id="warning-payment"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">

    <div id="content" class="col-sm-12"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($total_value<5) { ?>
        <p>
            <?php echo $gn_minimum_value_of_charge; ?>
        </p>

      <?php } else { ?>
      <div class="panel-group">
        <?php if ($gerencianet_payment_option_billet && $total_with_discount>5) { ?>

        <div class="panel panel-default" id="billet-option">
          
            <div class='panel-title gn-row' id="background-billet" name="background-billet">
            <div class="gn-row-left panel-heading panel-gerencianet gn-accordion-option-background">
                <div id="billet-radio-button" class="gn-left">
                    <input type="radio" name="paymentMethodBilletRadio" id="paymentMethodBilletRadio" value="0" />
                </div>
                <div class="gn-left icon-gerencianet">
                    <span class="icon-icones-personalizados_boleto"></span>
                </div>
                <div class="gn-left payment-option-gerencianet">
                    
                </div>
                <div class="clear"></div>
            </div>
            <div class="gn-row-right">
                <div>
                    <div class="gn-left gn-price-payment-info">
                        <center><span class="payment-old-price-gerencianet"></span><br><span class="payment-discount-gerencianet"><b></b></span></center>
                    </div>
                    <div class="gn-right gn-price-payment-selected">
                        
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            </div>
            <div id="collapse-payment-billet" <?php if ($gerencianet_payment_option_card) { ?>class="gn-hide"<?php } ?> >
                <div class="panel-body gn-panel"></div>
              </div>

        </div>
        <?php } ?>
        <?php if ($gerencianet_payment_option_card) { ?>
        <div class="panel panel-default gn-row gn-row-payment-method" id="card-option">

          <div class='panel-title gn-row' id="background-card" name="background-card">
            <div class="gn-row-left panel-heading panel-gerencianet gn-accordion-option-background">
                <div id="card-radio-button" class="gn-left">
                    <input type="radio" name="paymentMethodCardRadio" id="paymentMethodCardRadio" value="0" />
                </div>
                <div class="gn-left icon-gerencianet">
                    <span class="icon-icones-personalizados_boleto"></span>
                </div>
                <div class="gn-left payment-option-gerencianet">
                    
                </div>
                <div class="clear"></div>
            </div>
            <div class="gn-row-right">
                <div>
                    <div class="gn-left gn-price-payment-info">
                        <center><span class="payment-old-price-gerencianet"></span><br><span class="payment-discount-gerencianet"><b></b></span></center>
                    </div>
                    <div class="gn-right gn-price-payment-selected">
                        
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            </div>
            <div id="collapse-payment-card" <?php if ($gerencianet_payment_option_billet) { ?>class="gn-hide"<?php } ?> >
                <div class="panel-body gn-panel"></div>
            </div>
        </div>
        <?php } ?>
        </div>

        <div id="price-billet" class="gn-hide">
            <table class="table table-bordered table-hover">
              <tfoot>
                <?php foreach ($totals_billet as $total) { ?>
                <tr>
                  <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
                  <td class="text-right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
              </tfoot>
            </table>

            <div>
                <div class="buttons gn-button-size">
                  <div class="pull-right">
                    <div id="button-payment-billet" class="btn btn-primary button-payment gn-button-pay" data-loading-text="<?php echo $gn_billet_button_continue_loading; ?>">
                        <div class="pull-left"><?php echo $gn_billet_button_continue; ?></div> <div class="gn-button-divisor"></div> <b><?php echo $total_paying_with_discount; ?></b>
                    </div>
                  </div>
                  <div class="pull-right gn-loading-request">
                      <div class="gn-loading-request-row">
                        <div class="pull-left gn-loading-request-text">
                        Aguarde um instante...
                        </div>
                        <div class="spin pull-left gn-loading-request-spin-box"><div class="icon-spinner6 gn-loading-request-spin-icon"></div></div>
                      </div>
                  </div>
                </div>
            </div>
        </div>

        <div id="price-card" class="gn-hide">
            <table class="table table-bordered table-hover">
              <tfoot>
                <?php foreach ($totals_card as $total) { ?>
                <tr>
                  <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
                  <td class="text-right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
              </tfoot>
            </table>
            <div>

                <div class="buttons gn-button-size">
                  <div class="pull-right">
                    <div id="button-payment-card" class="btn btn-primary button-payment gn-button-pay" data-loading-text="<?php echo $gn_card_payment_button_loading; ?>">
                        <div class="pull-left"><?php echo $gn_card_payment_button; ?></div> <div class="gn-button-divisor"></div> <b><?php echo $total_paying_without_discount; ?></b>
                    </div>
                  </div>
                  <div class="pull-right gn-loading-request">
                      <div class="gn-loading-request-row">
                        <div class="pull-left gn-loading-request-text">
                        Aguarde um instante...
                        </div>
                        <div class="spin pull-left gn-loading-request-spin-box"><div class="icon-spinner6 gn-loading-request-spin-icon"></div></div>
                      </div>
                  </div>
                </div>
            </div>
        </div>

        <div id="price-no-payment-selected">
            <table class="table table-bordered table-hover">
              <tfoot>
                <?php foreach ($totals_card as $total) { ?>
                <tr>
                  <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
                  <td class="text-right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
              </tfoot>
            </table>
            <div>
                <div class="buttons gn-button-size">
                  <div class="pull-right">
                    <input type="button" value="Selecione a forma de pagamento" class="btn btn-primary disabled" disabled="disabled" />
                  </div>
                </div>
            </div>
        </div>

      <?php } ?>
      <?php echo $content_bottom; ?></div>
      
    </div>
</div>
<script type="text/javascript"><!--
//v0.1.2.5
$(document).ready(function() {

    var active=0;

    $.ajax({
        url: 'index.php?route=payment/gerencianet/payment_billet_option',
        dataType: 'html',
        success: function(html) {
            $('#collapse-payment-billet .panel-body').html(html);

            $('.cpf-mask').mask('000.000.000-00', {
                onComplete: function(val, e, field, options) {
                    if (!verifyCPF(val)) {
                        $('.warning-payment').slideDown();
                        $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cpf; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
                        scrollToTop();
                    } else {
                        $('.warning-payment').slideUp();
                    }
                },
                placeholder: "___.___.___-__"
            });

            $('.cnpj-mask').mask('00.000.000/0000-00', {
                onComplete: function(val, e, field, options) {
                    if (!verifyCNPJ(val)) {
                        $('.warning-payment').slideDown();
                        $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cnpj; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
                        scrollToTop();
                    } else {
                        $('.warning-payment').slideUp();
                    }
                },
                placeholder: "__.___.___/____-__"
            });
            
            $('.phone-mask').mask('(00) 0000-00009', {
                onComplete: function(val, e, field, options) {
                    if (!verifyPhone(val)) {
                        $('.warning-payment').slideDown();
                        $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_phone_number; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
                    } else {
                        $('.warning-payment').slideUp();
                    }
                },
                placeholder: "(__) _____-____"
            });

            $('.birth-mask').mask('00/00/0000', {
                onComplete: function(val, e, field, options) {
                    if (!verifyBirthDate(val)) {
                        $('.warning-payment').slideDown();
                        $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_birth; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
                    } else {
                        $('.warning-payment').slideUp();
                    }
                },
                placeholder: "__/__/____"
            });

            $('#billet-option').html('<div id="background-billet" name="background-billet" class="gn-accordion-option-background">' +
                '<div class="gn-row-left panel-heading panel-gerencianet "' + 
                '>' +
                '<div id="billet-radio-button" class="gn-left">' +
                    '<input type="radio" name="paymentMethodBilletRadio" id="paymentMethodBilletRadio" value="0" />' +
                '</div>' +
                '<div class="gn-left icon-gerencianet">' +
                    '<span class="icon-icones-personalizados_boleto"></span>' +
                '</div>' +
                '<div class="gn-left payment-option-gerencianet">' +
                    '<?php echo $gn_pay_billet; ?>' +
                '</div>' +
                '<div class="clear"></div>' +
            '</div>' +
            '<div class="gn-row-right">' +
                '<div>' +
                    '<div class="gn-left gn-price-payment-info">' +
                        '<center><span class="payment-old-price-gerencianet"><?php if ($discount_span) { echo $total_paying_without_discount; } ?></span><br><span class="payment-discount-gerencianet"><b><?php echo $discount_span; ?></b></span></center>' +
                    '</div>' +
                    '<div class="gn-right gn-price-payment-selected total-gerencianet">' +
                       '<?php echo $total_paying_with_discount; ?>' +
                    '</div>' +
                    '<div class="clear"></div>' +
                '</div>' +
            '</div>' +
            '</div>' +
            '<div id="collapse-payment-billet" <?php if ($gerencianet_payment_option_card) { ?>class="gn-hide"<?php } ?>>' +
                '<div class="panel-body gn-panel">' + html + '</div>' +
            '</div>');

            $('#background-billet').click(function(e){
                if (active!=1) {
                    $('#collapse-payment-billet').slideDown();
                    $('#collapse-payment-card').slideUp();
                    $('#paymentMethodCardRadio').prop('checked', false);
                    $('#paymentMethodBilletRadio').prop('checked', true);
                    $("#background-card").css("background-color", "#ffffff");
                    $("#background-billet").css("background-color", "#f5f5f5");
                    $('#price-billet').show();
                    $('#price-card').hide();
                    $('#price-no-payment-selected').hide();
                    active = 1;
                } else {
                    $('#collapse-payment-billet').slideUp();
                    $('#paymentMethodCardRadio').prop('checked', false);
                    $('#paymentMethodBilletRadio').prop('checked', false);
                    $("#background-card").css("background-color", "#ffffff");
                    $("#background-billet").css("background-color", "#ffffff");
                    $('#price-billet').hide();
                    $('#price-no-payment-selected').show();
                    active = 0;
                }
            });

            $("#background-billet").css("background-color", "#FFFFFF");

            $('#pay_billet_with_cnpj').click(function() {
                if ($(this).is(':checked')) {
                    $('#pay_cnpj').slideDown();
                } else {
                    $('#pay_cnpj').slideUp();
                }
            });

            <?php 
            if (isset($gerencianet_payment_option_billet) && !isset($gerencianet_payment_option_card)) {?>
                $('#accordion-billet-click').click();
            <?php } ?>
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

    $.ajax({
        url: 'index.php?route=payment/gerencianet/payment_card_option',
        dataType: 'html',
        success: function(html) {
            $('#card-option').html('<div id="background-card" name="background-card" class="gn-accordion-option-background">' +
                '<div class="gn-row-left panel-heading panel-gerencianet "' + 
                '>' +
                '<div id="card-radio-button" class="gn-left">' +
                    '<input type="radio" name="paymentMethodCardRadio" id="paymentMethodCardRadio" value="0" />' +
                '</div>' +
                '<div class="gn-left icon-gerencianet">' +
                    '<span class="icon-credit-card2"></span>' +
                '</div>' +
                '<div class="gn-left payment-option-gerencianet">' +
                    '<?php echo $gn_pay_card; ?>' +
                '</div>' +
                '<div class="clear"></div>' +
            '</div>' +
            '<div class="gn-row-right">' +
                '<div>' +
                    '<div class="gn-left gn-price-payment-info">' +
                        '<center><span class="payment-installments-gerencianet">Pague em até</span><br><span class="payment-discount-gerencianet"><b><?php echo $max_installments; ?></b></span></center>' +
                    '</div>' +
                    '<div class="gn-right gn-price-payment-selected total-gerencianet">' +
                       '<?php echo $total_paying_without_discount; ?>' +
                    '</div>' +
                    '<div class="clear"></div>' +
                '</div>' +
            '</div>' +
            '</div>' +
            '<div id="collapse-payment-card" <?php if ($gerencianet_payment_option_billet) { ?>class="gn-hide"<?php } ?>>' +
                '<div class="panel-body gn-panel">' + html + '</div>' +
            '</div>');

            $('#background-card').click(function(e){
                if (active!=2) {
                    $('#collapse-payment-card').slideDown();
                    $('#collapse-payment-billet').slideUp();
                    $('#paymentMethodCardRadio').prop('checked', true);
                    $('#paymentMethodBilletRadio').prop('checked', false);
                    $("#background-card").css("background-color", "#f5f5f5");
                    $("#background-billet").css("background-color", "#ffffff");
                    $('#price-billet').hide();
                    $('#price-card').show();
                    $('#price-no-payment-selected').hide();
                    active = 2;
                } else {
                    $('#collapse-payment-card').slideUp();
                    $('#paymentMethodCardRadio').prop('checked', false);
                    $('#paymentMethodBilletRadio').prop('checked', false);
                    $("#background-card").css("background-color", "#ffffff");
                    $("#background-billet").css("background-color", "#ffffff");
                    $('#price-card').hide();
                    $('#price-no-payment-selected').show();
                    active = 0;
                }
            });


            $('#pay_card_with_cnpj').click(function() {
                if ($(this).is(':checked')) {
                    $('#pay_cnpj_card').slideDown();
                } else {
                    $('#pay_cnpj_card').slideUp();
                }
            });

            $('input[type=radio][name=input-payment-card-brand]').change(function() {
                getInstallments(this.value);
            });

            $('#input-payment-card-number').mask('0000000000000000000');
            $('#input-payment-card-cvv').mask('000000');

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});



var billingAddressShow=false;
function showBillingAdress() {
    if (!billingAddressShow) {
        $('.billing-address-data').slideDown();
        $('#showBillingAdress').html('<?php echo $gn_hide_shipping_data; ?>');

    } else {
        $('.billing-address-data').slideUp();
        $('#showBillingAdress').html('<?php echo $gn_show_shipping_data; ?>');
    }

    billingAddressShow=!billingAddressShow;
    
}

var id_charge = 0;
function createCharge(paymentType) {
    $('.gn-loading-request').fadeIn();
    $.ajax({
        url: 'index.php?route=payment/gerencianet/create_charge',
        type: 'POST',
        beforeSend: function() {
            $('.button-payment').button('loading');
        },
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
                $('.gn-loading-request').fadeOut();
                if (!$('.warning-payment').is(":visible")) {
                    $('.warning-payment').slideDown();
                    scrollToTop();
                }
                $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_charge_error; ?> <b>' + obj.message + '</b><button type="button" class="close" data-dismiss="alert">&times;</button>');
                $('.button-payment').button('reset');
            }
            

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }

    });
}


$(document).delegate('#button-payment-billet', 'click', function() {
    if (id_charge!=0) {
        payBilletCharge();
    } else {
        if (($("#pay_billet_with_cnpj").is(':checked') && verifyCNPJ($('#cnpj').val())) || !($("#pay_billet_with_cnpj").is(':checked'))) {
            if (($("#pay_billet_with_cnpj").is(':checked') && $('#corporate_name').val()!="") || !($("#pay_billet_with_cnpj").is(':checked'))) {
                if (verifyCPF($('#cpf').val())) {
                    if (verifyPhone($('#phone_number').val())) {
                        createCharge('billet');
                    }
                } else {
                    if (!$('.warning-payment').is(":visible")) {
                        $('.warning-payment').slideDown();
                        scrollToTop();
                    }
                    $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cpf; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
                }
            } else {
                if (!$('.warning-payment').is(":visible")) {
                    $('.warning-payment').slideDown();
                    scrollToTop();
                }
                $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_corporate_name; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
            }
        } else {
            if (!$('.warning-payment').is(":visible")) {
                $('.warning-payment').slideDown();
                scrollToTop();
            }
            $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cnpj; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
        }
    }
});


var errorMessage;
function validateCardFields() {
    errorMessage = '';
    if (!(($("#pay_card_with_cnpj").is(':checked') && verifyCNPJ($('#cnpj_card').val())) || !($("#pay_card_with_cnpj").is(':checked')))) {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cnpj; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if (!(($("#pay_card_with_cnpj").is(':checked') && $('#corporate_name_card').val()!="") || !($("#pay_card_with_cnpj").is(':checked')))) {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_corporate_name; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if (!(verifyCPF($('#input-payment-card-cpf').val()))) {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cpf; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if (!(verifyPhone($('#input-payment-card-phone').val()))) {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_phone_number; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if (!(verifyEmail($('#input-payment-card-email').val()))) {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_email; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if (!(verifyBirthDate($('#input-payment-card-birth').val()))) {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_birth; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-street').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_street; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-address-number').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_number; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-neighborhood').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_neighborhood; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-zipcode').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_cep; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-city').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_city; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-state').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_state; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('input[name=input-payment-card-brand]:checked', '#payment-card-form').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_card_brand; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-installments').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_card_installments; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-number').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_card_number; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-cvv').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_card_cvv; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    } else if ($('#input-payment-card-expiration-month').val()=="" || $('#input-payment-card-expiration-year').val()=="") {
        errorMessage = '<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_card_expiration; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>';
    }

    if (errorMessage!='') {
        showError(errorMessage);
        return false;
    } else {
        return true;
    }
}

function showError(message) {
    if (!$('.warning-payment').is(":visible")) {
        $('.warning-payment').slideDown();
    }
    scrollToTop();
    $('.warning-payment').html(message);
}

$(document).delegate('#button-payment-card', 'click', function() {
    if (validateCardFields()) {
        if (id_charge!=0) {
            payCardCharge();
        } else {
            createCharge('card');
        }
    }
});

function payBilletCharge() {
    $('.gn-loading-request').fadeIn();
    $.ajax({
        url: 'index.php?route=payment/gerencianet/pay_billet',
        type: 'POST',
        data: 'id_charge=' + id_charge + '& cpf='+ $('#cpf').val().replace(/[^\d]+/g,'') + '& first_name=' + $('#first_name').val() + '& phone_number=' + $('#phone_number').val().replace(/[^\d]+/g,'') + '& cnpj=' + $('#cnpj').val().replace(/[^\d]+/g,'') + '& corporate_name=' + $('#corporate_name').val() + '& pay_billet_with_cnpj=' + $('#pay_billet_with_cnpj').val(),
        beforeSend: function() {
            $('.button-payment').button('loading');
        },
        success: function(response) {
            var obj = $.parseJSON(response);
            if (obj.code==200) {
                var url = encodeURIComponent(obj.data.link);
                var redirect = $('<form action="' + "<?php echo $success_url; ?>&payment=billet&order=<?php echo $actual_order_id; ?>&charge=" + obj.data.charge_id + '" method="post">' +
                  '<input type="text" name="billet" value="' + url + '" />' +
                  '</form>');
                $('body').append(redirect);
                redirect.submit();
            } else {
                $('.warning-payment').slideDown();
                $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_charge_error; ?> <b>' + obj.message + '</b><button type="button" class="close" data-dismiss="alert">&times;</button>');
                scrollToTop();
                $('#button-payment-billet').button('reset');
                $('.form-group').show();
                $('.gn-loading-request').fadeOut();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}


function payCardCharge() {
    $('.button-payment').button('loading');
    $('.gn-loading-request').fadeIn();

    card_brand = $('input[name=input-payment-card-brand]:checked', '#payment-card-form').val()
    card_number = $("#input-payment-card-number").val();
    card_cvv = $("#input-payment-card-cvv").val();
    expiration_month = $("#input-payment-card-expiration-month").val();
    expiration_year = $("#input-payment-card-expiration-year").val();

    var callback = function(error, response) {
      if(error) {
        $('.warning-payment').slideDown();
        $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_pay_charge_card_error." ".$gn_pay_charge_card_error_generic; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
        scrollToTop();
        $('.button-payment').button('reset');
        $('.gn-loading-request').fadeOut();

      } else {
        var dateBirth = $('#input-payment-card-birth').val().split("/");

        $.ajax({
            url: 'index.php?route=payment/gerencianet/pay_card',
            type: 'POST',
            data: 'id_charge=' + id_charge + '& payment_token='+ response.data.payment_token + '& first_name='+  $('#input-payment-card-name').val() + '& cpf='+ $('#input-payment-card-cpf').val().replace(/[^\d]+/g,'') + '& phone_number=' + $('#input-payment-card-phone').val().replace(/[^\d]+/g,'') + '& birth='+  dateBirth[2] + "-" + dateBirth[1] + "-" + dateBirth[0]+ '& email='+  $('#input-payment-card-email').val() + '& street='+  $('#input-payment-card-street').val() + '& number='+  $('#input-payment-card-address-number').val() + '& neighborhood='+  $('#input-payment-card-neighborhood').val() + '& complement='+  $('#input-payment-card-complement').val() + '& zipcode='+  $('#input-payment-card-zipcode').val().replace(/[^\d]+/g,'') + '& city='+  $('#input-payment-card-city').val() + '& state='+  $('#input-payment-card-state').val() + '& installments='+  $('#input-payment-card-installments').val() + '& cnpj=' + $('#cnpj_card').val().replace(/[^\d]+/g,'') + '& corporate_name=' + $('#corporate_name_card').val() + '& pay_card_with_cnpj=' + $('#pay_card_with_cnpj').val(),
            beforeSend: function() {
                $('.button-payment').button('loading');
            },
            success: function(response) {
                var obj = $.parseJSON(response);
                if (obj.code==200) {
                    window.location.href = "<?php echo $success_url; ?>&payment=card&order=<?php echo $actual_order_id; ?>&charge=" + obj.data.charge_id;
                } else {
                    $('.warning-payment').slideDown();
                    $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i>  <?php echo $gn_pay_charge_card_error." ".$gn_pay_charge_card_error_generic_unknow; ?><button type="button" class="close" data-dismiss="alert">&times;</button>');
                    scrollToTop();
                    $('#button-payment-card').button('reset');
                    $('.form-group').show();

                    $('.gn-loading-request').fadeOut();

                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
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

function getInstallments(card_brand) {
    $('#input-payment-card-installments').html('<option value=""><?php echo $gn_loading_installments; ?></option>').show();
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
                $('#input-payment-card-installments').html(options).show();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function verifyCPF(cpf) {
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
}

function verifyCNPJ(cnpj) {
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
}

function verifyPhone(phone_number) {
    if (phone_number.length < 14) {
        if (!$('.warning-payment').is(":visible")) {
            $('.warning-payment').slideDown();
            scrollToTop();
        }
        $('.warning-payment').html('<i class="fa fa-exclamation-circle"></i> <?php echo $gn_invalid_phone_number; ?> <button type="button" class="close" data-dismiss="alert">&times;</button>');
        return false; 
    } else {
        var pattern = new RegExp(/^[1-9]{2}9?[0-9]{8}$/);
        if (pattern.test(phone_number.replace(/[^\d]+/g,''))) {
            $('.warning-payment').hide();
            return true; 
        } else {
            return false; 
        }
    }
}

function verifyEmail(email) {
    var pattern = new RegExp(/^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/);
    return pattern.test(email);
}

function verifyBirthDate(birth) {
    var pattern = new RegExp(/^[12][0-9]{3}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12][0-9]|3[01])$/);
    var date = birth.split("/");
    return pattern.test(date[2] + "-" + date[1] + "-" + date[0]);
}

function scrollToTop() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
}

var getPaymentToken;
$gn.ready(function(checkout) {

    getPaymentToken = checkout.getPaymentToken;
});

//--></script>
<?php echo $footer; ?>