<?php

/**
 * Lista de constants da extensão
 */
abstract class Constants {

    /**
     * Lista de campos do admin, separados por tabs
     */
    public const adminFields = array(
        'general' => array(
            'payment_gerencianetpix_prod_client_id' => array('required' => true),
            'payment_gerencianetpix_prod_client_secret' => array('required' => true),
            'payment_gerencianetpix_dev_client_id' => array('required' => true),
            'payment_gerencianetpix_dev_client_secret' => array('required' => true),
            'payment_gerencianetpix_payee_id' => array('required' => true),
            'payment_gerencianetpix_sandbox' => array('required' => false, 'type' => 'checkbox'),
            'payment_gerencianetpix_debug' => array('required' => false, 'type' => 'checkbox'),
            'payment_gerencianetpix_status' => array('required' => false, 'type' => 'checkbox', 'tooltip' => 'status_info')
        ),
        'pix' => array(
            'payment_gerencianetpix_pix_key' => array('required' => true),
            'payment_gerencianetpix_certificate' => array('required' => true, 'tooltip' => 'certificate_info'),
            'payment_gerencianetpix_discount' => array('required' => false, 'tooltip' => 'discount_info'),
            'payment_gerencianetpix_due_date' => array('required' => true),
            'payment_gerencianetpix_mtls' => array('required' => false, 'type' => 'checkbox', 'tooltip' => 'mtls_info')
        ),
        'order' => array(
            'payment_gerencianetpix_status_new' => array('required' => true, 'type' => 'select'),
            'payment_gerencianetpix_status_paid' => array('required' => true, 'type' => 'select'),
            'payment_gerencianetpix_status_refunded' => array('required' => true, 'type' => 'select')
        )
    );

    /**
     * Informações sobre o plugin
     */
    const aboutInfo = array(
        'version' => '3.0.1',
        'website' => 'https://gerencianet.com.br',
        'documentation' => 'https://dev.gerencianet.com.br/docs',
        'support' => 'https://gerencianet.com.br/central-de-ajuda/',
        'logoUrl' => 'https://gerencianet.com.br/wp-content/themes/Gerencianet/assets/images/svg/logo-gerencianet-topo.svg'
    );

    /**
     * Padrão de Formatação do array recebido na Classe do SDK da Gerencianet
     */
    public const configOptionsPix = [
        'clientIdProd'      => 'payment_gerencianetpix_prod_client_id',
        'clientSecretProd'  => 'payment_gerencianetpix_prod_client_secret',
        'clientIdDev'       => 'payment_gerencianetpix_dev_client_id',
        'clientSecretDev'   => 'payment_gerencianetpix_dev_client_secret',
        'sandbox'           => 'payment_gerencianetpix_sandbox',
        'debug'             => 'payment_gerencianetpix_debug',
        'pixKey'            => 'payment_gerencianetpix_pix_key',
        'pixCert'           => 'payment_gerencianetpix_certificate',
        'pixDiscount'       => 'payment_gerencianetpix_discount',
        'pixHours'          => 'payment_gerencianetpix_due_date',
        'mtls'              => 'payment_gerencianetpix_mtls',
        'payeeId'           => 'payment_gerencianetpix_payee_id'
    ];
}