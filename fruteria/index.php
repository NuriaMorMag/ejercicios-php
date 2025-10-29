<?php
// Maneja una lista de precios almacenada en el array precios
require_once "precios.php";
session_start();

// Manejo de la sesión con dos valores
// 'cliente' => nombre del cliente
// 'pedidos' => array asociativo fruta => cantidad


// Nuevo cliente: anoto en la sesión su nombre y creo su tabla de pedidos vacía
if (isset($_GET['cliente']) && !isset($_SESSION['cliente']) ) {
    $_SESSION['cliente'] = $_GET['cliente'];
    $_SESSION['pedidos'] = [];
}

// No hay definido un cliente todavía en la session 
if (!isset($_SESSION['cliente'])) {
    require_once 'bienvenida.php';
    exit();
}


// Proceso las acciones 
if (isset($_POST["accion"])) {
    $fruta = $_POST["fruta"];
    $cantidad = $_POST["cantidad"];
    switch ($_POST["accion"]) {
        case " Anotar ":
            // Actualizo la tabla de pedidos en la sesión
            if (isset($_SESSION['pedidos'][$fruta])) {
                $_SESSION['pedidos'][$fruta] += $cantidad;
            } else {
                $_SESSION['pedidos'][$fruta] = $cantidad;
            }
            break;
        case " Anular ":
            // Vacío la tabla de pedidos en la sesión
            unset($_SESSION['pedidos'][$fruta]);
            break;
        case " Terminar ":
            $compraRealizada = htmlTablaPedidosImportes($precios);
            // Destruyo la sesión y vuelvo a la página de bienvenida
            require_once 'despedida.php';
            session_destroy();
            exit();
          
    }
}

$compraRealizada = htmlTablaPedidosImportes($precios);
require_once 'compra.php';


// Función axiliar que genera una tabla HTML a partir  la tabla de pedidos
// Almacenada en la sesión

//Versión más simple: para mostrar solo la lista de frutas y cantidades
//antes de calcular precios
//no se está usando
function htmlTablaPedidos(): string 
{
    $msg = "";
    $msg .= "<table>";
    foreach ( $_SESSION['pedidos'] as $fruta => $cantidad){
        $msg .= "<tr><td> $fruta : $cantidad </td></tr>";
    }
    $msg .= "</table>";
    return $msg;
}
// Función axiliar que genera una tabla HTML a partir  la tabla de pedidos
// Almacenada en la sesión
function htmlTablaPedidosImportes($precios): string
{
    $msg = "";
    $importeTotal = 0;
    $msg .= "<table>";
    $msg .= "<th> Fruta </th><th> Cantidad x Importe </th> <th> Subtotal </th>";
    foreach ( $_SESSION['pedidos'] as $fruta => $cantidad){
        $precio = $precios[$fruta];
        $importe = $precio * $cantidad;
        $importeTotal += $importe;
        $msg .= "<tr>";
        $msg .= "<td> $fruta </td>";
        $msg .= "<td> $precio x  $cantidad </td>";
        $msg .= "<td> $importe </td>";
        $msg .= "</tr>";
    }
    $msg .= " <tr><td colspan=2><b> Importe total :</b></td><td> $importeTotal</td></tr>";
    $msg .= "</table>";
    return $msg;
}