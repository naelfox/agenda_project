<?php

$host = "localhost";
$dbname = "agenda";
$user = "root";
$pass = "";


try{

    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);


    //ativacao do modo erro
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


}

catch (PDOException $e){

    //erro na conexão
    $errorMessage = $e->getMessage();

    echo "Erro na conexão: $errorMessage";

}