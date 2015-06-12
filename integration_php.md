#Integrações RD Station

##PHP

Muitos sites em PHP possuem uma página que é um script para enviar o email de contato ou tratar o preenchimento de algum formulário.

Para fazer com que essa página envie os dados para o CRM do RD Station, é só inserir nosso script de integração em seu código e fazer a chamada quando for controlar a submissão dos dados.

##Script para integração


```PHP
<?php
/**
 * RD Station - Integrações
 * addLeadConversionToRdstationCrm()
 * Envio de dados para a API de leads do RD Station
 *
 * Parâmetros:
 *     ($rdstation_token) - token da sua conta RD Station ( encontrado em https://www.rdstation.com.br/docs/api )
 *     ($identifier) - identificador da página ou evento ( por exemplo, 'pagina-contato' )
 *     ($data_array) - um Array com campos do formulário ( por exemplo, array('email' => 'teste@rdstation.com.br', 'nome' =>'Fulano') )
 */
function addLeadConversionToRdstationCrm( $rdstation_token, $identifier, $data_array ) {
  $api_url = "http://www.rdstation.com.br/api/1.2/conversions";

  try {
    if (empty($data_array["token_rdstation"]) && !empty($rdstation_token)) { $data_array["token_rdstation"] = $rdstation_token; }
    if (empty($data_array["identificador"]) && !empty($identifier)) { $data_array["identificador"] = $identifier; }
    if (empty($data_array["c_utmz"])) { $data_array["c_utmz"] = $_COOKIE["__utmz"]; }
    unset($data_array["password"], $data_array["password_confirmation"], $data_array["senha"],
          $data_array["confirme_senha"], $data_array["captcha"], $data_array["_wpcf7"],
          $data_array["_wpcf7_version"], $data_array["_wpcf7_unit_tag"], $data_array["_wpnonce"],
          $data_array["_wpcf7_is_ajax_call"]);

    if ( !empty($data_array["token_rdstation"]) && !( empty($data_array["email"]) && empty($data_array["email_lead"]) ) ) {
      $data_query = http_build_query($data_array);
      if (in_array ('curl', get_loaded_extensions())) {
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_query);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
      } else {
        $params = array('http' => array('method' => 'POST', 'content' => $data_query, 'ignore_errors' => true));
        $ctx = stream_context_create($params);
        $fp = @fopen($api_url, 'rb', false, $ctx);
      }
    }
  } catch (Exception $e) { }
}
?>
```

##Como usar

Para usar, basta chamar a função do script passando o token RD Station da sua conta, o identificador da fonte/evento (ex: pagina-contato), e um array com as informações do formulário.

```PHP
<?php

/* ou use os parâmetros do POST */
$form_data_array = $_POST;
/* ou crie o seu próprio array de informações */
$form_data_array = array('email'=>'teste@rdstation.com.br', 'nome'=>'Fulano', 'empresa'=>'RD Station', 'cargo'=>'Robo');

addLeadConversionToRdstationCrm("SEU_TOKEN_RDSTATION_AQUI", "teste-php", $form_data_array);
?>
```


##Campos e informações do formulário

Dos dados do usuário, a informação de **email** ou **email_lead** é sempre **obrigatória**. Se não estiver presente, um erro retornará.

Diversos outros campos podem ser utilizados para um chaveamento automática com a ferramenta inteligente de CRM. Segue uma lista:

<ul>
<li>nome</li>
<li>telefone</li>
<li>empresa</li>
<li>cargo</li>
<li>twitter</li>
</ul>

Se quiser retirar algum campo para não enviar ao RD Station, pode modificar o array de dados:

```PHP
<?php
$form_data_array = $_POST; /* suponha que exista um campo "senha" no seu formulário */
unset($form_data_array["senha"]);
?>
```

##Avisos de conversão por email

O RD Station pode lhe enviar um email quando uma nova conversão for realizada em seu site. Para isso, basta colocar o seu email na configuração da página da API (https://www.rdstation.com.br/docs/api)

Erros

A API pode retornar erro caso:

<ul>
    <li>(401) seu token RD Station esteja errado ou inválido;</li>
    <li>(400) não esteja recebendo um identificador;</li>
    <li>(400) não esteja recebendo a informação **email** ou **email_lead** do formulário;</li>
</ul>


#Exemplos completos

Na código HTML+PHP abaixo, é possível ver uma página com formulário que submete para ela mesmo e que utiliza o script de integração para capturar os dados do formulário e enviar para o RD Station.
rdstation-exemplo-integracao-php.php

```PHP
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PHP | Integrações RD Station</title>

<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
  /**
   * RD Station - Integrações
   * addLeadConversionToRdstationCrm()
   * Envio de dados para a API de leads do RD Station
   *
   * Parâmetros:
   *     ($rdstation_token) - token da sua conta RD Station ( encontrado em https://www.rdstation.com.br/docs/api )
   *     ($identifier) - identificador da página ou evento ( por exemplo, 'pagina-contato' )
   *     ($data_array) - um Array com campos do formulário ( por exemplo, array('email' => 'teste@rdstation.com.br', 'nome' =>'Fulano') )
   */
  function addLeadConversionToRdstationCrm( $rdstation_token, $identifier, $data_array ) {
    $api_url = "http://www.rdstation.com.br/api/1.2/conversions";

    try {
      if (empty($data_array["token_rdstation"]) && !empty($rdstation_token)) { $data_array["token_rdstation"] = $rdstation_token; }
      if (empty($data_array["identificador"]) && !empty($identifier)) { $data_array["identificador"] = $identifier; }
      if (empty($data_array["c_utmz"])) { $data_array["c_utmz"] = $_COOKIE["__utmz"]; }
      unset($data_array["password"], $data_array["password_confirmation"], $data_array["senha"],
            $data_array["confirme_senha"], $data_array["captcha"], $data_array["_wpcf7"],
            $data_array["_wpcf7_version"], $data_array["_wpcf7_unit_tag"], $data_array["_wpnonce"],
            $data_array["_wpcf7_is_ajax_call"]);

      if ( !empty($data_array["token_rdstation"]) && !( empty($data_array["email"]) && empty($data_array["email_lead"]) ) ) {
        $data_query = http_build_query($data_array);
        if (in_array ('curl', get_loaded_extensions())) {
          $ch = curl_init($api_url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_query);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_exec($ch);
          curl_close($ch);
        } else {
          $params = array('http' => array('method' => 'POST', 'content' => $data_query, 'ignore_errors' => true));
          $ctx = stream_context_create($params);
          $fp = @fopen($api_url, 'rb', false, $ctx);
        }
      }
    } catch (Exception $e) { }
  }

  $form_data = $_POST;
  addLeadConversionToRdstationCrm("f1c940384a971f2982c61a5e5f11e6b9", "teste-php", $form_data);
  /**
   * Atenção!
   * Token de testes - Usar o próprio de sua conta encontrado em: https://www.rdstation.com.br/docs/api
  */
}
?>

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
  <h2>Exemplo para PHP</h2>

<?php if ($_SERVER['REQUEST_METHOD']=='GET') { ?>
  <form id="conversion-form" action="rdstation-exemplo-integracao-php.php" method="POST">
    <div class="field">
      <label>E-mail:*</label>
      <input type="text" name="email" class="required email" />
    </div>
    <div class="field">
      <label>Nome:*</label>
      <input type="text" name="nome" class="required" />
    </div>
    <div class="field">
      <label>Empresa:</label>
      <input type="text" name="empresa" class="" />
    </div>
    <div class="actions">
      <input type="submit" value="Enviar" />
    </div>
  </form>
<?php } else { ?>
  <p>Obrigado por entrar em contato!</p>
<?php } ?>

  <div>
    <p>
      http://www.rdstation.com.br<br/>
      suporte @ rdstation . com . br
    </p>
  </div>
</div>

</body>
</html>
```
