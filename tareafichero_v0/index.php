<!--
App que permita modificar las contraseñas de los usuarios registrados
 a partir de los datos que se guardan el fichero usuarios.txt
-->

<?php 
include_once 'util.php';
session_start();

$mensaje="";

// Si no hay sesión iniciada y tampoco se ha enviado un formulario,
// mostramos la pantalla de acceso 
if (!isset($_SESSION['usuario']) && !isset($_POST['orden'])){
    include_once 'vistas/acceso.php';
    header('Location: acceso.php');
    exit();
}


if (isset($_POST['orden']) && $_POST['orden'] === "entrar") {
    // Campos de usuario y contraseña rellenos
    // con valores correctos
    // Actualizo variable de sesión
    // Si falla muestro acceso.php
    
    $user = isset($_POST['username']) ? $_POST['username'] : ''; //si $_POST['u'] existe y no es null, usa su valor; si no , usa ''
    $pass = isset($_POST['password']) ? $_POST['password'] : '';
    

    if (userOk($user, $pass)) {
    session_regenerate_id(true); //cambia el id de la sesion
    $_SESSION['usuario'] = $user; //guardamos quién está conectado
    $_SESSION['permiso'] = true; //las páginas lo reconocen como autorizado
    $token=uniqid(); 
    $_SESSION['token'] = $token;

    header('Location: vistas/cambiarcontra.php'); // Redirigimos al formulario para cambiar contraseña
    exit();
    } else {
        $msg = "Usuario o contraseña incorrectos";
        header('Location: vistas/acceso.php?msg'.urlencode($msg));
        exit();
    }
}

if (isset($_POST['orden']) && $_POST['orden'] === "cambiar") {
    // Comprobar que los campos están llenos
    // Se cambiar si la contraseña antigua es correcta
    // Y las nuevas contraseñas son iguales sino volvemos
    // a mostrar cambiarcontra
    // si falla muestro cambiarcontra.php

    if (empty($_SESSION['permiso'])) {
        $msg = "Acceso no autorizado.";
        header('Location: vistas/acceso.php?msg'.urlencode($msg));
        exit();
    
    } 
    
   //verificacion token
    if ( !isset( $_SESSION['token'] ) || !isset( $_POST['token'] ) ) { 
        $msg = "Error de seguridad (token no válido)";
        header('Location: vistas/acceso.php?msg'.urlencode($msg));
        exit();
    }
 
    if ($_SESSION['token'] != $_POST['token']) { 
        $msg = "Token inválido.";
        header('Location: vistas/acceso.php?msg'.urlencode($msg));
        exit();
    }

    $currentpass = isset($_POST['password']) ? $_POST['password'] : '';
    $pass1 = isset($_POST['password1']) ? $_POST['password1'] : '';
    $pass2 = isset($_POST['password2']) ? $_POST['password2'] : '';

    //Verificar que se han rellenado los campos
    if ($pass1 === '' || $pass2 === '' || $currentpass === '') {
        $msg = "Rellena todos los campos.";
        header('Location: vistas/cambiarcontra.php?msg='. urlencode($msg));
        exit();
    }

    // Comprobar que la contraseña actual es correcta
    if (!userOk($_SESSION['usuario'], $currentpass)) {
        $msg = "Contraseña actual incorrecta.";
        header('Location: vistas/cambiarcontra.php?msg='. urlencode($msg));
        exit();
    }

    // Comprobar que las nuevas coinciden
    if ($pass1 !== $pass2) {
        $msg = "Las nuevas contraseñas no coinciden.";
        header('Location: vistas/cambiarcontra.php?msg='. urlencode($msg));
        exit();
    }

    // Actualizar la contraseña en el fichero de datos
    if (updatePasswd($_SESSION['usuario'], $pass1)) {
        unset($_SESSION['token']); // Una vez cambiado, eliminar el token para evitar reutilización
        $msg = "Contraseña actualizada correctamente.";
        header('Location: vistas/resultado.php?msg='. urlencode($msg));
        exit();

    } else {
        $msg = "Error al actualizar la contraseña.";
        header('Location: vistas/cambiarcontra.php?msg='. urlencode($msg));
        exit();
    }
  
}


