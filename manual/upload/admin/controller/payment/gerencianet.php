<?php
class ControllerPaymentGerencianet extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('payment/gerencianet');
        $this->document->setTitle('Gerencianet');
        $this->load->model('setting/setting');
        $gerencianetModuleVersion = "v0.4.2";

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $incorrectsFields = "";

            if ($this->request->post['gerencianet_status'] == "0") {
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_status');
            }

            if ($this->request->post['gerencianet_client_id_development'] == "" || $this->request->post['gerencianet_client_secret_development'] == "") {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_development_keys');
            }

            if ($this->request->post['gerencianet_client_id_production'] == "" || $this->request->post['gerencianet_client_secret_production'] == "") {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_production_keys');
            }

            if ($this->request->post['gerencianet_payee_code'] == "") {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_payee_code');
            }

            $payment_option = false;
            if (isset($this->request->post['gerencianet_payment_option_card'])) {
                if ($this->request->post['gerencianet_payment_option_card'] == "1") {
                    $payment_option = true;
                }
            } else {
                $this->request->post['gerencianet_payment_option_card'] = "0";
            }
            if (isset($this->request->post['gerencianet_payment_option_billet'])) {
                if ($this->request->post['gerencianet_payment_option_billet'] == "1") {
                    $payment_option = true;
                }
            } else {
                $this->request->post['gerencianet_payment_option_billet'] = "0";
            }
            if (!$payment_option) {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_no_payment_selected');
            }

            if (isset($this->request->post['gerencianet_osc'])) {
                if ($this->request->post['gerencianet_osc'] != "1") {
                    $this->request->post['gerencianet_osc'] = "0";
                }
            } else {
                $this->request->post['gerencianet_osc'] = "0";
            }

            $this->request->post['gerencianet_billet_instruction_line_1'] = substr($this->request->post['gerencianet_billet_instruction_line_1'], 0, 90);
            $this->request->post['gerencianet_billet_instruction_line_2'] = substr($this->request->post['gerencianet_billet_instruction_line_2'], 0, 90);
            $this->request->post['gerencianet_billet_instruction_line_3'] = substr($this->request->post['gerencianet_billet_instruction_line_3'], 0, 90);
            $this->request->post['gerencianet_billet_instruction_line_4'] = substr($this->request->post['gerencianet_billet_instruction_line_4'], 0, 90);

            if ($incorrectsFields == "") {
                $this->session->data['success'] = $this->language->get('gn_config_saved');
            } else {
                $this->session->data['success'] = $this->language->get('gn_config_saved_not_on') . "<b>" . $incorrectsFields . "</b>";
                $this->request->post['gerencianet_status'] = "0";
            }

            $this->model_setting_setting->editSetting('gerencianet', $this->request->post);
            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->document->addScript('../catalog/view/javascript/jquery/jquery.mask.min.js');
        $this->document->addStyle('../catalog/view/javascript/gerencianet/style.css');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['button_save'] = $this->language->get('text_button_save');
        $data['button_cancel'] = $this->language->get('text_button_cancel');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['gn_entry_sandbox'] = $this->language->get('gn_entry_sandbox');
        $data['gn_entry_client_id_development'] = $this->language->get('gn_entry_client_id_development');
        $data['gn_entry_client_secret_development'] = $this->language->get('gn_entry_client_secret_development');
        $data['gn_entry_client_id_production'] = $this->language->get('gn_entry_client_id_production');
        $data['gn_entry_client_secret_production'] = $this->language->get('gn_entry_client_secret_production');
        $data['gn_entry_payee_code'] = $this->language->get('gn_entry_payee_code');
        $data['gn_entry_payment_options'] = $this->language->get('gn_entry_payment_options');
        $data['gn_entry_payment_options_billet_and_card'] = $this->language->get('gn_entry_payment_options_billet_and_card');
        $data['gn_entry_payment_options_billet'] = $this->language->get('gn_entry_payment_options_billet');
        $data['gn_entry_payment_options_card'] = $this->language->get('gn_entry_payment_options_card');
        $data['gn_entry_installments'] = $this->language->get('gn_entry_installments');
        $data['gn_config_geral'] = $this->language->get('gn_config_geral');
        $data['gn_config_order_status'] = $this->language->get('gn_config_order_status');
        $data['gn_edit_config'] = $this->language->get('gn_edit_config');
        $data['gn_entry_billet_days_to_expire'] = $this->language->get('gn_entry_billet_days_to_expire');
        $data['gn_entry_billet_days_to_expire_placeholder'] = $this->language->get('gn_entry_billet_days_to_expire_placeholder');
        $data['gn_entry_new_status'] = $this->language->get('gn_entry_new_status');
        $data['gn_entry_waiting_status'] = $this->language->get('gn_entry_waiting_status');
        $data['gn_entry_paid_status'] = $this->language->get('gn_entry_paid_status');
        $data['gn_entry_unpaid_status'] = $this->language->get('gn_entry_unpaid_status');
        $data['gn_entry_refunded_status'] = $this->language->get('gn_entry_refunded_status');
        $data['gn_entry_contested_status'] = $this->language->get('gn_entry_contested_status');
        $data['gn_entry_canceled_status'] = $this->language->get('gn_entry_canceled_status');
        $data['gn_entry_status_config_description'] = $this->language->get('gn_entry_status_config_description');
        $data['gn_entry_help_sandbox'] = $this->language->get('gn_entry_help_sandbox');
        $data['gn_entry_sandbox_production'] = $this->language->get('gn_entry_sandbox_production');
        $data['gn_entry_sandbox_development'] = $this->language->get('gn_entry_sandbox_development');
        $data['gn_entry_help_billet_expire'] = $this->language->get('gn_entry_help_billet_expire');
        $data['gn_entry_help_status_new'] = $this->language->get('gn_entry_help_status_new');
        $data['gn_entry_help_status_waiting'] = $this->language->get('gn_entry_help_status_waiting');
        $data['gn_entry_help_status_paid'] = $this->language->get('gn_entry_help_status_paid');
        $data['gn_entry_help_status_unpaid'] = $this->language->get('gn_entry_help_status_unpaid');
        $data['gn_entry_help_status_refunded'] = $this->language->get('gn_entry_help_status_refunded');
        $data['gn_entry_help_status_contested'] = $this->language->get('gn_entry_help_status_contested');
        $data['gn_entry_help_status_canceled'] = $this->language->get('gn_entry_help_status_canceled');
        $data['gn_entry_help_status'] = $this->language->get('gn_entry_help_status');
        $data['gn_entry_help_keys'] = $this->language->get('gn_entry_help_keys');
        $data['gn_entry_help_payee_code'] = $this->language->get('gn_entry_help_payee_code');
        $data['gn_entry_help_notification_update'] = $this->language->get('gn_entry_help_notification_update');
        $data['gn_entry_help_notification_update_notify'] = $this->language->get('gn_entry_help_notification_update_notify');
        $data['gn_entry_help_discount'] = $this->language->get('gn_entry_help_discount');
        $data['gn_entry_help_billet_instructions'] = $this->language->get('gn_entry_help_billet_instructions');
        $data['gn_entry_payment_notification_update'] = $this->language->get('gn_entry_payment_notification_update');
        $data['gn_entry_payment_notification_update_notify'] = $this->language->get('gn_entry_payment_notification_update_notify');
        $data['gn_entry_discount_title'] = $this->language->get('gn_entry_discount_title');
        $data['gn_entry_discount_billet'] = $this->language->get('gn_entry_discount_billet');
        $data['gn_entry_discount_status'] = $this->language->get('gn_entry_discount_status');
        $data['gn_entry_discount_type'] = $this->language->get('gn_entry_discount_type');
        $data['gn_entry_discount_type_fixed'] = $this->language->get('gn_entry_discount_type_fixed');
        $data['gn_entry_discount_type_percent'] = $this->language->get('gn_entry_discount_type_percent');
        $data['gn_entry_billet_instructions'] = $this->language->get('gn_entry_billet_instructions');
        $data['gn_entry_discount_value'] = $this->language->get('gn_entry_discount_value');
        $data['gn_entry_discount_card'] = $this->language->get('gn_entry_discount_card');
        $data['gn_entry_official_module_title'] = $this->language->get('gn_entry_official_module_title');
        $data['gn_entry_official_module_version'] = $gerencianetModuleVersion;
        $data['gn_config_credentials'] = $this->language->get('gn_config_credentials');
        $data['gn_entry_status_on'] = $this->language->get('gn_entry_status_on');
        $data['gn_entry_status_off'] = $this->language->get('gn_entry_status_off');
        $data['gn_entry_keys_production_title'] = $this->language->get('gn_entry_keys_production_title');
        $data['gn_entry_keys_development_title'] = $this->language->get('gn_entry_keys_development_title');
        $data['gn_entry_keys_production_help'] = $this->language->get('gn_entry_keys_production_help');
        $data['gn_entry_keys_development_help'] = $this->language->get('gn_entry_keys_development_help');
        $data['gn_entry_payee_code_help'] = $this->language->get('gn_entry_payee_code_help');
        $data['gn_entry_close'] = $this->language->get('gn_entry_close');
        $data['gn_entry_payment_osc'] = $this->language->get('gn_entry_payment_osc');
        $data['gn_entry_help_payment_osc'] = $this->language->get('gn_entry_help_payment_osc');
        $data['gn_entry_payment_osc_option'] = $this->language->get('gn_entry_payment_osc_option');

        $ch = curl_init();
        $options = array(
            CURLOPT_URL         => "https://tls.testegerencianet.com.br",
            CURLOPT_RETURNTRANSFER         => true,
            CURLOPT_FOLLOWLOCATION         => true,
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 5,    // time-out on connect
            CURLOPT_TIMEOUT        => 5,    // time-out on response
        );
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (($info['http_code'] == 200) && ($content == 'Gerencianet_Connection_TLS1.2_OK!')) {
            $this->tlsOk = false;
            $this->error['warning'] =  $this->language->get('gn_config_check_tls');
        } else {
            $this->tlsOk = true;
            if (isset($_COOKIE["gnTestTlsLog"])) {
                setcookie("gnTestTlsLog", false, time() - 1);
            }
        }
        curl_close($ch);

        if (!$this->tlsOk && !isset($_COOKIE["gnTestTlsLog"])) {
            setcookie("gnTestTlsLog", true);
            // register log
            $account = $this->config->get('gerencianet_payee_code');
            $ip = $_SERVER['SERVER_ADDR'];
            $modulo = 'opencart';
            $control = md5($account . $ip . 'modulologs-tls');
            $dataPost = array(
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'modulo' => $modulo,
            );
            $post = array(
                'control' => $control,
                'account' => $account,
                'ip' => $ip,
                'origin' => 'modulo',
                'data' => json_encode($dataPost)
            );
            $ch1 = curl_init();
            $options1 = array(
                CURLOPT_URL         => "https://fortunus.gerencianet.com.br/logs/tls",
                CURLOPT_RETURNTRANSFER         => true,
                CURLOPT_FOLLOWLOCATION         => true,
                CURLOPT_HEADER         => true,  // don't return headers
                CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
                CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
                CURLOPT_CONNECTTIMEOUT => 5,    // time-out on connect
                CURLOPT_TIMEOUT        => 5,    // time-out on response
                CURLOPT_POST        => true,
                CURLOPT_POSTFIELDS        => json_encode($post),
            );
            curl_setopt_array($ch1, $options1);
            $content1 = curl_exec($ch1);
            $info1 = curl_getinfo($ch1);
            curl_close($ch1);
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/gerencianet', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('payment/gerencianet', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['gerencianet_sandbox'])) {
            $data['gerencianet_sandbox'] = $this->request->post['gerencianet_sandbox'];
        } else {
            $data['gerencianet_sandbox'] = $this->config->get('gerencianet_sandbox');
        }

        if (isset($this->request->post['gerencianet_payment_options'])) {
            $data['gerencianet_payment_options'] = $this->request->post['gerencianet_payment_options'];
        } else {
            $data['gerencianet_payment_options'] = $this->config->get('gerencianet_payment_options');
        }

        if (isset($this->request->post['gerencianet_billet_days_to_expire'])) {
            $data['gerencianet_billet_days_to_expire'] = $this->request->post['gerencianet_billet_days_to_expire'];
        } else {
            if (intval($this->config->get('gerencianet_billet_days_to_expire')) == "") {
                $data['gerencianet_billet_days_to_expire'] = "5";
            } else {
                $data['gerencianet_billet_days_to_expire'] = $this->config->get('gerencianet_billet_days_to_expire');
            }
        }

        if (isset($this->request->post['gerencianet_client_id_development'])) {
            $data['gerencianet_client_id_development'] = $this->request->post['gerencianet_client_id_development'];
        } else {
            $data['gerencianet_client_id_development'] = $this->config->get('gerencianet_client_id_development');
        }

        if (isset($this->request->post['gerencianet_client_secret_development'])) {
            $data['gerencianet_client_secret_development'] = $this->request->post['gerencianet_client_secret_development'];
        } else {
            $data['gerencianet_client_secret_development'] = $this->config->get('gerencianet_client_secret_development');
        }

        if (isset($this->request->post['gerencianet_client_id_production'])) {
            $data['gerencianet_client_id_production'] = $this->request->post['gerencianet_client_id_production'];
        } else {
            $data['gerencianet_client_id_production'] = $this->config->get('gerencianet_client_id_production');
        }

        if (isset($this->request->post['gerencianet_client_secret_production'])) {
            $data['gerencianet_client_secret_production'] = $this->request->post['gerencianet_client_secret_production'];
        } else {
            $data['gerencianet_client_secret_production'] = $this->config->get('gerencianet_client_secret_production');
        }

        if (isset($this->request->post['gerencianet_payee_code'])) {
            $data['gerencianet_payee_code'] = $this->request->post['gerencianet_payee_code'];
        } else {
            $data['gerencianet_payee_code'] = $this->config->get('gerencianet_payee_code');
        }

        if (isset($this->request->post['gerencianet_status'])) {
            $data['gerencianet_status'] = $this->request->post['gerencianet_status'];
        } else {
            $data['gerencianet_status'] = $this->config->get('gerencianet_status');
        }

        if (isset($this->request->post['gerencianet_new_status_id'])) {
            $data['gerencianet_new_status_id'] = $this->request->post['gerencianet_new_status_id'];
        } else {
            $data['gerencianet_new_status_id'] = $this->config->get('gerencianet_new_status_id');
        }

        if (isset($this->request->post['gerencianet_waiting_status_id'])) {
            $data['gerencianet_waiting_status_id'] = $this->request->post['gerencianet_waiting_status_id'];
        } else {
            $data['gerencianet_waiting_status_id'] = $this->config->get('gerencianet_waiting_status_id');
        }

        if (isset($this->request->post['gerencianet_paid_status_id'])) {
            $data['gerencianet_paid_status_id'] = $this->request->post['gerencianet_paid_status_id'];
        } else {
            $data['gerencianet_paid_status_id'] = $this->config->get('gerencianet_paid_status_id');
        }

        if (isset($this->request->post['gerencianet_unpaid_status_id'])) {
            $data['gerencianet_unpaid_status_id'] = $this->request->post['gerencianet_unpaid_status_id'];
        } else {
            $data['gerencianet_unpaid_status_id'] = $this->config->get('gerencianet_unpaid_status_id');
        }

        if (isset($this->request->post['gerencianet_refunded_status_id'])) {
            $data['gerencianet_refunded_status_id'] = $this->request->post['gerencianet_refunded_status_id'];
        } else {
            $data['gerencianet_refunded_status_id'] = $this->config->get('gerencianet_refunded_status_id');
        }

        if (isset($this->request->post['gerencianet_contested_status_id'])) {
            $data['gerencianet_contested_status_id'] = $this->request->post['gerencianet_contested_status_id'];
        } else {
            $data['gerencianet_contested_status_id'] = $this->config->get('gerencianet_contested_status_id');
        }

        if (isset($this->request->post['gerencianet_canceled_status_id'])) {
            $data['gerencianet_canceled_status_id'] = $this->request->post['gerencianet_canceled_status_id'];
        } else {
            $data['gerencianet_canceled_status_id'] = $this->config->get('gerencianet_canceled_status_id');
        }

        if (isset($this->request->post['gerencianet_payment_notification_update_notify'])) {
            $data['gerencianet_payment_notification_update_notify'] = $this->request->post['gerencianet_payment_notification_update_notify'];
        } else {
            $data['gerencianet_payment_notification_update_notify'] = $this->config->get('gerencianet_payment_notification_update_notify');
        }

        if (isset($this->request->post['gerencianet_payment_notification_update'])) {
            $data['gerencianet_payment_notification_update'] = $this->request->post['gerencianet_payment_notification_update'];
        } else {
            $data['gerencianet_payment_notification_update'] = $this->config->get('gerencianet_payment_notification_update');
        }

        if (isset($this->request->post['gerencianet_discount_billet_value'])) {
            $data['gerencianet_discount_billet_value'] =  str_replace(",", ".", $this->request->post['gerencianet_discount_billet_value']);
        } else {
            if ($this->config->get('gerencianet_discount_billet_value') == "") {
                $data['gerencianet_discount_billet_value'] = "";
            } else {
                $data['gerencianet_discount_billet_value'] = preg_replace('/[^0-9]/', '', $this->config->get('gerencianet_discount_billet_value')) . '%';
            }
        }

        if (isset($this->request->post['gerencianet_billet_instruction_line_1'])) {
            $data['gerencianet_billet_instruction_line_1'] = $this->request->post['gerencianet_billet_instruction_line_1'];
        } else {
            $data['gerencianet_billet_instruction_line_1'] = $this->config->get('gerencianet_billet_instruction_line_1');
        }

        if (isset($this->request->post['gerencianet_billet_instruction_line_2'])) {
            $data['gerencianet_billet_instruction_line_2'] = $this->request->post['gerencianet_billet_instruction_line_2'];
        } else {
            $data['gerencianet_billet_instruction_line_2'] = $this->config->get('gerencianet_billet_instruction_line_2');
        }

        if (isset($this->request->post['gerencianet_billet_instruction_line_3'])) {
            $data['gerencianet_billet_instruction_line_3'] = $this->request->post['gerencianet_billet_instruction_line_3'];
        } else {
            $data['gerencianet_billet_instruction_line_3'] = $this->config->get('gerencianet_billet_instruction_line_3');
        }

        if (isset($this->request->post['gerencianet_billet_instruction_line_4'])) {
            $data['gerencianet_billet_instruction_line_4'] = $this->request->post['gerencianet_billet_instruction_line_4'];
        } else {
            $data['gerencianet_billet_instruction_line_4'] = $this->config->get('gerencianet_billet_instruction_line_4');
        }

        if (isset($this->request->post['gerencianet_payment_option_billet'])) {
            $data['gerencianet_payment_option_billet'] = $this->request->post['gerencianet_payment_option_billet'];
        } else {
            $data['gerencianet_payment_option_billet'] = $this->config->get('gerencianet_payment_option_billet');
        }

        if (isset($this->request->post['gerencianet_payment_option_card'])) {
            $data['gerencianet_payment_option_card'] = $this->request->post['gerencianet_payment_option_card'];
        } else {
            $data['gerencianet_payment_option_card'] = $this->config->get('gerencianet_payment_option_card');
        }

        if (isset($this->request->post['gerencianet_osc'])) {
            $data['gerencianet_osc'] = $this->request->post['gerencianet_osc'];
        } else {
            $data['gerencianet_osc'] = $this->config->get('gerencianet_osc');
        }

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/gerencianet.tpl', $data));
    }
}
