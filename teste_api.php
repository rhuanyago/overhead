<?php

$url = "https://swapi.dev/api/people/";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$resultado = json_decode(curl_exec($ch));

//var_dump($resultado);

foreach($resultado->results as $ator){
    //var_dump($ator);
    echo "Nome: " . $ator->name . "<br>";
    echo "Altura: " . $ator->height . "<br>";

    foreach ($ator->films as $filme) {
        echo "Filme: " . $filme . "<br>";
    }

    echo "<hr>";
}

?>