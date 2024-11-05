<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de associados</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>", method="post">
        <div>
            <label>Nome:</label>
            <input type="text", name="nome", id="nome" required>
        </div>
        <div>
            <label>E-mail:</label>
            <input type="email" , name="email", id="email" required>
        </div>
        <div>
            <label>CPF:</label>
            <input type="text" , name="cpf", id="cpf" required>
        </div>
        <div>
            <label>Data de filiação:</label>
            <input type="date" , name="data_filiacao", id="data_filiacao" required>
        </div>
        <div>
            <input type="submit", name="enviar", value="enviar">
        </div>
    </form>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        // $nome = $_POST["nome"];
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_SPECIAL_CHARS);
        $data = $_POST["data_filiacao"];

        // echo "Nome: {$nome} <br>";
        // echo "Email: {$email} <br>";
        // echo "CPF: {$cpf} <br>";
        // echo "Data: {$data} <br>";

        if(empty($nome)){
            echo "Nome inválido <br>";
        }elseif(empty($email)){
            echo "Email inválido <br>";
        }elseif(empty($cpf)){
            echo "CPF inválido <br>";
        }else{
            include("database.php");
        
            $insert = "INSERT INTO associados (nome, email, cfp, data_filiacao)
                       VALUES ('{$nome}', '{$email}', '{$cpf}', '{$data}');";
        
            
            try{
                mysqli_query($db_connection, $insert);
                echo "Associado cadastrado <br>";
            }catch(mysqli_sql_exception $e){
                if ($e->getCode() === 1062) {
                    preg_match('/Duplicate entry \'(.*?)\' for key \'(.*?)\'/', $e->getMessage(), $field);
                    $field_value = $field[1];
                    $field_name = $field[2];
                    echo "Já existe o associado com {$field_name} {$field_value} <br>";
                    // switch (count($field)){
                    //     case 2:
                    //         echo "Já existe o associado com nome {$nome} <br>";
                    //         break;
                    //     case 3:
                    //         echo "Já existe o associado com email {$email} <br>";
                    //         break;
                    //     case 4:
                    //         echo "Já existe o associado com CPF {$cpf} <br>";
                    //         break;   
                    // }
                    echo $e->getMessage();
                }else{
                    echo "Não foi possível cadastrar o associado <br>";
                }
            }finally{
                mysqli_close($db_connection);
            }

            // mysqli_query($db_connection, $insert);
            // mysqli_close($db_connection);


     


            
        
            
        
        }
        
    }

?>
    
    






