<?php

/**
 * Lista de constantes para as configurações salvas do Usuário
 */
abstract class Constants {

    public const configOptionsPix = [
        'clientIdProd' => 'payment_gerencianetpix_prod_client_id',
        'clientSecretProd' => 'payment_gerencianetpix_prod_client_secret',
        'clientIdDev' => 'payment_gerencianetpix_dev_client_id',
        'clientSecretDev' => 'payment_gerencianetpix_dev_client_secret',
        'sandbox' => 'payment_gerencianetpix_sandbox',
        'debug' => 'payment_gerencianetpix_debug',
        'pixKey' => 'payment_gerencianetpix_pix_key',
        'pixCert' => 'payment_gerencianetpix_certificate',
        'pixDiscount' => 'payment_gerencianetpix_discount',
        'pixHours' => 'payment_gerencianetpix_due_date',
        'mtls' => 'payment_gerencianetpix_mtls',
        'payeeId' => 'payment_gerencianetpix_payee_id'
    ];

    public const constantValues = [
        'currency'  => 'BRL'
    ];

    // constante responsavel em armazenar as opções de status do pedido
    public const orderStatus = [
        'PENDING' => 'payment_gerencianetpix_status_new', 
        'COMPLETE' => 'payment_gerencianetpix_status_paid',
        'REFUNDED' => 'payment_gerencianetpix_status_refunded'
    ];
}
