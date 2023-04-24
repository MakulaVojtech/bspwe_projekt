<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        $domain = $request->input('domain');
        $output = [];

        exec(base_path('resources/scripts/create_domain.bat ').$domain, $output);

        if($output[array_key_last($output)] === 'success') {
            session()->flash('success', "The domain with name \"$domain\" was successfully!");
        } else {
            session()->flash('error', "Something went wrong.\"{$output[array_key_last($output)]}\"");
        }

        return back();
    }

    public function getAllDomains()
    {
        $domains = [];
        $data = [
            [
                "domain_name"=>"Test1",
                "Ftpuser"=>"test1",
                "FtpPassword"=>"xHeslo123",
                "DbName"=>"test1.db",
                "DbUser"=>"test1",
                "DbPassword"=>"xHeslo123"
            ],
            [
                "domain_name"=>"Test2",
                "Ftpuser"=>"test2",
                "FtpPassword"=>"xHeslo123",
                "DbName"=>"test2.db",
                "DbUser"=>"test2",
                "DbPassword"=>"xHeslo123"
            ],
            [
                "domain_name"=>"Test3",
                "Ftpuser"=>"test3",
                "FtpPassword"=>"xHeslo123",
                "DbName"=>"test3.db",
                "DbUser"=>"test3",
                "DbPassword"=>"xHeslo123"
            ],
            [
                "domain_name"=>"Test4",
                "Ftpuser"=>"test4",
                "FtpPassword"=>"xHeslo123",
                "DbName"=>"test4.db",
                "DbUser"=>"test4",
                "DbPassword"=>"xHeslo123"
            ],
        ];
        exec(base_path('resources/scripts/get_domains.bat '), $domains);

       return view('dashboard', ['domains'=>$data]);
    }
}
