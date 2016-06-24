<?php
include_once(DIR_SYSTEM . '../lib/gerencianet/autoload.php');
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

class ControllerPaymentGerencianet extends Controller {
	public function index() {
    	$this->load->language('payment/gerencianet');

		$this->load->model('checkout/order');

		$gn_checkout_type = $this->config->get('gerencianet_osc');
		if ($gn_checkout_type=="1") {
			$data['checkout_type'] = "OSC";
		} else {
			$data['checkout_type'] = "default";
		}

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$data['button_confirm'] = $this->language->get('button_confirm');
			$data['action'] = $this->url->link('payment/gerencianet/finalize');
			
			if ($gn_checkout_type=="1") {

				if ($this->config->get('gerencianet_sandbox')) {
					$data['scriptPaymentToken'] = html_entity_decode("<script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://sandbox.gerencianet.com.br/v1/cdn/".$this->config->get('gerencianet_payee_code')."/'+v;s.async=false;s.id='".$this->config->get('gerencianet_payee_code')."';if(!document.getElementById('".$this->config->get('gerencianet_payee_code')."')){document.getElementsByTagName('head')[0].appendChild(s);};&#36;gn={validForm:true,processed:false,done:{},ready:function(fn){&#36;gn.done=fn;}};</script>");
				} else {
					$data['scriptPaymentToken'] = html_entity_decode("<script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://api.gerencianet.com.br/v1/cdn/".$this->config->get('gerencianet_payee_code')."/'+v;s.async=false;s.id='".$this->config->get('gerencianet_payee_code')."';if(!document.getElementById('".$this->config->get('gerencianet_payee_code')."')){document.getElementsByTagName('head')[0].appendChild(s);};&#36;gn={validForm:true,processed:false,done:{},ready:function(fn){&#36;gn.done=fn;}};</script>");
				}

				if (isset($this->session->data['shipping_method']['cost'])) {
					$shipping_price = $this->session->data['shipping_method']['cost'];
				} else {
					$shipping_price=0;
				}

				$data['gn_loading_installments'] = $this->language->get('gn_loading_installments');

				$data['checkout_type'] = "OSC";
				$data['billet_option'] = $this->config->get('gerencianet_payment_option_billet');
				$data['card_option'] = $this->config->get('gerencianet_payment_option_card');
				$data['sandbox'] = $this->config->get('gerencianet_sandbox');
				$data['order_total_billet_formatted'] = $this->formatCurrencyBRL(intval($order_info['total']*100-intval(($this->getBilletDiscount())*($order_info['total']-$shipping_price))));
				$data['order_total_card_formatted'] = $this->formatCurrencyBRL(($order_info['total'])*100);

				$data['order_total_billet'] = $this->formatMoney($data['order_total_billet_formatted'],true);
				$data['order_total_card'] = $this->formatMoney($data['order_total_card_formatted'],true);
				$data['discount'] = $this->getBilletDiscount();
				$data['discount_formatted'] = $this->config->get('gerencianet_discount_billet_value');
				$data['discount_total_value'] = $this->formatCurrencyBRL(intval((($this->getBilletDiscount())*($order_info['total']-$shipping_price))));
				$data['gn_warning_sandbox_message'] = "O modo Sandbox (Ambiente de testes) está ativo. Suas cobranças não serão validadas.";
				$data['gn_billet_payment_method_comments'] = "Optando pelo pagamento por Boleto, a confirmação será realizada no dia útil seguinte ao pagamento.";
				$data['gn_card_payment_comments'] = 'Optando pelo pagamento com cartão de crédito, o pagamento é processado e a confirmação ocorrerá em até 48 horas.';

				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
	         		$data['success_url'] = str_replace("http://", "https://", $this->url->link('payment/gerencianet/success'));
				} else {
					$data['success_url'] = $this->url->link('payment/gerencianet/success');
		      	}

		      	if (strpos($data['success_url'], '?') !== true) {
		      		$data['success_url'] = $data['success_url'] . "?";
		      	}

				$data['actual_order_id'] = $this->session->data['order_id'];

				$options = $this->gerencianet_config_payment_api();
				$params = array('total' => (floatval($order_info['total'])*100), 'brand' => 'visa');
				$error_api = false;
				try {
				    $api = new Gerencianet($options);
				    $installments = $api->getInstallments($params, array());
				    $data['max_installments'] = end($installments['data']['installments'])['installment'] . "x de " . $this->formatCurrencyBRL(intval(end($installments['data']['installments'])['value']));

				} catch (GerencianetException $e) {
					return "Ocorreu um erro inesperado. Tente novamente em alguns minutos.";
					$data['max_installments'] = "1 x de " . $data['order_total_card_formatted'];
				} catch (Exception $e) {
					return "Ocorreu um erro inesperado. Tente novamente em alguns minutos.";
					$data['max_installments'] = "1 x de " . $data['order_total_card_formatted'];
				}

				if (isset($order_info['payment_firstname'])) {
					$data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['first_name'] = '';
				}

				if (isset($order_info['payment_lastname'])) {
					$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['last_name'] = '';
				}

				if (isset($order_info['cpf'])) {
					$data['cpf'] = html_entity_decode($order_info['cpf'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['cpf'] = '';
				}
				if (isset($order_info['telephone'])) {
					$data['phone_number'] = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['phone_number'] = '';
				}

				if (isset($order_info['email'])) {
					$data['email'] = html_entity_decode($order_info['email'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['email'] = '';
				}

				if (isset($order_info['birth'])) {
					$data['birth'] = html_entity_decode($order_info['birth'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['birth'] = '';
				}

				if (isset($order_info['payment_street'])) {
					$data['street'] = html_entity_decode($order_info['payment_street'], ENT_QUOTES, 'UTF-8');
				} else if (isset($order_info['payment_address_1'])) {
					$data['street'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['street'] = '';
				}

				if (isset($order_info['payment_number'])) {
					$data['number'] = html_entity_decode($order_info['payment_number'], ENT_QUOTES, 'UTF-8');
				} else if (isset($order_info['payment_address_2'])) {
					$data['number'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['number'] = '';
				}

				if (isset($order_info['payment_neighborhood'])) {
					$data['neighborhood'] = html_entity_decode($order_info['payment_neighborhood'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['neighborhood'] = '';
				}

				if (isset($order_info['payment_complement'])) {
					$data['complement'] = html_entity_decode($order_info['payment_complement'], ENT_QUOTES, 'UTF-8');
				} else if (isset($order_info['payment_adress_complement'])) {
					$data['complement'] = html_entity_decode($order_info['payment_adress_complement'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['complement'] = '';
				}

				if (isset($order_info['payment_postcode'])) {
					$data['zipcode'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['zipcode'] = '';
				}

				if (isset($order_info['payment_city'])) {
					$data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['city'] = '';
				}

				if (isset($order_info['payment_zone'])) {
					$data['state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['state'] = '';
				}

				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
	         		$data['base'] = $this->config->get('config_ssl');
		      	} else {
		         	$data['base'] = $this->config->get('config_url');
		      	}
		    }

			
			if (version_compare(VERSION, '2.2') < 0) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/gerencianet.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/payment/gerencianet.tpl', $data);
				} else {
					return $this->load->view('default/template/payment/gerencianet.tpl', $data);
				}
			} else {
				return $this->load->view('payment/gerencianet', $data);
			}			
		}
	}

	public function callback() {
		if ($this->config->get('gerencianet_payment_notification_update')) {

			$this->load->model('checkout/order');
			$this->load->model('extension/extension');

			$options = $this->gerencianet_config_payment_api();

			if (isset($this->request->post['notification'])) {
				$token = $this->request->post['notification'];
			} else {
				$token = '';
			}

			if ($token) {
			 
				$params = array(
				  'token' => $token
				);
				 
				try {
				    $api = new Gerencianet($options);
				    $notification = $api->getNotification($params, array());


				    if ($notification['code']==200) {

				    	foreach ($notification['data'] as $notification_data) {
					    	$orderIdFromNotification = $notification_data['custom_id'];
					    	$orderStatusFromNotification = $notification_data['status']['current'];
					    }

					    $updateOrderHistory=false;

						switch($orderStatusFromNotification) {
							case 'new':
								$order_status_id = $this->config->get('gerencianet_new_status_id');
								$updateOrderHistory = false;
								break;
							case 'waiting':
								$order_status_id = $this->config->get('gerencianet_waiting_status_id');
								$updateOrderHistory = false;
								break;
							case 'paid':
								$order_status_id = $this->config->get('gerencianet_paid_status_id');
								$updateOrderHistory = true;
								break;
							case 'unpaid':
								$order_status_id = $this->config->get('gerencianet_unpaid_status_id');
								$updateOrderHistory = true;
								break;
							case 'refunded':
								$order_status_id = $this->config->get('gerencianet_refunded_status_id');
								$updateOrderHistory = true;
								break;
							case 'contested':
								$order_status_id = $this->config->get('gerencianet_contested_status_id');
								$updateOrderHistory = true;
								break;
							case 'canceled':
								$order_status_id = $this->config->get('gerencianet_canceled_status_id');
								$updateOrderHistory = true;
								break;
						}
						if ($updateOrderHistory) {
							if ($this->config->get('gerencianet_payment_notification_update_notify')) {
								$this->model_checkout_order->addOrderHistory(intval($orderIdFromNotification), intval($order_status_id), '', true);
							} else {
								$this->model_checkout_order->addOrderHistory(intval($orderIdFromNotification), intval($order_status_id), '', false);
							}
						}
						
					}

				} catch (GerencianetException $e) {
				    $this->log->write('GERENCIANET :: NOTIFICATION: ' . $token);
				    $this->log->write('GERENCIANET :: ERROR: ' . $e['errorDescription']);
				} catch (Exception $e) {
				    $this->log->write('GERENCIANET :: NOTIFICATION: ' . $token);
				    $this->log->write('GERENCIANET :: ERROR: ' . $e->getMessage());
				}
			}
		}
	}

	public function finalize() {
		$this->load->language('payment/gerencianet');

		$data['button_confirm'] = $this->language->get('button_confirm');

		if ($this->config->get('gerencianet_sandbox')) {
			$data['scriptPaymentToken'] = html_entity_decode("<script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://sandbox.gerencianet.com.br/v1/cdn/".$this->config->get('gerencianet_payee_code')."/'+v;s.async=false;s.id='".$this->config->get('gerencianet_payee_code')."';if(!document.getElementById('".$this->config->get('gerencianet_payee_code')."')){document.getElementsByTagName('head')[0].appendChild(s);};&#36;gn={validForm:true,processed:false,done:{},ready:function(fn){&#36;gn.done=fn;}};</script>");
		} else {
			$data['scriptPaymentToken'] = html_entity_decode("<script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://api.gerencianet.com.br/v1/cdn/".$this->config->get('gerencianet_payee_code')."/'+v;s.async=false;s.id='".$this->config->get('gerencianet_payee_code')."';if(!document.getElementById('".$this->config->get('gerencianet_payee_code')."')){document.getElementsByTagName('head')[0].appendChild(s);};&#36;gn={validForm:true,processed:false,done:{},ready:function(fn){&#36;gn.done=fn;}};</script>");
		}

		$this->load->model('extension/extension');
		$this->load->model('checkout/order');
		$this->document->addScript('catalog/view/javascript/jquery/jquery.mask.min.js');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			
			$data['item_name'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
			$data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$data['products'][] = array(
					'name'     => htmlspecialchars($product['name']),
					'model'    => htmlspecialchars($product['model']),
					'price'    => $this->formatCurrencyBRL(intval($product['price']*100)/100),
					'quantity' => $product['quantity'],
					'option'   => $option_data,
					'weight'   => $product['weight']
				);
			}

			$data['discount_amount_cart'] = 0;

			$total = $this->formatCurrencyBRL(intval(($order_info['total'] - $this->cart->getSubTotal())*100)/100);
			
			if ($total > 0) {
				$data['products'][] = array(
					'name'     => $this->language->get('text_total'),
					'model'    => '',
					'price'    => $total,
					'quantity' => 1,
					'option'   => array(),
					'weight'   => 0
				);
			} else {
				$data['discount_amount_cart'] -= $total;
			}


			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
			$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
			$this->document->addStyle('catalog/view/javascript/gerencianet/style.css');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => 'Cart',
				'href' => $this->url->link('checkout/cart')
			);

			$data['breadcrumbs'][] = array(
				'text' => 'Checkout',
				'href' => $this->url->link('checkout/checkout', '', 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('payment/gerencianet/finalize', '', 'SSL')
			);

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];
				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			$data['logged'] = $this->customer->isLogged();

			if (isset($this->session->data['account'])) {
				$data['account'] = $this->session->data['account'];
			} else {
				$data['account'] = '';
			}

		    $data['gerencianet_payment_option_billet'] = $this->config->get('gerencianet_payment_option_billet');
		    $data['gerencianet_payment_option_card'] = $this->config->get('gerencianet_payment_option_card');
		    $data['gerencianet_discount_billet_value'] = $this->getBilletDiscount();

		    if (isset($data['gerencianet_discount_billet_value'])) {
		    	if ($this->getBilletDiscount() > 0 ) {
		    		$data['discount_span'] = 'Desconto de ' . $this->config->get('gerencianet_discount_billet_value');
		    	} else {
		    		$data['discount_span'] = '';
		    	}
		    } else {
		    	$data['discount_span'] = '';
		    }

		    $order_data['totals'] = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

				}
			}

			$sort_order = array();

		    $data['totals_card'] = array();
		    $data['totals_billet'] = array();
			$data['tax_and_discounts'] = array();

			$shippingOnArray=true;
			$totalOnArray=true;
			$billetDiscountAdded=false;

			foreach ($order_data['totals'] as $total) {
				if (intval(floatval($total['value'])*100)==intval(floatval($order_info['total'])*100)) {
					$data['totals_billet'][] = array(
						'title' => $total['title'],
						'text'  => $this->formatCurrencyBRL(intval($total['value']-(($this->getBilletDiscount()/100)*$this->cart->getSubTotal())*100)/100),
					);
				} else {
					$data['totals_billet'][] = array(
						'title' => $total['title'],
						'text'  => $this->formatCurrencyBRL(intval($total['value']*100)/100),
					);
				}
				if (!$billetDiscountAdded && $this->getBilletDiscount()>0) {
					$data['totals_billet'][] = array(
						'title' => 'Desconto de ' . $this->config->get('gerencianet_discount_billet_value'),
						'text'  => '-' . $this->formatCurrencyBRL(intval(($this->getBilletDiscount()/100)*$this->cart->getSubTotal()*100)/100),
					);
					$billetDiscountAdded=true;
				}
				$data['totals_card'][] = array(
					'title' => $total['title'],
					'text'  => $this->formatCurrencyBRL(intval(floatval($total['value'])*100)/100),
				);
			}

			$data['total_with_discount'] = $order_info['total']-(($this->getBilletDiscount()/100)*$this->cart->getSubTotal());

			$data['total_paying_with_discount'] = $this->formatCurrencyBRL(floatval(($order_info['total']-(($this->getBilletDiscount()/100)*$this->cart->getSubTotal()))*100));
			$data['total_paying_without_discount'] = $this->formatBRL((floatval($order_info['total'])*100));


			$options = $this->gerencianet_config_payment_api();

			$params = array('total' => (floatval($order_info['total'])*100), 'brand' => 'visa');

			try {
			    $api = new Gerencianet($options);
			    $installments = $api->getInstallments($params, array());
			    $data['max_installments'] = end($installments['data']['installments'])['installment'] . "x de " . $this->formatCurrencyBRL(intval(end($installments['data']['installments'])['value']));
			} catch (GerencianetException $e) {
				$data['max_installments'] = "1 x de " . $data['total_paying_without_discount'];
			} catch (Exception $e) {
				$data['max_installments'] = "1 x de " . $data['total_paying_without_discount'];
			}

			if ($this->config->get('gerencianet_sandbox')) {
				$data['alert_sandbox'] = $this->language->get('text_testmode');
			} else {
				$data['alert_sandbox'] = '';
			}

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];
				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($order_info['payment_firstname'])) {
				$data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['first_name'] = '';
			}

			if (isset($order_info['payment_lastname'])) {
				$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['last_name'] = '';
			}

			if (isset($order_info['cpf'])) {
				$data['cpf'] = html_entity_decode($order_info['cpf'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['cpf'] = '';
			}
			if (isset($order_info['telephone'])) {
				$data['phone_number'] = html_entity_decode($order_info['telephone'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['phone_number'] = '';
			}

			if (isset($order_info['email'])) {
				$data['email'] = html_entity_decode($order_info['email'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['email'] = '';
			}

			if (isset($order_info['birth'])) {
				$data['birth'] = html_entity_decode($order_info['birth'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['birth'] = '';
			}

			if (isset($order_info['payment_street'])) {
				$data['street'] = html_entity_decode($order_info['payment_street'], ENT_QUOTES, 'UTF-8');
			} else if (isset($order_info['payment_address_1'])) {
				$data['street'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['street'] = '';
			}

			if (isset($order_info['payment_number'])) {
				$data['number'] = html_entity_decode($order_info['payment_number'], ENT_QUOTES, 'UTF-8');
			} else if (isset($order_info['payment_address_2'])) {
				$data['number'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['number'] = '';
			}

			if (isset($order_info['payment_neighborhood'])) {
				$data['neighborhood'] = html_entity_decode($order_info['payment_neighborhood'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['neighborhood'] = '';
			}

			if (isset($order_info['payment_complement'])) {
				$data['complement'] = html_entity_decode($order_info['payment_complement'], ENT_QUOTES, 'UTF-8');
			} else if (isset($order_info['payment_adress_complement'])) {
				$data['complement'] = html_entity_decode($order_info['payment_adress_complement'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['complement'] = '';
			}

			if (isset($order_info['payment_postcode'])) {
				$data['zipcode'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['zipcode'] = '';
			}

			if (isset($order_info['payment_city'])) {
				$data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['city'] = '';
			}

			if (isset($order_info['payment_zone'])) {
				$data['state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['state'] = '';
			}


			$this->session->data['total_values_card_order_' . $this->session->data['order_id']] = $data['totals_card'];
			$this->session->data['total_values_billet_order_' . $this->session->data['order_id']] = $data['totals_billet'];

			$data['shipping_required'] = $this->cart->hasShipping();

			$data['gn_pay_billet'] = $this->language->get('gn_pay_billet');
			$data['gn_pay_card'] = $this->language->get('gn_pay_card');
			$data['gn_minimum_value_of_charge'] = $this->language->get('gn_minimum_value_of_charge');
			$data['gn_invalid_cpf'] = $this->language->get('gn_invalid_cpf');
			$data['gn_invalid_cnpj'] = $this->language->get('gn_invalid_cnpj');
			$data['gn_invalid_corporate_name'] = $this->language->get('gn_invalid_corporate_name');
			$data['gn_hide_shipping_data'] = $this->language->get('gn_hide_shipping_data');
			$data['gn_show_shipping_data'] = $this->language->get('gn_show_shipping_data');
			$data['gn_charge_error'] = $this->language->get('gn_charge_error');
			$data['gn_invalid_card_expiration'] = $this->language->get('gn_invalid_card_expiration');
			$data['gn_invalid_card_cvv'] = $this->language->get('gn_invalid_card_cvv');
			$data['gn_invalid_card_number'] = $this->language->get('gn_invalid_card_number');
			$data['gn_invalid_card_installments'] = $this->language->get('gn_invalid_card_installments');
			$data['gn_invalid_card_brand'] = $this->language->get('gn_invalid_card_brand');
			$data['gn_invalid_state'] = $this->language->get('gn_invalid_state');
			$data['gn_invalid_city'] = $this->language->get('gn_invalid_city');
			$data['gn_invalid_cep'] = $this->language->get('gn_invalid_cep');
			$data['gn_invalid_number'] = $this->language->get('gn_invalid_number');
			$data['gn_invalid_street'] = $this->language->get('gn_invalid_street');
			$data['gn_invalid_birth'] = $this->language->get('gn_invalid_birth');
			$data['gn_invalid_email'] = $this->language->get('gn_invalid_email');
			$data['gn_invalid_neighborhood'] = $this->language->get('gn_invalid_neighborhood');
			$data['gn_charge_successfully_created'] = $this->language->get('gn_charge_successfully_created');
			$data['gn_pay_charge_card_error'] = $this->language->get('gn_pay_charge_card_error');
			$data['gn_pay_charge_card_error_generic'] = $this->language->get('gn_pay_charge_card_error_generic');
			$data['gn_pay_charge_card_error_generic_unknow'] = $this->language->get('gn_pay_charge_card_error_generic_unknow');
			$data['gn_pay_charge_card_successfully'] = $this->language->get('gn_pay_charge_card_successfully');
			$data['gn_loading_installments'] = $this->language->get('gn_loading_installments');
			$data['gn_invalid_phone_number'] = $this->language->get('gn_invalid_phone_number');
			$data['gn_card_payment_button'] = $this->language->get('gn_card_payment_button');
			$data['gn_card_payment_button_loading'] = $this->language->get('gn_card_payment_button_loading');
			$data['gn_billet_button_continue'] = $this->language->get('gn_billet_button_continue');
			$data['gn_billet_button_continue_loading'] = $this->language->get('gn_billet_button_continue_loading');
			$data['gn_phone'] = $this->language->get('gn_phone');
			$data['gn_phone_placeholder'] = $this->language->get('gn_phone_placeholder');
			$data['gn_show_billet'] = $this->language->get('gn_show_billet');
			$data['gn_card_payment_comments'] = $this->language->get('gn_card_payment_comments');
			$data['gn_email'] = $this->language->get('gn_email');
			$data['gn_email_placeholder'] = $this->language->get('gn_email_placeholder');
			$data['gn_name'] = $this->language->get('gn_name');
			$data['gn_name_placeholder'] = $this->language->get('gn_name_placeholder');
			$data['gn_cpf'] = $this->language->get('gn_cpf');
			$data['gn_cpf_placeholder'] = $this->language->get('gn_cpf_placeholder');
			$data['gn_cnpj_option'] = $this->language->get('gn_cnpj_option');
			$data['gn_cnpj'] = $this->language->get('gn_cnpj');
			$data['gn_corporate_name'] = $this->language->get('gn_corporate_name');
			$data['gn_corporate_name_placeholder'] = $this->language->get('gn_corporate_name_placeholder');
			$data['gn_phone'] = $this->language->get('gn_phone');
			$data['gn_phone_placeholder'] = $this->language->get('gn_phone_placeholder');
			$data['gn_birth'] = $this->language->get('gn_birth');
			$data['gn_birth_placeholder'] = $this->language->get('gn_birth_placeholder');
			$data['gn_billing_address_title'] = $this->language->get('gn_billing_address_title');
			$data['gn_show_shipping_data'] = $this->language->get('gn_show_shipping_data');
			$data['gn_street'] = $this->language->get('gn_street');
			$data['gn_street_placeholder'] = $this->language->get('gn_street_placeholder');
			$data['gn_street_number'] = $this->language->get('gn_street_number');
			$data['gn_street_number_placeholder'] = $this->language->get('gn_street_number_placeholder');
			$data['gn_neighborhood'] = $this->language->get('gn_neighborhood');
			$data['gn_neighborhood_placeholder'] = $this->language->get('gn_neighborhood_placeholder');
			$data['gn_address_complement'] = $this->language->get('gn_address_complement');
			$data['gn_address_complement_placeholder'] = $this->language->get('gn_address_complement_placeholder');
			$data['gn_cep'] = $this->language->get('gn_cep');
			$data['gn_cep_placeholder'] = $this->language->get('gn_cep_placeholder');
			$data['gn_city'] = $this->language->get('gn_city');
			$data['gn_city_placeholder'] = $this->language->get('gn_city_placeholder');
			$data['gn_state'] = $this->language->get('gn_state');
			$data['gn_state_no_selected'] = $this->language->get('gn_state_no_selected');
			$data['gn_shipping_address_title'] = $this->language->get('gn_shipping_address_title');
			$data['gn_no_shipping_data'] = $this->language->get('gn_no_shipping_data');
			$data['gn_add_shipping_data'] = $this->language->get('gn_add_shipping_data');
			$data['gn_change_shipping_data'] = $this->language->get('gn_change_shipping_data');
			$data['gn_card_title'] = $this->language->get('gn_card_title');
			$data['gn_card_brand'] = $this->language->get('gn_card_brand');
			$data['gn_card_brand_no_selected'] = $this->language->get('gn_card_brand_no_selected');
			$data['gn_card_installments_options'] = $this->language->get('gn_card_installments_options');
			$data['gn_card_installments_options_no_selected'] = $this->language->get('gn_card_installments_options_no_selected');
			$data['gn_card_number'] = $this->language->get('gn_card_number');
			$data['gn_card_cvv'] = $this->language->get('gn_card_cvv');
			$data['gn_card_expiration'] = $this->language->get('gn_card_expiration');
			$data['gn_card_expiration_month'] = $this->language->get('gn_card_expiration_month');
			$data['gn_card_expiration_month_placeholder'] = $this->language->get('gn_card_expiration_month_placeholder');
			$data['gn_card_expiration_year'] = $this->language->get('gn_card_expiration_year');
			$data['gn_card_expiration_year_placeholder'] = $this->language->get('gn_card_expiration_year_placeholder');
			$data['gn_billet_payment_method_comments'] = $this->language->get('gn_billet_payment_method_comments');
			$data['template'] = $this->config->get('config_template');

			$data['total_value'] = floatval($order_info['total']);
			$data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
			$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
			$data['address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
			$data['address2'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
			$data['city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
			$data['zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
			$data['country'] = $order_info['payment_iso_code_2'];
			$data['email'] = $order_info['email'];
			$data['cancel_return'] = $this->url->link('checkout/checkout', '', 'SSL');

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
         		$data['success_url'] = str_replace("http://", "https://", $this->url->link('payment/gerencianet/success'));
			} else {
				$data['success_url'] = $this->url->link('payment/gerencianet/success');
	      	}

	      	if (strpos($data['success_url'], '?') !== true) {
	      		$data['success_url'] = $data['success_url'] . "?";
	      	}

			$data['actual_order_id'] = $this->session->data['order_id'];

			$data['shipping_firstname'] = html_entity_decode($order_info['shipping_firstname'], ENT_QUOTES, 'UTF-8');
			$data['shipping_lastname'] = html_entity_decode($order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8');
			$data['shipping_address_1'] = html_entity_decode($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8');
			$data['shipping_address_2'] = html_entity_decode($order_info['shipping_address_2'], ENT_QUOTES, 'UTF-8');
			$data['shipping_city'] = html_entity_decode($order_info['shipping_city'], ENT_QUOTES, 'UTF-8');
			$data['shipping_postcode'] = html_entity_decode($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8');
			$data['shipping_zone'] = html_entity_decode($order_info['shipping_zone'], ENT_QUOTES, 'UTF-8');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (version_compare(VERSION, '2.2') < 0) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/gerencianet_payment.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/gerencianet_payment.tpl', $data));
				} else {
					$this->response->setOutput($this->load->view('default/template/payment/gerencianet_payment.tpl', $data));
				}
			} else {
				$this->response->setOutput($this->load->view('payment/gerencianet_payment', $data));
			}
		}
	}

	public function success() {
		$this->load->language('payment/gerencianet');
		$this->load->model('checkout/order');
		$this->load->model('extension/extension');

		if (isset($this->request->get['order']) && isset($this->request->get['charge']) && isset($this->request->get['payment'])) {
			$data['generated_order_number'] = $this->request->get['order'];
			$data['generated_charge_number'] = $this->request->get['charge'];
			$data['generated_payment_type'] = $this->request->get['payment'];

			if ($data['generated_payment_type']=="billet") {
				$data['generated_billet_url'] = urldecode($this->request->post['billet']);
				if (isset($this->session->data['total_values_billet_order_' . $data['generated_order_number']])) {
					$data['totals_session'] = $this->session->data['total_values_billet_order_' . $data['generated_order_number']];
				}
			} else {
				if (isset($this->session->data['total_values_card_order_' . $data['generated_order_number']])) {
					$data['totals_session'] = $this->session->data['total_values_card_order_' . $data['generated_order_number']];
				}
			}

			$order_info = $this->model_checkout_order->getOrder($data['generated_order_number']);

			if ($order_info) {
				
				$this->document->setTitle($this->language->get('success_payment'));

				$data['heading_title'] = $this->language->get('success_payment');

				$this->document->addStyle('catalog/view/javascript/gerencianet/style.css');

				$data['breadcrumbs'] = array();

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/home')
				);

				$data['breadcrumbs'][] = array(
					'text' => 'Cart',
					'href' => $this->url->link('checkout/cart')
				);

				$data['breadcrumbs'][] = array(
					'text' => 'Checkout',
					'href' => $this->url->link('checkout/checkout', '', 'SSL')
				);

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('success_payment'),
					'href' => $this->url->link('payment/gerencianet/success', '', 'SSL')
				);

				$data['gn_success_payment_title'] = $this->language->get('gn_success_payment_title');
				$data['gn_success_payment_order'] = $this->language->get('gn_success_payment_order');
				$data['gn_success_payment_order_billet_comment'] = $this->language->get('gn_success_payment_order_billet_comment');
				$data['gn_success_payment_order_card_comment'] = $this->language->get('gn_success_payment_order_card_comment');
				$data['gn_success_payment_order_number'] = $this->language->get('gn_success_payment_order_number');
				$data['gn_success_payment_type_billet_title'] = $this->language->get('gn_success_payment_type_billet_title');
				$data['gn_success_payment_type_card_title'] = $this->language->get('gn_success_payment_type_card_title');
				$data['gn_success_payment_box_title_billet'] = $this->language->get('gn_success_payment_box_title_billet');
				$data['gn_success_payment_box_title_card'] = $this->language->get('gn_success_payment_box_title_card');
				$data['gn_success_payment_box_comments_billet'] = $this->language->get('gn_success_payment_box_comments_billet');
				$data['gn_success_payment_box_comments_card_part1'] = $this->language->get('gn_success_payment_box_comments_card_part1');
				$data['gn_success_payment_box_comments_card_part2'] = $this->language->get('gn_success_payment_box_comments_card_part2');
				$data['gn_success_payment_charge_number'] = $this->language->get('gn_success_payment_charge_number');
				$data['gn_success_payment_billet_button'] = $this->language->get('gn_success_payment_billet_button');
				$data['gn_success_payment_order_details'] = $this->language->get('gn_success_payment_order_details');

				if ($this->customer->isLogged()) {
					$data['text_message'] = sprintf($this->language->get('gn_success_text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('information/contact'));
				} else {
					$data['text_message'] = sprintf($this->language->get('gn_success_text_guest'), $this->url->link('information/contact'));
				}


				if (isset($this->session->data['buyer_email'])) {
					$data['buyer_email'] = $this->session->data['buyer_email'];
				} else {
					$data['buyer_email'] = "";
				}
			
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				if (version_compare(VERSION, '2.2') < 0) {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/gerencianet_success.tpl')) {
						$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/payment/gerencianet_success.tpl', $data));
					} else {
						$this->response->setOutput($this->load->view('default/template/payment/gerencianet_success.tpl', $data));
					}
				} else {
					$this->response->setOutput($this->load->view('payment/gerencianet_success', $data));
				}
			}
		}
	}

	public function gerencianet_config_payment_api() {
		$this->load->language('payment/gerencianet');
	    $this->load->model('setting/setting');

    	if ($this->config->get('gerencianet_sandbox')) {
			$options = array(
			  'client_id' => $this->config->get('gerencianet_client_id_development'),
			  'client_secret' => $this->config->get('gerencianet_client_secret_development'),
			  'sandbox' => true
			);

		} else {
			$options = array(
			  'client_id' => $this->config->get('gerencianet_client_id_production'),
			  'client_secret' => $this->config->get('gerencianet_client_secret_production'),
			  'sandbox' => false
			);

		}
	    
		return $options;
	}

	public function create_charge() {

		$options = $this->gerencianet_config_payment_api();

		$this->load->model('checkout/order');
		$this->load->model('extension/extension');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$order_data['totals'] = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$sort_order = array();

		$results = $this->model_extension_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);
			}
		}

		$sort_order = array();

		foreach ($order_data['totals'] as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $order_data['totals']);

		$data['totals'] = array();
		$data['taxes'] = array();

		$shippingOnArray=true;
		$subTotalOnArray=true;
		$totalOnArray=true;
		if (isset($this->session->data['shipping_method']['cost'])) {
			$shipping_price = $this->session->data['shipping_method']['cost'];
		} else {
			$shipping_price=0;
		}
		foreach ($order_data['totals'] as $total) {
			if ((floatval($total['value'])==floatval($shipping_price)) && $shippingOnArray) {
				$shippingOnArray=false;
			} else if (((floatval($total['value'])==floatval($this->cart->getSubTotal())) || $total['title']=="Sub-Total") && $subTotalOnArray) {
				$subTotalOnArray=false;
			} else if (((floatval($total['value'])==floatval($order_info['total'])) || $total['title']=="Total") && $totalOnArray) {
				$totalOnArray=false;
			} else {
				if (floatval($total['value'])>0) {
					$data['taxes'][] = array(
						'title' => $total['title'],
						'value'  => $total['value'],
					);
				}
			}
		}

		if ($order_info) {
			$items = array();
			foreach ($this->cart->getProducts() as $product) {

				$item = array(
					'name' => htmlspecialchars($product['name']),
			        'amount' => intval($product['quantity']),
			        'value' => (int)(number_format((floatval($product['price'])*100), 0, '', ''))
				);
				array_push($items, $item);
			}
		}

		foreach ($data['taxes'] as $new_tax) {
			$item = array(
				'name' => $new_tax['title'],
		        'amount' => 1,
		        'value' => intval(floatval($new_tax['value'])*100)
			);
			array_push($items, $item);
		}

		if (isset($this->session->data['shipping_method']['cost'])) {
			$shipping = array(
			    array(
			        'name' => $this->session->data['shipping_method']['title'],
			        'value' => (int)(number_format(floatval($this->session->data['shipping_method']['cost'])*100, 0, '', ''))
			    )
			);
		}

		$metadata = array(
		    'custom_id' => strval($this->session->data['order_id']),
		    'notification_url' => $this->url->link('payment/gerencianet/callback', '', 'SSL')
		);

		if (isset($this->session->data['shipping_method']['cost'])) {
			$body = array(
			    'items' => $items,
	    		'shippings' => $shipping,
	    		'metadata' => $metadata
			);
		} else {
			$body = array(
			    'items' => $items,
	    		'metadata' => $metadata
			);
		}

		try {
		    $api = new Gerencianet($options);
		    $charge = $api->createCharge(array(), $body);
		 
		    $this->result_api($charge, true);

		} catch (GerencianetException $e) {
		    $errorResponse = array(
		        "code" => $e->code,
		        "error" => $e->error,
		        "message" => $e->errorDescription,
		    );
		    $this->result_api($errorResponse, false);
		} catch (Exception $e) {
		    $errorResponse = array(
		        "message" => $e->getMessage(),
		    );
		    $this->result_api($errorResponse, false);
		}
	}


	public function pay_billet() {

		$this->load->language('payment/gerencianet');
		$this->load->model('checkout/order');
		$this->load->model('extension/extension');

		$data['id_charge'] = $this->request->post['id_charge'];
		
		$options = $this->gerencianet_config_payment_api();

		if ($this->config->get('gerencianet_billet_days_to_expire')=="") {
	    	$billetExpireDays = "5";
	    } else {
	    	if (intval($this->config->get('gerencianet_billet_days_to_expire'))<1) {
	        	$billetExpireDays = "5";
	    	} else {
	    		$billetExpireDays = intval($this->config->get('gerencianet_billet_days_to_expire'));
	    	}
	    }
	    
      	$expirationDate = date("Y-m-d", mktime (0, 0, 0, date("m")  , date("d")+intval($billetExpireDays), date("Y")));

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {

			$order_data['totals'] = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
				}
			}

			$sort_order = array();

			foreach ($order_data['totals'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $order_data['totals']);

			$data['totals'] = array();
			$data['taxes'] = array();

			if (isset($this->session->data['shipping_method']['cost'])) {
				$shipp = $this->session->data['shipping_method']['cost'];
			} else {
				$shipp = 0;
			}
			
			$discount_cupouns_and_vouchers = ($this->cart->getSubTotal()+$shipp)-$order_info['total'];

			$discountFormatedByOC = $this->formatMoney(intval(ceil((($this->getBilletDiscount()/100)*$this->cart->getSubTotal() + $discount_cupouns_and_vouchers)*100))/100, true);
			$discountFormatedByOC_no_currency_format = $this->formatMoney(intval(ceil((($this->getBilletDiscount()/100)*$this->cart->getSubTotal())*100))/100, true);
			$total_billet_discount_no_currency_format=0;
			if ($this->getBilletDiscount()>0) {
				$total_discount = $discountFormatedByOC;
				$total_billet_discount_no_currency_format = $discountFormatedByOC_no_currency_format;
			} else {
				$total_discount = ceil(floatval(($this->cart->getSubTotal()+$shipp)-$order_info['total'])*100);
			}

			if (isset($this->request->post['first_name'])) { 
				$data['first_name'] = 	$this->request->post['first_name'];
			} else {
				if (isset($order_info['payment_firstname'])) {
					$data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['first_name'] = '';
				}
			}

			if (isset($this->request->post['last_name'])) { 
				$data['last_name'] = 	$this->request->post['last_name'];
			} else {
				if (isset($order_info['payment_lastname'])) {
					$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['last_name'] = '';
				}
			}

			if (isset($this->request->post['cpf'])) { 
				$data['cpf'] = 	$this->request->post['cpf'];
			} else {
				if (isset($order_info['cpf'])) {
					$data['cpf'] = $order_info['cpf'];
				} else {
					$data['cpf'] = '';
				}
			}

			if (isset($this->request->post['phone_number'])) { 
				$data['phone_number'] = 	$this->request->post['phone_number'];
			} else {
				if (isset($data['phone_number'])) {
					$data['phone_number'] = $order_info['phone_number'];
				} else {
					$data['phone_number'] = '';
				}
			}

			if (isset($this->request->post['pay_billet_with_cnpj'])) { 
				$data['pay_billet_with_cnpj'] = $this->request->post['pay_billet_with_cnpj'];
			} else {
				$data['pay_billet_with_cnpj'] = '';
			}

			if (isset($this->request->post['cnpj'])) { 
				$data['cnpj'] = $this->request->post['cnpj'];
			} else {
				$data['cnpj'] = '';
			}

			if (isset($this->request->post['corporate_name'])) { 
				$data['corporate_name'] = $this->request->post['corporate_name'];
			} else {
				$data['corporate_name'] = '';
			}


			if ($data['pay_billet_with_cnpj'] && $data['corporate_name'] && $data['cnpj']) {
				$juridical_data = array(
				  'corporate_name' => $data['corporate_name'],
				  'cnpj' => $data['cnpj']
				);

				$customer = array(
				    'name' => $data['first_name'] . ' ' . $data['last_name'],
				    'cpf' => $data['cpf'],
				    'phone_number' => $data['phone_number'],
  					'juridical_person' => $juridical_data
				);
			} else {
				$customer = array(
				    'name' => $data['first_name'] . ' ' . $data['last_name'],
				    'cpf' => $data['cpf'],
				    'phone_number' => $data['phone_number']
				);
			}


			$params = array('id' => $data['id_charge']);

			$discount = array(
				'type' => 'currency',
				'value' => intval($total_discount)
			);

			if ($total_discount>0) {
				$body = array(
				    'payment' => array(
				        'banking_billet' => array(
				            'expire_at' => $expirationDate,
				            'customer' => $customer,
				            'discount' => $discount
				        )
				    )
				);
			} else {
				$body = array(
				    'payment' => array(
				        'banking_billet' => array(
				            'expire_at' => $expirationDate,
				            'customer' => $customer
				        )
				    )
				);
			}

			try {
			    $api = new Gerencianet($options);
			    $charge = $api->payCharge($params, $body);

			    if (isset($this->session->data['shipping_method']['cost'])) {
					$shipping_price = $this->session->data['shipping_method']['cost'];
				} else {
					$shipping_price=0;
				}

			    $totalWithBilletDiscount = ($order_info['total']-floatval($total_discount/100));

			    if ($total_discount>0) {
				    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET payment_method = 'Boleto - Gerencianet', total = '" . (float)$totalWithBilletDiscount . "'  WHERE order_id = '" . (int)$this->session->data['order_id'] . "'");
				    $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$this->session->data['order_id'] . "', code = 'voucher', title = 'Desconto de " . $this->config->get('gerencianet_discount_billet_value') . " no Boleto', `value` = '" . -floatval($discountFormatedByOC_no_currency_format/100) . "', sort_order = '2'");
				    $this->db->query("UPDATE " . DB_PREFIX . "order_total SET value = '" . (float)$totalWithBilletDiscount . "' WHERE title = 'Total' AND order_id = '" . (int)$this->session->data['order_id'] . "'");
			    } else {
			    	$this->db->query("UPDATE `" . DB_PREFIX . "order` SET payment_method = 'Boleto - Gerencianet' WHERE order_id = '" . (int)$this->session->data['order_id'] . "'");
			    }
			    
			    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('gerencianet_waiting_status_id'), '<a href="' . $charge['data']['link'] . '" target="_blank">' . $this->language->get('gn_billet_oc_order_comment') . '</a>', true);
			    $this->session->data['order_id'] = '';
			    $this->cart->clear();
			    $this->result_api($charge, true);
			} catch (GerencianetException $e) {
			    $errorResponse = array(
			        "code" => $e->code,
			        "error" => $e->error,
			        "message" => $e->errorDescription,
			    );
			    $this->result_api($errorResponse, false);
			} catch (Exception $e) {
			    $errorResponse = array(
			        "message" => $e->getMessage(),
			    );
			    $this->result_api($errorResponse, false);
			}
		}
	}


	public function pay_card() {

		$this->load->language('payment/gerencianet');
		$this->load->model('checkout/order');
		$this->load->model('extension/extension');

		$options = $this->gerencianet_config_payment_api();

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {

			$order_data['totals'] = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
				}
			}

			$sort_order = array();

			foreach ($order_data['totals'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $order_data['totals']);

			$data['totals'] = array();
			$data['taxes'] = array();

			$total_discount=0;

			foreach ($order_data['totals'] as $total) {
				
				if (floatval($total['value'])<0) {
					$total_discount += $this->formatMoney(intval($total['value']*100)/100, true);
				}
			}

			if (isset($this->session->data['shipping_method']['cost'])) {
				$shipp = $this->session->data['shipping_method']['cost'];
			} else {
				$shipp = 0;
			}

			$total_discount = intval(ceil((($this->cart->getSubTotal()+$shipp)-$order_info['total'])*100));

			if (isset($this->request->post['first_name'])) { 
				$data['first_name'] = 	$this->request->post['first_name'];
			} else {
				if (isset($order_info['payment_firstname'])) {
					$data['first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['first_name'] = '';
				}
			}

			if (isset($this->request->post['last_name'])) { 
				$data['last_name'] = 	$this->request->post['last_name'];
			} else {
				if (isset($order_info['payment_lastname'])) {
					$data['last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
				} else {
					$data['last_name'] = '';
				}
			}

			if (isset($this->request->post['cpf'])) { 
				$data['cpf'] = 	$this->request->post['cpf'];
			} else {
				if (isset($order_info['cpf'])) {
					$data['cpf'] = $order_info['cpf'];
				} else {
					$data['cpf'] = '';
				}
			}

			if (isset($this->request->post['phone_number'])) { 
				$data['phone_number'] = 	$this->request->post['phone_number'];
			} else {
				if (isset($data['phone_number'])) {
					$data['phone_number'] = $order_info['phone_number'];
				} else {
					$data['phone_number'] = '';
				}
			}

			if (isset($this->request->post['email'])) { 
				$data['email'] = 	$this->request->post['email'];
			} else {
				if (isset($data['email'])) {
					$data['email'] = $order_info['email'];
				} else {
					$data['email'] = '';
				}
			}

			if (isset($this->request->post['birth'])) { 
				$data['birth'] = 	$this->request->post['birth'];
			} else {
				if (isset($data['birth'])) {
					$data['birth'] = $order_info['birth'];
				} else {
					$data['birth'] = '';
				}
			}


			if (isset($this->request->post['street'])) { 
				$data['street'] = 	$this->request->post['street'];
			} else {
				if (isset($data['street'])) {
					$data['street'] = $order_info['street'];
				} else {
					$data['street'] = '';
				}
			}

			if (isset($this->request->post['number'])) { 
				$data['number'] = 	$this->request->post['number'];
			} else {
				if (isset($data['number'])) {
					$data['number'] = $order_info['number'];
				} else {
					$data['number'] = '';
				}
			}


			if (isset($this->request->post['birth'])) { 
				$data['birth'] = 	$this->request->post['birth'];
			} else {
				if (isset($data['birth'])) {
					$data['birth'] = $order_info['birth'];
				} else {
					$data['birth'] = '';
				}
			}


			if (isset($this->request->post['neighborhood'])) { 
				$data['neighborhood'] = 	$this->request->post['neighborhood'];
			} else {
				if (isset($data['neighborhood'])) {
					$data['neighborhood'] = $order_info['neighborhood'];
				} else {
					$data['neighborhood'] = '';
				}
			}

			if (isset($this->request->post['complement'])) { 
				$data['complement'] = 	$this->request->post['complement'];
			} else {
				if (isset($data['complement'])) {
					$data['complement'] = $order_info['complement'];
				} else {
					$data['complement'] = '';
				}
			}


			if (isset($this->request->post['zipcode'])) { 
				$data['zipcode'] = 	$this->request->post['zipcode'];
			} else {
				if (isset($data['zipcode'])) {
					$data['zipcode'] = $order_info['zipcode'];
				} else {
					$data['zipcode'] = '';
				}
			}


			if (isset($this->request->post['city'])) { 
				$data['city'] = 	$this->request->post['city'];
			} else {
				if (isset($data['city'])) {
					$data['city'] = $order_info['city'];
				} else {
					$data['city'] = '';
				}
			}


			if (isset($this->request->post['state'])) { 
				$data['state'] = $this->request->post['state'];
			} else {
				if (isset($data['state'])) {
					$data['state'] = $order_info['state'];
				} else {
					$data['state'] = '';
				}
			}

			if (isset($this->request->post['installments'])) { 
				$data['installments'] = $this->request->post['installments'];
			} else {
				if (isset($data['installments'])) {
					$data['installments'] = $order_info['installments'];
				} else {
					$data['installments'] = '';
				}
			}

			if (isset($this->request->post['id_charge'])) { 
				$data['id_charge'] = $this->request->post['id_charge'];
			} else {
				$data['id_charge'] = '';
			}

			if (isset($this->request->post['payment_token'])) { 
				$data['payment_token'] = $this->request->post['payment_token'];
			} else {
				$data['payment_token'] = '';
			}

			$this->session->data['buyer_email'] = $data['email'];

			$params = array('id' => $data['id_charge']);
			$paymentToken = $data['payment_token'];


			if (isset($this->request->post['pay_card_with_cnpj'])) { 
				$data['pay_card_with_cnpj'] = $this->request->post['pay_card_with_cnpj'];
			} else {
				$data['pay_card_with_cnpj'] = '';
			}

			if (isset($this->request->post['cnpj'])) { 
				$data['cnpj'] = $this->request->post['cnpj'];
			} else {
				$data['cnpj'] = '';
			}

			if (isset($this->request->post['corporate_name'])) { 
				$data['corporate_name'] = $this->request->post['corporate_name'];
			} else {
				$data['corporate_name'] = '';
			}

			if ($data['pay_card_with_cnpj'] && $data['corporate_name'] && $data['cnpj']) {
				$juridical_data = array(
				  'corporate_name' => $data['corporate_name'],
				  'cnpj' => $data['cnpj']
				);

				$customer = array(
				    'name' => $data['first_name'] . " " . $data['last_name'],
				    'cpf' => $data['cpf'],
				    'phone_number' => $data['phone_number'],
				    'email' => $data['email'],
				    'birth' => $data['birth'],
  					'juridical_person' => $juridical_data
				);
			} else {
				$customer = array(
				    'name' => $data['first_name'] . " " . $data['last_name'],
				    'cpf' => $data['cpf'],
				    'phone_number' => $data['phone_number'],
				    'email' => $data['email'],
				    'birth' => $data['birth']
				);
			}

			$billingAddress = array(
			    'street' => $data['street'],
			    'number' => $data['number'],
			    'neighborhood' => $data['neighborhood'],
			    'zipcode' => preg_replace( '/[^0-9]/', '', $data['zipcode']),
			    'city' => $data['city'],
			    'state' => $data['state'],
			    'complement' => $data['complement']
			);

			$discount = array(
				'type' => 'currency',
				'value' => intval($total_discount)
			);

			if ($total_discount>0) {
				$body = array(
				    'payment' => array(
				        'credit_card' => array(
				            'installments' => intval($data['installments']),
				            'billing_address' => $billingAddress,
				            'payment_token' => $paymentToken,
				            'customer' => $customer,
				            'discount' => $discount
				        )
				    )
				);
			} else {
				$body = array(
				    'payment' => array(
				        'credit_card' => array(
				            'installments' => intval($data['installments']),
				            'billing_address' => $billingAddress,
				            'payment_token' => $paymentToken,
				            'customer' => $customer
				        )
				    )
				);
			}
			
			try {
			    $api = new Gerencianet($options);
			    $charge = $api->payCharge($params, $body);

			    $this->db->query("UPDATE `" . DB_PREFIX . "order` SET payment_method = 'Cartão de Crédito - Gerencianet' WHERE order_id = '" . (int)$this->session->data['order_id'] . "'");

			    $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('gerencianet_waiting_status_id'), $this->language->get('gn_card_oc_order_comment'), true);
			    $this->session->data['order_id'] = '';
			    $this->cart->clear();
			    $this->result_api($charge, true);
			} catch (GerencianetException $e) {
			    $errorResponse = array(
			        "code" => $e->code,
			        "error" => $e->error,
			        "message" => $e->errorDescription,
			    );
			    $this->result_api($errorResponse, false);
			} catch (Exception $e) {
			    $errorResponse = array(
			        "message" => $e->getMessage(),
			    );
			    $this->result_api($errorResponse, false);
			}
		}
	}


	public function get_installments() {

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$data['total'] = number_format(floatval($order_info['total']*100), 0, '', '');		
			$data['brand'] = $this->request->post['brand'];

			$options = $this->gerencianet_config_payment_api();

			$params = array('total' => $data['total'], 'brand' => $data['brand']);

			try {
			    $api = new Gerencianet($options);
			    $installments = $api->getInstallments($params, array());

			    $this->result_api($installments, true);
			} catch (GerencianetException $e) {
			    $errorResponse = array(
			        "code" => $e->code,
			        "error" => $e->error,
			        "message" => $e->errorDescription,
			    );
			    $this->result_api($errorResponse, false);
			} catch (Exception $e) {
			    $errorResponse = array(
			    	"code" => 0,
			        "message" => $e->getMessage(),
			    );
			    $this->result_api($errorResponse, false);
			}
		}
	}


	public function result_api($result, $success) {
		if ($success) {
			echo json_encode($result);
		} else {
			if (isset($result['message']['property'])) {
				$property = explode("/",$result['message']['property']);
				$propertyName = end($property);
			} else {
				$propertyName="";
			}

			$messageShow = $this->getErrorMessage(intval($result['code']), $propertyName);
			$errorResponse = array(
				"code" => 0,
		        "message" => $messageShow
		    );
			echo json_encode($errorResponse);
		}
	}

	public function getErrorMessage($error_code, $property) {
		$messageErrorDefault = 'Ocorreu um erro ao tentar realizar a sua requisição. Entre em contato com o proprietário da loja.';
		switch($error_code) {
			case 3500000:
				$message = 'Erro interno do servidor.';
				break;
			case 3500001:
				$message = $messageErrorDefault;
				break;
			case 3500002:
				$message = $messageErrorDefault;
				break;
			case 3500007:
				$message = 'O tipo de pagamento informado não está disponível.';
				break;
			case 3500008:
				$message = 'Requisição não autorizada.';
				break;
			case 3500010:
				$message = $messageErrorDefault;
				break;
			case 3500021:
				$message = 'Não é permitido parcelamento para assinaturas.';
				break;
			case 3500030:
				$message = 'Esta transação já possui uma forma de pagamento definida.';
				break;
			case 3500034:
				$message = 'O campo ' . $this->getFieldName($property) . ' não está preenchido corretamente.';
				break;
			case 3500042:
				$message = $messageErrorDefault;
				break;
			case 3500044:
				$message = 'A transação não pode ser paga. Entre em contato com o vendedor.';
				break;
			case 4600002:
				$message = $messageErrorDefault;
				break;
			case 4600012:
				$message = 'Transação não autorizada.';
				break;
			case 4600022:
				$message = $messageErrorDefault;
				break;
			case 4600026:
				$message = 'cpf inválido';
				break;
			case 4600029:
				$message = 'pedido já existe';
				break;
			case 4600032:
				$message = $messageErrorDefault;
				break;
			case 4600035:
				$message = 'Serviço indisponível para a conta. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
				break;
			case 4600037:
				$message = 'O valor da emissão é superior ao limite operacional da conta. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
				break;
			case 4600111:
				$message = 'valor de cada parcela deve ser igual ou maior que R$5,00';
				break;
			case 4600142:
				$message = 'Transação não processada por conter incoerência nos dados cadastrais.';
				break;
			case 4600148:
				$message = 'já existe um pagamento cadastrado para este identificador.';
				break;
			case 4600196:
				$message = $messageErrorDefault;
				break;
			case 4600204:
				$message = 'cpf deve ter 11 números';
				break;
			case 4600209:
				$message = 'Limite de emissões diárias excedido. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
				break;
			case 4600210:
				$message = 'não é possível emitir três emissões idênticas. Por favor, entre em contato com nosso suporte para orientações sobre o uso correto dos serviços Gerencianet.';
				break;
			case 4600212:
				$message = 'Número de telefone já associado a outro CPF. Não é possível cadastrar o mesmo telefone para mais de um CPF.';
				break;
			case 4600224:
				$message = $messageErrorDefault;
				break;
			case 4600254:
				$message = 'identificador da recorrência não foi encontrado';
				break;
			case 4600257:
				$message = 'pagamento recorrente já executado';
				break;
			case 4600329:
				$message = 'código de segurança deve ter três digitos';
				break;
			case 4699999:
				$message = 'falha inesperada';
				break;
			default:
				$message = $messageErrorDefault;
				break;
		}
		$this->log->write('GERENCIANET :: ERROR: ' . $error_code);
		return $message;
	}
	
	public function getFieldName($name) {
		switch($name) {
			case "neighborhood":
				return 'Bairro';
				break;
			case "street":
				return 'Endereço';
				break;
			case "number":
				return 'Número';
				break;
			case "city":
				return 'Cidade';
				break;
			case "zipcode":
				return 'CEP';
				break;
			case "name":
				return 'Nome';
				break;
			case "cpf":
				return 'CPF';
				break;
			case "phone_number":
				return 'Telefone de contato';
				break;
			case "email":
				return 'Email';
				break;
			case "cpf":
				return 'CPF';
				break;
			case "birth":
				return 'Data de nascimento';
				break;
			default:
				return '';
				break;
		}
	}

	public function formatMoney($value, $gnFormat) {
	    $cleanString = preg_replace('/([^0-9\.,])/i', '', $value);
	    $onlyNumbersString = preg_replace('/([^0-9])/i', '', $value);

	    $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

	    $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
	    $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

	    if ($gnFormat) {
	    	return (int) (((float) str_replace(',', '.', $removedThousendSeparator))*100);
	    } else {
	    	return ((float) str_replace(',', '.', $removedThousendSeparator));
	    }
	}

	public function formatCurrencyBRL($value) {
		$formated = "R$".number_format($value/100, 2, ',', '.');

		return $formated;
	}

	public function formatBRL($value) {
		$formated = "R$".number_format($value/100, 2, ',', '.');

		return $formated;
	}

	public function getBilletDiscount() {
	    return floatval(preg_replace( '/[^0-9.]/', '', str_replace(",",".",$this->config->get('gerencianet_discount_billet_value'))));
	}

}