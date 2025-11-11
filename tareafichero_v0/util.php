<?php 
define ('FILEUSER','dat/usuarios.txt');
/**
 * 
 * Compruba que la usuario y la contraseña son correctos consultando
 * el archivo de datos
 * @param mixed $login
 * @param mixed $passwd
 * @return bool
 */


// Definimos el nombre del recurso remoto del que se va a leer
define("FICH_DATOS", 'usuarios.txt');
function userOk ( $login, $passwd):bool {
     
    $fich_remoto = @file_get_contents(FICH_DATOS);

    //para evitar el error de que el fichero no existe o no se puede leer
    if ($fich_remoto === false) {
        echo "Fichero no se puede leer";
        return false;
    }

    // Abrimos los ficheros y comprobamos resultados
    $fich_remoto = @fopen(FICH_DATOS, 'r') or die("Error al abrir el recurso remoto");

    // Procesamos cada línea
    while ($linea = fgets($fich_remoto)) {  
        $partes = explode('|', trim($linea));
        
        if (count($partes) >= 2) {
            $user = $partes[0];
            $pass = $partes[1];

            // Comprobamos si el usuario coincide y la contraseña es válida
            if ($user === $login && password_verify($passwd, $pass)) {
                fclose($fich_remoto);
                return true;
            }
        }
    }
    fclose($fich_remoto); // cerramos los ficheros
    return false;
}

/**
 *  Actualiza la password de un usuario en el archivo de datos
 * @param mixed $login
 * @param mixed $passwd
 * @return bool true si el usuarios existe en el fichero
 */
function updatePasswd ($login, $passwd):bool {

    $fich_remoto = @file_get_contents(FICH_DATOS);

    //para evitar el error de que el fichero no existe o no se puede leer
    if ($fich_remoto === false) {
        echo "Fichero no se puede leer";
        return false;
    }
  
    $filearray = file(FICH_DATOS); //lee el fichero y pone cada línea en un elemento de un array
    $actualizado = false; 
    
    // Recorremos cada línea del array
    foreach ($filearray as $i => $linea) {
        $partes = explode('|', trim($linea));
        if (count($partes) >= 2 && $partes[0] === $login) {
            // Si el usuario coincide, reemplazamos la línea entera
            $filearray[$i] = $login . '|' . $passwd . "|\n";
            $actualizado = true;
            break;
        }
    }

    // Si se modificó algo, convertimod el array de líneas de nuevo en una sola cadena concatenando todas las líneas en su orden original
    if ($actualizado) {
        file_put_contents(FICH_DATOS, implode('', $filearray));
    }

    return $actualizado;
}

