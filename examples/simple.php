<?php

/**
 * This file acts as an example to connect a simple application
 *
 *
 */

// location to the mysqli connect file
require_once('/database/mysqli/connect.php'); 

// begin with connecting the db class
$db = connect::getInstance();
// now connect your actual database details
// handle is for using multiple database, look at multiple-database-example.php
$db->createConnection('handle','host','database','user','password');


// Running Database Queries Use:
// $db->handle->query("sql","result_type");
// sql = "SELECT/INSERT/ALTER/DELETE" Etc.
// result_type = "row" or "result" (only use result_type if you want results from your query, otherwise leave blank)
// return = array of database objects


/**
 * QUERIES with "multiple results"
 * Use "result" as the result_type
 * Returns array of database objects
 */

$results = $db->handle->query("SELECT * FROM mytable WHERE mycolumn = 12 ORDER BY RAND()","result");

if ($results) {
	foreach($results as $row) {
		// $row has database objects 
		$row->id;
		$row->column_name;
	}
}


/**
 * QUERIES for only 1 result
 * Use "row" as the result_type
 * Returns one database object
 */

$result = $db->handle->query("SELECT * FROM mytable WHERE id = 30","row");

if ($results) {
	// $results has database objects 
    $result->id;
    $result->column_name;
}




/**
 * UPDATE QUERIES
 */
$query = $db->handle->query("UPDATE mytable SET column_name = 'TEST_NAME' WHERE id = 30");
// $query = $db->handle->query("INSERT mytable SET column_name = 'TEST_NAME'");
// $query = $db->handle->query("DELETE mytable WHERE id = 30");
if ($query) {
	// query passed
}

