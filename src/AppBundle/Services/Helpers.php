<?php
namespace AppBundle\Services;

class Helpers
{
    public function cotizacionARS_BTC()
    {
        $cotizacion=@file_get_contents("https://api.coindesk.com/v1/bpi/currentprice/ARS.json");
        if ($cotizacion=="") {
            return 0;
        }
        $cotizacion=json_decode($cotizacion);
        return floatval($cotizacion->bpi->ARS->rate_float);
    }
}
