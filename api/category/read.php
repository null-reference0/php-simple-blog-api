<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog category object
$category = new Category($db);

// Blog category query
$result = $category->read();
// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
	// Category array
	$category_arr = array();
	$category_arr['data'] = array();

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$category_item = array(
			'id' => $id,
			'name' => $name
		);

		array_push($category_arr['data'], $category_item);
	}

	// Turn to JSON
	echo json_encode($category_arr);
} else {
	// No categories
	echo json_encode(array('message' => 'No Categories Found'));
}
