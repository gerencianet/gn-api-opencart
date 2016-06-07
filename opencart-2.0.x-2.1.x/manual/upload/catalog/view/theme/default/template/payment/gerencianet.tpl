<?php if ($checkout_type == "default") { ?>
<form action="<?php echo $action; ?>" method="post">
  <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
    </div>
  </div>
</form>
<?php } else { ?>

<div id="gerencianet-container">
    <?php if ($sandbox) { ?>
    <div class="gn-osc-attention-payment" id="wc-gerencianet-messages-sandbox" style="display: block;">
        <div>O modo Sandbox (Ambiente de testes) está ativo. Suas cobranças não serão validadas.</div>
    </div>
    <?php } ?>

    <div class="gn-osc-warning-payment" id="wc-gerencianet-messages">
        <?php if (($card_option && $order_total_card<500) && ($billet_option && $order_total_billet<500)) { ?>
            <div>O valor mínimo para pagar com a Gerencianet é de R$5,00.</div>
        <?php } ?>
    </div>

    <div style="margin: 5px 0px -2px 0px;">
        <?php if ($billet_option && $order_total_billet>=500) { ?>
        <div id="gn-billet-payment-option" class="gn-osc-payment-option gn-osc-payment-option-selected">
            <div>
                <div id="billet-radio-button" class="gn-osc-left">
                    <input type="radio" name="paymentMethodRadio" id="paymentMethodBilletRadio" class="gn-osc-radio" value="billet" checked="true" />
                </div>
                <div class="gn-osc-left gn-osc-icon-gerencianet">
                    <span class="gn-icon-icones-personalizados_boleto"></span>
                </div>
                <div class="gn-osc-left gn-osc-payment-option-gerencianet">
                    <strong><?php echo "Pagar com Boleto Bancário"; ?></strong>
                    <?php if ($discount>0) { ?>
                        <span style="font-size: 14px; line-height: 15px;"><br><?php echo $discount_formatted; ?> de desconto</span>
                    <?php } ?>
                </div>
                <div class="gn-osc-left gn-osc-payment-option-sizer"></div>
                <div class="clear"></div>
            </div>
        </div>
        <?php } ?>
        <?php if ($card_option && $order_total_card>=500) { ?>
        <div id="gn-card-payment-option" class="gn-osc-payment-option gn-osc-payment-option-unselected">
            <div>
                <div id="card-radio-button" class="gn-osc-left">
                    <input type="radio" name="paymentMethodRadio" id="paymentMethodCardRadio" class="gn-osc-radio" value="card" />
                </div>
                <div class="gn-osc-left gn-osc-icon-gerencianet">
                    <span class="gn-icon-credit-card2"></span>
                </div>
                <div class="gn-osc-left gn-osc-payment-option-gerencianet">
                    <strong><?php echo "Pagar com Cartão de Crédito"; ?></strong>
                    <span style="font-size: 14px; line-height: 15px;"><br>em até <?php echo $max_installments; ?></span>
                </div>
                <div class="gn-osc-left gn-osc-payment-option-sizer"></div>
                <div class="clear"></div>
            </div>
        </div>
        <?php } ?>
        <div class="clear"></div>
    </div>
    <?php if ($billet_option && $order_total_billet>=500) { ?>
    <div id="collapse-payment-billet" class="gn-osc-background" >
      <div class="panel-body">
          <div class="gn-osc-row gn-osc-pay-comments">
              <p class="gn-left-space-2"><strong><?php echo $gn_billet_payment_method_comments; ?></strong></p>
          </div>
          <div class="gn-form">
            <div id="billet-data">
                <div style="background-color: #F3F3F3; border: 1px solid #F3F3F3;">
              <div class="gn-osc-row">
                <div class="gn-col-12 gn-cnpj-row">
                <input type="checkbox" name="pay_billet_with_cnpj" id="pay_billet_with_cnpj" value="1" /> Pagar com dados de Pessoa Jurídica
                </div>
              </div>

              <div id="pay_cnpj" class="required gn-osc-row">
                <div class="gn-col-2 gn-label">
                  <label for="gn_billet_cnpj" class="gn-right-padding-1">CNPJ: </label>
                </div>
                <div class="gn-col-10">
                  
                  <div>
                    <div class="gn-col-3 required">
                      <input type="text" name="gn_billet_cnpj" id="gn_billet_cnpj" class="form-control cnpj-mask" value="" />
                    </div>
                    <div class="gn-col-8">
                      <div class="required">
                        <div class="gn-col-4 gn-label">
                          <label class=" gn-col-12 gn-right-padding-1" for="gn_billet_corporate_name">Razão Social: </label>
                        </div>
                        <div class="gn-col-8">
                          <input type="text" name="gn_billet_corporate_name" id="gn_billet_corporate_name" class="form-control" value="" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>

              <div id="gn_name_row" class="required gn-osc-row gn-billet-field" >
                <div class="gn-col-2 gn-label">
                  <label for="gn_billet_full_name" class="gn-right-padding-1">Nome: </label>
                </div>
                <div class="gn-col-10">
                  <input type="text" name="gn_billet_full_name" id="gn_billet_full_name" value="<?php echo $first_name.' '.$last_name; ?>" class="form-control" />
                </div>
              </div>


              <div id="gn_email_row" class=" required gn-osc-row gn-billet-field" >
                <div class="gn-col-2 gn-label">
                  <label class="gn-col-12 gn-right-padding-1" for="gn_billet_email">Email: </label>
                </div>
                <div class="gn-col-10">
                  <input type="text" name="gn_billet_email" value="<?php echo $email; ?>" id="gn_billet_email" class="form-control" />
                </div>
              </div>

              <div id="gn_cpf_phone_row" class="required gn-osc-row gn-billet-field" >
                <div class="gn-col-2 gn-label">
                  <label for="gn_billet_cpf" class="gn-right-padding-1">CPF: </label>
                </div>
                <div class="gn-col-10">
                  
                  <div>
                    <div class="gn-col-3 required">
                      <input type="text" name="gn_billet_cpf" id="gn_billet_cpf" value="<?php echo $cpf; ?>" class="form-control cpf-mask" />
                    </div>
                    <div class="gn-col-8">
                      <div class=" required">
                        <div class="gn-col-4 gn-label">
                        <label class="gn-col-12 gn-right-padding-1" for="gn_billet_phone_number" >Telefone: </label>
                        </div>
                        <div class="gn-col-4">
                          <input type="text" name="gn_billet_phone_number" id="gn_billet_phone_number" value="<?php echo $phone_number; ?>" class="form-control phone-mask" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            </div>

        </div>

        <div class="gn-osc-row" style="padding: 20px;">
            <?php if ($discount>0) { ?>
            <div class="gn-osc-row" style="border: 1px solid #DEDEDE; border-bottom: 0px; margin: 0px; padding:5px;">
                <div class="gn-pull-left">
                    <strong>DESCONTO DE <?php echo $discount_formatted; ?> NO BOLETO:</strong>
                </div>
                <div class="gn-pull-right">
                    <strong>-<?php echo $discount_total_value; ?></strong>
                </div>
            </div>
            <?php } ?>
            <div class="gn-osc-row" style="border: 1px solid #DEDEDE; margin: 0px; padding:5px;">
                <div class="gn-pull-left">
                    <strong>TOTAL:</strong>
                </div>
                <div class="gn-pull-right">
                    <strong><?php echo $order_total_billet_formatted; ?></strong>
                </div>
            </div>
            <div class="gn-osc-row">
                <div class="gn-pull-right">

                  <div class="gn-osc-row">
                    <div class="buttons">
                      <div class="pull-right">
                        <input type="submit" id="gn-pay-billet-button" value="Finalizar Pedido e Pagar com Boleto Bancário" class="btn btn-primary" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="pull-right gn-loading-request">
                    <div class="gn-loading-request-row">
                      <div class="pull-left gn-loading-request-text">
                        Autorizando, aguarde...
                      </div>
                      <div class="pull-left gn-icons">
                        <div class="spin gn-loading-request-spin-box icon-gerencianet"><div class="gn-icon-spinner6 gn-loading-request-spin-icon"></div></div>
                      </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
      </div>

    <?php } ?>  
    <?php if ($card_option && $order_total_card>=500) { ?>
      <div id="collapse-payment-card"  class="panel-collapse <?php if ($billet_option=='1') { ?>gn-hide<?php } ?> gn-osc-background" >
        <div class="panel-body">
                <div class="gn-osc-row gn-osc-pay-comments">
                   <p class="gn-left-space-2"><strong><?php echo $gn_card_payment_comments; ?></strong></p>
                </div>

                <div class="gn-form">
                <div id="card-data" >
                    <div style="background-color: #F3F3F3; border: 1px solid #F3F3F3;">
                    <div class="gn-osc-row">
                      <div class="gn-col-12 gn-cnpj-row">
                        <input type="checkbox" name="pay_card_with_cnpj" id="pay_card_with_cnpj" value="1" />  Pagar com dados de Pessoa Jurídica
                      </div>
                    </div>

                    <div id="pay_cnpj_card" class=" required gn-osc-row" >
                      <div class="gn-col-2 gn-label">
                      <label class="gn-right-padding-1" for="gn_card_cnpj">CNPJ: </label>
                      </div>
                      <div class="gn-col-10">
                        
                        <div>
                          <div class="gn-col-3 required">
                            <input type="text" name="gn_card_cnpj" id="gn_card_cnpj" class="form-control cnpj-mask" value="" />
                          </div>
                          <div class="gn-col-8">
                            <div class=" required gn-left-space-2">
                              <div class="gn-col-4 gn-label">
                                <label class="gn-col-12 gn-right-padding-1" for="gn_card_corporate_name">Razão Social: </label>
                              </div>
                              <div class="gn-col-8">
                                <input type="text" name="gn_card_corporate_name" id="gn_card_corporate_name" class="form-control" value="" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>

                    <div id="gn_card_name_row" class="required gn-osc-row gn-card-field" >
                      <div class="gn-col-2 gn-label">
                        <label class="gn-col-12 gn-right-padding-1" for="gn_card_full_name">Nome: </label>
                      </div>
                      <div class="gn-col-10">
                        <input type="text" name="gn_card_full_name" id="gn_card_full_name" value="<?php echo $first_name.' '.$last_name; ?>" class="form-control" />
                      </div>
                    </div>

                    <div id="gn_card_cpf_phone_row" class="required gn-osc-row gn-card-field" >
                    
                        <div class="gn-col-2 gn-label">
                            <label for="gn_card_cpf" class="gn-right-padding-1" >CPF: </label>
                        </div>
                        <div class="gn-col-4">
                            <input type="text" name="gn_card_cpf" id="gn_card_cpf" value="<?php echo $cpf; ?>" class="form-control cpf-mask gn-minimum-size-field" />
                        </div>
                        <div class="gn-col-6">
                          <div class="gn-col-4 gn-label">
                              <label class="gn-left-space-2 gn-right-padding-1" for="gn_card_phone_number">Telefone: </label>
                          </div>
                          <div class="gn-col-8">
                              <input type="text" name="gn_card_phone_number" value="<?php echo $phone_number; ?>" id="gn_card_phone_number" class="form-control phone-mask gn-minimum-size-field" />
                          </div>
                          
                        </div>
                    </div>

                    <div id="gn_card_birth_row" class=" required gn-osc-row gn-card-field" >
                      <div class="gn-col-3 gn-label-birth">
                          <label class="gn-right-padding-1" for="gn_card_birth">Data de nascimento: </label>
                      </div>
                      <div class="gn-col-3">
                          <input type="text" name="gn_card_birth" id="gn_card_birth" value="<?php echo $birth; ?>" class="form-control birth-mask" />
                      </div>
                    </div>

                    <div id="gn_card_email_row" class=" required gn-card-field" >
                      <div class="gn-col-2">
                        <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_email">Email: </label>
                      </div>
                      <div class="gn-col-10">
                        <input type="text" name="gn_card_email" value="<?php echo $email; ?>" id="gn_card_email" class="form-control" />
                      </div>
                    </div>

                    <div id="billing-adress" class="gn-section">
                        <div class="gn-osc-row gn-card-field gn-col-12">
                            <p>
                            <strong>ENDEREÇO DE COBRANÇA: </strong>
                            </p>
                        </div>

                        <div id="gn_card_street_number_row" class="required gn-osc-row gn-card-field" >
                            <div class="gn-col-2">
                                <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_street">Endereço: </label>
                            </div>
                            
                            <div class="gn-col-10">
                                <div class="gn-col-6 required">
                                    <input type="text" name="gn_card_street" id="gn_card_street" value="<?php echo $street; ?>" class="form-control" />
                                </div>
                                <div class="gn-col-6">
                                    <div class=" required gn-left-space-2">
                                        <div class="gn-col-5">
                                            <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_street_number">Número: </label>
                                        </div>
                                        <div class="gn-col-7">
                                            <input type="text" name="gn_card_street_number" id="gn_card_street_number" value="<?php echo $number; ?>" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="gn_card_neighborhood_row" class="gn-osc-row gn-card-field">
                            <div class="gn-col-2 required">
                                <label class="gn-col-12 gn-label required gn-right-padding-1" for="gn_card_neighborhood">Bairro: </label>
                            </div>
                    
                            <div class="gn-col-3">
                                
                                <input type="text" name="gn_card_neighborhood" id="gn_card_neighborhood" value="<?php echo $neighborhood; ?>" class="form-control" />
                            </div>
                            <div class="gn-col-7">
                                <div class=" gn-left-space-2">
                                  <div class="gn-col-5">
                                  <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_complement">Complemento: </label>
                                  </div>
                                  <div class="gn-col-7">
                                    <input type="text" name="gn_card_complement" id="gn_card_complement" value="<?php echo $complement; ?>" class="form-control" maxlength="54" />
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div id="gn_card_city_zipcode_row" class="required billing-address-data gn-card-field gn-osc-row" >
                            <div class="gn-col-2">
                                <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_zipcode">CEP: </label>
                            </div>
                            <div class="gn-col-10">
                                <div class="gn-col-4 required">
                                    <input type="text" name="gn_card_zipcode" id="gn_card_zipcode" value="<?php echo $zipcode; ?>" class="form-control" />
                                </div>
                                <div class="gn-col-8">
                                    <div class=" required gn-left-space-2">
                                      <div class="gn-col-4">
                                          <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_city">Cidade: </label>
                                      </div>
                                      <div class="gn-col-6">
                                        <input type="text" name="gn_card_city" id="gn_card_city" value="<?php echo $city; ?>" class="form-control" />
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="gn_card_state_row" class="required billing-address-data gn-card-field gn-osc-row" >
                          <div class="gn-col-2">
                            <label class="gn-col-12 gn-label gn-right-padding-1" for="gn_card_state">Estado: </label>
                          </div>
                          <div class="gn-col-10">
                            <select name="gn_card_state" id="gn_card_state" class="form-control gn-form-select">
                              <option value=""></option> 
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
                    <div class="clear"></div>

                    <div class="gn-section" style="background-color: #F0F0F0; padding: 5px 10px;">
                        <div class="required gn-osc-row">
                            <div>
                            <label class="" for="gn_card_brand">Selecione a bandeira do cartão: </label>
                            </div>
                            <div>
                                <div class="gn-card-brand-selector">
                                    <input id="none" type="radio" name="gn_card_brand" id="gn_card_brand" value="" checked class="gn-hide" />
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="visa" type="radio" name="gn_card_brand" id="gn_card_brand" value="visa" class="gn-hide" />
                                        <label class="gn-card-brand gn-visa" for="visa"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="mastercard" type="radio" name="gn_card_brand" id="gn_card_brand" value="mastercard" class="gn-hide" />
                                        <label class="gn-card-brand gn-mastercard" for="mastercard"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="amex" type="radio" name="gn_card_brand" id="gn_card_brand" value="amex" class="gn-hide" />
                                        <label class="gn-card-brand gn-amex" for="amex"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="diners" type="radio" name="gn_card_brand" id="gn_card_brand" value="diners" class="gn-hide" />
                                        <label class="gn-card-brand gn-diners" for="diners"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="discover" type="radio" name="gn_card_brand" id="gn_card_brand" value="discover" class="gn-hide" />
                                        <label class="gn-card-brand gn-discover" for="discover"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="jcb" type="radio" name="gn_card_brand" id="gn_card_brand" value="jcb" class="gn-hide" />
                                        <label class="gn-card-brand gn-jcb" for="jcb"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="elo" type="radio" name="gn_card_brand" id="gn_card_brand" value="elo" class="gn-hide" />
                                        <label class="gn-card-brand gn-elo" for="elo"></label>
                                    </div>
                                    <div class="pull-left gn-card-brand-content">
                                        <input id="aura" type="radio" name="gn_card_brand" id="gn_card_brand" value="aura" class="gn-hide" />
                                        <label class="gn-card-brand gn-aura" for="aura"></label>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>

                        <div class="gn-osc-row required">
                                <div class="gn-col-6">
                                    <div>
                                        Número do cartão:
                                    </div>
                                    <div>
                                        <div class="gn-card-number-input-row" style="margin-right: 20px;">
                                            <input type="text" name="gn_card_number_card" id="gn_card_number_card" value="" class="form-control gn-input-card-number" />
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                
                                <div class="gn-col-6">
                                    <div>
                                        Código de Segurança:
                                    </div>
                                    <div>
                                        <div class="pull-left gn-cvv-row">
                                            <input type="text" name="gn_card_cvv" id="gn_card_cvv" value="" class="form-control gn-cvv-input" />
                                        </div>
                                        <div class="pull-left">
                                            <div class="gn-cvv-info">
                                                <div class="pull-left gn-icon-card-input">
                                                </div>
                                                <div class="pull-left">
                                                    São os três últimos
                                                    dígitos no verso do cartão.
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <input type="hidden" name="gn_card_payment_token" id="gn_card_payment_token" value="" />
                        </div>

                        <div class="gn-osc-row">
                            <div class="gn-col-12">
                                    <div>   
                                        Validade:
                                    </div>
                                    <div class="gn-card-expiration-row">
                                        <select class="form-control gn-card-expiration-select" name="gn_card_expiration_month" id="gn_card_expiration_month" >
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
                                        <select class="form-control gn-card-expiration-select" name="gn_card_expiration_year" id="gn_card_expiration_year" >
                                            <option value=""> YYYY </option>
                                            <?php 
                                            $actual_year = intval(date("Y")); 
                                            $last_year = $actual_year + 15;
                                            for ($i = $actual_year; $i <= $last_year; $i++) {
                                                echo '<option value="'.$i.'"> '.$i.' </option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="clear"></div>
                                    </div>
                                </div>

                        </div>

                        <div class="gn-osc-row required">
                            <div class="gn-col-12">
                                <label class="" for="gn_card_installments">Quantidade de parcelas:</label>
                            </div>
                            <div class="gn-col-12">
                                <select name="gn_card_installments" id="gn_card_installments" class="form-control gn-form-select">
                                    <option value="">Selecione a bandeira do cartão</option> 
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
              </div>

            </div>
        </div>
        <div class="gn-osc-row" style="padding: 20px;">
            <div class="gn-osc-row" style="border: 1px solid #DEDEDE; margin: 0px; padding:5px;">
                <div class="gn-pull-left">
                    <strong>TOTAL:</strong>
                </div>
                <div class="gn-pull-right">
                    <strong><?php echo $order_total_card_formatted; ?></strong>
                </div>
            </div>
            <div class="gn-osc-row">
                <div class="gn-pull-right">
                
                    <div class="gn-osc-row">
                      <div class="buttons">
                        <div class="pull-right">
                          <input type="submit" id="gn-pay-card-button" value="Finalizar Pedido e Pagar com Cartão de Crédito" class="btn btn-primary" />
                        </div>
                      </div>
                    </div>

                </div>
                <div class="pull-right gn-loading-request">
                    <div class="gn-loading-request-row">
                      <div class="pull-left gn-loading-request-text">
                        Autorizando, aguarde...
                      </div>
                      <div class="pull-left gn-icons">
                        <div class="spin gn-loading-request-spin-box icon-gerencianet"><div class="gn-icon-spinner6 gn-loading-request-spin-icon"></div></div>
                      </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        
      </div>
      <?php } ?>

</div>

<?php echo $scriptPaymentToken; ?>

<script type="text/javascript">
    var getPaymentToken;
    $gn.ready(function(checkout) {
        getPaymentToken = checkout.getPaymentToken;
    });

    var billetActive = "<?php echo $billet_option; ?>";
    var cardActive = "<?php echo $card_option; ?>";
    var id_charge = 0;
    var success_url = "<?php echo $success_url; ?>";
    var actual_order_id = "<?php echo $actual_order_id; ?>";
</script>

<script src='<?php echo $base; ?>catalog/view/javascript/jquery/jquery.maskedinput.js' type='text/javascript'></script>
<script src='<?php echo $base; ?>catalog/view/javascript/gerencianet/checkout-osc.js' type='text/javascript'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>catalog/view/javascript/gerencianet/style-osc.css" />



<?php } ?>