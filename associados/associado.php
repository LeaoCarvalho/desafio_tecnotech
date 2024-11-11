<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associado</title>
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

    if($_SERVER["REQUEST_METHOD"] == "GET"){

        include("../database.php");

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        $select = "SELECT nome, email, cfp, data_filiacao FROM associados WHERE id = '{$id}'";
        $result = $db_connection->query($select);
        

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            list($valor_devido, $pagamentos) = getPagamentos($db_connection, $id, $row["data_filiacao"]);

            echo "<div>
                    Nome: {$row["nome"]}
                    <br>
                    E-mail: {$row["email"]}
                    <br>
                    CPF: {$row["cfp"]}
                    <br>
                    Data de filiação: {$row["data_filiacao"]}
                    <br>";
            if($valor_devido > 0){
                echo "O associado ainda precissa pagar {$valor_devido}
                        <br>";
            }else{
                echo "O associado pagou todas suas anuidades
                <br>";
            }
            if(count($pagamentos) > 0){
                echo "Anuidades:
                <br>";
            }

            foreach($pagamentos as $anuidade => $pagamento){
                echo "Ano:" . $pagamento["ano"] . "<br>";
                echo "Valor:" . $pagamento["valor"] . "<br>";
                if($pagamento["situacao"]){
                    echo "Pago <br>";
                }else{
                    echo "<form action=\" " . htmlspecialchars($_SERVER["PHP_SELF"]) . " \", method=\"post\">
                            <input type=\"hidden\" name=\"associado\" value=\"{$id}\">
                            <input type=\"hidden\" name=\"anuidade\" value=\"{$anuidade}\">
                            <input type=\"submit\", name=\"enviar\", value=\"cadastrar pagamento\">
                            </form>
                            <br>
                    ";
                }
            }
            echo "</div>";
            echo "<div>
              <a href=\"/desafio_tecnotech/associados/lista_associados.php\">Voltar a lista</a>
            </div>";
        } else {
            echo "Não foi possível encontrar o associado <br> ";
        }
        
        mysqli_close($db_connection);

    }elseif($_SERVER["REQUEST_METHOD"] == "POST"){
        
        include("../database.php");
        
        $associado = filter_input(INPUT_POST, "associado", FILTER_VALIDATE_INT);
        $anuidade = filter_input(INPUT_POST, "anuidade", FILTER_VALIDATE_INT);
        $situacao = "1";

        $select_associado = "SELECT nome, email, cfp, data_filiacao FROM associados WHERE id = '{$associado}'";
        $result_associado = $db_connection->query($select_associado);
        
        $select_anuidade = "SELECT ano, valor FROM anuidades WHERE id = '{$anuidade}'";
        $result_anuidade = $db_connection->query($select_anuidade);

        if ($result_associado->num_rows != 1){
            echo "Não foi possível encontrar o associado {$associado} <br>";
            mysqli_close($db_connection);
        }elseif ($result_anuidade->num_rows != 1){
            echo "Não foi possível encontrar a anuidade {$anuidade} <br>";
            mysqli_close($db_connection);
        }else{

            $insert = "INSERT INTO pagamentos (associado, anuidade, situacao)
                           VALUES ('{$associado}','{$anuidade}', '{$situacao}');";
    
            try{
                mysqli_query($db_connection, $insert);
                echo "Pagamento cadastrado <br>";
            }catch(mysqli_sql_exception $e){
                echo "Não foi possível cadastrar o pagamento <br>";
            }finally{
                mysqli_close($db_connection);
                echo "<div>
                        <a href=\"/desafio_tecnotech/associados/lista_associados.php\">Voltar a lista</a>
                    </div>";
            }
        }




    }


?>

    
    
</body>
</html>