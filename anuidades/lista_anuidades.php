<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de anuidades</title>
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <?php

        include("../database.php");

        $select = "SELECT id, ano, valor FROM anuidades";
        $result = $db_connection->query($select);

        echo "
                <div class=\"centralize\">
                    <div>
                        <div class=\"centralize\">
                            <h1>Anuidades:</h1>
                        </div>
        ";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                        <div class=\"centralize\">
                            <div class=\"border\">
                                <div class=\"centralize\">
                                    Ano: {$row["ano"]}
                                </div>
                                <div class=\"centralize\">
                                    Valor: {$row["valor"]}
                                </div>
                                <div class=\"centralize\">
                                    <a href=\"/desafio_tecnotech/anuidades/editar_anuidade.php?id={$row["id"]}\">editar</a>
                                </div>
                            </div>
                        </div>
                      ";
            }
        } else {
            echo "Nenhuma anuidade cadastrada ainda <br>";
        }

        echo "<div>
                <a href=\"/desafio_tecnotech/anuidades/cadastro_anuidade.php\">Cadastrar nova anuidade</a>
              </div>";

        echo "
                </div>
            </div>
        ";
        

        mysqli_close($db_connection);

    ?>

    
    
</body>
</html>