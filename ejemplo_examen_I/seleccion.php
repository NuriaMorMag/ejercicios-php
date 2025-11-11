<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = "";
    $_SESSION['lenguajes']=[];
}

//si me envían un nombre, guardo el nombre
if (!isset($_POST['nombre'])){
    $_SESSION['nombre']=$_POST['nombre'];
}

//si me envían lenguajes, los guardo
if (!isset($_POST['lenguajes'])){
    $_SESSION['nombre']=$_POST['lenguajes'];
    print_r($_SESSION['lenguajes']); //porque es un array
}

$nombre = $_SESSION['nombre'];

function estalenguaje($lenguaje): bool {
    return in_array($lenguaje, $_SESSION['lenguajes']);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Selección de personal</title>
</head>
<body>
<h2> Datos de candidato: Paso 2º </h2>
<form  action="seleccion.php" method="POST">
<fieldset>
<legend>Datos Profesionales </legend>
Nombre : <input type="text" name="nombre" value=<?=$nombre?>></br> <!--poner $nombre-->
Lenguajes de programación:<br>
<select name="lenguajes[]" multiple="multiple" size=6>
     <option value="Java" <?= estalenguaje("Java") ? "selected='selected'": "" ?>> Java</option>    
     <option value="Javascripts" <?= estalenguaje("JavaScript") ? "selected='selected'": "" ?>>Javascripts</option>
     <option value="Php" <?= estalenguaje("Php") ? "selected='selected'": "" ?>>Php</option>
     <option value="Python" <?= estalenguaje("Python") ? "selected='selected'": "" ?>>Python</option>
     <option value="Perl" <?= estalenguaje("Perl") ? "selected='selected'": "" ?>>Perl</option>
     <option value="C#" <?= estalenguaje("C#") ? "selected='selected'": "" ?>>C#</option>
     </select><br>
<input type="submit" value="Enviar">
</fieldset>
</form>
</body>
</html>