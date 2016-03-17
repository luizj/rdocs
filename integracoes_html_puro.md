# Integrações RD Station
## HTML Puro

Para quem não tem conhecimento técnico, a integração via HTML Puro é a mais simples de integrar ao RD Station.
Mas, infelizmente, ainda é preciso fazer algumas pequenas modificações no seu arquivo HTML.

### Usando a API

Quatro coisas são necessárias editar/adicionar na sua página para a integração funcionar:

 <b>1.</b> Ter um input (campo de texto) com o nome <strong>email</strong> ou <strong>email_lead</strong>:

```HTML
      <input type="text" name="email" />
```

 <b>2.</b> Ter um input <em>hidden</em> com o nome <strong>token_rdstation</strong> e valor do seu token RD Station (encontrado na [página de integrações](https://www.rdstation.com.br/integracoes))

```HTML
      <input type="hidden" name="token_rdstation" value="SEU_TOKEN_RD_STATION" />
```

 <b>3.</b> Ter um input <em>hidden</em> com o nome <strong>identificador</strong> e valor com nome da sua página ou evento que deseje mapear nas conversões.

```HTML
      <input type="hidden" name="identificador" value="pagina-contato" />
```

 <b>4.</b> Fazer o formulário postar as informações para a API

```HTML
      <form action="https://www.rdstation.com.br/api/1.3/conversions" method="POST">
```

Após isso, sua página já está integrada com o RD Station.
Recomendamos que a teste e veja se os dados aparecem na ferramenta de CRM.

### Direcionamento do visitante após conversão

Muitas vezes, os sites redirecionam o visitante para uma página de obrigado após a submissão de um formulário.
Se assim desejar, é possível inserir um input <em>hidden</em> com o nome <strong>redirect_to</strong> e com o valor da URL da página que se queira enviar o visitante após a conversão.

```HTML
      <input type="hidden" name="redirect_to" value="http://seusite.com.br/obrigado/" />
```

### Reconhecimento da origem do visitante

Com o Google Analytics, é possível descobrir a fonte da origem de seu visitante na hora que ele converter.

```HTML
<input type="hidden" name="c_utmz" id="c_utmz" value="" />
<input type="hidden" name="traffic_source" id="traffic_source" value="" />
<script type="text/javascript">
function read_cookie(a){var b=a+"=";var c=document.cookie.split(";");for(var d=0;d<c.length;d++){var e=c[d];while(e.charAt(0)==" ")e=e.substring(1,e.length);if(e.indexOf(b)==0){return e.substring(b.length,e.length)}}return null}try{document.getElementById("c_utmz").value=read_cookie("__utmz"); document.getElementById("traffic_source").value=read_cookie("__trf.src");}catch(err){}
</script>
```

### Recebendo visitas do Lead Tracking

Além do reconhecimento da origem do Lead, também é possível fazer o monitoramento da navegação do Lead em seu site, utilizando o Lead Tracking.

Para isso, é preciso adicionar dentro da tag `<head>` do seu site o código de monitoramento, que pode ser obtido conforme a [central de ajuda](http://ajuda.rdstation.com.br/hc/pt-br/articles/205133846-Como-instalar-o-C%C3%B3digo-de-Monitoramento-do-RD-Station-em-meu-site-).

Depois de adicionado o código de monitoramento, é preciso adicionar um novo campo no HTML com *name* e *id* de **client_id** e também adicionar um trecho de código javascript, ao código já existente.

```HTML
<input type="hidden" name="client_id" id="client_id" value="" />
<script type="text/javascript">
function read_cookie(a){var b=a+"=";var c=document.cookie.split(";");for(var d=0;d<c.length;d++){var e=c[d];while(e.charAt(0)==" ")e=e.substring(1,e.length);if(e.indexOf(b)==0){return e.substring(b.length,e.length)}}return null}try{document.getElementById("c_utmz").value=read_cookie("__utmz");document.getElementById("traffic_source").value=read_cookie("__trf.src");document.getElementById("client_id").value=JSON.parse(decodeURIComponent(read_cookie("rdtrk"))).id}catch(err){}
</script>
```

### Outros campos e informações do formulário

Dos dados do usuário, a informação de <strong>email</strong> ou <strong>email_lead</strong> é sempre <u><strong>obrigatória</strong></u>. Se não estiver presente, um erro retornará.

Diversos outros campos podem ser utilizados para um chaveamento automática com a ferramenta inteligente de CRM.
Segue uma lista:
<ul><li>nome</li><li>telefone</li><li>empresa</li><li>cargo</li><li>twitter</li></ul>
Eles não são obrigatórios e você não precisa inserí-los na sua página se não desejar. Mas se já usar algum parecido, pode ajustar o nome dele conforme a lista acima para uma melhor integração.

### Avisos de conversão por email

O RD Station pode lhe enviar um email quando uma nova conversão for realizada em seu site.
Para isso, basta colocar o seu email na [página de configurações](https://www.rdstation.com.br/configuracoes)

### Erros

A API pode retornar erro caso:
 - (401) seu token RD Station esteja errado ou inválido;
 - (400) não esteja recebendo um identificador;
 - (400) não esteja recebendo a informação <strong>email</strong> ou <strong>email_lead</strong> do formulário;

É importante que se teste a integração após as modificações para evitar esses erros aparecerem para o seu visitante.

Também é interessante usar alguma validação dos campos para requerer o preenchimento do campo de email, mas para isso será preciso algum controle Javascript ou de alguma outra linguagem.

### Exemplos completos

Na código HTML abaixo, é possível ver uma página com um formulário simples que envia as informações para a API e depois redireciona o visitante para outra página.


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
<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/ABC123-loader.js" ></script>
</head>
<body>
<div id="wrapper">

  <h1>Integrações RD Station</h1>
  <h2>HTML Puro</h2>

  <form action="https://www.rdstation.com.br/api/1.3/conversions" method="POST">
    <input type="hidden" name="token_rdstation" value="f1c940384a971f2982c61a5e5f11e6b9" />
    <!--
      * Atenção!
      * Token de testes - Usar o próprio de sua conta encontrado em: https://www.rdstation.com.br/docs/api
    -->
    <input type="hidden" name="identificador" value="teste-html-puro" />
    <input type="hidden" name="redirect_to" value="http://resultadosdigitais.com.br" />
    <input type="hidden" name="client_id" id="client_id" value="" />

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
<input type="hidden" name="c_utmz" id="c_utmz" value="" />
<input type="hidden" name="traffic_source" id="traffic_source" value="" />
<script type="text/javascript">
function read_cookie(a){var b=a+"=";var c=document.cookie.split(";");for(var d=0;d<c.length;d++){var e=c[d];while(e.charAt(0)==" ")e=e.substring(1,e.length);if(e.indexOf(b)==0){return e.substring(b.length,e.length)}}return null}try{document.getElementById("c_utmz").value=read_cookie("__utmz"); document.getElementById("traffic_source").value=read_cookie("__trf.src");document.getElementById("client_id").value=JSON.parse(decodeURIComponent(read_cookie("rdtrk"))).id}catch(err){}
</script>
      <input type="submit" value="Enviar" />
    </div>
  </form>

</div>

</body>
</html>

```

