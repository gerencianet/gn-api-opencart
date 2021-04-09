<?php

if (version_compare(phpversion(), '5.4.0', '>=')) {
    include_once('gn_lib/constants.php');
    include_once('gn_lib/gatewayPix.php');   
} else {
    echo "A versão do PHP instalado no servidor não é compatível com o módulo da Gerencianet. Por favor, verifique os requisitos do módulo.";
    die();
}

/**
 * Controlador responsável por gerir a opção de pagamento via gerencianet
 */
class ControllerExtensionPaymentGerencianet extends Controller {
    
    /**
     * Redireciona o usuário para a página de pagamento
     */
    public function index() {
        $this->load->language('extension/payment/gerencianet');
        $this->load->model('checkout/order');

        $data = array();
        // Verifica se a moeda utilizada é o Real('BRL')
        if($this->session->data['currency'] != Constants::constantValues['currency']) {
            $messageError = $this->language->get('message_error_gerencianet');
			
            return "<span><h4>$messageError</h4></span>";
        }

        $data['action'] = $this->url->link('extension/payment/gerencianet/finalize');
        $data['button_confirm'] = $this->language->get('button_confirm');

        // Valor do Desconto em %
        $data['discount'] = $this->config->get('payment_gerencianet_discount');     
        
        // Informações Sobre Simbolos da Moeda
        $data['currency_symbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
        $data['currency_symbol_right'] = $this->currency->getSymbolRight($this->session->data['currency']);

        // Informações do Pedido
        $data['order_id'] = $this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($data['order_id']);

        // Valor Total do Pedido com Desconto Aplicado
        $discount = $this->totalValueWithDiscount($order_info['total'], $data['discount']);
        $data['discount_total'] = number_format($discount, 2, ',', ' ');
    
        
        return $this->load->view('extension/payment/gerencianet', $data);
    }

    /**
     * Exibe o QR CODE e Chave PIX do pagamento
     * @return array
     */
    public function finalize() {
        $this->load->language('extension/payment/gerencianet');
        $this->load->model('checkout/order');

        // Estilo personalizado
        $this->document->addScript('catalog/view/javascript/payment/script.js');
        $this->document->addStyle('catalog/view/theme/default/stylesheet/payment/style.css');

        $data = array();

        // Informações do Pedido
        $data['order_id'] = $this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($data['order_id']);

        // Gera uma nova cobrança
        $qrCode = $this->createCharge($order_info['total'], $data['order_id']); 
        $data['qrCodeImage'] = $qrCode['imagemQrcode'];
        $data['qrCodeCopy']  = $qrCode['qrcode'];   

        // Limpa o carrinho
        $this->cart->clear();

        $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

        return $this->response->setOutput($this->load->view('extension/payment/finalize', $data));
    }

    /**
     * Cria uma nova cobrança Pix
     * @return array $qrCode['image'] e $qrCode['qrcode']
     */
    private function createCharge($orderTotal, $order_id) {
        // Dependências de persistência personalizado
        $this->load->model('extension/payment/gerencianet');

        $dataConfig = $this->getConfigOptionsPix();
        $gatewayPix = new GatewayPix($dataConfig);

        // Busca no banco se já existe uma cobrança criada
        $dataDB = $this->model_extension_payment_gerencianet->find('order_id', $order_id);

        if(isset($dataDB['tx_id'])) {
            // Retorna apenas o QRcode
            $qrcode = $gatewayPix->generateQRCode($dataDB['loc_id']);
        } else {
            // Calcula o valor total com desconto
            $totalValueWithDiscount = $this->totalValueWithDiscount($orderTotal, $dataConfig['pixDiscount']);

            $body = [
                "calendario" => [
                    "expiracao" =>  $dataConfig['pixHours'] * 3600
                ],
                "valor" => [
                    "original" => $totalValueWithDiscount
                ],
                "chave" => $dataConfig['pixKey']
            ];
            // Gera uma nova cobrança
            $apiResponse = $gatewayPix->createCharge($body);

            if($apiResponse['txid']) {
                // Id da location enviada pela API
                $locationId = $apiResponse['loc']['id'];
                $qrcode = $gatewayPix->generateQRCode($locationId);

                // Salva a cobrança no BD
                $data = [
                    'order_id' => $order_id,
                    'tx_id' => $apiResponse['txid'],
                    'loc_id' => $locationId,
                    'status' => $this->config->get(Constants::orderStatus['PENDING'])
                ];
                $this->model_extension_payment_gerencianet->insert($data);

                // Muda o status do pedido no OpenCart
                $this->changeStatusOrder($order_id, $this->config->get(Constants::orderStatus['PENDING']));
            }
        }

        return $qrcode;
    }

    /**
     * Retorna o valor total da cobrança com o desconto
     * @param float $orderTotal
     * @param string $pixDiscount
     * 
     * @return float
     */
    private function totalValueWithDiscount($orderTotal, $pixDiscount) {

        $percentageDiscount = floatval(preg_replace('/[^0-9.]/', '', str_replace(",", ".", $pixDiscount)));
        $totalWithDiscount = floatval($orderTotal - ($orderTotal * ($percentageDiscount/100)));

        // Formata o numero em 2 casas decimais
        return number_format($totalWithDiscount, 2, '.', '');
    }

    /**
    * Retorna as configurações do usuário
    * @return array
    */
    private function getConfigOptionsPix() {
        $option = Constants::configOptionsPix;

        $dataPix = Array();
        foreach($option as $key => $value) {
            //recebendo as configurações salvas no Admin
            $dataPix[$key] =  $this->config->get($value);
        }

        return $dataPix;
    }

    /**
     * Muda o status do pedido
     * @param string $status
     * @param string $order_id 
     */
    private function changeStatusOrder($order_id, $id_status) {
        $this->load->model('checkout/order');
        
        $this->model_checkout_order->addOrderHistory($order_id, intval($id_status));
    }

    /**
     * 
     * Callback responsável em tratar as informações recebidas pela Gerencianet
     */
    public function callback() {
        $this->load->model('extension/payment/gerencianet');

        // Hook data retrieving
        @ob_clean();
        $postData = json_decode(file_get_contents('php://input'));

        // Hook validation
        if (isset($postData->evento) && isset($postData->data_criacao)) {
            header('HTTP/1.0 200 OK');

            exit();
        }

        $pixPaymentData = $postData->pix;

        // Hook manipulation
        if (empty($pixPaymentData)) {
            $this->log->write('Pagamento Pix não recebido pelo Webhook.');
            exit();
        } else {
            header('HTTP/1.0 200 OK');

            $txID  = $pixPaymentData[0]->txid;
            $e2eID = $pixPaymentData[0]->endToEndId;

            // Recebe o id do Status
            $statusComplete = $this->config->get(Constants::orderStatus['COMPLETE']);

            $conditions = [
                'tx_id' => $txID
            ];
            $data = [
                'e2e_id' => $e2eID,
                'status' => $statusComplete
            ];

            // Salva o EndToEndId no Banco
            $this->model_extension_payment_gerencianet->update($conditions, $data);

            // Busca no banco o id do Pedido
            $column = 'tx_id';
            $dataDB = $this->model_extension_payment_gerencianet->find($column, $txID);

            // Muda o status do pedido no OpenCart
            $this->changeStatusOrder($dataDB['order_id'], $statusComplete);
        }
    }
}