<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de anuidades</title>
</head>
<body>

    <?php

        include("../database.php");

        $select = "SELECT id, ano, valor FROM anuidades";
        $result = $db_connection->query($select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>
                        Ano: {$row["ano"]}
                        <br>
                        Valor: {$row["valor"]}
                        <br>
                        <a href=\"/desafio_tecnotech/anuidades/editar_anuidade.php?id={$row["id"]}\">editar</a>
                      </div>";
            }
        } else {
            echo "Nenhuma anuidade cadastrada ainda <br>";
        }

        echo "<div>
                <a href=\"/desafio_tecnotech/anuidades/cadastro_anuidade.php\">Cadastrar nova anuidade</a>
              </div>";
        

        mysqli_close($db_connection);

    ?>

    
    
</body>
</html>