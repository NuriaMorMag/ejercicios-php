<?php
session_start();

define('CUENTAFICHERO', 'misaldo.txt');

// NO está definido el token
if (!isset($_SESSION['token'])) {
header('Location: acceso.php?msg=Error+de+acceso 1');
exit();
} else {
    $msg="Token definido"; //acceso y ejercicio01 comparten token. Mismo navegador
    header('Location: acceso.php?msg'.urlencode($msg)); //lo mismo que header('Location: acceso.php?msg=Token+correcto');
}

if ($SESSION['token'] != $_POST['token']) {
    $msg="Error de acceso";
    header('Location: acceso.php?msg'.urlencode($msg)); //vuelve otra vez a cargar acceso.php pero con un mensaje
    exit(); //si queremos que termine
}
echo "Bien por ahora"; //el token está bien

//puede pasar que $_POST['token'] no esté

$saldo = @file_get_contents(CUENTAFICHERO);

//para evitar el error de que el fichero no existe o no se puede leer
if ($saldo === false) {
    echo "Fichero no se puede leer";
    die();
}

//VER SALDO
if ($_POST['Orden'] == "Ver saldo") {
    $msg="Su saldo actual es ".number_format($saldo,2, ',', '.'); //o ...es".$saldo simplemente
    header('Location: acceso.php?msg'.urlencode($msg)); //vuelve otra vez a cargar acceso.php pero con un mensaje
    exit(); 
}

//INGRESO
//Checkear: si está vacío o no es numérico
if(empty($_POST['importe']) || !is_numeric($_POST['importe']) || $_POST['importe'] <0) {
    $msg="Importe erróneo o importe menor que 0.";
    header('Location: acceso.php?msg'.urlencode($msg)); 
    exit(); 
}

$importe = $_POST['importe'];
if ($_POST['Orden'] == "Ingreso") {
    $saldo = $saldo + $importe;
    file_put_contents(CUENTAFICHERO, $saldo);
    $msg = "Operación realizada";
    header('Location: acceso.php?msg'.urlencode($msg)); 
    exit();

}

//REINTEGRO
//condición: no puedes sacar más dinero del que tengas
$importe = $_POST['importe'];
if ( $importe <= $saldo ) {
    $saldo = $saldo - $importe;
    file_put_contents(CUENTAFICHERO, $saldo);
    $msg = "Operación realizada";
} else  {
    $msg = "Importe erróneo o importe superior al saldo";
}
header('Location: acceso.php?msg'.urlencode($msg)); 
exit();

