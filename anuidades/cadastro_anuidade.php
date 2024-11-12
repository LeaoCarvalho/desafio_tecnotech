<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de anuidade</title>
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <div class="centralize">
        <div>
            <div class="centralize">
                <h1>
                    Cadastro de novas anuidades
                </h1>
            </div>
            <div class="border">
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
                <div class="centralize">
                    <a href="/desafio_tecnotech/anuidades/lista_anuidades.php">Voltar para a lista</a>
                </div>
            </div>
        </div>

    </div>




    
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ano = filter_input(INPUT_POST, "ano", FILTER_VALIDATE_INT);
        $valor = filter_input(INPUT_POST, "valor", FILTER_VALIDATE_INT);
        
        if(empty($ano)){
            echo "
            <div class=\"centralize\">
                <h1>
                    \"{$_POST["ano"]}\" não é um ano válido
                </h1>
            </div>
            ";
        }elseif(empty($valor)){
            echo "
            <div class=\"centralize\">
                <h1>
                    \"{$_POST["valor"]}\" não é um valor válido
                </h1>
            </div>
            ";
        }else{
            include("../database.php");
            
            $insert = "INSERT INTO anuidades (ano, valor)
                       VALUES ('{$ano}','{$valor}');";
        
        
        try{
            mysqli_query($db_connection, $insert);
                echo "
                <div class=\"centralize\">
                    <h2>
                        Anuidade cadastrada
                    </h2>
                </div>
                ";
            }catch(mysqli_sql_exception $e){
                if ($e->getCode() === 1062) {
                    preg_match('/Duplicate entry \'(.*?)\' for key \'(.*?)\'/', $e->getMessage(), $field);
                    $field_value = $field[1];
                    $field_name = $field[2];
                    echo "
                        <div class=\" centralize\">
                            <h2>
                                Já existe a anuidade com {$field_name} {$field_value}
                            </h2>
                        </div>
                    ";
                }else{
                    echo "
                        <div class=\" centralize\">
                            <h2>
                                Não foi possível cadastrar a anuidade
                            </h2>
                        </div>
                    ";
                }
            }finally{
                mysqli_close($db_connection);
            }

        }
        
    }
    
    ?>
</body>
</html>