<?php

//Codificación UTF-8 para interpretar los valores
define ('PIEDRA',   "&#x1F91C;"); 
define ('PIEDRA2',  "&#x1F91B;");
define ('TIJERAS',  "&#x1F596;");
define ('PAPEL',    "&#x1F91A;" );

//Array con mensajes en función del ganador
$mensajes = [
          "Empate",
          "Ha ganado el jugador 1",
          "Ha ganado el jugador 2"
        ];


/**
 *  Calcula el ganador 
 *  Parámetros: Dos valores PIEDRA, PAPEL O TIJERA
 *  Resultado: 0 (Empate),1 (1 Gana jugador 1), 2 (Gana jugador 2)   
 */

function calcularGanador (String $valor1, String $valor2): int{ 
    //Recibe dos fichas (por ejemplo PIEDRA y TIJERAS)
    
    $ganador =0;
    
    if ( $valor1 == $valor2 ) return $ganador;
    
    switch ($valor1){
        case PIEDRA:  $ganador = ( $valor2 == TIJERAS)?1:2; break;
        case TIJERAS: $ganador = ( $valor2 == PAPEL  )?1:2; break;
        case PAPEL:   $ganador = ( $valor2 == PIEDRA )?1:2; break;
    }
    return $ganador; //devuelve 0,1 o 2
}

function obtenerFicha (){
  $valor = rand(0,2);
  switch ($valor){
    case 0: return PIEDRA;
    case 1: return TIJERAS;
    case 2: return PAPEL;
  }
}

$jugador1 = obtenerFicha(); //Devuelve PIEDRA, PAPEL o TIJERAS
$jugador2 = obtenerFicha();
$pos = calcularGanador($jugador1,$jugador2);
$mensaje =  $mensajes[$pos]; 
$jugador2 = ($jugador2 == PIEDRA)?PIEDRA2:$jugador2;
/**
 * Esto cambia la ficha de jugador2 por PIEDRA2 si era piedra, 
 * para que los puños de jugadores 1 y 2 se vean orientados 
 * de forma distinta
 */
?>

<html>
<head>
<title>Online PHP Script Execution</title>
</head>
<body>
<h1>¡Piedra, papel, tijera!</h1>

    <p>Actualice la página para mostrar otra partida.</p>

    <table>
      <tr>
        <th>Jugador 1</th>
        <th>Jugador 2</th>
      </tr>
      <tr>
        <td><span style="font-size: 7rem"><?= $jugador1; ?></span></td>
        <td><span style="font-size: 7rem"><?= $jugador2; ?></span></td>
      </tr>
      <tr>
        <th colspan="2"><?= $mensaje ?></th>
      </tr>
    </table>
</body>
</html>