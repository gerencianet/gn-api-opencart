<?php

if (version_compare(phpversion(), '5.4.0', '>=')) {
    include_once('gn_lib/toaster_message.php');
    include_once('gn_lib/constants.php');
    include_once('gn_lib/gatewayPix.php');   
} else {
    echo "A versão do PHP instalado no servidor não é compatível com o módulo da Gerencianet. Por favor, verifique os requisitos do módulo.";
    die();
}


/**
 * Controller custom extension for payments
 *
 * @package     Gerencianet Payment Extension for OpenCart
 * @author      Gerencianet
 * @copyright   (c) 2021 Gerencianet. All rights reserved.
 * @version     3.0.0
 */
class ControllerExtensionPaymentGerencianet extends Controller {

    /**     
     * Gera a tabela da Gerencianet no BD ao instalar o plugin
     */
    public function install() {
        
        $this->load->model('extension/payment/gerencianet');

        $this->model_extension_payment_gerencianet->createTable();
    }

    /**
     * Carrega dependencias
     */
    private function init() {

        // Set module title
        $this->document->setTitle('Gerencianet');
        $this->document->addStyle('view/stylesheet/payment/style.css');

        // Load models
        $this->load->model('setting/setting');
        $this->load->model('localisation/order_status');

		// Load language files
		$this->load->language('extension/payment/gerencianet');
	}

    /**
     * Ao iniciar a extensão
     */
    public function index() {
        $data = array();
        $this->init();
        $data['action'] = $this->url->link('extension/payment/gerencianet', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);
        $data['header'] = $this->load->controller('common/header');
       $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        // Generate Breadcrumbs
		$this->generateBreadcrumbs($data);
        // Load language keys
        $this->generateLanguageText($data);
        // Get Opencart order status options 
        $this->getOrderStatus($data);
        // Get Information about plugin Gerencianet
        $this->getAboutInfoGerencianet($data);
        // Verify and save settings
        $this->saveSettings($data);
        $data['messages'] = ToasterMessage::getInstance()->getMessages();
        $this->response->setOutput($this->load->view('extension/payment/gerencianet', $data));
    }

    /**
     * Gera links e textos dos breadcrumbs
     */
    private function generateBreadcrumbs(&$data) {
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
	}

    /**
     * Carrega todos os textos usados pelo template
     */
    private function generateLanguageText(&$data) {
        $keys = array(
			'payment_gerencianet_painel_header',
			'payment_gerencianet_pix',
			'payment_gerencianet_boleto',
			'payment_gerencianet_cartao',
			'payment_gerencianet_about',
			'payment_gerencianet_order_status'
		);
       
		foreach ($keys as $key) {
            $data[$key] = $this->language->get($key);
		}

        // Load fields
        $this->generateFieldsText($data);
	}

    /**
     * Monta um objeto para popular o form de cadastro
     */
    private function generateFieldsText(&$data) {
        $keys = Constants::adminFields;

        $data['fields'] = array();
		foreach ($keys as $moduleName => $module) {
            $data['fields'][$moduleName] = array();
            
            foreach ($module as $key => $val) {
                $value = isset($this->request->post[$key]) ? $this->request->post[$key] : $this->config->get($key);
                $data['fields'][$moduleName][] = array(
                    'id' => $key,
                    'id_required' => isset($val['obrigatorio'])? ($val['obrigatorio'] ? $key . '_required': null) : null,
                    'label' => $this->language->get($key),
                    'value' => $value,
                    'type' => isset($val['type']) ? $val['type'] : null,
                    'required' => $val['required'],
                    'tooltip' => isset($val['tooltip']) ? $this->language->get('payment_gerencianet_'.$val['tooltip']) : null
                );
            }
		}
	}

    /**
     * Carrega as opções de Status de pagamentos do usuário
     */
    private function getOrderStatus(&$data) {

        $statusOption = $this->model_localisation_order_status->getOrderStatuses();        

        $data['options'] = $this->mapSelectOption($statusOption);
    }

    /**
     * Renomeia o nome das propriedas do objeto 
     * @param array $data
     * @return array $arrayMap
     */
    private function mapSelectOption($data) {
        $arrayMap = array();
        foreach($data as $value) {
            $option = [
                'id' => $value['order_status_id'],
                'name' => $value['name']
            ];

            array_push($arrayMap, $option);
        }

        return $arrayMap;
    }

    /**
     * Carrega as informações sobre o Plugin para ser mostradas na tela
     * @param array data
     */
    private function getAboutInfoGerencianet(&$data) {
        $aboutInfo = Constants::aboutInfo;

        $data['text_version'] = $aboutInfo['version'];
        $data['text_about_link'] = $aboutInfo['website'];
        $data['text_about_user_manual_link'] = $aboutInfo['documentation'];
        $data['text_about_support_link'] = $aboutInfo['support'];
        
        $data['srcLogo'] = $aboutInfo['logoUrl'];
        $data['hrefLogo'] = $aboutInfo['website'];
    }

    /**
    * Trata as informações Recebidas no Formulário de Configuração
    * para o formato padrão recebido na Classe do SDK da Gerencianet
    * @return array
    */
    private function getConfigOptionsPix($data) {
        $option = Constants::configOptionsPix;
        $dataPix = Array();
        foreach($option as $key => $value) {
            $dataPix[$key] =  isset($data[$value]) === true ? $data[$value] : '0'; 
        }

        return $dataPix;
    }

    /**
     * Salva configurações na base
     */
    private function saveSettings(&$data) {
       
        if($this->validate()) {
            ToasterMessage::getInstance()->add(ToasterMessage::SUCCESS, $this->language->get('text_success'));
           
            $this->model_setting_setting->editSetting('payment_gerencianet', $this->request->post);

            $this->response->redirect($this->url->link('extension/payment/gerencianet', 'user_token=' . $this->session->data['user_token'], true));
        }
    }

    /**
     * Salva Webhook
     */
    private function saveWebhook($data){
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            && strpos($_SERVER['HTTP_REFERER'], 'localhost') === false 
            && strpos($_SERVER['HTTP_REFERER'], '127.0.0.1') === false
        ) {
            try {
                // URL do Webhook -> removendo 'admin'
                $url =  str_replace('/admin', '', $this->url->link('extension/payment/gerencianet/callback'));

                $dataConfig = $this->getConfigOptionsPix($data);
                $gatewayPix = new GatewayPix($dataConfig);
    
                $gatewayPix->registerWebhook($dataConfig['pixKey'], $url);

                return true;
            } catch (\Exception $e) {
                ToasterMessage::getInstance()->add(ToasterMessage::DANGER, $this->language->get('text_error_webhook'));
                return false;
            }
        } else {
            ToasterMessage::getInstance()->add(ToasterMessage::DANGER, $this->language->get('text_error_https_webhook'));
            return false;
        }
        
    }

    /**
     * Valida se todos os campos estão OK
     * 
     * Percorre todos os campos obrigatórios e válida as informações do cadastro
     * @return Boolean 
     */
    private function validate() {
      
      
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $fields = Constants::adminFields;
            ToasterMessage::getInstance()->clear();
            $success = true;
            
            
            if (isset($this->request->post['payment_gerencianet_pix_active']) && $this->request->post['payment_gerencianet_pix_active'] == 1) {
                $this->validadePix($fields, $success);
                $success = ($success) ? $this->saveWebhook($this->request->post) : $success;
            }
            if (isset($this->request->post['payment_gerencianet_boleto_active']) && $this->request->post['payment_gerencianet_boleto_active'] == 1) {
                $this->validadeBillet($fields, $success);
            }

            return $success;
        } else {
            return false;
        }
        
        
    }

    /**
     * Valida os campos obritórios do pix
     */
    function validadePix($fields,&$success)
    {
        foreach ($fields as $moduleName => $module) {
            if ($moduleName == 'pix') {
                foreach ($module as $key => $val) {
                    // Verifica se o campo obrigatório não está vazio
                    if($val['obrigatorio'] && (!isset($this->request->post[$key]) || $this->request->post[$key] == '')) {
                        $message = '<strong>' . $this->language->get($key) . '</strong>' . $this->language->get('payment_gerencianet_empty_field');
                        ToasterMessage::getInstance()->add(ToasterMessage::WARNING, $message);
                        $success = false;
                    }

                }
            }
        }   

    }
    /**
     * Valida os campos obritórios do boleto
     */
    function validadeBillet($fields,&$success){

        foreach ($fields as $moduleName => $module) {
            if ($moduleName == 'boleto') {
                foreach ($module as $key => $val) {
                    // Verifica se o campo obrigatório não está vazio
                    if($val['obrigatorio'] && (!isset($this->request->post[$key]) || $this->request->post[$key] == '')) {
                        $message = '<strong>' . $this->language->get($key) . '</strong>' . $this->language->get('payment_gerencianet_empty_field');
                        ToasterMessage::getInstance()->add(ToasterMessage::WARNING, $message);
                        $success = false;
                    }
                }
            }
        }

    }
}
