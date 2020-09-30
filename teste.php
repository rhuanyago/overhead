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

    //echo $tempoConexaoDisp;


    $valueDevice = $value['Device'];

    //    ----------------- INFOS WAN | INTERNET -------------------

    //PPOE 
    if(isset($valueDevice['PPP']['Interface'][1]['Username']['_value'])){
        $nomeppoe = $valueDevice['PPP']['Interface'][1]['Username']['_value'];
    }else{
        $nomeppoe = '::';
    }

    //MAC WAN
    if(isset($valueDevice['Ethernet']['Interface'][6]['MACAddress']['_value'])){
        $macWan = $valueDevice['Ethernet']['Interface'][6]['MACAddress']['_value'];
    }else{
        $macWan = '::';
    }

    //IP IPV4 WAN
    if(isset($valueDevice['IP']['Interface'][3]['IPv4Address'][1]['IPAddress']['_value'])){
        $ipv4Wan = $valueDevice['IP']['Interface'][3]['IPv4Address'][1]['IPAddress']['_value'];
    }else{
        $ipv4Wan = '::';
    }

    //Gateway Padrão WAN
    if(isset($valueDevice['PPP']['Interface'][1]['IPCP']['RemoteIPAddress']['_value'])){
        $gatewayPadraoWan = $valueDevice['PPP']['Interface'][1]['IPCP']['RemoteIPAddress']['_value'];
    }else{
        $gatewayPadraoWan = '::';
    }

    //DNS WAN
    if(isset($valueDevice['PPP']['Interface'][1]['IPCP']['DNSServers']['_value'])){
        $dnsWan = $valueDevice['PPP']['Interface'][1]['IPCP']['DNSServers']['_value'];
    }else{
        $dnsWan = '::';
    }

    // ---------------------------------  WI-FI ------------------------------------------

    //SSID WIFI 2.4
    if(isset($valueDevice['WiFi']['SSID'][1]['SSID']['_value'])){
        $ssidWifi24 = $valueDevice['WiFi']['SSID'][1]['SSID']['_value'];
    }else{
        $ssidWifi24 = '::';
    }

    //SENHA WIFI 2.4

    //CANAL WIFI 2.4
    if(isset($valueDevice['WiFi']['Radio'][1]['Channel']['_value'])){
        $canalWifi24 = $valueDevice['WiFi']['Radio'][1]['Channel']['_value'];
    }else{
        $canalWifi24 = '::';
    }

    //MAC WIFI 2.4
    if(isset($valueDevice['WiFi']['SSID'][1]['BSSID']['_value'])){
        $macWifi24 = $valueDevice['WiFi']['SSID'][1]['BSSID']['_value'];
    }else{
        $macWifi24 = '::';
    }

    //SSID WIFI 5.8
    if(isset($valueDevice['WiFi']['SSID'][3]['SSID']['_value'])){
        $ssidWifi58 = $valueDevice['WiFi']['SSID'][3]['SSID']['_value'];
    }else{
        $ssidWifi58 = '::';
    }

    //SENHA WIFI 5.8 

    //CANAL WIFI 5.8
    if(isset($valueDevice['WiFi']['Radio'][2]['Channel']['_value'])){
        $canalWifi58 = $valueDevice['WiFi']['Radio'][2]['Channel']['_value'];
    }else{
        $canalWifi58 = '::';
    }

    //MAC WIFI 5.8
    if(isset($valueDevice['WiFi']['SSID'][3]['BSSID']['_value'])){
        $macWifi58 = $valueDevice['WiFi']['SSID'][3]['BSSID']['_value'];
    }else{
        $macWifi58 = '::';
    }

    // -------------------- DISPOSITIVOS ------------------------------
    //UpTime
    if(isset($valueDevice['DeviceInfo']['UpTime']['_value'])){
        $segundos = $valueDevice['DeviceInfo']['UpTime']['_value'];
        //$segundos = '1846';
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$segundos");
    
        $dateDiff = $dtF->diff($dtT);
    
        if ($dateDiff->d > 0) {
            $upTime = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->d.' day'));
        }elseif ($dateDiff->h > 0) {
            $upTime = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->h.' hours'));
        }elseif ($dateDiff->i > 0) {
            $upTime = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->i.' minutes'));
        }

    }else{
        $upTime = '::';
    }

    //Serial
    if(isset($valueDevice['DeviceInfo']['SerialNumber']['_value'])){
        $serial = $valueDevice['DeviceInfo']['SerialNumber']['_value'];
    }else{
        $serial = '::';
    }
    
    //Fabricante
    if(isset($valueDevice['DeviceInfo']['Manufacturer']['_value'])){
        $fabricante = $valueDevice['DeviceInfo']['Manufacturer']['_value'];
    }else{
        $fabricante = '::';
    }

    //Modelo 
    if(isset($valueDevice['DeviceInfo']['HardwareVersion']['_value'])){
        $modelo = $valueDevice['DeviceInfo']['HardwareVersion']['_value'];
    }else{
        $modelo = '::';
    }

    //Status WIFI 
    if(isset($valueDevice['WiFi']['SSID'][1]['Enable']['_value'])){
        $wifiStatus = $valueDevice['WiFi']['SSID'][1]['Enable']['_value'];
        if ($wifiStatus == "Up") {
            $wifiStatus = "<i class='fa fa-check-circle'></i> Ativado";
        }else if ($wifiStatus == "Error"){
            $wifiStatus = "<i class='fas fa-exclamation-triangle'></i> Erro";
        }else {
            $wifiStatus = "<i class='fa fa-power-off'></i> Desativado";
        }
    }else{
        $wifiStatus = '::';
    }

    // ---------------------------- Dispositivos Conectados ----------------------------

    if (isset($valueDevice['Hosts']['Host'][1]['HostName']['_value'])) {
        $dadosDispositivos = $valueDevice['Hosts']['Host'];                       
        $hostname = $valueDevice['Hosts']['Host'][1]['HostName']['_value'];
        $ip_dispositivo = $valueDevice['Hosts']['Host'][1]['IPAddress']['_value'];
        $mac_dispositivo = $valueDevice['Hosts']['Host'][1]['PhysAddress']['_value'];
        $status_dispositivo = $valueDevice['Hosts']['Host'][1]['Active']['_value'];
        $segundosTempoConexao = $valueDevice['Hosts']['Host'][1]['LeaseTimeRemaining']['_value'];

        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$segundosTempoConexao");
    
        $dateDiff = $dtF->diff($dtT);
    
        if ($dateDiff->d > 0) {
            $tempoConexaoDisp = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->d.' day'));
        }elseif ($dateDiff->h > 0) {
            $tempoConexaoDisp = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->h.' hours'));
        }elseif ($dateDiff->i > 0) {
            $tempoConexaoDisp = date('d/m/Y H:i:s', strtotime('-'.$dateDiff->i.' minutes'));
        }

        //MANEIRA 2 
        // $a = count($dadosDispositivos); //valor -3 
        // $count = $a-3;
        // for ($i=1; $i <= $count; $i++) { 
        //     $hostname = $valueDevice['LANDevice'][1]['Hosts']['Host'][$i]['HostName']['_value'];
        //     $ip_dispositivo = $valueDevice['LANDevice'][1]['Hosts']['Host'][$i]['IPAddress']['_value'];
        //     $mac_dispositivo = $valueDevice['LANDevice'][1]['Hosts']['Host'][$i]['MACAddress']['_value'];
        //     $status_dispositivo = $valueDevice['LANDevice'][1]['Hosts']['Host'][$i]['Active']['_value'];

        //     $linha = '<td> '.$hostname.'</td><td style="text-align:center" >'.$ip_dispositivo.'</td><td style="text-align:center" >'.$mac_dispositivo.'</td>';
                        
        //     $arrDisp[] = $linha;
        // }
        
    }else {
        $dadosDispositivos = '::';
        $hostname = '::';
        $ip_dispositivo = '::';
        $mac_dispositivo = '::';
        $status_dispositivo = '::';
        $tempoConexaoDisp = '::';
    } 

    // -------------------------- Redirecionamento de Portas ----------------------------
    if(isset($valueDevice['NAT']['PortMapping'][1]['InternalClient']['_value'])){                
        $dadosRedirecionamento = $valueDevice['NAT']['PortMapping'];
        //$nomeServico = $valueDevice['NAT']['PortMapping'][1]['nameService']['_value'];
        $portaExterna = $valueDevice['NAT']['PortMapping'][1]['ExternalPort']['_value'];
        $ipInterno = $valueDevice['NAT']['PortMapping'][1]['InternalClient']['_value'];
        $portaInterna = $valueDevice['NAT']['PortMapping'][1]['InternalPort']['_value'];
        $protocolo = $valueDevice['NAT']['PortMapping'][1]['Protocol']['_value'];
    }else{
        $dadosRedirecionamento = '::';
        //$nomeServico = '::';
        $ipInterno = '::';
        $portaExterna = '::';
        $portaInterna = '::';
        $protocolo = '::';
    }

    // ---------------------------------- Potência do Wifi ----------------------------------

    //Potencia 2.4
    if(isset($valueDevice['WiFi']['Radio'][1]['TransmitPower']['_value'])){
        $potencia = $valueDevice['WiFi']['Radio'][1]['TransmitPower']['_value'];
        if($potencia > 50){
            $btn = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn btn-success" type="button">Alta <i class="fa fa-check"></i></button>';
        }elseif($potencia > 20){
            $btn = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn btn-warning" type="button">Média<i class="fa fa-exclamation"></i></button>';
        }elseif($potencia <= 20){
            $btn = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn btn-danger" type="button">Baixa<i class="fa fa-times"></i></button>';
        }
        $potencia = (json_encode([$potencia]));
    }else{
        $potencia = 0;
        $btn = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn" type="button">Não suportado</button>';
    }

    //Potencia 5.8
    if(isset($valueDevice['WiFi']['Radio'][2]['TransmitPower']['_value'])){
        $potencia58 = $valueDevice['WiFi']['Radio'][2]['TransmitPower']['_value'];
        if($potencia58 > 50){
            $btn58 = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn btn-success" type="button">Alta <i class="fa fa-check"></i></button>';
        }elseif($potencia58 > 20){
            $btn58 = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn btn-warning" type="button">Média<i class="fa fa-exclamation"></i></button>';
        }elseif($potencia58 <= 20){
            $btn58 = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn btn-danger" type="button">Baixa<i class="fa fa-times"></i></button>';
        }
        $potencia58 = (json_encode([$potencia58]));
    }else{
        $potencia58 = 0;
        $btn58 = '<button style="pointer-events: none;display:block;margin-left: auto;margin-right: auto;" class="btn" type="button">Não suportado</button>';
    }     


?>