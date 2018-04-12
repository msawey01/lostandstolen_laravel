<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;

class DBController extends Controller
{	
	function validateInput($item, $description, $date_found, $location_found)
	{
		if  (!$this->validateItem($item)) {
			return 'Item is not in the correct format';
		}
		if  (!$this->validateDescription($description)) {
			return 'Description is not in the correct format';
		}
		if  (!$this->validateLocation($location_found)) {
			return 'Location Found is not in the correct format';
		}
		if ($this->validateMysqlDate($date_found) == false) {
			return 'Date Found is not in the correct format, please use DD/MM/YYYY';
		}
		return null;
	}
	public function getItems()
	{
		$sql = "SELECT * FROM lostitem";
		return mysqli_query($mysqli, $sql);
	}
	public function printStuff() {
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
	}
	function deleteItems($ids) {
		$ids_array = explode(',', $ids);
		foreach ($ids_array as $id) {
			DB::table('lostitem')->where('id', '=', $id)->delete();
		}
		return redirect()->route('dbedit');
	}
	function insertItems() {
 		$item = $_POST['item'];
		$description = $_POST['description'];
		if (!strtotime($_POST['date_found'])) {
			$error = 'Date Found is not in the correct format, please use DD/MM/YYYY';
			return redirect()->route('dbedit', ['error' => $error]);
		}
		$date_found = strtotime($_POST['date_found']);
		$date_found = date("Y-m-d", $date_found);
		$location_found = $_POST['location_found'];
 		$error = $this->validateInput($item, $description, $date_found, $location_found);
		if (null != $error) {
			return redirect()->route('dbedit', ['error' => $error]);
		}
 		$query = DB::table(env('DB_ITEMS_TABLE'))->insert([
				'item' => $item,
				'description' => $description,
				'date_found' => $date_found,
				'location_found' => $location_found
 			]);
 		return redirect()->route('dbedit');
	}
	function validateMysqlDate($date)
	{
		return (preg_match( '#^(?P<year>\d{2}|\d{4})([- /.])(?P<month>\d{1,2})\2(?P<day>\d{1,2})$#', $date, $matches )
			   && checkdate($matches['month'],$matches['day'],$matches['year']));
	}
	private function getIdArray($ids) {
		 
	}
	function validateItem($item) {
		return !$this->IsNullOrEmptyString($item);
	}
	function validateDescription($description) {
		return !$this->IsNullOrEmptyString($description);
	}
	function validateLocation($description) {
		return !$this->IsNullOrEmptyString($description);
	}
	// Function for basic field validation (present and neither empty nor only white space
	function IsNullOrEmptyString($question){
		return (!isset($question) || trim($question)==='');
	}

}
