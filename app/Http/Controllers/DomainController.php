<?php

namespace App\Http\Controllers;

use App\Models\DomainDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DomainController extends Controller
{
    public function store(Request $request)
    {
        $domain = $request->input('domain');
        $output = [];

        exec(base_path('resources/scripts/script.sh ').$domain, $output);

        if(array_key_last($output) == 5) {
            $output = [
                'domain_name' => $output[0],
                'ftp_user' => $output[1],
                'ftp_password' => $output[2],
                'db_name' => $output[3],
                'db_user' => $output[4],
                'db_password' => $output[5],
            ];

            $domainDetails = new DomainDetails($output);

            $user = Auth::user();
            $user->domainDetails()->save($domainDetails);
            session()->flash('success', "The domain with name \"$domain\" was successfully!");
        } else {
            session()->flash('error', "Something went wrong.\"{$output[array_key_last($output)]}\"");
        }

        return back();
    }

    public function getAllDomains()
    {
        $user = Auth::user();
        $domains = $user->domainDetails;
       return view('dashboard', compact('domains'));
    }
}
