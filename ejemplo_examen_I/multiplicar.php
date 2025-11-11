
<?php

$numeros=[1=>'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez'];
$tmulti=[];

//puedo poner $pos + 1 o añadir claves al array: 1=>'uno'
foreach ($numeros as $pos => $nombre) {
    $tabladevalores = [];
    for ($i=1 ; $i<=10 ; $i++) {
        $tabladevalores[$i] = $pos * $i;
    }
    $tmulti[$nombre] = $tabladevalores;
}

echo "<pre><code>"; 
var_dump($tmulti);
echo "</pre></code>";

?>