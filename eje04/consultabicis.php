<?php
require_once("funciones.php");
$tabla = cargarbicis();

if ( isset($_GET['coordy']) && isset($_GET['coordx'])){
   $bicirecomendada = bicimascercana($tabla,$_GET['coordx'],$_GET['coordy']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>MOSTRAR BICIS OPERATIVA</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<h1> LISTA DE BICIS OPERATIVAS </h1>
<p>
<?= mostrartablabicis($tabla); ?>
</p>
<?= isset($bicirecomendada)?$bicirecomendada:"" ?>
<p> Indique su posición: </p>
<form>
  Coordx <input type="number" name="coordx" 
  value="<?= isset($_GET['coordx'])?$_GET['coordx']:'' ?>"
  ><br>
  Coordy <input type="number" name="coordy" 
  value="<?= isset($_GET['coordy'])?$_GET['coordy']:'' ?>"
  ><br>
  <input type="submit" value=" Enviar ">
</form>
</body>
</html>

<!--Aquí no hace falta pero si quisiese controlar la entrada de código: isset($bicirecomendada) ? htmlspecialchars($bicirecomendada) : "" -->