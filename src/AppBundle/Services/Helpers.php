<?php

namespace AppBundle\Services;

class Helpers {

    public function cotizacionARS_BTC() {
        $url="https://api.coindesk.com/v1/bpi/currentprice/ARS.json";
        $cotizacion = @file_get_contents($url);
        if ($cotizacion == "") {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_PROXY, '10.1.14.155');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, '3128');
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'pbussi:dpidpi');
            $cotizacion = curl_exec($ch);
            if ($cotizacion=="") return 0;
        }
        $cotizacion = json_decode($cotizacion);
        return $cotizacion;
        //return floatval($cotizacion->bpi->ARS->rate_float);
    }

}
