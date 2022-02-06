<?php 

$idcliente = isset($_GET["idcliente"]) ? $_GET["idcliente"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdprojeto";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM  clientes where idcliente= :idcliente";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idcliente",$idcliente);
            $stmt->execute();
            header("Location:listarclientes.php");
        }


        if($idcliente){
            //estou buscando os dados do cliente no BD
            $sql = "SELECT * FROM  clientes where idcliente= :idcliente";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idcliente",$idcliente);
            $stmt->execute();
            $cliente = $stmt->fetch(PDO::FETCH_OBJ);
            //var_dump($cliente);
        }
        if($_POST){
            if($_POST["idcliente"]){
                $sql = "UPDATE clientes SET nome=:nome, email=:email WHERE idcliente =:idcliente";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":nome", $_POST["nome"]);
                $stmt->bindValue(":email", $_POST["email"]);
                $stmt->bindValue(":idcliente", $_POST["idcliente"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO clientes(nome,email) VALUES (:nome,:email)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":nome",$_POST["nome"]);
                $stmt->bindValue(":email",$_POST["email"]);
                $stmt->execute(); 
            }
            header("Location:listarclientes.php");
        } 
    } catch(PDOException $e){
         echo "erro".$e->getMessage;
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Cadastro de Clientes</h1>
<form method="POST">
nome  <input type="text" name="nome"        value="<?php echo isset($cliente) ? $cliente->nome : null ?>"><br>
email <input type="text" name="email"       value="<?php echo isset($cliente) ? $cliente->email : null ?>"><br>
<input type="hidden"     name="idcliente"   value="<?php echo isset($cliente) ? $cliente->idcliente : null ?>">
<input type="submit">

</form>
<a href="listarclientes.php">volta</a>
</body>
</html>