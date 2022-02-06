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
      
            if($_POST["idcliente"]){
                $sql = "UPDATE clientes SET nome=:nome, email=:email, foto= :foto WHERE idcliente =:idcliente";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":nome", $_POST["nome"]);
                $stmt->bindValue(":email", $_POST["email"]);
                $stmt->bindValue(":foto", $_POST["foto"]);
                $stmt->bindValue(":idcliente", $_POST["idcliente"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO clientes(nome,email,foto) VALUES (:nome,:email, :foto)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":nome",$_POST["nome"]);
                $stmt->bindValue(":email",$_POST["email"]);
                $stmt->bindValue(":foto",$_POST["foto"]);
                $stmt->execute(); 
            }
            header("Location:listarclientes.php");
        
    } catch(PDOException $e){
         echo "erro".$e->getMessage;
        }

// Incluindo arquivo de conexão


// Selecionando fotos
$stmt = $con->prepare('SELECT foto FROM clientes WHERE idcliente = :idcliente');
$stmt->bindParam(':idcliente', $idcliente, PDO::PARAM_INT);
// Se executado
if ($stmt->execute())
{
    // Alocando foto
    $foto = $stmt->fetchObject();
    
    // Se existir
    if ($foto != null)
    {
        // Definindo tipo do retorno
        header('Content-Type: png ');
        
        // Retornando conteudo
        echo $foto->foto;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bo"></script>
</head>
<body>
<h1>Cadastro de Clientes</h1>
<form method="POST">
nome  <input type="text" name="nome"        value="<?php echo isset($cliente) ? $cliente->nome : null ?>"><br>
email <input type="text" name="email"       value="<?php echo isset($cliente) ? $cliente->email : null ?>"><br>
Foto <input type="file" name="foto" value="<?php echo isset($cliente) ? $cliente->foto : null ?>"><br>
<input type="hidden"     name="idcliente"   value="<?php echo isset($cliente) ? $cliente->idcliente : null ?>">
<input type="submit">
</form>
<a href="listarclientes.php">volta</a>
</body>
</html>