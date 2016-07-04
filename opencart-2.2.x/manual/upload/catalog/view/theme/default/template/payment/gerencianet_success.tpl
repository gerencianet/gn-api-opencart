<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> gn-success-content"><?php echo $content_top; ?>
      <div class="gn-payment-finalized">
      <h1><?php echo $gn_success_payment_title; ?></h1>
      
      <?php echo $text_message; ?>

      <p>
      <span class="gn-success-content-sub-tile"><b><?php echo $gn_success_payment_order; ?></b></span>
      <div >
      
        <?php if ($generated_payment_type=="billet") {
            echo $gn_success_payment_order_billet_comment;
        } else { 
            echo $gn_success_payment_order_card_comment;
        }  ?>

      <br>
      <b><?php echo $gn_success_payment_order_number . " " . $generated_order_number; ?></b> 

      </div>
      </p>
        <span class="gn-success-content-sub-tile"><b>
        <?php if ($generated_payment_type=="billet") {
            echo $gn_success_payment_type_billet_title;
        } else { 
            echo $gn_success_payment_type_card_title;
        }  ?>
        </b></span>
      <div>
        <div class="gn-success-payment">
            <div class="row gn-box-emission">
                <div class="pull-left gn-left-space-2">
                    <img src="catalog/view/javascript/gerencianet/images/gerencianet-configurations.png" alt="Gerencianet" title="Gerencianet" />
                </div>
                <div class="pull-left gn-title-emission">
                    <?php if ($generated_payment_type=="billet") { 
                        echo $gn_success_payment_box_title_billet;
                    } else { 
                        echo $gn_success_payment_box_title_card;
                    }  ?>
                </div>
            </div>

            <div class="gn-success-payment-inside-box">
                <div class="row">
                    <div class="col-sm-1">
                      <div class="gn-icon-emission-success">
                          <span class="gn-icon-check-circle-o"></span>
                      </div>
                    </div>

                    <div class="col-sm-10 gn-success-payment-billet-comments">
                        <?php if ($generated_payment_type=="billet") { 
                            echo $gn_success_payment_box_comments_billet;
                        } else {
                            echo $gn_success_payment_box_comments_card_part1 . " " . $buyer_email . " " . $gn_success_payment_box_comments_card_part2;
                        } ?>
                        
                        <p>
                        <?php echo $gn_success_payment_charge_number; ?> <b><?php echo $generated_charge_number; ?></b>
                        </p>
                    </div>

                </div>

                <?php if ($generated_payment_type=="billet") { ?>
                 <div class="row">
                    <div class="buttons gn-align-center">
                      <?php if ($generated_billet_url==false) { ?>
                        Acesse seu boleto diretamente de sua conta ou através do seu e-mail.
                      <?php } else { ?>
                        <a id="button-payment-billet" class="btn btn-primary button-payment gn-button-pay" href="<?php echo $generated_billet_url; ?>" target="_blank" >
                            <div class="gn-success-payment-button-icon"><span class="gn-icon-download"></span></div> <div class="gn-button-divisor"></div><?php echo $gn_success_payment_billet_button; ?>
                        </a>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
            </div>
          </div>
      </div>
      </p>
      </div>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<?php echo $footer; ?>