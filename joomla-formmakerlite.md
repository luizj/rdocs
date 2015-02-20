## Integração com o CMS Joomla via plugin Form Maker Lite

### Primeiros passos

Se você utiliza a plataforma Joomla, você pode integrar seus formulários com o RD Station utilizando o plugin [Form Maker Lite](http://extensions.joomla.org/extensions/contacts-and-feedback/forms/24170) e seguindo as instruções abaixo.

Ao criar seu formulário, siga os passos:

 1 - Clique em `FORM OPTIONS`;

 2 - Acesse a aba `JavaScript`;

 3 - dentro da função `before_load()` insira o código abaixo, fazendo as alterações descritas no próximo item:

 ```javascript

loadScript = function(c, b) {
  var d = document.getElementsByTagName("head")[0],
    a = document.createElement("script");
  a.type = "text/javascript";
  a.src = c;
  a.onload = b;
  a.onreadystatechange = function() {
    "complete" === this.readyState && b()
  };
  d.appendChild(a)
};
var meus_campos = {
  'wdform_1_elementform_id_temp': 'email'
};

var options = { fieldMapping: meus_campos }

loadScript(
  "https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js",
  function() {
    RdIntegration.integrate('SEU_TOKEN_RDSTATION', 'IDENTIFICADOR DESEJADO', options);
  }
);
 ```

### Configurando a integração

  Altere os seguintes dados:
  
 1 - troque "SEU_TOKEN_RDSTATION" pelo seu [token do RD Station](https://rdstation.com.br/integracoes);

 2 - troque "IDENTIFICADOR DESEJADO" pelo identificador que você deseja relacionar a esse formulário;

 3 - associe os dados do seu formulário aos dados do RD Station:
 
 Vá em editar o campo de e-mail e copie o `Field name` dele e coloque como `email` na variável *meus campos*:

```javascript
 var meus_campos = {
  'wdform_1_elementform_id_temp': 'email'
};
```

Repita esse passo para os demais campos, ficando, por exemplo, assim:

```javascript
 var meus_campos = {
  'wdform_1_elementform_id_temp': 'email',
  'wdform_2_element_firstform_id_temp, wdform_2_element_lastform_id_temp': 'nome',
  'wdform_4_element_firstform_id_temp, wdform_4_element_lastform_id_temp': 'telefone'
};
```

Por fim, a caixa do JavaScript deve estar semelhante a essa:

```javascript
// Occurs before the form is loaded
function before_load()
{
  loadScript = function(c, b) {
    var d = document.getElementsByTagName("head")[0],
      a = document.createElement("script");
    a.type = "text/javascript";
    a.src = c;
    a.onload = b;
    a.onreadystatechange = function() {
      "complete" === this.readyState && b()
    };
    d.appendChild(a)
  };

   var meus_campos = {
    'wdform_1_elementform_id_temp': 'email',
    'wdform_2_element_firstform_id_temp, wdform_2_element_lastform_id_temp': 'nome',
    'wdform_4_element_firstform_id_temp, wdform_4_element_lastform_id_temp': 'telefone'
  };

  var options = {
    options: meus_campos
  }

  loadScript(
    "https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js",
    function() {
      RdIntegration.integrate('f1c940384a971f2982c61a5e5f11e6b9', 'pagina-contato', options);
    }
  );
}

// Occurs just before submitting  the form
function before_submit()
{
     
}

// Occurs just before resetting the form
function before_reset()
{
     
}
```

Dessa forma, seu formulário estará integrado ao RD Station. Todos os Leads que converterem nesse formulário serão criados na sua base de Leads.

Em caso de dúvidas, você pode entrar em contato com o [nosso suporte](http://ajuda.rdstation.com.br/hc/pt-br/requests/new).
