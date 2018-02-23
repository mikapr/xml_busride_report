<?php

namespace App\Http\Controllers;

use App\BusWork;
use Illuminate\Http\Request;
use File;

class RideController extends Controller
{
    public function index()
    {
        return view('xml_loading');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xml',
        ]);

        $file = $request->file('file');

        $xmlContent = File::get($file);

        $xml = new \SimpleXMLElement($xmlContent);

        $buses = [];

        foreach ($xml->graph as $ride) {
            $busNum = (int) $ride['num'];
            if (isset($buses[$busNum]))
                $buses[$busNum]->addWork($ride);
            else
                $buses[$busNum] = new BusWork($busNum, $ride);
        }

        return view('report', ['buses' => $buses]);
    }
}
