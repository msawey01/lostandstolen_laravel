<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

class DeleteController extends Controller
{
	function getItemsToDelete($ids) {
		echo "works";
	}
	function deleteItems($ids) {
		#echo "Items to delete:\n";
		print_r(gettype($ids));
		DB::table('lostitem')->where('id', '=', $ids)->delete();
		
		return redirect()->route('dbedit');
	}
}