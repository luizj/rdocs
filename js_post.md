Se você deseja gerar uma um novo Lead ou uma nova conversão em um Lead já existente no RD Station via API, você pode utilizar a função `post` exposta abaixo.

Ela precisa receber um array com os dados a serem enviados para o RD Station. Alguns dados são obrigatórios, sendo eles:
- email
- token_rdstation
- identificador

Os demais dados enviados serão registrados no RD Station como dados da conversão.

## Estrutura dos dados

Segue um exemplo de como utilizar o script para fazer um post para a nossa API:

```html
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  var data_array = {
    email: 'integracao@test.com',
    identificador: 'Formulario de contato',
    token_rdstation: 'f1c940384a971f2982c61a5e5f11e6b9',
    nome: 'Fulano'
  }
    RdIntegration.post(data_array);
</script>
```

Com isso, você pode inserir a função `post`, por exemplo, ao submeter um formulário. Para evitar que você perca a função que executava antes da integração, você pode inseri-la como parâmetro no post. Por exemplo:

```html
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
  var data_array = {
    email: 'integracao@test.com',
    identificador: 'Formulario de contato',
    token_rdstation: 'f1c940384a971f2982c61a5e5f11e6b9',
    nome: 'Fulano'
  }
    RdIntegration.post(data_array, alert('callback'));
</script>
```

