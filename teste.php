<?php

    $segundos = '1846';
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$segundos");

    $dateDiff = $dtF->diff($dtT);

    if ($dateDiff->d > 0) {
        $tempoConexaoDisp = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->d.' day'));
    }elseif ($dateDiff->h > 0) {
        $tempoConexaoDisp = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->h.' hours'));
    }elseif ($dateDiff->i > 0) {
        $tempoConexaoDisp = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->i.' minutes'));
    }

    echo $tempoConexaoDisp;

   


?>