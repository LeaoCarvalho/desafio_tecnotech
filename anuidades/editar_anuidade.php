<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar anuidade</title>
    <link href="../style.css" rel="stylesheet">
</head>
<body>


<?php
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if(empty($id)){
            echo "
                <div class=\"centralize\">
                    <h2> Anuidade não encontrada </h2>
                </div>
                    ";
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
                    <div class=\"centralize\">
                        <div>
                            <div class=\"centralize\">
                                <h1>
                                    Editar anuidade
                                </h1>
                            </div>

                            <div class=\"border\">
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
                            </div>
                        </div>
                    </div>
                ";
            } else {
                echo "
                    <div class=\"centralize\">
                        <h1>
                            Anuidade não encontrada
                        </h1>
                    </div>
                    ";
            }


            
        }
    }elseif($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $ano = filter_input(INPUT_POST, "ano", FILTER_VALIDATE_INT);
        $valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_INT);

        if(empty($id)){
            echo "
                    <div class=\"centralize\">
                        <h1>
                            Id inválido
                        </h1>
                    </div>
                    ";
        }elseif(empty($ano)){
            echo "
                    <div class=\"centralize\">
                        <h1>
                            Ano inválido
                        </h1>
                    </div>
                    ";
            echo $_POST["ano"];
        }elseif(empty($valor)){
            echo "
                    <div class=\"centralize\">
                        <h1>
                            Valor inválido
                        </h1>
                    </div>
                    ";
        }else{
            $update = "UPDATE anuidades
                        SET ano = '{$ano}', valor = '{$valor}'
                        WHERE id = {$id};";
            
            try{
                include("../database.php");
                $db_connection->query($update);
                echo "
                    <div class=\"centralize\">
                        <h1>
                            O valor da anuidade de {$ano} agora é {$valor}
                        </h1>
                    </div>
                    ";
            }catch(mysqli_sql_exception){
                echo "
                    <div class=\"centralize\">
                        <h1>
                            Não foi possível modificar o valor da anuidade
                        </h1>
                    </div>
                    ";
            }finally{
                echo "
                    <div class=\"centralize\">
                        <a href=\"/desafio_tecnotech/anuidades/lista_anuidades.php\">Voltar para a lista</a>
                    </div>
                    ";
                mysqli_close($db_connection);
            }

        }
    }

?>
        
        
</body>
</html>