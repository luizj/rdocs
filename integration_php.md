# Integrações RD Station

## PHP

Muitos sites em PHP possuem uma página que é um script para enviar o email de contato ou tratar o preenchimento de algum formulário.
Para fazer com que essa página envie os dados para o RD Station, você deve inserir essa classe no seu código, e passar para ela os parâmetros necessários.

## Classe para integração

Recomendamos que você crie um arquivo separado para essa classe, chamado `RD_Station.php`. Você não vai precisar alterar este arquivo, apenas importá-lo mais tarde. Dentro do arquivo `RD_Station.php`, cole o código abaixo e salve.

```PHP
<?php

class RD_Station{
  public $form_data;
  public $token;
  public $identifier;
  public $ignore_fields = array();
  public $redirect_success = null;
  public $redirect_error = null;

  private $api_url = "https://www.rdstation.com.br/api/1.3/conversions";

  public function __construct($form_data){
    $this->form_data = $form_data;
  }

  public function ignore_fields(array $fields){
    foreach ($this->form_data as $field => $value) {
      if(in_array($field, $fields)){
        unset($this->form_data[$field]);
      }
    }
  }

  public function canSaveLead($data){
    $required_fields = array('email', 'token_rdstation');
    foreach ($required_fields as $field) {
      if(empty($data[$field]) || is_null($data[$field])){
        return false;
      }
    }
    return true;
  }

  function createLead() {
    $data_array = $this->form_data;
    $data_array['token_rdstation'] = $this->token;
    $data_array['identificador'] = $this->identifier;

    if(empty($data_array["c_utmz"])){
      $data_array["c_utmz"] = $_COOKIE["__utmz"];
    }

    if ( isset($_COOKIE["__trf_src"]) && empty($data_array["traffic_source"]) ) {
      $data_array["traffic_source"] = $_COOKIE["__trf_src"];
    }

    if(empty($data_array["client_id"]) && !empty($_COOKIE["rdtrk"])) {
      $data_array["client_id"] = json_decode($_COOKIE["rdtrk"])->{'id'};
    }

    $data_query = http_build_query($data_array);

    if($this->canSaveLead($data_array)){
      if (in_array ('curl', get_loaded_extensions())) {
        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_query);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);
      }
      else {
        $params = array('http'=>array('method'=>'POST', 'header'=>'Content-type: application/json', 'content'=>$data_query), 'ssl'=>array('verify_peer'=>false, 'verify_peer_name'=>false));
        $ctx = stream_context_create($params);
        $fp = @fopen($api_url, 'rb', false, $ctx);
      }
      $this->redirect_success ? header("Location: ".$this->redirect_success) : header("Location: /");
    }
    else{
      $this->redirect_error ? header("Location: ".$this->redirect_error) : header("Location: /");
    }
  }
}

?>
```

## Como usar

Dentro do arquivo que recebe os dados do seu formulário, importe o arquivo `RD_Station.php` que você criou. Em seguida importe a classe `RD_Station`, passando os dados recebidos no seu formulário como parâmetro para ela. Supondo que você esteja recebendo os dados do formulário na variável `$_POST`, seu código ficaria assim:

```PHP
<?php

// Importando o arquivo com a classe RD_Station
require_once("RD_Station.php");

// Instanciando a classe RD_Station
$rdstation = new RD_Station($_POST);

?>
```

Pode ser que você esteja recebendo os dados de outra forma ao invés da variável **$_POST**. Sem problemas, desde que seja um **array**.

Agora você precisa passar alguns parâmetros obrigatórios para a integração funcionar corretamente.

### Token RD Station

Um desses parâmetros **obrigatórios** é o seu **token público** do RD Station:
```PHP
<?php

// Importando o arquivo com a classe RD_Station
require_once("RD_Station.php");

// Instanciando a classe RD_Station
$rdstation = new RD_Station($_POST);

// Passando o meu token RD Station
$rdstation->token = 'INSIRA SEU TOKEN AQUI';

?>
```

### Identificador do formulário

Você também precisa passar um identificador para este formulário, dessa forma você sempre saberá o formulário de origem do lead:
```PHP
<?php

// Importando o arquivo com a classe RD_Station
require_once("RD_Station.php");

// Instanciando a classe RD_Station
$rdstation = new RD_Station($_POST);

// Token público do RD Station
$rdstation->token = 'INSIRA SEU TOKEN AQUI';

// Identificador do formulário
$rdstation->identifier = 'INSIRA SEU IDENTIFICADOR AQUI';

?>
```

### Ignorar campos do formulário

Não é recomendável enviar senhas ou captcha para o seu RD Station, por exemplo. Para evitar que esses campos sejam enviados, basta você informar à classe que eles devem ser ignorados. Insira o `name` desses campos em um array, como no exemplo abaixo:

```PHP
<?php

// Importando o arquivo com a classe RD_Station
require_once("RD_Station.php");

// Instanciando a classe RD_Station
$rdstation = new RD_Station($_POST);

// Token público do RD Station
$rdstation->token = 'INSIRA SEU TOKEN AQUI';

// Identificador do formulário
$rdstation->identifier = 'INSIRA SEU IDENTIFICADOR AQUI';

// Ignorando campos desnecessários
$rdstation->ignore_fields(array('campo1', 'campo2', 'campo3'));

?>
```

### Redirecionamentos

Seu formulário em PHP deve possuir algum lugar para onde ele redireciona o usuário caso tudo ocorra bem ou caso ocorra algum erro. Passe estes redirecionamentos para a instância do RD Station

```PHP
<?php

// Importando o arquivo com a classe RD_Station
require_once("RD_Station.php");

// Instanciando a classe RD_Station
$rdstation = new RD_Station($_POST);

// Token público do RD Station
$rdstation->token = 'INSIRA SEU TOKEN AQUI';

// Identificador do formulário
$rdstation->identifier = 'INSIRA SEU IDENTIFICADOR AQUI';

// Ignorando campos desnecessários
$rdstation->ignore_fields(array('campo1', 'campo2', 'campo3'));

// Redirecionamento caso tudo esteja ok
$rdstation->redirect_success = 'http://linkdesejadoaqui.com.br';

// Redirecionamento caso ocorram erros
$rdstation->redirect_error = 'http://linkdesejadoaqui.com.br';

?>
```
### Criando o lead

A última coisa que você precisa fazer, é chamar a função que cria o lead. Se você passou todos os parâmetros corretamente, os leads irão aparecer no seu RD Station quando o seu formulário for enviado:

```PHP
<?php

// Importando o arquivo com a classe RD_Station
require_once("RD_Station.php");

// Instanciando a classe RD_Station
$rdstation = new RD_Station($_POST);

// Token público do RD Station
$rdstation->token = 'INSIRA SEU TOKEN AQUI';

// Identificador do formulário
$rdstation->identifier = 'INSIRA SEU IDENTIFICADOR AQUI';

// Ignorando campos desnecessários
$rdstation->ignore_fields(array('campo1', 'campo2', 'campo3'));

// Redirecionamento caso tudo esteja ok
$rdstation->redirect_success = 'http://linkdesejadoaqui.com.br';

// Redirecionamento caso ocorram erros
$rdstation->redirect_error = 'http://linkdesejadoaqui.com.br';

// Criando os leads
$rdstation->createLead();

?>
```

##Campos e informações do formulário

Dos dados do usuário, a informação de **email** ou **email_lead** é sempre **obrigatória**. Se não estiver presente, um erro retornará.

Diversos outros campos podem ser utilizados para um chaveamento automático com o RD Station. Segue uma lista:

<ul>
<li>nome</li>
<li>telefone</li>
<li>empresa</li>
<li>cargo</li>
<li>twitter</li>
</ul>


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
