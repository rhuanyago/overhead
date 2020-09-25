<?php

    $segundos = '85983';
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$segundos");
   
    $dateDiff = $dtF->diff($dtT);


    echo $data = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->d.' day'));

   


?>