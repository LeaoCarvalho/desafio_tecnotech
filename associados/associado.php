<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associado</title>
    <link href="../style.css" rel="stylesheet">
</head>
<body>

<?php

    function getPagamentos($db, $id, $data){

        // $select_associado = "SELECT data_filiacao FROM associados WHERE id = '{$id}'";
        // $result_associado = $db->query($select_associado);
        // if($result_associado->num_rows != 0){
        //     return null;
        // }
        // $data = $result_associado->fetch_assoc()["data_filiacao"];

        $ano = date("Y", strtotime($data));
        $select_anuidades = "SELECT id, ano, valor FROM anuidades WHERE ano <= '{$ano}'";
        $result_anuidade = $db->query($select_anuidades);
        $anuidades = [];
        while ($row = $result_anuidade->fetch_assoc()) {
            $anuidades[$row["id"]] = [
                "ano" => $row["ano"],
                "valor" => $row["valor"],
                "situacao" => false
            ];
        }

        $select_pagamentos = "SELECT anuidade, situacao FROM pagamentos WHERE associado = '{$id}'";
        $result_pagamento = $db->query($select_pagamentos);
        while ($row = $result_pagamento->fetch_assoc()) {
            $anuidades[$row["anuidade"]]["situacao"] = $row["situacao"];
        }

        $aPagar = 0;
        foreach($anuidades as $anuidade){
            if(!$anuidade["situacao"]){
                $aPagar += $anuidade["valor"];
            }
        }
        
        return [$aPagar, $anuidades];
    }

    include("../database.php");

    $id = "";
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    }elseif($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    }

    if(!empty($id)){

        $select = "SELECT nome, email, cfp, data_filiacao FROM associados WHERE id = '{$id}'";
        $result = $db_connection->query($select);
        
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
    
            list($valor_devido, $pagamentos) = getPagamentos($db_connection, $id, $row["data_filiacao"]);
    
            echo "
                    <div class=\" centralize\">
                        <h1>Associado:</h1>
                    </div>
                    <div class=\" centralize\">
                        <div class=\" border\">
                            <div>
                                Nome: {$row["nome"]}
                            </div>
                            <div>
                                E-mail: {$row["email"]}
                            </div>
                            <div>
                                CPF: {$row["cfp"]}
                            </div>
                            <div>
                                Data de filiação: {$row["data_filiacao"]}
                            </div>
                ";
            if($valor_devido > 0){
                echo "
                        <div>
                            O associado ainda precissa pagar {$valor_devido}
                        </div>
                    ";
            }else{
                echo "
                        <div>
                            O associado pagou todas suas anuidades
                        </div>
                    ";
            }
            if(count($pagamentos) > 0){
                echo "
                        <div>
                            Anuidades:
                        </div>
                    ";
            }
    
            foreach($pagamentos as $anuidade => $pagamento){
                echo "<div class=\"center\"><div class=\"border\">";
                echo "
                        <div>
                            Ano:" . $pagamento["ano"] . "
                        </div>
                    ";
                echo "
                    <div>
                        Valor:" . $pagamento["valor"] . "
                    </div>
                ";
                if($pagamento["situacao"]){
                    echo "
                        <div>
                            Pago
                        </div>
                    ";
                }else{
                    echo "
                        <div>
                            <form action=\" " . htmlspecialchars($_SERVER["PHP_SELF"]) . " \", method=\"post\">
                            <input type=\"hidden\" name=\"id\" value=\"{$id}\">
                            <input type=\"hidden\" name=\"anuidade\" value=\"{$anuidade}\">
                            <input type=\"submit\", name=\"enviar\", value=\"cadastrar pagamento\">
                            </form>
                        </div>
                    ";
                }
                echo "</div></div>";
            }
            echo "
                    <div class=\"centralize\">
                        <a href=\"/desafio_tecnotech/associados/lista_associados.php\">Voltar a lista</a>
                    </div>";
            echo "
                    </div>
                    </div>";
        } else {
            echo "
                <div class=\" centralize\">
                    <h2>Não foi possível encontrar o associado</h2>
                </div>
                ";
        }
    }else{
        echo "
                <div class=\" centralize\">
                    <h1>Não foi possível encontrar o associado</h1>
                </div>
                ";
    }


    
    mysqli_close($db_connection);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        include("../database.php");
        
        $associado = filter_input(INPUT_POST, "associado", FILTER_VALIDATE_INT);
        $anuidade = filter_input(INPUT_POST, "anuidade", FILTER_VALIDATE_INT);
        $situacao = "1";

        $select_associado = "SELECT nome, email, cfp, data_filiacao FROM associados WHERE id = '{$id}'";
        $result_associado = $db_connection->query($select_associado);
        
        $select_anuidade = "SELECT ano, valor FROM anuidades WHERE id = '{$anuidade}'";
        $result_anuidade = $db_connection->query($select_anuidade);

        if ($result_associado->num_rows != 1){
            echo "
                <div class=\" centralize\">
                    <h2>Não foi possível encontrar o associado {$associado}</h2>
                </div>
                ";
            mysqli_close($db_connection);
        }elseif ($result_anuidade->num_rows != 1){
            echo "
                <div class=\" centralize\">
                    <h2>Não foi possível encontrar a anuidade {$anuidade}</h2>
                </div>
                ";
            mysqli_close($db_connection);
        }else{

            $insert = "INSERT INTO pagamentos (associado, anuidade, situacao)
                           VALUES ('{$associado}','{$anuidade}', '{$situacao}');";
    
            try{
                mysqli_query($db_connection, $insert);
                echo "
                <div class=\" centralize\">
                    <h2>Pagamento cadastrado</h2>
                </div>
                ";
            }catch(mysqli_sql_exception $e){
                echo "
                <div class=\" centralize\">
                    <h2>Não foi possível cadastrar o pagamento</h2>
                </div>
                ";
            }finally{
                mysqli_close($db_connection);
            }
        }




    }


?>

    
    
</body>
</html>