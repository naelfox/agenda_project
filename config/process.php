<?php

session_start();
include_once('connection.php');
include_once('url.php');

$data = $_POST;

if (!empty($data)) {
if($data['type'] === "create"){
    $name = $data["name"];
    $phone = $data["phone"];
    $observations = $data["observations"];

    $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";
    $statement = $conexao->prepare($query);

    $statement->bindParam(":name", $name);
    $statement->bindParam(":phone", $phone);
    $statement->bindParam(":observations", $observations);

    try{

        $statement->execute();
        $_SESSION["msg"] = "Contato criado com sucesso!";

    }
    
    catch (PDOException $e){
    
        //erro na conexão
        $errorMessage = $e->getMessage();
    
        echo "Erro na conexão: $errorMessage";
    
    }

}

else if($data['type'] === "edit"){
    $name = $data['name'];
    $phone = $data['phone'];
    $observations = $data['observations'];
    $id = $data['id'];

    $query = "UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id=:id";


    $statement = $conexao->prepare($query);

    $statement->bindParam(":name", $name);
    $statement->bindParam(":phone", $phone);
    $statement->bindParam(":observations", $observations);
    $statement->bindParam(":id", $id);

   
    try{

        $statement->execute();
        $_SESSION["msg"] = "Contato atualizado com sucesso!";

    }
    
    catch (PDOException $e){
    
        //erro na conexão
        $errorMessage = $e->getMessage();
    
        echo "Erro na conexão: $errorMessage";
    
    }

}


else if($data['id']){
    $id = $data['id'];

    $query = "DELETE from contacts WHERE id = :id";


    $statement = $conexao->prepare($query);

    $statement->bindParam(":id", $id);

    try{

        $statement->execute();
        $_SESSION["msg"] = "Contato foi excluido!";

    }
    
    catch (PDOException $e){
    
        //erro na conexão
        $errorMessage = $e->getMessage();
    
        echo "Erro na conexão: $errorMessage";
    
    }
    



}

header("Location:" . $BASE_URL . "../index.php");


} else {
    $id;
    if (!empty($_GET)) {
        $id = $_GET['id'];
    }
    if (!empty($id)) {
        //retorna um dado de um contato
        $query = "SELECT * FROM contacts WHERE id = :id";


        $statement = $conexao->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $contact = $statement->fetch();
    } else {
        //retorna todos os contatos
        $query = "SELECT * FROM contacts";

        $contacts = [];

        $statement = $conexao->prepare($query);

        $statement->execute();

        $contacts = $statement->fetchAll();
    }
}



$conexao = null;