<?php

namespace App\Http\Controllers;

use App\Services\XmlService;
use Illuminate\Http\Request;

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

        $buses = XmlService::parseBusRidesFromXml($file);

        return view('report', ['buses' => $buses]);
    }
}
