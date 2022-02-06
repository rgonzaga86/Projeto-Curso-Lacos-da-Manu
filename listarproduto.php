<?php  //listarproduto.php

include('conexao.php');

$sql = "select * from tblfotos";
$qry = mysqli_query($con,$sql);


echo "<table border=1>";
echo "<tr>";
echo "<td>nome</td>";
echo "<td>foto</td>";
echo "<td>fpreçooto</td>";

echo "<tr>";
while ($linha = mysqli_fetch_array($qry)){
echo "<tr>";
echo "<td>{$linha['nome']}</td>";
echo "<td><img src='{$linha['foto']}' width='110px' height='130px'></td>";

echo "<tr>";
}
echo "</table>";