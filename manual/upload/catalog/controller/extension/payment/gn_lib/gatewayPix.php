<?php

if (version_compare(phpversion(), '5.4.0', '>=')) {
	include_once('gerencianet/autoload.php');
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
     * @var array
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
            $newInstance = Gerencianet::getInstance(
                Array(
                    // OpenCart retorna 1 para true e NULL para false
                    'client_id' => $dataConfigPix['sandbox'] == 1 ? $dataConfigPix['clientIdDev'] : $dataConfigPix['clientIdProd'],
                    'client_secret' => $dataConfigPix['sandbox'] == 1 ? $dataConfigPix['clientSecretDev'] : $dataConfigPix['clientSecretProd'],
                    'pix_cert' => $dataConfigPix['pixCert'],
                    'debug' =>  $dataConfigPix['debug'] == 1,
                    'headers' => [
                        'x-skip-mtls-checking' => $dataConfigPix['mtls'] == 1 ? 'false' : 'true' //precisa ser string
                    ]
                )
            );
            return $newInstance;

        } catch (GerencianetException $e) {
            throw new Error($e->error);
        } catch (Exception $e) {
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