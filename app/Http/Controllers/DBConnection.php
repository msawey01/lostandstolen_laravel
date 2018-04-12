<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DBController extends Controller
{
	public function __construct()
	{
		$mysqli = new mysqli(env('DB_LOCATION'), env('DB_READ_USER'), env('DB_PASS'), env('DB_TYPE')) or die("unable to connect");
	}
}
