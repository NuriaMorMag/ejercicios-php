
<?php

//El código definitivo no tendría tantos comentarios

require_once("BiciElectrica.php");

// Leer el fichero csv y devuelve una tabla de bicicletas
function cargarbicis(): array
{
    $fich = @fopen("Bicis.csv", "r"); //abre el csv con fopen
    if ($fich == false) {
        die("Error al abrir el fichero"); //si no puede abrir el fichero da error
    }
    $tabla = [];

    //Lee línea a línea con fgetcsv() y crea un BiciElectrica por cada línea
    //Mete cada objeto bicicleta en un array ($valor) y lo devuelve
    while ($valor = fgetcsv($fich)) {
        //list() divide ese array en 5 variables
        list($id, $cx, $cy, $bat, $op) = $valor; //Así: $id  = $valor[0]; $cx  = $valor[1];...
        //Crea un objeto bici con esos datos
        $bici = new BiciElectrica($id, $cx, $cy, $bat, $op);
        $tabla[] = $bici;
    }
    fclose($fich); //cerrar fichero para liberar recursos

    return $tabla;
}

// Devuelve una cadena con la tabla html de bicis operativas
function mostrartablabicis($tabla): string
{
    $cadena = "<table><tr><th>Id</th><th>Coord X</th><th>Coord Y</th><th>Bateria</th></tr>";
    foreach ($tabla as $bici) {
        //Se busca dentro del objeto $bici la propiedad llamada "operativa" y devuelve el valor dentro del objeto
        if ($bici->operativa == 1) {
            $cadena .= "<tr>";
            $cadena .= "<td>" . $bici->id . "</td>";
            $cadena .= "<td>" . $bici->coordx . "</td>";
            $cadena .= "<td>" . $bici->coordy . "</td>";
            $cadena .= "<td>" . $bici->bateria . "%</td>";
            $cadena .= "</tr>";
        }
    }
    $cadena .="</table>";

    return $cadena;
}


/**
 * Devuelve la bici con menor distancia a las coordenadas de usuario. 
 * @param $tabla - tabla de bicicletas
 * @param $x - Coordenada x de usuario
 * @param $y - Coordenada x de usuario
 * @return BiciElectrica|null  bicicleta más cercana o null
 */
function bicimascercana($tabla, $x, $y)
{
    $bicicerca = null;
    $distanciamin = PHP_INT_MAX; //palabra PHP: número entero más grande que PHP puede manejar
    foreach ($tabla as $bici) {
        if ($bici->operativa == 1) {
            //$x y $y → coordenadas del usuario
            $longitud =  $bici->distancia($x, $y); //método de la clase que calcula la distancia con una fórmula
            if ($longitud < $distanciamin) {
                $bicicerca = $bici;
                $distanciamin = $longitud;
            }
        }
    }
    return $bicicerca;
}


/**
 * Funcion mostrartablabicis() ejemplo de proceso: if ($bici->operativa == 1)
 * PHP busca dentro del objeto $bici la propiedad llamada "coordx" o "operativa".
 * PHP las encuentra porque fueron declaradas en la clase BiciElectrica.
 * Como son privadas, PHP llama al método mágico __get().
 * __get() verifica
 * property_exists($this, "coordx")  -> true
 * Entonces devuelve el valor real almacenado dentro del objeto.
 * 
 * PHP_INT_MAX: PHP_INT_MIN es una constante predefinida en PHP que representa el valor entero mínimo que el sistema puede soportar.
 */