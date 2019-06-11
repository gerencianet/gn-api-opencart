<?php
$_['heading_title'] = 'Gerencianet';
 
$_['text_enabled'] = 'Ativado';
$_['text_disabled'] = 'Desativado';
$_['text_payment'] = 'Payment';
$_['text_gerencianet']	= '<a target="_BLANK" href="https://www.gerencianet.com.br"><img src="view/image/payment/gerencianet-payment.png" alt="Gerencianet" title="Gerencianet" /></a>';

$_['text_yes'] = 'Sim';
$_['text_no'] = 'Não';

$_['entry_status'] = 'Status:';
$_['entry_order_status'] = 'Situação do Pedido:';
 
$_['text_button_save'] = 'Salvar';
$_['text_button_cancel'] = 'Cancelar';

$_['gn_edit_config'] = 'Editando configurações do Módulo';
$_['gn_config_geral'] = 'Configurações gerais';
$_['gn_config_order_status'] = 'Status da Compra';
$_['gn_config_credentials'] = 'Credenciais';

$_['gn_config_saved'] = 'Suas configurações foram salvas com sucesso. Agora você já pode receber pela Gerencianet!';
$_['gn_config_check_tls'] = 'Identificamos que a sua hospedagem não suporta uma versão segura do TLS(Transport Layer Security) para se comunicar  com a Gerencianet. Para conseguir gerar transações, será necessário que contate o administrador do seu servidor e solicite que a hospedagem seja atualizada para suportar co municações por meio do TLS na versão mínima 1.2. Em caso de dúvidas e para maiores informações, contat e  a Equi pe Técnica da Gerencia net at ravés do suporte da empresa.';
$_['gn_config_saved_not_on'] = 'Suas configurações foram salvas com sucesso, mas seu módulo ainda não está ativo. Verifique se todos os campos obrigatórios foram preenchidos corretamente:<br>';

$_['gn_entry_sandbox'] = 'Modo';
$_['gn_entry_sandbox_development'] = 'Desenvolvimento (Testes)';
$_['gn_entry_sandbox_production'] = 'Produção (Pra valer!)';
$_['gn_entry_payment_options'] = 'Pagamentos permitidos';
$_['gn_entry_payment_options_billet_and_card'] = 'Boleto e Cartão de Crédito';
$_['gn_entry_payment_options_billet'] = 'Boleto Bancário';
$_['gn_entry_payment_options_card'] = 'Cartão de Crédito';
$_['gn_entry_payment_osc'] = 'Checkout em um passo';
$_['gn_entry_payment_osc_option'] = 'Habilitar checkout em um passo';
$_['gn_entry_help_payment_osc'] = 'Esta opção permite que o pagamento seja realizado diretamente na tela de Finalizar Compra. Antes de utilizar esta funcionalidade em produção, realize teste em modo de desenvolvimento para verificar a compatibilidade com a sua loja.';


$_['gn_entry_payment_notification_update'] = 'Atualizar status dos pedidos OpenCart automaticamente';
$_['gn_entry_payment_notification_update_notify'] = 'Ao atualizar o status do pedido, deseja enviar e-mail automático da sua loja para notificar o cliente?';

$_['gn_entry_client_id_development'] = 'Client ID';
$_['gn_entry_client_secret_development'] = 'Client Secret';

$_['gn_entry_client_id_production'] = 'Client ID';
$_['gn_entry_client_secret_production'] = 'Client Secret';

$_['gn_entry_payee_code'] = 'Identificador da Conta';
$_['gn_entry_billet_days_to_expire'] = 'Dias para vencimento do Boleto';
$_['gn_entry_billet_days_to_expire_placeholder'] = 'Digite o número de dias corridos para vencimento do Boleto.';

$_['gn_entry_new_status'] = "Status de Cobrança NEW";
$_['gn_entry_waiting_status'] = "Status de Cobrança WAITING";
$_['gn_entry_paid_status'] = "Status de Cobrança PAID";
$_['gn_entry_unpaid_status'] = "Status de Cobrança UNPAID";
$_['gn_entry_refunded_status'] = "Status de Cobrança REFUNDED";
$_['gn_entry_contested_status'] = "Status de Cobrança CONTESTED";
$_['gn_entry_canceled_status'] = "Status de Cobrança CANCELED";

$_['gn_entry_status_config_description'] = "Configure os Status de pagamento da Gerencianet com os Status de pagamento de sua loja. Assim, quando houver alteração do status do pagamento na Gerencianet, o status do pedido em sua loja será atualizado automaticamente de acordo com as configurações definidas abaixo.";

$_['gn_entry_help_sandbox'] = "Esta configuração permite que você realize testes para gerar cobranças fora do ambiente de produção.";
$_['gn_entry_help_status'] = "Define se o módulo da Gerencianet estará disponível para o cliente.";
$_['gn_entry_help_billet_expire'] = "Você pode configurar a quantidade de dias corridos para o vencimento do a data de geração.";
$_['gn_entry_help_status_new'] = "NEW - Cobrança gerada. Aguardando definição da forma de pagamento";
$_['gn_entry_help_status_waiting'] = "WAITING - Forma de pagamento selecionada. Aguardando a confirmação do pagamento";
$_['gn_entry_help_status_paid'] = "PAID - Pagamento confirmado";
$_['gn_entry_help_status_unpaid'] = "UNPAID - Não foi possível confirmar o pagamento da cobrança";
$_['gn_entry_help_status_refunded'] = "REFUNDED - Pagamento devolvido pelo lojista ou pelo intermediador Gerencianet";
$_['gn_entry_help_status_contested'] = "CONTESTED - Pagamento em processo de contestação";
$_['gn_entry_help_status_canceled'] = "CANCELED  - Cobrança cancelada pelo vendedor ou pelo pagador";
$_['gn_entry_help_keys'] = 'O par de chaves Client ID e Client Secret contém informações sigilosas que identificam sua aplicação e permitem a realização do pagamento. Para obter suas chaves você precisa entrar em sua conta Gerencianet e criar uma <a href="https://docs.gerencianet.com.br/#!/api-keys/create" target="_blank">Nova Aplicação</a>. Você terá acesso a dois pares de chaves: um de Desenvolvimento e outro de Produção.';
$_['gn_entry_help_payee_code'] = 'O identificador da conta é uma chave única utilizada para identificar uma determinada conta. Você pode encontrá-lo no link API, acima do menu de navegação lateral.';

$_['gn_entry_help_notification_update'] = "Você pode definir se o módulo Gerencianet deve alterar o status de um pedido automaticamente de acordo com a configuração da aba 'Status da Compra' sempre que houver mudança de status.";
$_['gn_entry_help_notification_update_notify'] = "Notifica o cliente por um email da sua loja quando uma atualização do status automática for realizada. Independente da opção escolhida, a Gerencianet enviará um email para o cliente informando sobre a cobrança.";
$_['gn_entry_help_discount'] = "Você pode escolher oferecer um desconto para o cliente que realizar o pagamento por Boleto.";
$_['gn_entry_help_billet_instructions'] = "Você pode personalizar as quatro linhas de instrução do boleto bancário. Se você não preencher nenhuma informação, serão exibidas as informações padrões.";

$_['gn_entry_discount_title'] = 'Configurar descontos';
$_['gn_entry_discount_billet'] = 'Desconto para pagamento por Boleto';
$_['gn_entry_discount_status'] = 'Status';
$_['gn_entry_discount_type'] = 'Tipo de desconto';
$_['gn_entry_discount_type_fixed'] = 'Valor fixo';
$_['gn_entry_discount_type_percent'] = 'Porcentagem do valor dos produtos';
$_['gn_entry_discount_value'] = 'Desconto para pagamento no Boleto (%)';
$_['gn_entry_billet_instructions'] = 'Instruções no Boleto Bancário:';

$_['gn_entry_incorrect_field_production_keys'] = 'Par de chaves de Produção';
$_['gn_entry_incorrect_field_development_keys'] = 'Par de chaves de Desenvolvimento';
$_['gn_entry_incorrect_field_payee_code'] = 'Identificador da Conta';
$_['gn_entry_incorrect_field_status'] = 'Status do Módulo está como "Inativo"';
$_['gn_entry_no_payment_selected'] = 'É obrigatório escolher/oferecer, pelo menos, uma forma de pagamento';

$_['gn_entry_official_module_title'] = 'Módulo Oficial de Pagamento';
$_['gn_entry_status_on'] = 'Ativo';
$_['gn_entry_status_off'] = 'Inativo (Não aparecerá como opção de pagamento para o cliente)';
$_['gn_entry_keys_production_title'] = 'PRODUÇÃO';
$_['gn_entry_keys_development_title'] = 'DESENVOLVIMENTO';
$_['gn_entry_keys_production_help'] = 'Onde eu encontro as chaves de produção?';
$_['gn_entry_keys_development_help'] = 'Onde eu encontro as chaves de desenvolvimento?';
$_['gn_entry_payee_code_help'] = 'Onde encontrar?';
$_['gn_entry_close'] = 'Fechar';
