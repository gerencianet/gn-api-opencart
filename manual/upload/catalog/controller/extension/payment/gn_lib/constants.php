<?php

/**
 * Lista de constantes para as configurações salvas do Usuário
 */
abstract class Constants {

    public const configOptionsPix = [
        'clientIdProd' => 'payment_gerencianet_prod_client_id',
        'clientSecretProd' => 'payment_gerencianet_prod_client_secret',
        'clientIdDev' => 'payment_gerencianet_dev_client_id',
        'clientSecretDev' => 'payment_gerencianet_dev_client_secret',
        'sandbox' => 'payment_gerencianet_sandbox',
        'debug' => 'payment_gerencianet_debug',
        'pixKey' => 'payment_gerencianet_pix_key',
        'pixCert' => 'payment_gerencianet_certificate',
        'pixDiscount' => 'payment_gerencianet_discount',
        'pixHours' => 'payment_gerencianet_due_date',
        'mtls' => 'payment_gerencianet_mtls',
        'payeeId' => 'payment_gerencianet_payee_id'
    ];

    public const constantValues = [
        'currency'  => 'BRL'
    ];

    // constante responsavel em armazenar as opções de status do pedido
    public const orderStatus = [
        'PENDING' => 'payment_gerencianet_status_new', 
        'COMPLETE' => 'payment_gerencianet_status_paid',
        'REFUNDED' => 'payment_gerencianet_status_refunded'
    ];
}
