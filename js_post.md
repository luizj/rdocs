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
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  var data_array = {
    email: 'integracao@test.com',
    identificador: 'Formulario de contato',
    token_rdstation: 'f1c940384a971f2982c61a5e5f11e6b9',
    nome: 'Fulano'
  };
  RdIntegration.post(data_array);
</script>
```

### Integrando formulário via método Post

Você pode inserir a função `post`, por exemplo, ao submeter um formulário. Para evitar que você perca a função que executava antes da integração, você pode inseri-la como um função nos parâmetros no post. Por exemplo:

```html
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  var data_array = {
    email: 'integracao@test.com',
    identificador: 'Formulario de contato',
    token_rdstation: 'f1c940384a971f2982c61a5e5f11e6b9',
    nome: 'Fulano'
  };
  RdIntegration.post(data_array, function () { alert('callback'); });
</script>
```

Se você capturar os dados do Lead diretamente do formulário, não se esqueça de enviar seu token do RD Station. Para isso, você pode adicionar ao formulário um campo hidden com o valor do token público de sua conta:

```
<input type="hidden" id="token_rdstation" name="token_rdstation" VALUE="f1c940384a971f2982c61a5e5f11e6b9">
```

Seu token pode ser obtido na [página de integrações do RD Station](https://rdstation.com.br/integracoes).


Se você tiver algum problema em utilizar essa função, você pode [abrir um ticket diretamente no suporte](http://ajuda.rdstation.com.br/hc/pt-br/requests/new).
