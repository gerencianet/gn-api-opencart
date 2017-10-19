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
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
    <div class="gn-reset">
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($total_value<5) { ?>
        <p>
            <?php echo $gn_minimum_value_of_charge; ?>
        </p>

      <?php } else { ?>

      <div class="panel-group">
        <?php if ($gerencianet_payment_option_billet && $total_with_discount>5) { ?>

        <div class="panel panel-default" id="billet-option">
          
            <div id="background-billet" name="background-billet" class="gn-accordion-option-background">
                <div class="gn-row-left panel-heading panel-gerencianet" >
                <div id="billet-radio-button" class="gn-left">
                    <input type="radio" name="paymentMethodBilletRadio" id="paymentMethodBilletRadio" value="0" />
                </div>
                <div class="gn-left gn-icon-gerencianet">
                    <span class="gn-icon-icones-personalizados_boleto"></span>
                </div>
                <div class="gn-left payment-option-gerencianet">
                    <?php echo $gn_pay_billet; ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="gn-row-right">
                <div>
                    <div class="gn-left gn-price-payment-info">
                        <center><span class="payment-old-price-gerencianet"><?php if ($discount_span) { echo $total_paying_without_discount; } ?></span><br><span class="payment-discount-gerencianet"><b><?php echo $discount_span; ?></b></span></center>
                    </div>
                    <div class="gn-right gn-price-payment-selected total-gerencianet">
                       <?php echo $total_paying_with_discount; ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            </div>
            <div id="collapse-payment-billet" <?php if ($gerencianet_payment_option_card) { ?>class="gn-hide"<?php } ?> >
                <div class="panel-body gn-panel">
                    
                    <?php if ($alert_sandbox) { ?>
                    <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $alert_sandbox; ?></div>
                    <?php } ?>
                    <div class="alert alert-warning warning-payment <?php if (!$error_warning) { ?> gn-hide <?php } ?>" ><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
                    <div class="alert alert-success success-payment gn-hide"></div>
                    <form class="form-horizontal">
                      <p><strong><?php echo $gn_billet_payment_method_comments; ?></strong></p>

                      <div class="gn-form">
                      <div id="billet-data">
                     
                        <div class="gn-row">
                          <div class="gn-col-12 gn-cnpj-row">
                          <input type="checkbox" name="pay_billet_with_cnpj" id="pay_billet_with_cnpj" value="1" />  <?php echo $gn_cnpj_option; ?>
                          </div>
                        </div>

                        <div id="pay_cnpj" class="required gn-row gn-hide">
                          <div class="gn-col-1">
                            <label class="gn-label" for="input-payment-billet-cnpj"><?php echo $gn_cnpj; ?></label>
                          </div>
                          <div class="gn-col-11">
                            
                            <div>
                              <div class="gn-col-3 required">
                                <input type="text" name="cnpj" id="cnpj" class="form-control cnpj-mask" />
                              </div>
                              <div class="gn-col-8">
                                <div class="required">
                                  <label class="gn-col-4 gn-label" for="input-payment-corporate-name"><?php echo $gn_corporate_name; ?></label>
                                  <div class="gn-col-8">
                                    <input type="text" name="corporate_name" id="corporate_name" placeholder="<?php echo $gn_corporate_name_placeholder; ?>" class="form-control" />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="required gn-row <?php if ($first_name) { ?> gn-hide <?php } ?>" >
                          <div class="gn-col-1">
                            <label class="gn-label" for="input-payment-billet-name"><?php echo $gn_name; ?></label>
                          </div>
                          <div class="gn-col-11">
                            <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" placeholder="<?php echo $gn_name_placeholder; ?>" class="form-control" />
                          </div>
                        </div>

                        <div class="required gn-row <?php if ($cpf) { ?> gn-hide <?php } ?>" >
                          <div class="gn-col-11">
  
                            <div>

                              <div id="gn-cpf-area">
                                <div class="gn-col-1">
                                  <label class="gn-label" for="input-payment-billet-cpf"><?php echo $gn_cpf; ?></label>
                                </div>
                                <div class="gn-col-3 required">
                                  <input type="text" name="cpf" id="cpf" value="<?php echo $cpf; ?>" placeholder="<?php echo $gn_cpf_placeholder; ?>" class="form-control cpf-mask" />
                                </div>
                              </div>

                              <div class="gn-col-8">
                                <div class=" required">
                                  <label class="gn-col-4 gn-label" for="input-payment-billet-phone"><?php echo $gn_phone; ?></label>
                                  <div class="gn-col-4">
                                    <input type="text" name="phone_number" id="phone_number" value="<?php echo $phone_number; ?>" placeholder="<?php echo $gn_phone_placeholder; ?>" class="form-control phone-mask" />
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>

                      </div>
                      </div>

                    </form>
                </div>
              </div>

        </div>
        <?php } ?>
        <?php if ($gerencianet_payment_option_card) { ?>
        <div class="panel panel-default gn-row gn-row-payment-method" id="card-option">

          <div id="background-card" name="background-card" class="gn-accordion-option-background">
                <div class="gn-row-left panel-heading panel-gerencianet" >
                <div id="card-radio-button" class="gn-left">
                    <input type="radio" name="paymentMethodCardRadio" id="paymentMethodCardRadio" value="0" />
                </div>
                <div class="gn-left gn-icon-gerencianet">
                    <span class="gn-icon-credit-card2"></span>
                </div>
                <div class="gn-left payment-option-gerencianet">
                    <?php echo $gn_pay_card; ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="gn-row-right">
                <div>
                    <div class="gn-left gn-price-payment-info">
                        <center><span class="payment-installments-gerencianet">Pague em até</span><br><span class="payment-discount-gerencianet"><b><?php echo $max_installments; ?></b></span></center>
                    </div>
                    <div class="gn-right gn-price-payment-selected total-gerencianet">
                       <?php echo $total_paying_without_discount; ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            </div>
            <div id="collapse-payment-card" <?php if ($gerencianet_payment_option_billet) { ?>class="gn-hide"<?php } ?> >
                <div class="panel-body gn-panel">
                    
                    <?php if ($alert_sandbox) { ?>
                <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $alert_sandbox; ?></div>
                <?php } ?>
                <div class="alert alert-warning warning-payment <?php if (!$error_warning) { ?> gn-hide <?php } ?>" ><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
                <div class="alert alert-success success-payment gn-hide"></div>
                <form class="form-horizontal" id="payment-card-form">
                    <p><strong><?php echo $gn_card_payment_comments; ?></strong></p>
                    
                    <div class="gn-form">
                    <div id="card-data" >
                        <div class="gn-initial-section">

                            <div class=" gn-row">
                              <div class="gn-col-12 gn-cnpj-row">
                              <input type="checkbox" name="pay_card_with_cnpj" id="pay_card_with_cnpj" value="1" />  <?php echo $gn_cnpj_option; ?>
                              </div>
                            </div>

                            <div id="pay_cnpj_card" class=" required gn-row gn-hide" >
                              <label class="gn-col-2 gn-label" for="input-payment-card-cnpj"><?php echo $gn_cnpj; ?></label>
                              <div class="gn-col-10">
                                
                                <div>
                                  <div class="gn-col-3 required">
                                    <input type="text" name="cnpj_card" id="cnpj_card" class="form-control cnpj-mask" />
                                  </div>
                                  <div class="gn-col-9">
                                    <div class=" required gn-left-space-2">
                                      <label class="gn-col-4 gn-label" for="input-payment-corporate-name"><?php echo $gn_corporate_name; ?></label>
                                      <div class="gn-col-8">
                                        <input type="text" name="corporate_name_card" id="corporate_name_card" placeholder="<?php echo $gn_corporate_name_placeholder; ?>" class="form-control" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class=" required gn-row <?php if ($first_name) { ?> gn-hide <?php } ?>" >
                              <div class="gn-col-2">
                                <label for="input-payment-card-name gn-label"><?php echo $gn_name; ?></label>
                              </div>
                              <div class="gn-col-10">
                                <input type="text" name="input-payment-card-name" id="input-payment-card-name" value="<?php echo $first_name; ?>" placeholder="<?php echo $gn_name_placeholder; ?>"  class="form-control" />
                              </div>
                            </div>

                            <div class=" required gn-row <?php if ($cpf && $phone_number && $birth) { ?> gn-hide <?php } ?>" >

                                <div id="gn-card-cpf-area">
                                  <label class="gn-col-2 gn-label" for="input-payment-card-cpf"><?php echo $gn_cpf; ?></label>
                                  <div class="gn-col-2">
                                      <input type="text" name="input-payment-card-cpf" id="input-payment-card-cpf" value="<?php echo $cpf; ?>" placeholder="<?php echo $gn_cpf_placeholder; ?>" class="form-control cpf-mask gn-minimum-size-field" />
                                  </div>
                                </div>

                                <div class="gn-col-2">
                                    <label class=" gn-left-space-2 gn-label" for="input-payment-card-phone"><?php echo $gn_phone; ?></label>
                                </div>
                                <div class="gn-col-2">
                                    <input type="text" name="input-payment-card-phone" value="<?php echo $phone_number; ?>" placeholder="<?php echo $gn_phone_placeholder; ?>" id="input-payment-card-phone" class="form-control phone-mask gn-minimum-size-field" />
                                </div>
                                <div class="gn-col-2">
                                    <label class=" gn-left-space-2 gn-label" for="input-payment-card-birth"><?php echo $gn_birth; ?></label>
                                </div>
                                <div class="gn-col-2">
                                    <input type="text" name="input-payment-card-birth" id="input-payment-card-birth" value="<?php echo $birth; ?>" placeholder="<?php echo $gn_birth_placeholder; ?>" class="form-control birth-mask" />
                                </div>
                            </div>

                            <div class=" required <?php if ($email) { ?> gn-hide <?php } ?>" >
                              <label class="gn-col-2 gn-label" for="input-payment-card-email"><?php echo $gn_email; ?></label>
                              <div class="gn-col-10">
                                <input type="text" name="input-payment-card-email" value="<?php echo $email; ?>" placeholder="<?php $gn_email_placeholder; ?>" id="input-payment-card-email" class="form-control" />
                              </div>
                            </div>
                        </div>

                        <div id="billing-adress" class="gn-section">
                            <p><strong><?php echo $gn_billing_address_title; ?></strong> <a id="showBillingAdress" onclick="showBillingAdress();" class="gn-cursor-pointer"><?php echo $gn_show_shipping_data; ?></a></p>

                            <div class="required gn-row">
                                <label class="gn-col-2 gn-label" for="input-payment-card-street"><?php echo $gn_street; ?></label>

                                <div class="gn-col-5 required">
                                    <input type="text" name="input-payment-card-address-street" id="input-payment-card-street" value="<?php echo $address1; ?>" placeholder="<?php echo $gn_street_placeholder; ?>" class="form-control" />
                                </div>
                                <div class="gn-col-5">
                                    <div class=" required gn-left-space-2">
                                      <label class="gn-col-5 gn-label" for="input-payment-card-address-number"><?php echo $gn_street_number; ?></label>
                                      <div class="gn-col-7">
                                        <input type="text" name="input-payment-card-address-number" id="input-payment-card-address-number" value="<?php echo $address2; ?>" placeholder="<?php echo $gn_street_number_placeholder; ?>" class="form-control" />
                                      </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="gn-row">
                                <div class="gn-col-2 required">
                                    <label class="gn-col-12 gn-label required" for="input-payment-card-neighborhood"><?php echo $gn_neighborhood; ?></label>
                                </div>
                        
                                <div class="gn-col-3">
                                    
                                    <input type="text" name="input-payment-card-neighborhood" id="input-payment-card-neighborhood" value="" placeholder="<?php echo $gn_neighborhood_placeholder; ?>" class="form-control" />
                                </div>
                                <div class="gn-col-7">
                                    <div class=" gn-left-space-2">
                                      <label class="gn-col-5 gn-label" for="input-payment-card-complement"><?php echo $gn_address_complement; ?></label>
                                      <div class="gn-col-7">
                                        <input type="text" name="input-payment-card-complement" id="input-payment-card-complement" value="" placeholder="<?php echo $gn_address_complement_placeholder; ?>" class="form-control" />
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="required billing-address-data gn-row <?php if ($zipcode && $city) { ?> gn-hide <?php } ?>" >
                                
                                <label for="input-payment-card-zipcode" class="gn-col-2 gn-label"><?php echo $gn_cep; ?></label>
                                
                                <div class="gn-col-10">
                                    <div class="gn-col-4 required">
                                        
                                        <input type="text" name="input-payment-card-zipcode" id="input-payment-card-zipcode" value="<?php echo $zipcode; ?>" placeholder="<?php echo $gn_cep_placeholder; ?>" class="form-control" />
                                    </div>
                                    <div class="gn-col-8">
                                        <div class=" required gn-left-space-2">
                                          <label class="gn-col-4 gn-label" for="input-payment-card-city"><?php echo $gn_city; ?></label>
                                          <div class="gn-col-6">
                                            <input type="text" name="input-payment-card-city" id="input-payment-card-city" value="<?php echo $city; ?>" placeholder="<?php echo $gn_city_placeholder; ?>" class="form-control" />
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" required billing-address-data gn-row <?php if ($state) { ?> gn-hide <?php } ?>" >
                              <label class="gn-col-2 gn-label" for="input-payment-card-state"><?php echo $gn_state; ?></label>
                              <div class="gn-col-10">
                                <select name="input-payment-card-state" id="input-payment-card-state" class="form-control gn-form-select">
                                  <option value=""><?php echo $gn_state_no_selected; ?></option> 
                                  <option value="AC" <?php if ($state=="AC" || $state=="Acre") { ?> selected <?php } ?>>Acre</option> 
                                  <option value="AL" <?php if ($state=="AL" || $state=="Alagoas") { ?> selected <?php } ?>>Alagoas</option> 
                                  <option value="AP" <?php if ($state=="AP" || $state=="Amapá") { ?> selected <?php } ?>>Amapá</option> 
                                  <option value="AM" <?php if ($state=="AM" || $state=="Amazonas") { ?> selected <?php } ?>>Amazonas</option> 
                                  <option value="BA" <?php if ($state=="BA" || $state=="Bahia") { ?> selected <?php } ?>>Bahia</option> 
                                  <option value="CE" <?php if ($state=="CE" || $state=="Ceará") { ?> selected <?php } ?>>Ceará</option> 
                                  <option value="DF" <?php if ($state=="DF" || $state=="Distrito Federal") { ?> selected <?php } ?>>Distrito Federal</option> 
                                  <option value="ES" <?php if ($state=="ES" || $state=="Espírito Santo") { ?> selected <?php } ?>>Espírito Santo</option> 
                                  <option value="GO" <?php if ($state=="GO" || $state=="Goiás") { ?> selected <?php } ?>>Goiás</option> 
                                  <option value="MA" <?php if ($state=="MA" || $state=="Maranhão") { ?> selected <?php } ?>>Maranhão</option> 
                                  <option value="MT" <?php if ($state=="MT" || $state=="Mato Grosso") { ?> selected <?php } ?>>Mato Grosso</option> 
                                  <option value="MS" <?php if ($state=="MS" || $state=="Mato Grosso do Sul") { ?> selected <?php } ?>>Mato Grosso do Sul</option> 
                                  <option value="MG" <?php if ($state=="MG" || $state=="Minas Gerais") { ?> selected <?php } ?>>Minas Gerais</option> 
                                  <option value="PA" <?php if ($state=="PA" || $state=="Pará") { ?> selected <?php } ?>>Pará</option> 
                                  <option value="PB" <?php if ($state=="PB" || $state=="Paraíba") { ?> selected <?php } ?>>Paraíba</option> 
                                  <option value="PR" <?php if ($state=="PR" || $state=="Paraná") { ?> selected <?php } ?>>Paraná</option> 
                                  <option value="PE" <?php if ($state=="PE" || $state=="Pernambuco") { ?> selected <?php } ?>>Pernambuco</option> 
                                  <option value="PI" <?php if ($state=="PI" || $state=="Piauí") { ?> selected <?php } ?>>Piauí</option> 
                                  <option value="RJ" <?php if ($state=="RJ" || $state=="Rio de Janeiro") { ?> selected <?php } ?>>Rio de Janeiro</option> 
                                  <option value="RN" <?php if ($state=="RN" || $state=="Rio Grande do Norte") { ?> selected <?php } ?>>Rio Grande do Norte</option> 
                                  <option value="RS" <?php if ($state=="RS" || $state=="Rio Grande do Sul") { ?> selected <?php } ?>>Rio Grande do Sul</option> 
                                  <option value="RO" <?php if ($state=="RO" || $state=="Rondônia") { ?> selected <?php } ?>>Rondônia</option> 
                                  <option value="RR" <?php if ($state=="RR" || $state=="Roraima") { ?> selected <?php } ?>>Roraima</option> 
                                  <option value="SC" <?php if ($state=="SC" || $state=="Santa Catarina") { ?> selected <?php } ?>>Santa Catarina</option> 
                                  <option value="SP" <?php if ($state=="SP" || $state=="São Paulo") { ?> selected <?php } ?>>São Paulo</option> 
                                  <option value="SE" <?php if ($state=="SE" || $state=="Sergipe") { ?> selected <?php } ?>>Sergipe</option> 
                                  <option value="TO" <?php if ($state=="TO" || $state=="Tocantins") { ?> selected <?php } ?>>Tocantins</option> 
                                </select>
                              </div>
                            </div>
                        </div>

                        <div class="gn-section">
                            <p><strong><?php echo $gn_card_title; ?></strong></p>

                            <div class="required gn-row">
                                <div>
                                <label class="" for="input-payment-card-brand"><?php echo $gn_card_brand; ?></label>
                                </div>
                                <div>
                                    <div class="gn-card-brand-selector">
                                        <input id="none" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="" checked class="gn-hide" />
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="visa" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="visa" class="gn-hide" />
                                            <label class="gn-card-brand gn-visa" for="visa"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="mastercard" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="mastercard" class="gn-hide" />
                                            <label class="gn-card-brand gn-mastercard" for="mastercard"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="amex" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="amex" class="gn-hide" />
                                            <label class="gn-card-brand gn-amex" for="amex"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="diners" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="diners" class="gn-hide" />
                                            <label class="gn-card-brand gn-diners" for="diners"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="discover" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="discover" class="gn-hide" />
                                            <label class="gn-card-brand gn-discover" for="discover"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="jcb" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="jcb" class="gn-hide" />
                                            <label class="gn-card-brand gn-jcb" for="jcb"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="elo" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="elo" class="gn-hide" />
                                            <label class="gn-card-brand gn-elo" for="elo"></label>
                                        </div>
                                        <div class="pull-left gn-card-brand-content">
                                            <input id="aura" type="radio" name="input-payment-card-brand" id="input-payment-card-brand" value="aura" class="gn-hide" />
                                            <label class="gn-card-brand gn-aura" for="aura"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" required">
                                    <div class="gn-col-5">
                                        <div>
                                            <?php echo $gn_card_number; ?>
                                        </div>
                                        <div>
                                            <div class="gn-card-number-icon-background">
                                                <span class="gn-icon-credit-card2 gn-card-number-icon"></span>
                                            </div>
                                            <div class="gn-card-number-input-row">
                                                <input type="text" name="input-payment-card-number" id="input-payment-card-number" value="" placeholder="" class="form-control gn-input-card-number" />
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="gn-col-3" sytle="overflow: auto;">
                                        <div>   
                                            <?php echo $gn_card_expiration; ?>
                                        </div>
                                        <div class="gn-card-expiration-row">
                                            <select class="form-control gn-card-expiration-select" name="input-payment-card-expiration-month" id="input-payment-card-expiration-month" >
                                                <option value=""> MM </option>
                                                <option value="01"> 01 </option>
                                                <option value="02"> 02 </option>
                                                <option value="03"> 03 </option>
                                                <option value="04"> 04 </option>
                                                <option value="05"> 05 </option>
                                                <option value="06"> 06 </option>
                                                <option value="07"> 07 </option>
                                                <option value="08"> 08 </option>
                                                <option value="09"> 09 </option>
                                                <option value="10"> 10 </option>
                                                <option value="11"> 11 </option>
                                                <option value="12"> 12 </option>
                                            </select>
                                            <div class="gn-card-expiration-divisor">
                                                /
                                            </div>
                                            <select class="form-control gn-card-expiration-select" name="input-payment-card-expiration-year" id="input-payment-card-expiration-year" >
                                                <option value=""> YYYY </option>
                                                <?php 
                                                $actual_year = intval(date("Y")); 
                                                $last_year = $actual_year + 15;
                                                for ($i = $actual_year; $i <= $last_year; $i++) {
                                                    echo '<option value="'.$i.'"> '.$i.' </option>';
                                                }
                                                ?>
                                            </select>
                                            <div></div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="gn-col-4">
                                        <div>
                                            <?php echo $gn_card_cvv; ?>
                                        </div>
                                        <div>
                                            <div class="pull-left gn-cvv-row">
                                                <input type="text" name="input-payment-card-cvv" id="input-payment-card-cvv" value="" class="form-control gn-cvv-input" />
                                            </div>
                                            <div class="pull-left">
                                                <div class="gn-cvv-info">
                                                    <div class="pull-left gn-icon-card-input">
                                                    </div>
                                                    <div class="pull-left">
                                                        São os três últimos<br>dígitos no verso do cartão.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                            </div>

                            <div class=" required">
                                <div class="gn-col-12">
                                    <label class="" for="input-payment-card-installments"><?php echo $gn_card_installments_options; ?></label>
                                </div>
                                <div class="gn-col-12">
                                    <select name="input-payment-card-installments" id="input-payment-card-installments" class="form-control gn-form-select">
                                        <option value=""><?php echo $gn_card_installments_options_no_selected; ?></option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                  </div>

                </div>
                </form>

                </div>
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
                        <div class="spin pull-left gn-loading-request-spin-box"><div class="gn-icon-spinner6 gn-loading-request-spin-icon"></div></div>
                      </div>
                  </div>
                </div>
            </div>
        </div>

        <div id="price-card" class="gn-hide">
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
                        <div class="spin pull-left gn-loading-request-spin-box"><div class="gn-icon-spinner6 gn-loading-request-spin-icon"></div></div>
                      </div>
                  </div>
                </div>
            </div>
        </div>

        <div id="price-no-payment-selected">
            <div>
                <div class="buttons gn-button-size">
                  <div class="pull-right">
                    <input type="button" value="Selecione a forma de pagamento" class="btn btn-primary disabled" disabled="disabled" />
                  </div>
                </div>
            </div>
        </div>

      <?php } ?>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
//v0.1.2.7
$(document).ready(function() {

    var active=0;

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
            $('#gn-cpf-area').hide();
        } else {
            $('#pay_cnpj').slideUp();
            $('#gn-cpf-area').show();
        }
    });

    <?php 
    if (isset($gerencianet_payment_option_billet) && !isset($gerencianet_payment_option_card)) {?>
        $('#accordion-billet-click').click();
    <?php } ?>
            

    

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
                    $('#gn-card-cpf-area').hide();
                } else {
                    $('#pay_cnpj_card').slideUp();
                    $('#gn-card-cpf-area').show();
                }
            });

            $('input[type=radio][name=input-payment-card-brand]').change(function() {
                getInstallments(this.value);
            });

            $('#input-payment-card-number').mask('0000000000000000000');
            $('#input-payment-card-cvv').mask('000000');

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
        url: 'index.php?route=extension/payment/gerencianet/create_charge',
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
                if (verifyCPF($('#cpf').val())  || ($("#pay_billet_with_cnpj").is(':checked'))) {
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
    } else if (!(verifyCPF($('#input-payment-card-cpf').val())) && !($("#pay_card_with_cnpj").is(':checked'))) {
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
        url: 'index.php?route=extension/payment/gerencianet/pay_billet',
        type: 'POST',
        data: 'id_charge=' + id_charge + '& cpf='+ $('#cpf').val().replace(/[^\d]+/g,'') + '& first_name=' + $('#first_name').val() + '& phone_number=' + $('#phone_number').val().replace(/[^\d]+/g,'') + '& cnpj=' + $('#cnpj').val().replace(/[^\d]+/g,'') + '& corporate_name=' + $('#corporate_name').val() + '& pay_billet_with_cnpj=' + $('#pay_billet_with_cnpj').val(),
        beforeSend: function() {
            $('.button-payment').button('loading');
        },
        success: function(response) {
            var obj = $.parseJSON(response);
            if (obj.code==200) {
                window.location.href = "<?php echo $success_url; ?>&payment=billet&order=<?php echo $actual_order_id; ?>&charge=" + obj.data.charge_id;
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
            url: 'index.php?route=extension/payment/gerencianet/pay_card',
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
        url: 'index.php?route=extension/payment/gerencianet/get_installments',
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