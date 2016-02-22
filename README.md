# Módulo Oficial da Gerencianet para o OpenCart - Versão 0.1.0 Beta #

Este módulo é compatível com as versões do OpenCart 2.0.0.0, 2.0.1.0, 2.0.1.1, 2.0.2.0, 2.0.3.1, 2.1.0.1 e 2.1.0.2.

## Instalação

# Automática

1. Baixe a [última versão](oc2.x/auto/gerencianet.ocmod.zip) do instalador automático do módulo.
2. Na administração da loja OpenCart acesse o menu `System > Settings` (`Configurações > Lojas`), clique no botão `Edit` (`Editar`), e na aba **FTP**, preencha as informações de acesso ao ftp de sua hospedagem, com atenção especial ao campo FTP Root (Diretório FTP), que é caminho completo para o diretório raiz onde está instalado o seu OpenCart, depois clique no botão `Save` (`Salvar`).
3. Acesse o menu `Extensions > Extension Installer` (`Extensões > Instalador`), clique no botão Upload e selecione o arquivo 'gn-api-opencart.ocmod.zip' (que você baixou no link citado anteriormente), e aguarde a conclusão da instalação automática.

*Caso você já tenha instalado o módulo da Gerencianet anteriormente, o sistema poderá informar que alguns arquivos serão sobrescritos. Não se preocupe, pois a instalação não afeterá nenhum arquivo que não seja do módulo da Gerencianet já existente em sua loja.

Atenção: Devido ao tamanho do arquivo de instalação do módulo, talvez seja necessário alterar o parâmetro `php_max_upload` do `php.ini` para no mínimo 3mb.


# Manual

1. Baixe a [última versão](oc2.x/manual/) dos arquivos do módulo.
2. Descompacte o arquivo baixado e realize o upload das pastas admin, catalog e lib para dentro do diretório principal do OpenCart*.

*Caso você já tenha instalado o módulo da Gerencianet anteriormente, o sistema poderá informar que alguns arquivos serão sobrescritos. Não se preocupe, pois a instalação não afeterá nenhum arquivo que não seja do módulo da Gerencianet já existente em sua loja.


## Configuração

Acessando `Extensions >  Payments` (`Extensões > Pagamentos`) já estará disponível o módulo da Gerencianet na lista. Clique em `install` para instalar o módulo e depois em `edit` para iniciar a configuração.

Três abas estarão disponíveis para realizar a configuração do módulo:

* Configurações Gerais
* Credenciais
* Status da Compra

# Configurações Gerais

Nesta aba pode ser configurado as seguintes propriedades:
* Modo: Determina se o módulo está em modo de testes. Em modo de teste você poderá gerar cobranças fictícias para testar o fluxo.
* Pagamentos permitidos: Determina quais tipos de pagamentos serão aceitos pelo módulo
* Dias para vencimento do Boleto: Determina em quantos dias após a data de geração o boleto irá vencer
* Desconto para pagamento no Boleto: Você poderá fornecer desconto para clientes que pagam através de Boleto Bancário.
* Atualizar status dos pedidos do OpenCart automaticamente: Determina se o módulo poderá atualizar automaticamente o status de um pedido de acordo com as notificações de atualização enviadas pela Gerencianet
* Ao atualizar, enviar email da sua loja automaticamente notificando o cliente: Notifica o cliente através de um email da sua loja quando uma atualização do status automática for realizada. Independente da opção, a Gerencianet enviará um email para o cliente informando sobre a cobrança.
* Status: Determina se o módulo de pagamentos da Gerencianet está Ativo ou Inativo.

# Credenciais

Nesta aba é necessário informar as credenciais da sua aplicação e o identificador da conta, obtidos em sua Aplicação criada na Gerencianet.

# Status da Compra

Nesta aba é realizada a configuração os Status de pagamento da Gerencianet com os Status de pagamento de sua loja. Assim, quando houver a alteração do status do pagamento na Gerencianet, automaticamente o status do pedido em sua loja será atualizado de acordo com as configurações definidas.

