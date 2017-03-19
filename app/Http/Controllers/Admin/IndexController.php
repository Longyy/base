<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Request;
class IndexController extends Controller
{
    public function index(Request $oRequest)
    {
        
        
        return view('admin.index');
    }
}