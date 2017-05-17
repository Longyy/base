<?php
namespace App\Http\Controllers;

use Estate\Validation\ValidatesServiceRequests;
use Illuminate\Routing\Controller;

abstract class RootController extends Controller
{
    use ValidatesServiceRequests;
}