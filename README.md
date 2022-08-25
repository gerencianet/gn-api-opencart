# Módulo de Integração Gerencianet  para OpenCart Brasil #

:warning: **Este módulo é compatível apenas com as versões do OpenCart 3.0.3.3 (Brasil 1.5.0) ou superior.**:warning:

**Em caso de dúvidas, você pode verificar a [Documentação](https://dev.gerencianet.com.br/docs/opencart-pix) da API na Gerencianet e, necessitando de mais detalhes ou informações, entre em contato conosco, via nossos [Canais de Comunicação](https://gerencianet.com.br/central-de-ajuda).**

## Requisitos

#### Testado nas seguintes versões do PHP:
``` 
    PHP  7.2, 7.3 e 7.4 
```

#### Dependências
Instalação de dependências que podem estar faltando (substitua o x pelo número da versão do seu PHP): 
```
    sudo apt-get install php7.x-dom
    sudo apt-get install php7.x-curl
    sudo apt-get install php7.x-gd
    sudo apt-get install php7.x-xml
    sudo apt-get install php7.x-zip
```

- OpenCart necessita do <code>curl</code> ativado
- É necessário que o <code>Real Brasileiro</code> esteja configurado como moeda padrão no Opencart.

## Instalação
### Automática

1. Faça o download do arquivo [gerencianet.ocmod.zip](auto/).

2. Acesse o menu `Extensions > Extension Installer` (`Extensões > Instalador`), clique no botão **Upload**, selecione o arquivo 'gerencianet.ocmod.zip' (citado na primeira instrução) e aguarde a conclusão da instalação automática.

:warning: Caso você já tenha instalado o módulo da Gerencianet anteriormente, o OpenCart poderá informar que alguns arquivos serão sobrescritos. Não se preocupe, pois a instalação não afetará qualquer arquivo que não seja do módulo da Gerencianet já existente em sua loja. :warning:

:warning: Atenção: Devido ao tamanho do arquivo de instalação do módulo, talvez seja necessário alterar o parâmetro `php_max_upload` do `php.ini` para no mínimo 10mb. :warning:


### Manual

1. Faça o download dos [arquivos da última versão do módulo](manual/).
2. Descompacte os arquivo baixado e realize o upload das pastas **admin**, **catalog** e **lib** para dentro do diretório principal do OpenCart.

:warning: Caso você já tenha instalado o módulo da Gerencianet anteriormente, o OpenCart poderá informar que alguns arquivos serão sobrescritos. Não se preocupe, pois a instalação não afetará qualquer arquivo que não seja do módulo da Gerencianet já existente em sua loja. :warning:


## Configuração

Acesse `Extensions >  Modifications` (`Extensões > Modificações`), selecione o módulo `Gerencianet` e clique no botão `Refresh` (`Atualizar`) no canto superior direito da página.

Ao acessar `Extensions >  Extensions` (`Extensões > Extensões`), você deverá selecionar o tipo de extensão que deseja. Escolha `Payments` (`Pagamentos`). Você já visualizará o módulo da Gerencianet disponível na lista. Clique em `install` (`instalar`) para instalar o módulo e depois em `edit` (`editar`) para iniciar a configuração.

Cinco abas estarão disponíveis para realizar a configuração do módulo:

* Geral
* PIX
* Boleto
* Cartão de Crédito
* Status do Pedido

### Configurações Gerais

Nesta aba é necessário informar:
* As **credenciais de Produção e Desenvolvimento** da sua aplicação (obtidas na sua conta Gerencianet)
* O **identificador da conta** (obtido na sua conta Gerencianet)
* **Habilita o checkout em um passo**: Determina se o  checkout do plugin  irá aparecer junto com o formulário de finalização do pedido ou se irá abrir uma nova página para finalização do pagamento.
* **Habilitar modo sandbox**: Determina se o módulo está em modo de testes. No modo de teste você pode gerar cobranças fictícias para testar o fluxo.
* **Ativo**: Determina se o módulo de pagamentos da Gerencianet está Ativo ou Inativo.

### PIX

Nesta aba, as seguintes propriedades podem ser configuradas:

* **Chave PIX**: Determina a qual chave PIX o pagamento será enviado
* **Caminho do certificado**: Deve ser informado o caminho onde se encontra o seu certificado de segurança `.pem`
* **Desconto no Pagamento**: Você pode fornecer desconto para clientes que pagam por meio do PIX.
* **Tempo de Vencimento (horas)**: Determina o tempo de validade do QrCode Gerado
* **Validar mTLS**: Habilita ou desabilita a verificação de segurança utilizando mTLS. Mais informações você encontra [AQUI](https://dev.gerencianet.com.br/docs/api-pix#section-webhook)

### Boleto

Nesta aba, as seguintes propriedades podem ser configuradas:

* **Dias Para Vencimento**: Determina a quantidade de dias  para o vencimento do boleto, a contar da data de sua geração.
* **Desconto no pagamento**: Determina a quantidade de desconto que será aplicado no boleto,  em porcentagem.
* **Defina o percentual de multa**: Configuração de multa para ser aplicada automaticamente  no caso de pagamento após o vencimento do boleto.
* **Defina o percentual de juros**: Configuração de jutos para ser aplicado automaticamente  no caso de pagamento após o vencimento do boleto.
* **Observação**: Permite incluir uma mensagem no boleto para o cliente final.
* **E-mail de cobrança**: Caso selecionado, serão enviados e-mails sobre as transações para o cliente final.
* **Ativar boleto**: Caso selecionado,   ativará a opção boleto como forma de pagamento.

### Cartão de Crédito

Nesta aba, as seguintes propriedades podem ser configuradas:

* **Ativar Cartão de Crédito**: Caso selecionado,   ativará a opção cartão de crédito  como forma de pagamento.

### Status do Pedido

Nesta aba é realizada a configuração dos Status de pagamento da Gerencianet com os Status de pagamento de sua loja. Assim, quando houver a alteração do status do pagamento na Gerencianet,  o status do pedido em sua loja será atualizado automaticamente de acordo com as configurações definidas.