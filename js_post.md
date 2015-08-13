## Fazendo um POST para a API do RD Station

O RD Station disponibiliza um serviço de integração via API muito fácil de ser integrado com seu formulário. Se você deseja gerar uma um novo Lead ou uma nova conversão em um Lead já existente, para você usar nosso serviço basta você carregar nosso _script_ na sua página e usar a função `post` disponível do serviço.

Primeiramente, antes de tudo, você deve carregar o _script_ em sua página. A partir do momento que você fizer isso, você será capaz de usar a função que fará a integração. Para carregar o _script_ na sua página, basta colar este código logo antes de fechar a tag `</body>` do seu html:

```html
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/latest/rd-js-integration.min.js"></script>
```

Pronto, agora você poderá acessar a varíavel `RDIntegration` que será responsável por comunicar com a nossa API e integrar seu formulário.

Após você ter o _script_ de integração já carregado no seu site, você pode usar a função `post`, ela que irá enviar os dados do seu formulário para nossa API, porém para isso você precisa ter uma estrutura de dados correta. Esta estrutura de dados deverá ser um array com os dados a serem enviados para o RD Station. 
Alguns dados são obrigatórios, sendo eles:
- email
- token_rdstation
- identificador

Os demais dados enviados serão registrados no RD Station como dados da conversão.

### Estrutura dos dados

Como falado anteriormente, a função `post` deverá receber um [array](https://pt.wikipedia.org/wiki/Arranjo_(computa%C3%A7%C3%A3o)) contendo os dados do seu formulário.

Para capturar os dados do seu formulário é muito fácil, basta você selecionar via Javascript os campos do formulário que deseja capturar o valor e após isso fazer a integração via função _post_ em algum evento de `click` ou `submit`. Veja um exemplo de caputura de dados em campos de um formulário:

```html
<form id="conversion-form" method="post" action="/">
  <label for="email">Email</label>
  <input name="email" type="email" />
  
  <label form="nome">Nome</label>
  <input name="name" type="text" />
  
  <input type="submit" id="submit-button" value="Enviar" />
</form>
```

Primeiramente, temos um formulário com apenas 2 campos: um campo de email e outro de nome. Note que cada campo do formulário tem um atributo `name`, é por este atributo que vamos fazer a captura do seu valor.

Recomendamos fortemente que você use a biblioteca [jQuery](https://jquery.com/) para lhe ajudar a manipular os dados e integrar o script. Para isso, basta carregar o `<script>` do jQuery juntamente com o script de integração do RDStation:

```html
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/latest/rd-js-integration.min.js"></script>
```

Agora veja um exemplo de como manipular os campos do seu formulário:

```html
<script type="text/javascript">
var form = $('#conversion-form');
var inputNome = form.find('input[name="nome"]');
var inputEmail = form.find('input[name="email"]');
</script>
```

Com apenas estas 3 linhas de Javascript já conseguimos capturar e manipular nossos campos do formulário. Agora vamos pegar os valores destes campos e integrar com o RDStation usando nosso serviço de integração:

```html
<script type="text/javascript">
var TOKEN = 'f1c940384a971f2982c61a5e5f11e6b9'; // token de exemplo

var form = $('#conversion-form');
var inputNome = form.find('input[name="nome"]');
var inputEmail = form.find('input[name="email"]');

form.on('submit', function(event) {
  var data_array = [
    { name: 'email', value: inputEmail.val() },
    { name: 'nome', value: inputNome.val() },
    { name: 'token_rdstation', value: TOKEN }
  ];
  
  RdIntegration.post(data_array);
  event.preventDefault();
});
</script>
```

Desta forma, toda vez que seu formulário for submetido, você estará capturando os valores dos inputs e integrando com o seu RDStation.

Se você capturar os dados do Lead diretamente do formulário, não se esqueça de enviar seu token do RD Station. Para isso, você pode adicionar o valor do seu token juntamente a estrutura de dados enviadas para a função _post_.

Seu token pode ser obtido na [página de integrações do RD Station](https://rdstation.com.br/integracoes).

Você pode ainda capturar todos os campos de um formulário automaticamente usando a função `serializeArray` disponível na biblioteca jQuery:

```html
<script type="text/javascript">
  var form = $('#conversion-form');
  
  form.on('submit', function(ev) {
    var inputs = form.find(':input');
    
    RdIntegration.post(inputs.serializeArray());
    event.preventDefault();
  });
</script>
```

Porém, para que seu integração funcione corretamente, você deve colocar o campo de _token_ e _identificador_ também como `<input>` na sua página, porém o tipo destes campos deve ser `hidden`:

```html
<input type="hidden" id="token_rdstation" name="token_rdstation" value="SEU_TOKEN_RDSTATION">
<input type="hidden" id="token_rdstation" name="identificador" value="IDENTIFICADOR_DESEJADO">
```

Veja como ficou o exemplo completo:

```html
<body>
  <!-- conteúdo da sua página -->
  <form id="conversion-form" method="post" action="/">
    <input type="hidden" id="token_rdstation" name="token_rdstation" value="SEU_TOKEN_RDSTATION">
    <input type="hidden" id="token_rdstation" name="identificador" value="IDENTIFICADOR_DESEJADO">
    
    <label for="email">Email</label>
    <input name="email" type="email" />
    
    <label form="nome">Nome</label>
    <input name="name" type="text" />
    
    <input type="submit" id="submit-button" value="Enviar" />
  </form>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/latest/rd-js-integration.min.js"></script>
  
  <script type="text/javascript">
    var form = $('#conversion-form');
    
    form.on('submit', function(ev) {
      var inputs = form.find(':input');
      
      RdIntegration.post(inputs.serializeArray());
      event.preventDefault();
    });
  </script>
</body>
```

### Integrando formulário via método Post

Você pode inserir a função `post`, por exemplo, ao submeter um formulário. Para evitar que você perca a função que executava antes da integração, você pode inseri-la como um função nos parâmetros no post. Por exemplo:

```html
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/latest/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  var data_array = [
    {name: 'email', value: 'integracao@test.com'},
    {name: 'identificador', value: 'Formulario de contato'},
    {name: 'token_rdstation', value: 'f1c940384a971f2982c61a5e5f11e6b9'},
    {name: 'nome', value: 'Fulano'}
  ];
  RdIntegration.post(data_array, function () { alert('callback'); });
</script>
```

Se você tiver algum problema em utilizar essa função, você pode [abrir um ticket diretamente no suporte](http://ajuda.rdstation.com.br/hc/pt-br/requests/new).
