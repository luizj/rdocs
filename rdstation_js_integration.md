# Integrações RD Station
## Como instalar o script para integração com formulário

Essa é a integração mais simples de ser feita. Basta adicionar o script diretamente na página do seu formulário, assim como o Google Analytics.

Os seus formulários irão para o RD Station com um identificador. Identificador é o nome do evento, por exemplo, cadastro, newsletter, formulário de orçamento, contato, entre outros, que irá aparecer na conversão do Lead no seu RD Station.


### Funcionamento

O componente integrador irá identificar automaticamente seu formulário se ele possuir um campo (`input`) com o nome **email**:
```HTML
<input type="text" name="email" />
```

Se o seu formulário possui o `input` mencionado, siga os passos abaixo para integrar seu formulário.

### Passo a passo da integração

Para realizar a integração você deve **inserir o script abaixo na página que contém o formulário**, seguindo esses passos:

1 - Inserir seu token RD Station onde diz `'SEU_TOKEN_RDSTATION_AQUI'`. Ele pode ser obtido nas suas [Configurações do RD Station](https://www.rdstation.com.br/integracoes);

2 - Definir um identificador para o evento de conversão e inserí-lo no script abaixo onde diz `'IDENTIFICADOR DESEJADO'`;

3 - Adicionar o código na página que contém o formulário.

```HTML
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
    RdIntegration.integrate('SEU_TOKEN_RDSTATION_AQUI', 'IDENTIFICADOR DESEJADO');
</script>
```

Após realizar esses passos, a sua integração está **pronta**. 
Recomendamos realizar alguns testes de integração para verificar se todos os dados aparecem no RD Station.

#### Meu formulário não atende ao padrão mencionado

Caso seu formulário possua um campo para o Lead informar o e-mail, porém o `input` desse campo tenha um nome diferente de <strong>email</strong>, você deverá configurar uma correspondência de campos.

Essa correspondência entre campos do seu formulário e os campos do RD Station pode ser feita também para outros campos. Por exemplo, se o campo onde o Lead informa o nome seja `name="nome_completo"` ou se o campo com informações a respeito do cargo do Lead seja `name="cargo_do_usuario"`, você pode utilizar a mesma estrutura para que esses dados sejam enviados corretamente para o RD Station.

Suponha que seu formulário possua os seguintes campos:
```HTML
<input type="text" name="email_do_usuario" />
<input type="text" name="Nome Completo" />
```

Você deve colocar somente o código abaixo do script de integração para que a correspondência de campos seja feita e os dados sejam adicionados corretamente no RD Station.

Assim, para integrar seu formulário, siga os passos 1 e 2 normalmente, e no passo 3 o seu código deverá ser algo como:

```HTML
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
    var meus_campos = {
      "email_do_usuario": "email",
      "Nome Completo": "name",
    }
    options = { fieldMapping: meus_campos }
    RdIntegration.integrate('SEU_TOKEN_RDSTATION_AQUI', 'IDENTIFICADOR DESEJADO', options);
</script>
```
Para cada campo adicionado, a linha deve terminar com uma virgula.
Exemplo:
```JavaScript
var meus_campos = {
      "email_do_usuario": "email",
      "Nome Completo": "name",
      "IdadeDoCliente": "idade",
      "Empresa do Usuario": "empresa",
    }
```

### Campos do Lead no RD Station

Os campos abaixo irão aparecer diretamente na tela de informação de Lead se mantiverem os nomes listados abaixo. Você pode utilizar a estrutura acima para enviar esses dados com seus respectivos nomes.

<ul>
<li>nome</li>
<li>telefone</li>
<li>empresa</li>
<li>cargo</li>
<li>twitter</li>
</ul>

Todas as informações que você deseja enviar ao RD Station devem estar em um HTML <em>input</em> e obrigatoriamente devem possuir uma tag <strong>name</strong> para identificá-los. Essas informações também ficarão disponíveis nos detalhes da conversão do Lead.
```HTML
<input type="text" name="Telefone" />
```

Recomendamos que o campo de nome possua a tag name="name", pois dessa forma, esse será o nome do Lead criado no RD Station. Caso não seja enviada essa informação, o nome do Lead será preenchida com o seu e-mail.
```HTML
<input type="text" name="name" />
```

### Avisos de conversão por email

O RD Station pode lhe enviar um email quando uma nova conversão for realizada em seu site. Para isso, basta colocar o seu email na configuração da [página da API](https://www.rdstation.com.br/integracoes)


### Exemplo completo

No código HTML abaixo, é possível ver uma página com um formulário que envia as informações para a API e depois redireciona o visitante para outra página.

```HTML
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>HTML Puro | Integrações RD Station</title>
<style type="text/css">
html,body{text-align:center;}
#wrapper{width:600px; margin:0 auto; text-align:center;}
#conversion-form{width:300px; margin:0 auto; border:1px solid silver;text-align:left;}
#conversion-form .field{padding:4px;}
#conversion-form .actions{text-align:center;}
#conversion-form label{display:block;}
#conversion-form input[type=text]{width:90%;}
</style>
</head>
<body>
<div id="wrapper">
 
  <h1>Integrações RD Station</h1>
  <h2>Integração Genérica via JavaScript</h2>
 
  <form id="sample"> 
    <div class="field">
      <label>E-mail:*</label>
      <input type="text" name="email" />
    </div>
    <div class="field">
      <label>Nome:*</label>
      <input type="text" name="nome" />
    </div>
    <div class="field">
      <label>Empresa:</label>
      <input type="text" name="empresa" />
    </div>
    <div class="actions">
      <input type="submit" value="Enviar" />
    </div>
  </form> 
</div>
<!-- Início do código de integração -->
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
    RdIntegration.integrate('f1c940384a971f2982c61a5e5f11e6b9', 'Formulário de contato');
</script>
<!-- Fim do código de integração -->
</body>
</html>
```

### Possíveis Erros

A API pode retornar erro caso:
 - (401) seu token RD Station esteja errado ou inválido;
 - (400) não esteja recebendo um identificador;
 - (400) não esteja recebendo o email (<strong>email</strong> ou <strong>email_lead</strong>) vindo do formulário;


### Possíveis Alertas
- (302) A API recebeu algum alerta e, ainda assim, registrou a conversão normalmente.
- Seu servidor pode emitir para o navegador um alerta de `No Access-Control-Allow-Origin`.
Este é um alerta de segurança pelo fato de estar trocando dados com outro servidor. Apesar do alerta, a integração funciona normalmente sem afetar nada no seu site.



É importante testar a integração após as modificações para evitar que erros como esses acima apareçam para o seu visitante.

Recomendados a utilização de alguma mecanismo para validação dos campos do formulário garantindo que o campo e-mail (obrigatório) seja sempre informado pelo visitante. 
