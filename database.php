<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "desafio_tecnotech";

    $db_connection = "";
    
    
    try{
        $db_connection = mysqli_connect($db_server,
                                        $db_user,
                                        $db_password,
                                        $db_name);

        echo "Conectado ao banco de dados <br>";
    }catch(mysqli_sql_exception){
        echo "Não foi possível se conectar ao banco de dados <br>";
    }


?>