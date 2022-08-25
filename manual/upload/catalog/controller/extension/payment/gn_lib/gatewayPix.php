<?php

if (version_compare(phpversion(), '5.4.0', '>=')) {
    include_once('gerencianet/autoload.php');
    include_once(__DIR__ . '/GerencianetValidation.php');
} else {
	echo "A versão do PHP instalado no servidor não é compatível com o módulo da Gerencianet. Por favor, verifique os requisitos do módulo.";
	die();
}

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

/**
 * Gateway de Pagamento, responsavel em realizar a comunicação entre a API-Gerencianet e o OpenCart
 */
class GatewayPix {
    
    /**
     * Instância da API-Gerencianet
     * @access private
     * @var object
     */
    private $apiInstance = [];

    /**
     * Precisa instânciar a classe Gateway passando as configurações salvas
     * @param array $optionConfig
     */
    public function __construct($optionConfig) {
        $this->apiInstance = $this->getGerencianetInstance($optionConfig);
    }

    /**
     * Cria uma instância da API-Gerencianet com as credenciais do cliente
     * @param array $dataConfigPix
     * @return array
     */
    private function getGerencianetInstance($dataConfigPix) {
        try {
            if(isset($dataConfigPix['pixCert'])){
                $newInstance = Gerencianet::getInstance(
                    Array(
                        // OpenCart retorna 1 para true e NULL para false
                        'client_id' => $dataConfigPix['sandbox'] == 1 ? $dataConfigPix['clientIdDev'] : $dataConfigPix['clientIdProd'],
                        'client_secret' => $dataConfigPix['sandbox'] == 1 ? $dataConfigPix['clientSecretDev'] : $dataConfigPix['clientSecretProd'],
                        'sandbox'=> $dataConfigPix['sandbox']==1,
                        'pix_cert' => $dataConfigPix['pixCert'],
                        'debug' =>  $dataConfigPix['debug'] == 1,
                        'headers' => [
                            'x-skip-mtls-checking' => $dataConfigPix['mtls'] == 1 ? 'false' : 'true' //precisa ser string
                        ]
                    )
                );
            }else{
                $newInstance = Gerencianet::getInstance(
                    Array(
                        // OpenCart retorna 1 para true e NULL para false
                        'client_id' => $dataConfigPix['sandbox'] == 1 ? $dataConfigPix['clientIdDev'] : $dataConfigPix['clientIdProd'],
                        'client_secret' => $dataConfigPix['sandbox'] == 1 ? $dataConfigPix['clientSecretDev'] : $dataConfigPix['clientSecretProd'],
                        'sandbox'=> $dataConfigPix['sandbox']==1,
                        'debug' =>  $dataConfigPix['debug'] == 1,
                        'timeout' => 60
                    )
                );
            }
           
            return $newInstance;

        } catch (GerencianetException $e) {
            throw new Error($e->error);
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }


   public  function getCharge($token){

        $response = [];
        $params = [
            'token' => $token
          ];
           
          try {
            
              $chargeNotification = $this->apiInstance->getNotification($params, []);
            // Para identificar o status atual da sua transação você deverá contar o número de situações contidas no array, pois a última posição guarda sempre o último status. Veja na um modelo de respostas na seção "Exemplos de respostas" abaixo.
            
            // Veja abaixo como acessar o ID e a String referente ao último status da transação.
              
              // Conta o tamanho do array data (que armazena o resultado)
              $i = count($chargeNotification["data"]);
              // Pega o último Object chargeStatus
              $ultimoStatus = $chargeNotification["data"][$i-1];
              // Acessando o array Status
              $status = $ultimoStatus["status"];
              // Obtendo o ID da transação    
              $custom_id = $chargeNotification["data"][0]["custom_id"];
              // Obtendo a String do status atual
              $statusAtual = $status["current"];
               //print_r($chargeNotification);
               $response['status']= $statusAtual;
               $response['custom_id']= $custom_id;
               return $response;
        } 
            catch (GerencianetException $e) {
                    throw new Error($e->code);
                    throw new Error($e->error);
                    throw new Error($e->errorDescription);
                } 
            catch (Exception $e) {
                    throw new Error($e->getMessage());
                }
            
            }            
    /**
     * Cria uma nova cobrança Pix
     * @param array $body 
     * @return array
     */
    public function createCharge($body) {
        try {
            //A cobrança imediata nao é preciso passar parametro
            $params = [];

            return $this->apiInstance->pixCreateImmediateCharge($params, $body);

        } catch(GerencianetException $e) {
            throw new Error($e->error);
        } catch(Exception $e) {
            throw new Error($e->getMessage());
        }
    }
    /**
     * Cria uma nova cobrança (boleto ou cartão)
     * @param array $order_info 
     * @param array $items 
     * @param array $shipping 
     * @param array $customer 
     * @param int $method 
     * @return array
     */
    public function createChargeTwoSteps($order_info,$items,$shipping,$customer,$method) {
        if ($method == 1) {
            $customer['emailCobranca'] = $order_info['emailCobranca'];
            $cliente = $this->getClientFields($customer);
            $validation = $this->validationClient($cliente);
            $dataVencimento = DateTime::createFromFormat('Y-m-d',date('Y-m-d'));
            $dataVencimento->add(new DateInterval('P' .$order_info['diasVencimento'] .'D'));
            $dataVencimentoFormatado =  $dataVencimento->format('Y-m-d');
            if ($validation['status']) {
                
                $items_cobranca = [];
                
                $notification = $order_info['url_callback'];
                $metadata = [
                    'notification_url'=> $notification,
                    'custom_id' => $order_info['order_id']
                ];
                
                if ($shipping > 0) {
                    $frete[] = [
                        'name' => $order_info['shipping_method'],
                        'value'=> (int)str_replace('.','',$shipping)
                    ];
                }
                
            
                foreach ($items as $produto) {
                    $total_produto = floatval(str_replace(',','',number_format($produto['price'], 2, ',', ''))) ;
                    $items_cobranca[] = [
                        'name'=>$produto['name'],
                        'amount'=>(int)$produto['quantity'],
                        'value'=> $total_produto
                    ];
                }
        
                try {
                    //A cobrança imediata nao é preciso passar parametro
                    $params = [];
                    if ($shipping > 0) {
                        $body = [
                            'items'=>$items_cobranca,
                            'metadata'=>$metadata,
                            'shippings' => $frete
                        ];
                    }else {
                        $body = [
                            'items'=>$items_cobranca,
                            'metadata'=>$metadata
                            
                        ];
                    }
                    
                    
                    $charge = $this->apiInstance->createCharge($params, $body)['data']['charge_id'];
                  
                        $pdf = $this->payChargeBillet($cliente,$dataVencimentoFormatado,$charge,$order_info);
                        return $pdf;
                } catch(GerencianetException $e) {
                    throw new Error($e->error);
                } catch(Exception $e) {
                    throw new Error($e->getMessage());
                }
            }else{
                return $validation['message'];
            }
        }else{
            $cliente = $this->getClientFieldsCard($customer);
            $validation = $this->validationClientCard($cliente,$customer);

            if ($validation['status']) {
                $items_cobranca = [];
                
                $notification = $order_info['url_callback'];
                $metadata = [
                    'notification_url'=> $notification,
                    'custom_id' => $order_info['order_id']
                ];
                if ($shipping > 0) {
                    $frete[] = [
                        'name' => $order_info['shipping_method'],
                        'value'=> (int)str_replace('.','',$shipping)
                    ];
                }
    
                
            
                foreach ($items as $produto) {
                    $total_produto = floatval(str_replace(',','',number_format($produto['price'], 2, ',', ''))) ;
                    $items_cobranca[] = [
                        'name'=>$produto['name'],
                        'amount'=>(int)$produto['quantity'],
                        'value'=> $total_produto
                    ];
                }
                try {
                    //A cobrança imediata nao é preciso passar parametro
                    $params = [];
                    if ($shipping > 0) {
                        $body = [
                            'items'=>$items_cobranca,
                            'metadata'=>$metadata,
                            'shippings' => $frete
                        ];
                    }else {
                        $body = [
                            'items'=>$items_cobranca,
                            'metadata'=>$metadata
                            
                        ];
                    }
                    
                    $charge = $this->apiInstance->createCharge($params, $body)['data']['charge_id'];
                    $card = $this->payChargeCard($cliente,$charge,$customer);
                    return $card;
                    
        
                } catch(GerencianetException $e) {
                    throw new Error($e->error);
                } catch(Exception $e) {
                    throw new Error($e->getMessage());
                }

            }else{
                return $validation['message'];
            }
            
        }
    }
  
    private function getClientFields($customer){
        $isJuridica = true;
        if (strpos($customer['documentoBoleto'],'/')) {
            $document = str_replace('/','',str_replace('-','',str_replace('.','',$customer['documentoBoleto']))); 
           
        }else{
            $document = str_replace('-','',str_replace('.','',$customer['documentoBoleto']));
        }
        $corporateName    = $customer['nomeBoleto'];
    
        $name  = $customer['nomeBoleto'];
        $phone = str_replace(' ','',str_replace('-','',str_replace('(','',str_replace(')','',$customer['telefoneBoleto']))));
        $email = $customer['emailBoleto'];
        $sendEmailGN = $customer['emailCobranca'] == 1 && strlen($email) > 0;
    
        if (strlen($document) <= 11)
            $isJuridica = false;
    
        if ($isJuridica == false) {
            if ($sendEmailGN == true && strlen($phone) > 0)
                $customerBillet = array(
                    'name'          => $name,
                    'cpf'           => (string)$document,
                    'email'         => $email,
                    'phone_number'  => $phone
                );
            elseif (strlen($phone) > 0) {
                $customerBillet = array(
                    'name'          => $name,
                    'cpf'           => (string)$document,
                    'phone_number'  => $phone
                );
            }elseif ($sendEmailGN == true){
                $customerBillet = array(
                    'name'          => $name,
                    'cpf'           => (string)$document,
                    'email'         => $email
                );
            }else {
                $customerBillet = array(
                    'name'          => $name,
                    'cpf'           => (string)$document
                );
            }
                
        } else {
            $juridical_data = array(
                'corporate_name' => (string)$corporateName,
                'cnpj'           => (string)$document
            );
    
            if ($sendEmailGN == "on" && strlen($phone) > 0)
                $customerBillet = array(
                    'email'             => $email,
                    'phone_number'      => $phone,
                    'juridical_person'  => $juridical_data
                );
            elseif (strlen($phone) > 0) {
                $customerBillet = array(
                    'phone_number'      => $phone,
                    'juridical_person'  => $juridical_data
                );
            }elseif ($sendEmailGN == true){
                $customerBillet = array(
                    'email'         => $email,
                    'juridical_person'  => $juridical_data
                );
            }else {
                $customerBillet = array(
                    'juridical_person'  => $juridical_data
                );
            }
                
        }
    
    
        return $customerBillet;
        
    }
    private function getClientFieldsCard($customer){
        $isJuridica = true;
        if (strpos($customer['documentoCartao'],'/') == true) {
            $document = str_replace('/','',str_replace('-','',str_replace('.','',$customer['documentoCartao']))); 
           
        }else{
            $document = str_replace('-','',str_replace('.','',$customer['documentoCartao']));
        }
        $corporateName    = $customer['nomeCartao'];
    
        $name  = $customer['nomeCartao'];
        $phone = str_replace(' ','',str_replace('-','',str_replace('(','',str_replace(')','',$customer['telefoneCartao']))));
        $email = $customer['emailCartao'];
        $dataDeNasentocimento = explode("-", str_replace('/', '-', $customer['nascimento']));
        $dataDeNasentocimento =$dataDeNasentocimento[2]."-". $dataDeNasentocimento[1]."-".$dataDeNasentocimento[0];
    
        if (strlen($document) <= 11)
            $isJuridica = false;
    
        if ($isJuridica == false) {
            
                $customerCard = array(
                    'name'          => $name,
                    'cpf'           => (string)$document,
                    'email'         => $email,
                    'phone_number'  => $phone,
                    'birth'         => $dataDeNasentocimento
                );
            
               
        } else {
            $juridical_data = array(
                'corporate_name' => (string)$corporateName,
                'cnpj'           => (string)$document
            );
                $customerCard = array(
                    'email'             => $email,
                    'phone_number'      => $phone,
                    'birth'         =>$dataDeNasentocimento,
                    'juridical_person'  => $juridical_data
                );
           
               
               
             
        }
    
    
        return $customerCard;
        
    }
    private function validationClient($customer){
        $validation = new GerencianetValidation();
        $validando['status'] = true;
        if (isset($customer['cpf']) && strlen($customer['cpf']) == 11) {
            if (!$validation->_name($customer['name'])) {
                $validando['status'] = false;
                $validando['message'][] = "Nome";
            }
            if (!$validation->_cpf($customer['cpf'])) {
                $validando['status'] = false;
                $validando['message'][] = "Cpf";
            }
            if (isset($customer['phone_number']) &&!$validation->_phone_number($customer['phone_number'])) {
                $validando['status'] = false;
                $validando['message'][] = "Telefone";
            }
            if (isset($customer['email']) &&!$validation->_email($customer['email'])) {
                $validando['status'] = false;
                $validando['message'][] = "E-mail";
            }
        }else{
            if (!$validation->_corporate($customer['juridical_person']['corporate_name'])) {
                $validando['status'] = false;
                $validando['message'][] = "Razão Social";
            }
            if (!$validation->_cnpj($customer['juridical_person']['cnpj'])) {
                $validando['status'] = false;
                $validando['message'][] = "Cnpj";
            }
            if (isset($customer['phone_number']) &&!$validation->_phone_number($customer['phone_number'])) {
                $validando['status'] = false;
                $validando['message'][] = "Telefone";
            }
            if (isset($customer['email']) &&!$validation->_email($customer['email'])) {
                $validando['status'] = false;
                $validando['message'][] = "E-mail";
            }
        }
        return $validando;
    }
    private function validationClientCard($customer,$billing_address){
        $validation = new GerencianetValidation();
        $validando['status'] = true;

        
        if (isset($customer['phone_number']) &&!$validation->_phone_number($customer['phone_number'])) {
            $validando['status'] = false;
            $validando['message'][] = "Telefone";
        }
        if (!$validation->_email($customer['email'])) {
            $validando['status'] = false;
            $validando['message'][] = "E-mail";
        }
        if (!$validation->_birthdate($customer['birth'])) {
            $validando['status'] = false;
            $validando['message'][] = "Data de Nascimento";
        }
        if (!$validation->_neighborhood($billing_address['bairro'])) {
            $validando['status'] = false;
            $validando['message'][] = "Bairro";
        }
        if (!$validation->_street($billing_address['rua'])) {
            $validando['status'] = false;
            $validando['message'][] = "Rua";
        }
        if (!$validation->_number($billing_address['numero'])) {
            $validando['status'] = false;
            $validando['message'][] = "Número";
        }
        if (!$validation->_state($billing_address['estado'])) {
            $validando['status'] = false;
            $validando['message'][] = "Estado";
        }
        if (!$validation->_city($billing_address['cidade'])) {
            $validando['status'] = false;
            $validando['message'][] = "Cidade";
        }
        
        if (strlen($customer['cpf']) > 11) {
            if (!$validation->_corporate($customer['juridical_person']['corporate_name'])) {
                $validando['status'] = false;
                $validando['message'][] = "Razão Social";
            }
            if (!$validation->_cnpj($customer['juridical_person']['cnpj'])) {
                $validando['status'] = false;
                $validando['message'][] = "Cnpj";
            }
        }else{
            if (!$validation->_name($customer['name'])) {
                $validando['status'] = false;
                $validando['message'][] = "Nome";
            }
            if (!$validation->_cpf($customer['cpf'])) {
                $validando['status'] = false;
                $validando['message'][] = "Cpf";
            }
        }
        return $validando;
    }

    /**
     * Gera o boleto
     * @param array $customer
     * @param string $expire_at
     * @param int $chargeId
     * @param array $dadosBoleto
     * @return string
     */
    private function payChargeBillet($customer,$expire_at,$chargeId,$dadosBoleto)
    {
        $params = [
            'id' => $chargeId,
        ];
        

        if ($dadosBoleto['desconto'] > 0) {
            $discount = [ 
                'type' => 'percentage', // tipo de desconto a ser aplicado
                'value' => (int)$dadosBoleto['desconto'] * 100 // valor de desconto 
            ];
            $bankingBillet = [
                'expire_at' => $expire_at, // data de vencimento do boleto (formato: YYYY-MM-DD)
                'customer' => $customer,
                'discount' => $discount
              ];
        }else {
            $bankingBillet = [
                'expire_at' => $expire_at, // data de vencimento do boleto (formato: YYYY-MM-DD)
                'customer' => $customer
              ];
        }
        $configurations = array();
		if($dadosBoleto['multa'] > 0)
			$configurations['fine'] = (int)$dadosBoleto['multa'] * 100;
		if($dadosBoleto['juros'] > 0)
			$configurations['interest'] = (int)$dadosBoleto['juros'];

		if(isset($configurations['fine']) || isset($configurations['interest']))
			$bankingBillet['configurations'] = $configurations;

		if(strlen($dadosBoleto['observacaoBoleto']) > 0)
			$bankingBillet['message'] = $dadosBoleto['observacaoBoleto'];

          
          $payment = [
            'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
          ];
           
          $body = [
            'payment' => $payment
          ];
         

          try {
            $billet = $this->apiInstance->payCharge($params, $body);
            $res['code'] = $billet['code'];
            $res['pdf'] = $billet['data']['pdf']['charge'];
            $res['copia_e_cola'] = $billet['data']['pix']['qrcode'];
            $res['imagem_pix'] = $billet['data']['pix']['qrcode_image'];
            $res['barcode'] = $billet['data']['barcode'];
            return $res ;
          } catch (\Throwable $th) {
            $validation = new GerencianetValidation();
            return $validation->getErrorMessage($th->getCode());
          }
    }


    /**
     * Gera a cobrança no cartão
     * @param array $customer
     * @param int $chargeId
     * @return boolean
     */
    private function payChargeCard($customer,$chargeId,$addres)
    {
        
        $params = [
            'id' => $chargeId,
        ];
        $paymentToken = $addres['payment_token'];
        $billingAddress = [
            'street' => $addres['rua'],
            'number' => $addres['numero'],
            'neighborhood' => $addres['bairro'],
            'zipcode' => str_replace('-','',str_replace('.','',$addres['cep'])),
            'city' => $addres['cidade'],
            'state' => $addres['estado'],
          ];
          $creditCard = [
            'installments' => (int) $addres["parcelasCartao"], // número de parcelas em que o pagamento deve ser dividido
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'customer' => $customer
          ];

          $payment = [
            'credit_card' => $creditCard // forma de pagamento (banking_billet = boleto)
          ];
           
          $body = [
            'payment' => $payment
          ];
          try {
            $card = $this->apiInstance->payCharge($params, $body);
            return $card;
          } catch (\Throwable $th) {
            $validation = new GerencianetValidation();
            return $validation->getErrorMessage($th->getCode());
          }
          
    }
    /**
     * Gera um QRcode a partir da ID da location
     * @param array $locationId
     * @return string
     */
    public function generateQRCode($locationId) {
        try {
            $params = [
                'id' => $locationId
            ];

            return $this->apiInstance->pixGenerateQRCode($params);

        } catch(GerencianetException $e) {
            throw new Error($e->error);
        } catch(Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    /**
     * Registra um novo WebHook
     * @param string $pixKey
     * @param string $url
     * 
     * @return array
     */
    public function registerWebhook($pixKey, $url) {
        try {
            $params = ['chave' => $pixKey];
            $body = ['webhookUrl' => $url];

            return $this->apiInstance->pixConfigWebhook($params, $body);

        } catch(GerencianetException $e) {
            throw new Error($e->error);
        } catch(Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}