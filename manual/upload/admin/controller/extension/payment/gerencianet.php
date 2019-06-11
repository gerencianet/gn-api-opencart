<?php
class ControllerExtensionPaymentGerencianet extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('extension/payment/gerencianet');
        $this->document->setTitle('Gerencianet');
        $this->load->model('setting/setting');
        $gerencianetModuleVersion = "v3.1.2";

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $incorrectsFields = "";
            if ($this->request->post['payment_gerencianet_status'] == "0") {
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_status');
            }

            if ($this->request->post['payment_gerencianet_client_id_development'] == "" || $this->request->post['payment_gerencianet_client_secret_development'] == "") {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_development_keys');
            }

            if ($this->request->post['payment_gerencianet_client_id_production'] == "" || $this->request->post['payment_gerencianet_client_secret_production'] == "") {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_production_keys');
            }

            if ($this->request->post['payment_gerencianet_payee_code'] == "") {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_incorrect_field_payee_code');
            }

            $payment_option = false;
            if (isset($this->request->post['payment_gerencianet_payment_option_card'])) {
                if ($this->request->post['payment_gerencianet_payment_option_card'] == "1") {
                    $payment_option = true;
                }
            } else {
                $this->request->post['payment_gerencianet_payment_option_card'] = "0";
            }
            if (isset($this->request->post['payment_gerencianet_payment_option_billet'])) {
                if ($this->request->post['payment_gerencianet_payment_option_billet'] == "1") {
                    $payment_option = true;
                }
            } else {
                $this->request->post['payment_gerencianet_payment_option_billet'] = "0";
            }
            if (!$payment_option) {
                if ($incorrectsFields != "") {
                    $incorrectsFields .= "; ";
                }
                $incorrectsFields .= $this->language->get('gn_entry_no_payment_selected');
            }

            if (isset($this->request->post['payment_gerencianet_osc'])) {
                if ($this->request->post['payment_gerencianet_osc'] != "1") {
                    $this->request->post['payment_gerencianet_osc'] = "0";
                }
            } else {
                $this->request->post['payment_gerencianet_osc'] = "0";
            }

            $this->request->post['payment_gerencianet_billet_instruction_line_1'] = substr($this->request->post['payment_gerencianet_billet_instruction_line_1'], 0, 90);
            $this->request->post['payment_gerencianet_billet_instruction_line_2'] = substr($this->request->post['payment_gerencianet_billet_instruction_line_2'], 0, 90);
            $this->request->post['payment_gerencianet_billet_instruction_line_3'] = substr($this->request->post['payment_gerencianet_billet_instruction_line_3'], 0, 90);
            $this->request->post['payment_gerencianet_billet_instruction_line_4'] = substr($this->request->post['payment_gerencianet_billet_instruction_line_4'], 0, 90);

            if ($incorrectsFields == "") {
                $this->session->data['success'] = $this->language->get('gn_config_saved');
            } else {
                $this->session->data['success'] = $this->language->get('gn_config_saved_not_on') . "<b>" . $incorrectsFields . "</b>";
                $this->request->post['payment_gerencianet_status'] = "0";
            }

            $this->model_setting_setting->editSetting('payment_gerencianet', $this->request->post);
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }

        $this->document->addScript('../catalog/view/javascript/jquery/jquery.mask.min.js');
        $this->document->addStyle('../catalog/view/javascript/gerencianet/style.css');

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

        if (($info['http_code'] !== 200) && ($content !== 'Gerencianet_Connection_TLS1.2_OK!')) {
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
            $account = $this->config->get('payment_gerencianet_payee_code');
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
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/gerencianet', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/gerencianet', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        if (isset($this->request->post['payment_gerencianet_sandbox'])) {
            $data['payment_gerencianet_sandbox'] = $this->request->post['payment_gerencianet_sandbox'];
        } else {
            $data['payment_gerencianet_sandbox'] = $this->config->get('payment_gerencianet_sandbox');
        }

        if (isset($this->request->post['payment_gerencianet_payment_options'])) {
            $data['payment_gerencianet_payment_options'] = $this->request->post['payment_gerencianet_payment_options'];
        } else {
            $data['payment_gerencianet_payment_options'] = $this->config->get('payment_gerencianet_payment_options');
        }

        if (isset($this->request->post['payment_gerencianet_billet_days_to_expire'])) {
            $data['payment_gerencianet_billet_days_to_expire'] = $this->request->post['payment_gerencianet_billet_days_to_expire'];
        } else {
            if (intval($this->config->get('payment_gerencianet_billet_days_to_expire')) == "") {
                $data['payment_gerencianet_billet_days_to_expire'] = "5";
            } else {
                $data['payment_gerencianet_billet_days_to_expire'] = $this->config->get('payment_gerencianet_billet_days_to_expire');
            }
        }

        if (isset($this->request->post['payment_gerencianet_client_id_development'])) {
            $data['payment_gerencianet_client_id_development'] = $this->request->post['payment_gerencianet_client_id_development'];
        } else {
            $data['payment_gerencianet_client_id_development'] = $this->config->get('payment_gerencianet_client_id_development');
        }

        if (isset($this->request->post['payment_gerencianet_client_secret_development'])) {
            $data['payment_gerencianet_client_secret_development'] = $this->request->post['payment_gerencianet_client_secret_development'];
        } else {
            $data['payment_gerencianet_client_secret_development'] = $this->config->get('payment_gerencianet_client_secret_development');
        }

        if (isset($this->request->post['payment_gerencianet_client_id_production'])) {
            $data['payment_gerencianet_client_id_production'] = $this->request->post['payment_gerencianet_client_id_production'];
        } else {
            $data['payment_gerencianet_client_id_production'] = $this->config->get('payment_gerencianet_client_id_production');
        }

        if (isset($this->request->post['payment_gerencianet_client_secret_production'])) {
            $data['payment_gerencianet_client_secret_production'] = $this->request->post['payment_gerencianet_client_secret_production'];
        } else {
            $data['payment_gerencianet_client_secret_production'] = $this->config->get('payment_gerencianet_client_secret_production');
        }

        if (isset($this->request->post['payment_gerencianet_payee_code'])) {
            $data['payment_gerencianet_payee_code'] = $this->request->post['payment_gerencianet_payee_code'];
        } else {
            $data['payment_gerencianet_payee_code'] = $this->config->get('payment_gerencianet_payee_code');
        }

        if (isset($this->request->post['payment_gerencianet_status'])) {
            $data['payment_gerencianet_status'] = $this->request->post['payment_gerencianet_status'];
        } else {
            $data['payment_gerencianet_status'] = $this->config->get('payment_gerencianet_status');
        }

        if (isset($this->request->post['payment_gerencianet_new_status_id'])) {
            $data['payment_gerencianet_new_status_id'] = $this->request->post['payment_gerencianet_new_status_id'];
        } else {
            $data['payment_gerencianet_new_status_id'] = $this->config->get('payment_gerencianet_new_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_waiting_status_id'])) {
            $data['payment_gerencianet_waiting_status_id'] = $this->request->post['payment_gerencianet_waiting_status_id'];
        } else {
            $data['payment_gerencianet_waiting_status_id'] = $this->config->get('payment_gerencianet_waiting_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_paid_status_id'])) {
            $data['payment_gerencianet_paid_status_id'] = $this->request->post['payment_gerencianet_paid_status_id'];
        } else {
            $data['payment_gerencianet_paid_status_id'] = $this->config->get('payment_gerencianet_paid_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_unpaid_status_id'])) {
            $data['payment_gerencianet_unpaid_status_id'] = $this->request->post['payment_gerencianet_unpaid_status_id'];
        } else {
            $data['payment_gerencianet_unpaid_status_id'] = $this->config->get('payment_gerencianet_unpaid_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_refunded_status_id'])) {
            $data['payment_gerencianet_refunded_status_id'] = $this->request->post['payment_gerencianet_refunded_status_id'];
        } else {
            $data['payment_gerencianet_refunded_status_id'] = $this->config->get('payment_gerencianet_refunded_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_contested_status_id'])) {
            $data['payment_gerencianet_contested_status_id'] = $this->request->post['payment_gerencianet_contested_status_id'];
        } else {
            $data['payment_gerencianet_contested_status_id'] = $this->config->get('payment_gerencianet_contested_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_canceled_status_id'])) {
            $data['payment_gerencianet_canceled_status_id'] = $this->request->post['payment_gerencianet_canceled_status_id'];
        } else {
            $data['payment_gerencianet_canceled_status_id'] = $this->config->get('payment_gerencianet_canceled_status_id');
        }

        if (isset($this->request->post['payment_gerencianet_payment_notification_update_notify'])) {
            $data['payment_gerencianet_payment_notification_update_notify'] = $this->request->post['payment_gerencianet_payment_notification_update_notify'];
        } else {
            $data['payment_gerencianet_payment_notification_update_notify'] = $this->config->get('payment_gerencianet_payment_notification_update_notify');
        }

        if (isset($this->request->post['payment_gerencianet_payment_notification_update'])) {
            $data['payment_gerencianet_payment_notification_update'] = $this->request->post['payment_gerencianet_payment_notification_update'];
        } else {
            $data['payment_gerencianet_payment_notification_update'] = $this->config->get('payment_gerencianet_payment_notification_update');
        }

        if (isset($this->request->post['payment_gerencianet_discount_billet_value'])) {
            $data['payment_gerencianet_discount_billet_value'] =  str_replace(",", ".", $this->request->post['payment_gerencianet_discount_billet_value']);
        } else {
            if ($this->config->get('payment_gerencianet_discount_billet_value') == "") {
                $data['payment_gerencianet_discount_billet_value'] = "";
            } else {
                $data['payment_gerencianet_discount_billet_value'] = preg_replace('/[^0-9]/', '', $this->config->get('payment_gerencianet_discount_billet_value')) . '%';
            }
        }

        if (isset($this->request->post['payment_gerencianet_billet_instruction_line_1'])) {
            $data['payment_gerencianet_billet_instruction_line_1'] = $this->request->post['payment_gerencianet_billet_instruction_line_1'];
        } else {
            $data['payment_gerencianet_billet_instruction_line_1'] = $this->config->get('payment_gerencianet_billet_instruction_line_1');
        }

        if (isset($this->request->post['payment_gerencianet_billet_instruction_line_2'])) {
            $data['payment_gerencianet_billet_instruction_line_2'] = $this->request->post['payment_gerencianet_billet_instruction_line_2'];
        } else {
            $data['payment_gerencianet_billet_instruction_line_2'] = $this->config->get('payment_gerencianet_billet_instruction_line_2');
        }

        if (isset($this->request->post['payment_gerencianet_billet_instruction_line_3'])) {
            $data['payment_gerencianet_billet_instruction_line_3'] = $this->request->post['payment_gerencianet_billet_instruction_line_3'];
        } else {
            $data['payment_gerencianet_billet_instruction_line_3'] = $this->config->get('payment_gerencianet_billet_instruction_line_3');
        }

        if (isset($this->request->post['payment_gerencianet_billet_instruction_line_4'])) {
            $data['payment_gerencianet_billet_instruction_line_4'] = $this->request->post['payment_gerencianet_billet_instruction_line_4'];
        } else {
            $data['payment_gerencianet_billet_instruction_line_4'] = $this->config->get('payment_gerencianet_billet_instruction_line_4');
        }

        if (isset($this->request->post['payment_gerencianet_payment_option_billet'])) {
            $data['payment_gerencianet_payment_option_billet'] = $this->request->post['payment_gerencianet_payment_option_billet'];
        } else {
            $data['payment_gerencianet_payment_option_billet'] = $this->config->get('payment_gerencianet_payment_option_billet');
        }

        if (isset($this->request->post['payment_gerencianet_payment_option_card'])) {
            $data['payment_gerencianet_payment_option_card'] = $this->request->post['payment_gerencianet_payment_option_card'];
        } else {
            $data['payment_gerencianet_payment_option_card'] = $this->config->get('payment_gerencianet_payment_option_card');
        }

        if (isset($this->request->post['payment_gerencianet_osc'])) {
            $data['payment_gerencianet_osc'] = $this->request->post['payment_gerencianet_osc'];
        } else {
            $data['payment_gerencianet_osc'] = $this->config->get('payment_gerencianet_osc');
        }

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $data['isValidaPHPVersion'] = version_compare(phpversion(), '5.4.0', '>=');
        $this->response->setOutput($this->load->view('extension/payment/gerencianet', $data));
    }
}
