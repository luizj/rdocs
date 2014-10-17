# Integrações RD Station
## Como instalar script para integração com formulário utilizando o plugin Contact Form 7 do Wordpress

Essa é a integração mais simples de ser feita. Basta apenas adicionar um script padrão diretamente na página do seu formulário, assim como o Google Analytics.

Os seus formulários irão para o RD Station com um identificador. Identificador é o nome do evento, por exemplo, cadastro, newsletter, formulário de orçamento, contato, entre outros, que irá aparecer na conversão do Lead no seu RD Station.


### Requisito (presença campo email)

Existe uma característica necessária e muito importante para a integração funcionar (talvez você precise editá-la ou adicioná-a na sua página)


Todo formulário a ser integrado deve ter um input com o nome <strong>email</strong> ou <strong>your-email</strong>:
```HTML
<input type="text" name="your-email" />
```

### Integrando os seus formulários

Uma vez atendida a especificação acima, para realizar a integração você deve inserir o script abaixo no editor do formulário de contato do Contact Form 7:

1 - Inserir seu token RD Station onde diz `'SEU_TOKEN_RDSTATION_AQUI'`. Ele pode ser obtido nas suas [Configurações do RD Station](https://www.rdstation.com.br/integracoes);

2 - Definir um identificador para o evento de conversão e inserí-lo no script abaixo onde diz `'IDENTIFICADOR DESEJADO'`;

3 - Adicionar o código no formulário.

```HTML
<script type ='text/javascript' src="https://d335luupugsy2.cloudfront.net/js/integration/0.1.0/rd-js-integration.min.js"></script>
<script type ='text/javascript'>
    RDStationFormIntegration('SEU_TOKEN_RDSTATION_AQUI', 'IDENTIFICADOR DESEJADO');
</script>
```

Exemplo:
!["RD Station JS Integration - Contact Form 7"](http://s10.postimg.org/k1zhvardl/Screen_Shot_2014_10_17_at_2_34_41_PM.png "RD Station JS Integration - Contact Form 7")

Após esses passos, recomendamos sempre testar a integração para verificar se todos dados aparecem no RD Station.


### Avisos de conversão por email

O RD Station pode lhe enviar um email quando uma nova conversão for realizada em seu site. Para isso, basta colocar o seu email na configuração da [página da API](https://www.rdstation.com.br/integracoes)


### Possíveis Erros

A API pode retornar erro caso:
 - (401) seu token RD Station esteja errado ou inválido;
 - (400) não esteja recebendo um identificador;
 - (400) não esteja recebendo o email (<strong>email</strong> ou <strong>email_lead</strong>) vindo do formulário;

É importante testar a integração após as modificações para evitar que erros comos esses acima apareçam para o seu visitante.

Também é interessante usar alguma validação dos campos pedidos para evitar o não preenchimento do campo de email.