<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    //
    public function index(Request $request)
    {
/*        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $profiles = Profile::where('resident_last_name', $cond_name)->get();
        } else {
            $profiles = Profile::all();
        }
        return view('admin.profile.index', ['profiles' => $profiles, 'cond_name' => $cond_name]);
*/    }
    
}
