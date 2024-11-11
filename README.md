# Desafio Tecnotech

## Como usar a aplicação

Para usar a aplicação é preciso que se tenha instalado um interpretador php e servidor, como o apache, além disso que tenha acesso a um banco de dados mysql. Minha recomendação é que use o xampp, pois cuidará de todas esses requisitos.

### Caso use o xampp, faça o seguinte:
* Copie essa pasta para o arquivo htdocs do xampp;
* Crie o banco de dados e as tabelas usando o "meu_database.sql";
* Inicie o servidor e banco de dados com o xampp.

## Funcionalidades

* Da página root (ou index), você pode ir para uma listagem de associados ou uma listagem de anuidades.
    * Na lista de associados você poderá ver o nome, e-mail, CPF, data de filiação e situação de pagamento de cada associado, bem como ir para uma página que detalha melhor os pagamentos do associado. Além disso pode ir para uma página de cadastro de novos associados.
        * Na página que detalha melhor cada associado tem todas as informações que estavam presentes na listagem e lista cada pagamento feito ou pendente
        * Na página de cadastro de associado é possível preencher nome, e-mail, CPF e data de filiação do associado, ele estará devendo as anuidades a partir do ano da data de filiação.
    * Na lista de anuidades você poderá ver o ano e valor de cada anuidade, bem como ir para uma página que para mudar o valor. Além disso pode ir para uma página de cadastro de novas anuidades.
        * Na página de edição de anuidade é possivel mudar o valor de uma anuidade.
        * Na página de cadastro de anuidades é possível cadastrar uma nova anuidade para determinado ano e escolher o valor.
