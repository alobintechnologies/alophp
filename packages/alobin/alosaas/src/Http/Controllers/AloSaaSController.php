<?php

namespace Alobin\AloSaaS\Http\Controllers;


use AloStatus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class AloSaaSController extends Controller
{
	public function index()
	{
		
		dd(Config::get("alosaas::message"));
		return view("alosaas::hello");
	}
}