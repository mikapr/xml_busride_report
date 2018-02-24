<?php

namespace App\Services;


use App\BusWork;
use Illuminate\Support\Facades\File;

class XmlService
{
    public static function parseBusRidesFromXml($xmlFile)
    {
        $xmlContent = File::get($xmlFile);

        $xml = new \SimpleXMLElement($xmlContent);

        $buses = [];

        foreach ($xml->graph as $ride) {
            $busNum = (int) $ride['num'];
            if (isset($buses[$busNum]))
                $buses[$busNum]->addWork($ride);
            else
                $buses[$busNum] = new BusWork($busNum, $ride);
        }

        return $buses;
    }
}