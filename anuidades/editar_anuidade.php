<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar anuidade</title>
</head>
<body>


<?php
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if(empty($id)){
            echo "missing id <br>";
        }else{

            include("../database.php");

            $select = "SELECT ano, valor FROM anuidades WHERE id = '{$id}'";
            $result = $db_connection->query($select);

            mysqli_close($db_connection);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ano = $row["ano"];
                $valor = $row["valor"];
                echo "
                <form action=\" " . htmlspecialchars($_SERVER["PHP_SELF"]) . " \", method=\"post\">
                <input type=\"hidden\" name=\"id\" value=\"{$id}\">
                <input type=\"hidden\" name=\"ano\" value=\"{$ano}\">
                    <div>
                        Ano: {$ano}
                    </div>
                    <div>
                        <label>Valor:</label>
                        <input type=\"number\" name=\"valor\", id=\"valor\" value=\"{$valor}\" required>
                    </div>
                    <div>
                        <input type=\"submit\", name=\"enviar\", value=\"enviar\">
                    </div>
                </form>
                ";
            } else {
                echo "Id inválido <br>";
            }


            
        }
    }elseif($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $ano = filter_input(INPUT_POST, "ano", FILTER_VALIDATE_INT);
        $valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_INT);

        if(empty($id)){
            echo "Id inválido <br>";
        }elseif(empty($ano)){
            echo "Ano inválido <br>";
            echo $_POST["ano"];
        }elseif(empty($valor)){
            echo "Valor inválido <br>";
        }else{
            $update = "UPDATE anuidades
                        SET ano = '{$ano}', valor = '{$valor}'
                        WHERE id = {$id};";
            
            try{
                include("../database.php");
                $db_connection->query($update);
                echo "O valor da anuidade de {$ano} agora é {$valor} <br>";
            }catch(mysqli_sql_exception){
                echo "Não foi possível modificar o valor da anuidade <br>";
            }finally{
                echo "<a href=\"/desafio_tecnotech/anuidades/lista_anuidades.php\">Voltar para a lista</a> <br>";
                mysqli_close($db_connection);
            }

        }
    }

?>
        
        
</body>
</html>