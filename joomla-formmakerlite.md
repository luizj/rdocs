## Integração com o CMS Joomla via plugin Form Maker Lite

### Primeiros passos

Se você utiliza a plataforma Joomla, você pode integrar seus formulários com o RD Station utilizando o plugin [Form Maker Lite](http://extensions.joomla.org/extensions/contacts-and-feedback/forms/24170) e seguindo as instruções abaixo.

Ao criar seu formulário, siga os passos:

 1 - Clique em `FORM OPTIONS`;

 2 - Acesse a aba `JavaScript`;

 3 - dentro da função `before_load()` insira o código abaixo, fazendo as alterações descritas no próximo item:

 ```javascript

function before_load()
{
  loadScript = function() {
    var head = document.getElementsByTagName("head")[0],
      script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js";
    head.appendChild(script)
  };

  loadScript();
};

// Occurs just before submitting  the form
function before_submit()
{
  var dados = {
    'email': document.getElementById('wdform_2_element1').value,
    'identificador': 'IDENTIFICADOR DESEJADO',
    'token_rdstation': 'SEU_TOKEN_RDSTATION'
  };

  RdIntegration.post(dados);
}

// Occurs just before resetting the form
function before_reset()
{

}
 ```

### Configurando a integração

  Altere os seguintes dados:
  
 1 - troque "SEU_TOKEN_RDSTATION" pelo seu [token do RD Station](https://rdstation.com.br/integracoes);

 2 - troque "IDENTIFICADOR DESEJADO" pelo identificador que você deseja relacionar a esse formulário;

 3 - associe os dados do seu formulário aos dados do RD Station:
 
 Vá em editar o campo de e-mail e copie o `Field name` dele e coloque como `email` na variável *dados*:

```javascript
  var dados = {
    'email': document.getElementById('wdform_1_elementform_id_temp').value,
    'identificador': 'IDENTIFICADOR DESEJADO',
    'token_rdstation': 'SEU_TOKEN_RDSTATION'
  };
```

*Note que é preciso colocar o `Field name` na função `document.getElementById('wdform_1_elementform_id_temp').value`.*

Repita esse passo para os demais campos, ficando, por exemplo, assim:

```javascript
  var dados = {
    'email': document.getElementById('wdform_1_elementform_id_temp').value,
    'telefone': document.getElementById('wdform_2_element_form_id_temp').value,
    'nome': document.getElementById('wdform_3_element_firstform_id_temp').value + ' ' + 'document.getElementById('wdform_3_element_lastform_id_temp').value,
    'identificador': 'IDENTIFICADOR DESEJADO',
    'token_rdstation': 'SEU_TOKEN_RDSTATION'
  };
```

*O campo nome é composto por dois campos, por isto tem um formato um pouco diferente dos demais.'

Por fim, a caixa do JavaScript deve estar semelhante a essa:

```javascript
// Occurs before the form is loaded
function before_load()
{
  loadScript = function() {
    var head = document.getElementsByTagName("head")[0],
      script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js";
    head.appendChild(script)
  };

  loadScript();
}

// Occurs just before submitting  the form
function before_submit()
{
 var dados = {
    'email': document.getElementById('wdform_1_elementform_id_temp').value,
    'telefone': document.getElementById('wdform_2_element_form_id_temp').value,
    'nome': document.getElementById('wdform_3_element_firstform_id_temp').value + ' ' + 'document.getElementById('wdform_3_element_lastform_id_temp').value,
    'identificador': 'IDENTIFICADOR DESEJADO',
    'token_rdstation': 'SEU_TOKEN_RDSTATION'
  };

  RdIntegration.post(dados);
}

// Occurs just before resetting the form
function before_reset()
{

}
```

Dessa forma, seu formulário estará integrado ao RD Station. Todos os Leads que converterem nesse formulário serão criados na sua base de Leads.

Em caso de dúvidas, você pode entrar em contato com o [nosso suporte](http://ajuda.rdstation.com.br/hc/pt-br/requests/new).
