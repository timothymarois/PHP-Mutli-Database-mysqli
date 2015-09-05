<?php

/**
 * This file is an example of connecting multiple database to one application.
 *
 */

require_once('/database/mysqli/connect.php'); 
$db = connect::getInstance();



/**
 * Connection Multiple Database
 * ('handle','host','database','user','password')
 *
 * Handle:
 *  - name your handle ( db1,db2 ) what is the easist to use in your application.
 *  - be sure to change the "handle" name within your queries (examples below)
 */
$db->createConnection('db1','host','database','user','password');
$db->createConnection('db2','host','database','user','password');
$db->createConnection('db3','host','database','user','password');



/**
 * Running Database Queries Use:
 * $db->handle->query("sql","result_type");
 * 
 * sql         = query in which you would like to run.
 * result_type = "row" or "result" (use result_type if you want results returned from your query, otherwise leave blank/null)
 */


/**
 * Running Queries
 * (change out the handle, in my case db1,db2,db3) and run a query on any database connected
 */

// handle : db1
$db->db1->query("SELECT * FROM mytable WHERE mycolumn = 12 ORDER BY RAND()","result");

// handle : db12
$db->db1->query("SELECT * FROM mytable WHERE mycolumn = 12 ORDER BY RAND()","result");


// `handle` would be changed to db1,db2, etc or the name of what you changed it too.

/**
 * QUERIES with "multiple results"
 * Use "result" as the result_type
 * Returns array of database objects
 */
$results = $db->handle->query("SELECT * FROM mytable WHERE mycolumn = 12 ORDER BY RAND()","result");
if ($results) {
	foreach($results as $row) {
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
    $result->id;
    $result->column_name;
}


/**
 * UPDATE QUERIES
 * all other queries which do not require results returned.
 * if the query passes, it will return true.
 */
$query = $db->handle->query("UPDATE mytable SET column_name = 'TEST_NAME' WHERE id = 30");
// $query = $db->handle->query("INSERT mytable SET column_name = 'TEST_NAME'");
// $query = $db->handle->query("DELETE mytable WHERE id = 30");
if ($query) {
	/* Query Returns TRUE */
}
