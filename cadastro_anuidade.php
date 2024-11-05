<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de anuidade</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>", method="post">
        <div>
            <label>Ano:</label>
            <input type="number" name="ano", id="ano" required>
        </div>
        <div>
            <label>Valor:</label>
            <input type="number" name="valor", id="valor" required>
        </div>
        <div>
            <input type="submit", name="enviar", value="enviar">
        </div>
    </form>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ano = filter_input(INPUT_POST, "ano", FILTER_VALIDATE_INT);
        $valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_INT);


        // echo "Nome: {$ano} <br>";
        if(empty($ano)){
            echo "{$_POST["ano"]} não é um ano válido <br>";
        }elseif(empty($valor)){
            echo "Valor inválido <br>";
        }else{
            include("database.php");
        
            $insert = "INSERT INTO anuidades (ano, valor)
                       VALUES ('{$ano}','{$valor}');";
        
            
            try{
                mysqli_query($db_connection, $insert);
                echo "Anuidade cadastrada <br>";
            }catch(mysqli_sql_exception $e){
                echo "Não foi possível cadastrar o associado <br>";
            }finally{
                mysqli_close($db_connection);
            }

        }
        
    }

?>
    
    






