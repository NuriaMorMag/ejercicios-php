<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  include 'captura.html';
  exit;
}

//htmlspecialchars para reemplazar caracteres especiales 
//por sus correspondientes entidades HTML 
$nombre = htmlspecialchars($_POST['nombre']); 
$alias = htmlspecialchars($_POST['alias']);
$edad = intval($_POST['edad']); 

// implode para convertir el array en texto separado por comas
$armas = isset($_POST['armas']) ? implode(", ", $_POST['armas']) : "Ninguna";
$magia = $_POST['magia'] ?? "No"; //Valor por defecto "No"

$img = "calavera.png";
$msg = "";

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
  $tipo = mime_content_type($_FILES['imagen']['tmp_name']); //detecta el tipo real del archivo 
  $tam = $_FILES['imagen']['size'];
  if ($tipo == 'image/png' && $tam <= 10240) {
    $destino = "uploads/" . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
    $img = $destino;
  } else $msg = "Error: solo PNG <10KB";
} elseif ($_FILES['imagen']['error'] != UPLOAD_ERR_NO_FILE) {
  $msg = "Error al subir la imagen";
}

echo "<div style='background:yellow;padding:10px;'>
<h3>Datos del Jugador</h3>
<p><b>Nombre:</b> $nombre</p>
<p><b>Alias:</b> $alias</p>
<p><b>Edad:</b> $edad</p>
<p><b>Armas:</b> $armas</p>
<p><b>¿Practica artes mágicas?:</b> $magia</p>
<p><b>Imagen subida:</b></p>
<img src='$img' width='120'><br>
<small>$msg</small>
</div>";
?>