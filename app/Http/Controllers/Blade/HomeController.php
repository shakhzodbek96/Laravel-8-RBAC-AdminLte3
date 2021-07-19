<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $is_role_exists = DB::select("SELECT COUNT(*) as cnt FROM `model_has_roles` WHERE model_id = ".auth()->id());

        if ($is_role_exists[0]->cnt)
            return view('pages.dashboard');
        else
            return view('welcome');
	}

}
