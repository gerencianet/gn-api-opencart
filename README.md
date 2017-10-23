# Módulo de Integração Gerencianet para OpenCart-2.3 - Versão 2.0.0 #

:warning: **Este módulo é compatível apenas com as versões do OpenCart superior a 2.3.0.2. Caso você tenha uma versão inferior do Opencart, você deve seguir os passos deste [link](https://github.com/gerencianet/gn-api-opencart).** 

**Em caso de dúvidas, você pode verificar a [Documentação](https://docs.gerencianet.com.br) da API na Gerencianet e, necessitando de mais detalhes ou informações, entre em contato conosco, via nossos [Canais de Comunicação](https://gerencianet.com.br/central-de-ajuda).**

## Pré-instalação

:warning: Este passo só deve ser seguido caso você tenha a versão antiga do módulo Gerencianet/Opencart e o Opencart 2.3.x.

1 - Desinstale o módulo antigo da Gerencianet;

2 - Apague os seguintes arquivos no servidor onde o Opencart está instalado:

- loja/admin/controller/payment/gerencianet.php
- loja/admin/language/en-gb/payment/gerencianet.php
- loja/admin/view/template/payment/gerencianet.tpl

- loja/catalog/controller/payment/gerencianet.php
- loja/catalog/language/en-gb/payment/gerencianet.php
- loja/catalog/model/payment/gerencianet.php
- loja/catalog/view/theme/default/template/payment/gerencianet.tpl
- loja/catalog/view/theme/default/template/payment/gerencianet_payment.tpl
- loja/catalog/view/theme/default/template/payment/gerencianet_success.tpl

:warning: Nenhum diretório deve ser apagado, apenas os arquivos citados acima.

## Instalação

### Automática

1. Faça o download do instalador [automático do módulo](auto/).
2. Na administração da loja OpenCart, acesse o menu `System > Settings` (`Configurações > Lojas`) e clique no botão `Edit` (`Editar`). Na aba **FTP**, preencha as informações de acesso ao ftp de sua hospedagem. Tenha atenção especial ao campo FTP Root (Diretório FTP), que é caminho completo para o diretório raiz onde está instalado o seu OpenCart. Em seguida, clique no botão `Save` (`Salvar`).
3. Acesse o menu `Extensions > Extension Installer` (`Extensões > Instalador`), clique no botão **Upload**, selecione o arquivo 'gerencianet.ocmod.zip' (citado na primeira instrução) e aguarde a conclusão da instalação automática.

* Caso você já tenha instalado o módulo da Gerencianet anteriormente, o OpenCart poderá informar que alguns arquivos serão sobrescritos. Não se preocupe, pois a instalação não afetará qualquer arquivo que não seja do módulo da Gerencianet já existente em sua loja.

Atenção: Devido ao tamanho do arquivo de instalação do módulo, talvez seja necessário alterar o parâmetro `php_max_upload` do `php.ini` para no mínimo 3mb.


### Manual

1. Faça o download dos [arquivos da última versão do módulo](manual/).
2. Descompacte os arquivo baixado e realize o upload das pastas **admin**, **catalog** e **lib** para dentro do diretório principal do OpenCart*.

*Caso você já tenha instalado o módulo da Gerencianet anteriormente, o OpenCart poderá informar que alguns arquivos serão sobrescritos. Não se preocupe, pois a instalação não afetará qualquer arquivo que não seja do módulo da Gerencianet já existente em sua loja.


## Configuração

Ao acessar `Extensions >  Extensions` (`Extensões > Extensões`), você deverá selecionar o tipo de extensão que deseja. Escolha `Payments` (`Pagamentos`). Você já visualizará o módulo da Gerencianet disponível na lista. Clique em `install` (`instalar`) para instalar o módulo e depois em `edit` (`editar`) para iniciar a configuração.

Três abas estarão disponíveis para realizar a configuração do módulo:

* Configurações Gerais
* Credenciais
* Status da Compra

### Configurações Gerais

Nesta aba, as seguintes propriedades podem ser configuradas:
* Modo: Determina se o módulo está em modo de testes. No modo de teste você pode gerar cobranças fictícias para testar o fluxo.
* Pagamentos permitidos: Determina quais tipos de pagamentos serão aceitos pelo módulo
* Dias para vencimento do Boleto: Determina em quantos dias o boleto irá vencer após a data de geração
* Desconto para pagamento no Boleto: Você pode fornecer desconto para clientes que pagam por meio de Boleto Bancário.
* Instruções no Boleto Bancário: Você pode definir quatro linhas com até 90 caracteres de instruções no Boleto Bancário. Se as linhas não forem preenchidas, serão exibidas as instruções padrões no boleto
* Atualizar status dos pedidos do OpenCart automaticamente: Determina se o módulo poderá atualizar automaticamente o status de um pedido de acordo com as notificações de atualização enviadas pela Gerencianet
* Envio de e-mail automático da sua loja para notificar o cliente: Notifica o cliente por um e-mail da sua loja quando uma atualização do status automática for realizada. Independente da opção, a Gerencianet enviará um e-mail para o cliente informando sobre a cobrança.
* Status: Determina se o módulo de pagamentos da Gerencianet está Ativo ou Inativo.

### Credenciais

Nesta aba é necessário informar as credenciais da sua aplicação e o identificador da conta obtidos na Aplicação criada na Gerencianet.

### Status da Compra

Nesta aba é realizada a configuração dos Status de pagamento da Gerencianet com os Status de pagamento de sua loja. Assim, quando houver a alteração do status do pagamento na Gerencianet,  o status do pedido em sua loja será atualizado automaticamente de acordo com as configurações definidas.

## Requisitos

* É necessário que o Real Brasileiro esteja configurado como moeda padrão no Opencart.
* Versão mínima do PHP: 5.4.0
* Versão mínima do OpenCart: 2.3.0.2
