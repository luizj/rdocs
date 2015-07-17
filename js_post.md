## Fazendo um POST para a API do RD Station

Se você deseja gerar uma um novo Lead ou uma nova conversão em um Lead já existente no RD Station via API, você pode utilizar a função `post` exposta abaixo.

Ela precisa receber um array com os dados a serem enviados para o RD Station. Alguns dados são obrigatórios, sendo eles:
- email
- token_rdstation
- identificador

Os demais dados enviados serão registrados no RD Station como dados da conversão.

### Estrutura dos dados

Segue um exemplo de como utilizar o script para fazer um post para a nossa API:

```html
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.4.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  var data_array = [
    {name: 'email', value: 'integracao@test.com'},
    {name: 'identificador', value: 'Formulario de contato'},
    {name: 'token_rdstation', value: 'f1c940384a971f2982c61a5e5f11e6b9'},
    {name: 'nome', value: 'Fulano'}
  ];
  RdIntegration.post(data_array);
</script>
```
Este exemplo acima é executado logo ao abrir a página, o ideal é que a execução esteja associada ao `submit` de um form.

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

Se você capturar os dados do Lead diretamente do formulário, não se esqueça de enviar seu token do RD Station. Para isso, você pode adicionar ao formulário um campo hidden com o valor do token público de sua conta:

```
<input type="hidden" id="token_rdstation" name="token_rdstation" VALUE="f1c940384a971f2982c61a5e5f11e6b9">
```

Seu token pode ser obtido na [página de integrações do RD Station](https://rdstation.com.br/integracoes).

### Associando a execução do script ao submit de um form

Para associar a função ao submit de um form de seu website, é possível utilizar o exemplo abaixo (Observe que o mesmo utiliza jQuery, que deve ser carregado se não estiver por padrão na página):

```html
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.4.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  $('form').on('submit', function(event) {
    event.preventDefault();
    var $form = $(event.target).closest('form');
    var inputs = $($form).find(':input').serializeArray();
    RdIntegration.post(inputs, event.submit); 
  });
</script>
```

Além disso o token de integração e identificador devem estar definidos como campos hidden do formulário:

```
<input type="hidden" id="token_rdstation" name="token_rdstation" VALUE="SEU_TOKEN_RDSTATION">
<input type="hidden" id="token_rdstation" name="identificador" VALUE="IDENTIFICADOR_DESEJADO">
```


Se você tiver algum problema em utilizar essa função, você pode [abrir um ticket diretamente no suporte](http://ajuda.rdstation.com.br/hc/pt-br/requests/new).
