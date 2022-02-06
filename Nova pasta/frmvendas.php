<?php 

$idvenda = isset($_GET["idvenda"]) ? $_GET["idvenda"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdprojeto";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM venda where idvenda= :idvenda";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idvenda",$idvenda);
            $stmt->execute();
            header("Location:listarvendas.php");
        }


        if($idvenda){
            //estou buscando os dados do produto no BD
            $sql = "SELECT * FROM  venda where idvenda= :idvenda";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idvenda",$idvenda);
            $stmt->execute();
            $idvenda = $stmt->fetch(PDO::FETCH_OBJ);
            //var_dump($venda);
        }
        if($_POST){
            if($_POST["idvenda"]){
                $sql = "UPDATE venda SET dtvenda=:dtvenda, idproduto=:idproduto, idvendedor=:idvendedor, qtdvenda=:qtdvenda WHERE idvenda=:idvenda";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":dtvenda", $_POST["dtvenda"]);
                $stmt->bindValue(":idproduto", $_POST["idproduto"]);
                $stmt->bindValue("idvendedor", $_POST["idvendedor"]);
                $stmt->bindValue(":qtdvenda", $_POST["qtdvenda"]);
                $stmt->bindValue ("idvenda", $_POST["idvenda"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO venda (dtvenda, idproduto, idvendedor, qtdvenda) VALUES (:dtvenda, :idproduto, :idvendedor, :qtdvenda)";
                $stmt = $con->prepare($sql);
               
                $stmt->bindValue(":dtvenda", $_POST["dtvenda"]);
                $stmt->bindValue(":idproduto", $_POST["idproduto"]);
                $stmt->bindValue("idvendedor", $_POST["idvendedor"]);
                $stmt->bindValue(":qtdvenda", $_POST["qtdvenda"]);
                $stmt->execute(); 
            }
            header("Location:listarvendas.php");
        } 
    } catch(PDOException $e){
         echo "erro".$e->getMessage;
        }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Cadastro de Vendas</h1>
<form method="POST">
Data da Venda   <input type="date" name="dtvenda"             required value="<?php echo isset($idvenda) ? $idvenda->dtvenda: null  ?>"><br>
Id Vendedor     <input type="text" name="idvendedor"            required value="<?php echo isset($idvenda) ? $idvenda->idvendedor: null ?>"><br>
Id Produto      <input type="text" name="idproduto"             required value="<?php echo isset($idvenda) ? $idvenda->idproduto: null ?>"><br>
Qtd Venda       <input type="text" name="qtdvenda"              required value="<?php echo isset($idvenda) ? $idvenda->qtdvenda:   null ?>"><br>



<input type="hidden"     name="idvenda"   value="<?php echo isset($idvenda) ? $idvenda->idvenda : null ?>">
<input type="submit">
</form>
<a href="listarvendas.php">volta</a>
</body>
</html>