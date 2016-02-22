<?php if ($alert_sandbox) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $alert_sandbox; ?></div>
<?php } ?>
<div class="alert alert-warning warning-payment <?php if (!$error_warning) { ?> gn-hide <?php } ?>" ><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<div class="alert alert-success success-payment gn-hide"></div>

<form class="form-horizontal">
  <p><strong><?php echo $gn_billet_payment_method_comments; ?></strong></p>

  <div id="billet-data">

    <div class="form-group">
      <div class="col-sm-12 gn-cnpj-row">
      <input type="checkbox" name="pay_billet_with_cnpj" id="pay_billet_with_cnpj" value="1" />  <?php echo $gn_cnpj_option; ?>
      </div>
    </div>

    <div id="pay_cnpj" class="form-group required gn-hide">
      <label class="col-sm-1 control-label" for="input-payment-billet-cnpj"><?php echo $gn_cnpj; ?></label>
      <div class="col-sm-11">
        
        <div class="row">
          <div class="col-sm-3 required">
            <input type="text" name="cnpj" id="cnpj" class="form-control cnpj-mask" />
          </div>
          <div class="col-sm-8">
            <div class="form-group required">
              <label class="col-sm-4 control-label" for="input-payment-corporate-name"><?php echo $gn_corporate_name; ?></label>
              <div class="col-sm-8">
                <input type="text" name="corporate_name" id="corporate_name" placeholder="<?php echo $gn_corporate_name_placeholder; ?>" class="form-control" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group required <?php if ($first_name) { ?> gn-hide <?php } ?>" >
      <label class="col-sm-1 control-label" for="input-payment-billet-name"><?php echo $gn_name; ?></label>
      <div class="col-sm-11">
        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" placeholder="<?php echo $gn_name_placeholder; ?>" class="form-control" />
      </div>
    </div>

    <div class="form-group required <?php if ($cpf) { ?> gn-hide <?php } ?>" >
      <label class="col-sm-1 control-label" for="input-payment-billet-cpf"><?php echo $gn_cpf; ?></label>
      <div class="col-sm-11">
        
        <div class="row">
          <div class="col-sm-3 required">
            <input type="text" name="cpf" id="cpf" value="<?php echo $cpf; ?>" placeholder="<?php echo $gn_cpf_placeholder; ?>" class="form-control cpf-mask" />
          </div>
          <div class="col-sm-8">
            <div class="form-group required">
              <label class="col-sm-4 control-label" for="input-payment-billet-phone"><?php echo $gn_phone; ?></label>
              <div class="col-sm-4">
                <input type="text" name="phone_number" id="phone_number" value="<?php echo $phone_number; ?>" placeholder="<?php echo $gn_phone_placeholder; ?>" class="form-control phone-mask" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</form>