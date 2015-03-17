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
      <form action="https://www.rdstation.com.br/api/1.2/conversions" method="POST">
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
<script type="text/javascript">
function read_cookie(a){var b=a+"=";var c=document.cookie.split(";");for(var d=0;d<c.length;d++){var e=c[d];while(e.charAt(0)==" ")e=e.substring(1,e.length);if(e.indexOf(b)==0){return e.substring(b.length,e.length)}}return null}try{document.getElementById("c_utmz").value=read_cookie("__utmz")}catch(err){}
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