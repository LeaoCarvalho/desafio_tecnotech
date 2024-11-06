<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de anuidades</title>
</head>
<body>

    <?php

        function pagamentoEmDia($db, $id, $data){
            $ano = date("Y", strtotime($data));
            $select_anuidades = "SELECT id FROM anuidades WHERE ano <= '{$ano}'";
            $result_anuidade = $db->query($select_anuidades);
            $anuidades = [];
            while ($row = $result_anuidade->fetch_assoc()) {
                $anuidades[$row["id"]] = false;
            }

            $select_pagamentos = "SELECT anuidade, situacao FROM pagamentos WHERE associado <= '{$id}'";
            $result_pagamento = $db->query($select_pagamentos);
            while ($row = $result_pagamento->fetch_assoc()) {
                $anuidades[$row["anuidade"]] = $row["situacao"];
            }
            
            foreach($anuidades as $key => $value){
                if(!$value){
                    return false;
                }
            }
            return true;
        }

        include("database.php");
        	



        $select = "SELECT id, nome, email, cfp, data_filiacao FROM associados";
        $result = $db_connection->query($select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $situacao = "";
                if(pagamentoEmDia($db_connection, $row["id"], $row["data_filiacao"])){
                    $situacao = "em dia";
                }else{
                    $situacao = "pagamento a fazer";
                }
                echo "<div>
                        Nome: {$row["nome"]}
                        <br>
                        E-mail: {$row["email"]}
                        <br>
                        CPF: {$row["cfp"]}
                        <br>
                        Data de filiação: {$row["data_filiacao"]}
                        <br>
                        Situação: {$situacao}
                        <br>
                        <a href=\"/desafio_tecnotech/associado.php?id={$row["id"]}\">Ver detalhes</a>
                      </div>";
            }
        } else {
            echo "Nenhum associado cadastrado ainda <br>";
        }

        echo "<div>
                <a href=\"/desafio_tecnotech/cadastro_associados.php\">Cadastrar novo associado</a>
              </div>";
        

        mysqli_close($db_connection);

    ?>

    
    
</body>
</html>