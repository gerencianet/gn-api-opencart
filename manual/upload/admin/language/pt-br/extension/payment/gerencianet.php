<?php

$_['heading_title'] = 'Gerencianet';
$_['text_payment'] = 'Extensões';
$_['text_success'] = 'Informações salvas com sucesso';
$_['text_error'] = 'Erro ao salvar informações.';
$_['text_gerencianet']	= '<a target="_BLANK" href="https://www.gerencianet.com.br"><img style="width: 150px;" src="view/image/payment/gerencianet.png" alt="Gerencianet" title="Gerencianet" /></a>';
$_['text_error_webhook'] = 'Erro ao Cadastrar Webhook. Por favor, verifique as informações.';
$_['text_error_https_webhook'] = 'Identificamos que o seu domínio não possui certificado de segurança HTTPS ou não é válido para registrar o Webhook!';
$_['payment_gerencianet_painel_header'] = 'Configuração';
$_['payment_gerencianet_pix'] = 'PIX';
$_['payment_gerencianet_boleto'] = 'Boleto';
$_['payment_gerencianet_cartao'] = 'Cartão de Crédito';
$_['payment_gerencianet_about'] = 'Sobre';
$_['payment_gerencianet_empty_field'] = ' é um campo obrigatório';

// General options
$_['payment_gerencianet_prod_client_id'] = 'Client_ID Produção';
$_['payment_gerencianet_prod_client_secret'] = 'Client_Secret Produção';
$_['payment_gerencianet_dev_client_id'] = 'Client_ID Desenvolvimento';
$_['payment_gerencianet_dev_client_secret'] = 'Client_Secret Desenvolvimento';
$_['payment_gerencianet_payee_id'] = 'Código Identificador da Conta';   
$_['payment_gerencianet_debug'] = 'Debug';
$_['payment_gerencianet_status'] = 'Ativo';
$_['payment_gerencianet_transparent'] = 'Habilita o checkout em um passo';
$_['payment_gerencianet_transparent_info'] = 'Marque essa opção se você deseja que o chekout para pagamento ocorra apenas em um passo';
$_['payment_gerencianet_sandbox'] = 'Habilitar modo sandbox';
$_['payment_gerencianet_status_info'] = 'Habilitar ou Desabilitar a Extensão da Gerencianet';

// Pix options
$_['payment_gerencianet_pix_key'] = 'Chave PIX';
$_['payment_gerencianet_pix_key_info'] = 'Chave Pix cadastrada na Gerencianet';
$_['payment_gerencianet_certificate'] = 'Caminho do certificado';
$_['payment_gerencianet_certificate_info'] = 'Adicione o arquivo (.pem) em uma pasta privada no servidor e informe o caminho completo';
$_['payment_gerencianet_discount'] = 'Desconto no pagamento (%)';
$_['payment_gerencianet_discount_info'] = 'Valor do Percentual de Desconto. Ex.: 5';
$_['payment_gerencianet_due_date'] = 'Tempo de vencimento (horas)';
$_['payment_gerencianet_mtls'] = 'Validar mTLS';
$_['payment_gerencianet_mtls_info'] = 'Entenda os riscos de não configurar o mTLS acessando o link https://gnetbr.com/rke4baDVyd';
$_['payment_gerencianet_pix_active'] = 'Ativar pix';
$_['payment_gerencianet_pix_active_info'] = 'Marque essa opção para deixar o Pix disponível como forma de pagamento';

// Billet options
$_['payment_gerencianet_boleto_vencimento'] = 'Dias Para Vencimento';
$_['payment_gerencianet_boleto_vencimento_info'] = 'Número de dias corridos para o vencimento da cobrança depois que a mesma foi gerada';
$_['payment_gerencianet_boleto_desconto'] = 'Desconto no pagamento';
$_['payment_gerencianet_boleto_desconto_info'] = 'Defina um desconto em porcentagem';
$_['payment_gerencianet_boleto_email_cobranca'] = 'Email de  cobrança';
$_['payment_gerencianet_boleto_email_cobranca_info'] = 'Marque essa opção se você deseja que a Gerencainet envie emails de transações para o cliente final';
$_['payment_gerencianet_boleto_multa'] = 'Defina o percentual de multa';
$_['payment_gerencianet_boleto_multa_info'] = 'Percentual de multa (máximo 2). Ex: 2 (2% após o vencimento)';
$_['payment_gerencianet_boleto_juros'] = 'Defina o percentual de juros';
$_['payment_gerencianet_boleto_juros_info'] = 'Percentual de juros (máximo 33). Ex: 33 (0.033% ao dia)';
$_['payment_gerencianet_boleto_observacoes'] = 'Observação';
$_['payment_gerencianet_boleto_observacoes_info'] = 'Permite incluir uma mensagem no boleto, para o cliente final';
$_['payment_gerencianet_boleto_active'] = 'Ativar boleto';
$_['payment_gerencianet_boleto_active_info'] = 'Marque essa opção para deixar o Boleto disponível como forma de pagamento';

//Card options
$_['payment_gerencianet_cartao_active'] = 'Ativar Cartão de Crédito';
$_['payment_gerencianet_cartao_active_info'] = 'Marque essa opção para deixar o Cartão de crédito disponível como forma de pagamento';


// Order Status options
$_['payment_gerencianet_order_status'] = 'Status do Pedido';
$_['payment_gerencianet_status_new'] = 'Inicial';
$_['payment_gerencianet_status_paid'] = 'Completo';
$_['payment_gerencianet_status_refunded'] = 'Reembolso';