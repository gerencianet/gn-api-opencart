<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-gn-std-uk" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php 
    if (!version_compare(phpversion(), '5.4.0', '>=')) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
      A versão do PHP instalado no servidor não é compatível com o módulo da Gerencianet. Por favor, verifique os requisitos do módulo.
      </div>
    <?php } ?>
    <?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (isset($error_warning) && $error_warning != '') { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $gn_edit_config; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row gn-admin-title-row">
          <div class="pull-left">
            <a target="_BLANK" href="https://www.gerencianet.com.br"><img src="view/image/payment/gerencianet-configurations.png" alt="Gerencianet" title="Gerencianet" /></a> 
          </div>
          <div class="pull-left gn-admin-title">
            <b><?php echo $gn_entry_official_module_title.' - '.$gn_entry_official_module_version; ?></b>
          </div>
        </div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-gn-std-uk" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $gn_config_geral; ?></a></li>
            <li><a href="#tab-keys" data-toggle="tab"><?php echo $gn_config_credentials; ?></a></li>
            <li><a href="#tab-status" data-toggle="tab"><?php echo $gn_config_order_status; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">


              <div class="form-group">
                <label class="col-sm-3 control-label" for="entry-sandbox"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_sandbox; ?>"><?php echo $gn_entry_sandbox; ?></span></label>
                <div class="col-sm-9">
                  <div class="pull-left gn-admin-item-form">
                    <input type="radio" name="gerencianet_sandbox" value="1" <?php if ($gerencianet_sandbox) { ?> checked <?php } ?>> 
                  </div>
                  <div class="pull-left gn-admin-item-left">
                    <?php echo $gn_entry_sandbox_development; ?>
                  </div>
                  <div class="pull-left gn-admin-item-form">
                    <input type="radio" name="gerencianet_sandbox" value="0" <?php if (!$gerencianet_sandbox) { ?> checked <?php } ?>> 
                  </div>
                  <div class="pull-left gn-admin-item-right">
                    <?php echo $gn_entry_sandbox_production; ?>
                  </div>
                </div>
              </div>

              <div class="form-group">
              <label class="col-sm-3 control-label" for="entry-payment-options"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_billet_expire; ?>"><?php echo $gn_entry_payment_options; ?></span></label>
                <div class="col-sm-9">
                  <div class="pull-left gn-admin-item-form">
                    <input type="checkbox" name="gerencianet_payment_option_billet" value="1" <?php if ($gerencianet_payment_option_billet) { ?> checked <?php } ?>>
                  </div>
                  <div class="pull-left gn-admin-item-left">
                    <?php echo $gn_entry_payment_options_billet; ?>
                  </div>
                  <div class="pull-left gn-admin-item-form">
                    <input type="checkbox" name="gerencianet_payment_option_card" value="1" <?php if ($gerencianet_payment_option_card) { ?> checked <?php } ?>>
                  </div>
                  <div class="pull-left gn-admin-item-right">
                    <?php echo $gn_entry_payment_options_card; ?>
                  </div>
                </div>
              </div>

              <div class="form-group">
              <label class="col-sm-3 control-label" for="entry-payment-options"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_payment_osc; ?>"><?php echo $gn_entry_payment_osc; ?></span></label>
                <div class="col-sm-9">
                  <div class="pull-left gn-admin-item-form">
                    <input type="checkbox" name="gerencianet_osc" value="1" <?php if ($gerencianet_osc) { ?> checked <?php } ?>>
                  </div>
                  <div class="pull-left gn-admin-item-left">
                    <?php echo $gn_entry_payment_osc_option; ?>
                  </div>
                </div>
              </div>

              <div class="form-group gn-admin-detail-config">
                <div class="col-sm-3 control-label"></div>
                <div class="col-sm-9 gn-admin-detail-background">
                  <div class="form-group gn-admin-detail-content">
                    <label class="control-label" for="gerencianet_billet_days_to_expire"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_billet_expire; ?>"><?php echo $gn_entry_billet_days_to_expire; ?></span></label>
                    <div>
                      <input type="text" name="gerencianet_billet_days_to_expire" value="<?php echo $gerencianet_billet_days_to_expire; ?>" placeholder="<?php echo $gn_entry_billet_days_to_expire_placeholder; ?>" id="gerencianet_billet_days_to_expire" class="form-control billet_expiration"/>
                    </div>
                  </div>
                  <div class="form-group gn-admin-detail-content">
                    <label class="control-label" for="gerencianet_discount_billet_value"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_discount; ?>"><?php echo $gn_entry_discount_value; ?></span></label>
                    <div>
                      <input type="text" name="gerencianet_discount_billet_value" value="<?php echo $gerencianet_discount_billet_value; ?>" placeholder="0%" id="gerencianet_discount_billet_value" class="form-control percent"/>
                    </div>
                  </div>
                  <div class="form-group gn-admin-detail-content">
                    <label class="control-label" for="gerencianet_billet_instruction_line_1"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_billet_instructions; ?>"><?php echo $gn_entry_billet_instructions; ?></span></label>
                    <div class="gn-admin-row-billet-instructions">
                      <input type="text" name="gerencianet_billet_instruction_line_1" value="<?php echo $gerencianet_billet_instruction_line_1; ?>" placeholder="" id="gerencianet_billet_instruction_line_1" maxlength="90" class="form-control"/>
                    </div>
                    <div class="gn-admin-row-billet-instructions">
                      <input type="text" name="gerencianet_billet_instruction_line_2" value="<?php echo $gerencianet_billet_instruction_line_2; ?>" placeholder="" id="gerencianet_billet_instruction_line_2" maxlength="90" class="form-control"/>
                    </div>
                    <div class="gn-admin-row-billet-instructions">
                      <input type="text" name="gerencianet_billet_instruction_line_3" value="<?php echo $gerencianet_billet_instruction_line_3; ?>" placeholder="" id="gerencianet_billet_instruction_line_3" maxlength="90" class="form-control"/>
                    </div>
                    <div class="gn-admin-row-billet-instructions">
                      <input type="text" name="gerencianet_billet_instruction_line_4" value="<?php echo $gerencianet_billet_instruction_line_4; ?>" placeholder="" id="gerencianet_billet_instruction_line_4" maxlength="90" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label" for="gerencianet_payment_notification_update"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_notification_update; ?>"><?php echo $gn_entry_payment_notification_update; ?></span></label>
                <div class="col-sm-9">
                  <div class="pull-left gn-admin-item-form">
                    <input type="radio" name="gerencianet_payment_notification_update" value="1" <?php if ($gerencianet_payment_notification_update) { ?> checked <?php } ?>> 
                  </div>
                  <div class="pull-left gn-admin-item-left">
                    <?php echo $text_yes; ?>
                  </div>
                  <div class="pull-left gn-admin-item-form">
                    <input type="radio" name="gerencianet_payment_notification_update" value="0" <?php if (!$gerencianet_payment_notification_update) { ?> checked <?php } ?>> 
                  </div>
                  <div class="pull-left gn-admin-item-right">
                    <?php echo $text_no; ?>
                  </div>
                </div>
              </div>

              <div class="form-group gn-admin-detail-config">
                <div class="col-sm-3 control-label"></div>
                <div class="col-sm-9 gn-admin-detail-background">
                  <div class="form-group gn-admin-detail-content">
                    <label class="control-label" for="gn_entry_payment_notification_update_notify"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_notification_update_notify; ?>"><?php echo $gn_entry_payment_notification_update_notify; ?></span></label>
                    <div>
                      <div class="col-sm-10 gn-admin.item-notification">
                        <div class="pull-left gn-admin-item-form">
                          <input type="radio" name="gerencianet_payment_notification_update_notify" value="1" <?php if ($gerencianet_payment_notification_update_notify) { ?> checked <?php } ?>> 
                        </div>
                        <div class="pull-left gn-admin-item-left">
                          <?php echo $text_yes; ?>
                        </div>
                        <div class="pull-left gn-admin-item-form">
                          <input type="radio" name="gerencianet_payment_notification_update_notify" value="0" <?php if (!$gerencianet_payment_notification_update_notify) { ?> checked <?php } ?>> 
                        </div>
                        <div class="pull-left gn-admin-item-right">
                          <?php echo $text_no; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="gerencianet_status"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status; ?>"><?php echo $entry_status; ?></span></label>
                <div class="col-sm-9">
                  <div class="pull-left gn-admin-item-form">
                    <input type="radio" name="gerencianet_status" value="1" <?php if ($gerencianet_status) { ?> checked <?php } ?>> 
                  </div>
                  <div class="pull-left gn-admin-item-left">
                    <?php echo $gn_entry_status_on; ?>
                  </div>
                  <div class="pull-left gn-admin-item-form">
                    <input type="radio" name="gerencianet_status" value="0" <?php if (!$gerencianet_status) { ?> checked <?php } ?>> 
                  </div>
                  <div class="pull-left gn-admin-item-right">
                    <?php echo $gn_entry_status_off; ?>
                  </div>
                </div>
              </div>
            </div>
              
            <div class="tab-pane" id="tab-keys">
              <?php echo $gn_entry_help_keys; ?>
              
              <div class="form-group required">
                <div class="gn-admin-keys-title">
                  <span><b><?php echo $gn_entry_keys_production_title; ?></b></span> &nbsp; <a onclick="showGnTutorial('keysProduction');" class="gn-admin-cursor-pointer"><?php echo $gn_entry_keys_production_help; ?></a>
                </div>
                <label class="col-sm-3 control-label" for="entry-client-id-production"><?php echo $gn_entry_client_id_production; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="gerencianet_client_id_production" value="<?php echo $gerencianet_client_id_production; ?>" placeholder="<?php echo $gn_entry_client_id_production; ?>" id="entry-client-id-production" class="form-control"/>
                </div>
              </div>

              <div class="form-group required" >
                <label class="col-sm-3 control-label" for="entry-client-secret-production"><?php echo $gn_entry_client_secret_production; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="gerencianet_client_secret_production" value="<?php echo $gerencianet_client_secret_production; ?>" placeholder="<?php echo $gn_entry_client_secret_production; ?>" id="entry-client-secret-production" class="form-control"/>
                </div>
              </div>

              <div class="form-group required">
                <div class="gn-admin-keys-title">
                  <span><b><?php echo $gn_entry_keys_development_title; ?></b></span> &nbsp; <a onclick="showGnTutorial('keysDevelopment');" class="gn-admin-cursor-pointer"><?php echo $gn_entry_keys_development_help; ?></a>
                </div>
                <label class="col-sm-3 control-label" for="entry-client-id-development"><?php echo $gn_entry_client_id_development; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="gerencianet_client_id_development" value="<?php echo $gerencianet_client_id_development; ?>" placeholder="<?php echo $gn_entry_client_id_development; ?>" id="entry-client-id-development" class="form-control"/>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-3 control-label" for="entry-client-secret-development"><?php echo $gn_entry_client_secret_development; ?></label>
                <div class="col-sm-9">
                  <input type="text" name="gerencianet_client_secret_development" value="<?php echo $gerencianet_client_secret_development; ?>" placeholder="<?php echo $gn_entry_client_secret_development; ?>" id="entry-client-secret-development" class="form-control"/>
                </div>
              </div>


              <?php echo $gn_entry_help_payee_code; ?>

              <div class="form-group required">
                <div class="col-sm-3 control-label">
                  <label for="entry-gerencianet-payee-code"><?php echo $gn_entry_payee_code; ?></label><br>
                  <a onclick="showGnTutorial('payeeCode');" class="gn-admin-cursor-pointer"><?php echo $gn_entry_payee_code_help; ?></a>
                </div>
                <div class="col-sm-9">
                  <input type="text" name="gerencianet_payee_code" id="gerencianet_payee_code" value="<?php echo $gerencianet_payee_code; ?>" placeholder="<?php echo $gn_entry_payee_code; ?>" class="form-control"/>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tab-status">
              <?php echo $gn_entry_status_config_description; ?>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_new; ?>"><?php echo $gn_entry_new_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_new_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_new_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_waiting; ?>"><?php echo $gn_entry_waiting_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_waiting_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_waiting_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_paid; ?>"><?php echo $gn_entry_paid_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_paid_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_paid_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_unpaid; ?>"><?php echo $gn_entry_unpaid_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_unpaid_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_unpaid_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_refunded; ?>"><?php echo $gn_entry_refunded_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_refunded_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_refunded_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_contested; ?>"><?php echo $gn_entry_contested_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_contested_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_contested_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $gn_entry_help_status_canceled; ?>"><?php echo $gn_entry_canceled_status; ?></span></label>
                <div class="col-sm-9">
                  <select name="gerencianet_canceled_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $gerencianet_canceled_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="tutorialGnBox" class="gn-admin-tutorial-box">
  <div class="gn-admin-tutorial-row">
    <div class="gn-admin-tutorial-line">
      <div class="pull-right gn-admin-tutorial-close">
        <?php echo $gn_entry_close; ?> <b>X</b>
      </div>
    </div>
    <img id="imgTutorial" src="view/image/payment/gerencianet-exemplo-chaves-desenvolvimento.png" />
  </div>
</div>
<script type="text/javascript">

  $(document).ready(function() {
    $("#tutorialGnBox").click(function() {
      $("#tutorialGnBox").fadeOut();
    });

    $(".percent").mask("##0,00%", {reverse: true, onKeyPress: function(percentage){
        if (percentage.length>6) {
          $(".percent").val("99,99%");
        }
      }});
    $(".billet_expiration").mask("999");
  });

  function showGnTutorial(tutorial) {
    switch(tutorial) {
      case "keysDevelopment": $("#imgTutorial").attr("src","view/image/payment/gerencianet-exemplo-chaves-desenvolvimento.png"); break;
      case "keysProduction": $("#imgTutorial").attr("src","view/image/payment/gerencianet-exemplo-chaves-producao.png"); break;
      case "payeeCode": $("#imgTutorial").attr("src","view/image/payment/gerencianet-exemplo-identificador-conta.png"); break;
    }
    $("#tutorialGnBox").fadeIn();
  }

</script>

<style>

.gn-admin-title-row {
  margin-bottom: 10px; 
  margin-left: 5px;
}

.gn-admin-item-form {
  margin-top:7px;
}

.gn-admin-cursor-pointer {
    cursor: pointer;  
}

.gn-admin-item-left {
  margin-top:8px;
  margin-left: 8px;
  margin-right: 40px;
}

.gn-admin-item-right {
  margin:8px;
}

.gn-admin.item-notification {
  padding-left: 0px; 
  margin-left: 0px;
}

.gn-admin-keys-title {
  margin-left:30px; 
  margin-top:3px; 
  margin-bottom: 20px; 
}

.gn-admin-keys-title span {
  font-size: 15px;
}

.gn-admin-detail-config {
  padding: 0px;
  background-color: #F0F0F0;
}

.gn-admin-detail-content {
  padding-left: 20px; 
  padding-right: 20px; 
  padding-top: 0px;
}

.gn-admin-detail-background {
  background-color: #FFF;
}

.gn-admin-title {
    border-left: 1px solid #CCC;
    font-size: 18px; 
    padding-left: 10px; 
    margin-left: 15px;
}

.gn-admin-tutorial-box {
    z-index: 99999; 
    position: absolute; 
    top: 0; 
    left: 0; 
    background: rgba(0, 0, 0, .7); 
    width: 100%; 
    height: 100%; 
    text-align: center; 
    vertical-align: middle; 
    display: none;
}

.gn-admin-tutorial-row {
    display:inline-block;
    margin-top: 15%;
}

.gn-admin-tutorial-line {
    width:100%;
}

.gn-admin-tutorial-close {
    color: #DEDEDE; 
    cursor: pointer;
}

.gn-admin-row-billet-instructions {
    margin: 3px 0px;
}

</style>

<?php echo $footer; ?>