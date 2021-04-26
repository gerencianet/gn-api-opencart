<?php

$_['heading_title'] = 'Gerencianet Pix';
$_['text_payment'] = 'Extensões';
$_['text_success'] = 'Informações salvas com sucesso';
$_['text_error'] = 'Erro ao salvar informações.';
$_['text_error_webhook'] = 'Erro ao Cadastrar Webhook. Por favor, verifique as informações.';
$_['text_error_https_webhook'] = 'Identificamos que o seu domínio não possui certificado de segurança HTTPS ou não é válido para registrar o Webhook!';
$_['payment_gerencianetpix_painel_header'] = 'Configuração';
$_['payment_gerencianetpix_pix'] = 'PIX';
$_['payment_gerencianetpix_about'] = 'Sobre';
$_['payment_gerencianetpix_empty_field'] = ' é um campo obrigatório';

// General options
$_['payment_gerencianetpix_prod_client_id'] = 'Client_ID Produção';
$_['payment_gerencianetpix_prod_client_secret'] = 'Client_Secret Produção';
$_['payment_gerencianetpix_dev_client_id'] = 'Client_ID Desenvolvimento';
$_['payment_gerencianetpix_dev_client_secret'] = 'Client_Secret Desenvolvimento';
$_['payment_gerencianetpix_payee_id'] = 'Código Identificador da Conta';
$_['payment_gerencianetpix_debug'] = 'Debug';

// Pix options
$_['payment_gerencianetpix_pix_key'] = 'Chave PIX';
$_['payment_gerencianetpix_certificate'] = 'Caminho do certificado';
$_['payment_gerencianetpix_certificate_info'] = 'Adicione o arquivo (.pem) em uma pasta privada no servidor e informe o caminho completo';
$_['payment_gerencianetpix_discount'] = 'Desconto no pagamento (%)';
$_['payment_gerencianetpix_discount_info'] = 'Valor do Percentual de Desconto. Ex.: 5';
$_['payment_gerencianetpix_due_date'] = 'Tempo de vencimento (horas)';
$_['payment_gerencianetpix_mtls'] = 'Validar mTLS';
$_['payment_gerencianetpix_mtls_info'] = 'Entenda os riscos de não configurar o mTLS acessando o link https://gnetbr.com/rke4baDVyd';
$_['payment_gerencianetpix_sandbox'] = 'Habilitar modo sandbox';
$_['payment_gerencianetpix_status'] = 'Ativo';
$_['payment_gerencianetpix_status_info'] = 'Habilitar ou Desabilitar a Extensão da Gerencianet';

// Order Status options
$_['payment_gerencianetpix_order_status'] = 'Status do Pedido';
$_['payment_gerencianetpix_status_new'] = 'Inicial';
$_['payment_gerencianetpix_status_paid'] = 'Completo';
$_['payment_gerencianetpix_status_refunded'] = 'Reembolso';