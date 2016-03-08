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
		    <label class="gn-col-2 gn-label" for="input-payment-card-cpf"><?php echo $gn_cpf; ?></label>
		    	<div class="gn-col-2">
					<input type="text" name="input-payment-card-cpf" id="input-payment-card-cpf" value="<?php echo $cpf; ?>" placeholder="<?php echo $gn_cpf_placeholder; ?>" class="form-control cpf-mask gn-minimum-size-field" />
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
	        		<input type="text" name="input-payment-card-address-street" id="input-payment-card-street" value="" placeholder="<?php echo $gn_street_placeholder; ?>" class="form-control" />
        		</div>
			    <div class="gn-col-5">
				    <div class=" required gn-left-space-2">
				      <label class="gn-col-5 gn-label" for="input-payment-card-address-number"><?php echo $gn_street_number; ?></label>
				      <div class="gn-col-7">
				        <input type="text" name="input-payment-card-address-number" id="input-payment-card-address-number" value="" placeholder="<?php echo $gn_street_number_placeholder; ?>" class="form-control" />
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
			    				<span class="icon-credit-card2 gn-card-number-icon"></span>
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
					    		<div class="clear gn-cvv-info">
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