<?php

/**
 * This file is designed to be a test on localhost while working on the develop branch
 * @author timothymarois@gmail.com
 */

echo memory_get_usage() . "<br>";

require_once('../database/mysqli/connect.php'); 
$db = connect::getInstance();

// connect to localhost on database test using root
$db->createConnection('local','localhost','test','root','');


echo memory_get_usage() . "<br>";



// test the insert query (once)
// $db->local->query("INSERT INTO test_table SET random = '".(time()+mt_rand(99,99999))."' ");
// print_r('<pre>affected_rows: '.$db->local->affected_rows.'</pre>'); // should print "1"
// print_r('<pre>insert_id: '.$db->local->insert_id.'</pre>'); // print the ID generated (from auto-increment)

// test the update query (once)
// $db->local->query("UPDATE test_table SET random = '".(time()+mt_rand(99,99999))."' LIMIT 20");
// print_r('<pre>affected_rows: '.$db->local->affected_rows.'</pre>'); // should print 5


/**
 * $db->local->query("UPDATE ~")
 * $db->local->query("DELETE ~")
 * will return int() of affected_rows
 * Since UPDATE and DELETE are modifing existing rows, lets be sure to return how many it actually modified.
 * Now int(0) will be returned if no rows are modified
 */

if ($insert_id = $db->local->query("INSERT INTO test_table SET random = '".(time()+mt_rand(99,99999))."' ")->insert_id()) {
	print_r('<pre>insert_id: '.$insert_id.'</pre>'); // prints (the ID of the new row)
}

if ($affected_rows = $db->local->query("UPDATE test_table SET random = '".(time()+mt_rand(99,99999))."'")->affected_rows()) {
	print_r('<pre>updated -> affected_rows: '.$affected_rows.'</pre>'); // prints (all rows in the database)
}

if ($affected_rows = $db->local->query("DELETE FROM test_table")->affected_rows()) {
	print_r('<pre>deleted -> affected_rows: '.$affected_rows.'</pre>'); // prints out total number of rows deleted
}

echo memory_get_usage() . "<br>";

/**
 * API Functionality with MySQLi
 *  (you can still use these, however, the queries above, automatically return these values)
 * $db->local->affected_rows
 * $db->local->insert_id
 */

// test the insert query (randomize how many)
for($x=0; $x < mt_rand(99,999); $x++) {
	$db->local->query("INSERT INTO test_table SET random = '".(time()+mt_rand(99,99999))."' ");
} 


// display all the rows on the page
// by default use "result"
$q = $db->local->query("SELECT * FROM test_table ");
print '<pre>';
print 'num_rows(): '.$q->num_rows()." \n";
foreach($q->result() as $r) {
	print "id = ".$r->id." \n";
}
print '</pre>';

// only return 1 item, use "row"
// you can still declare "result" to confirm
$q = $db->local->query("SELECT * FROM test_table LIMIT 1")->row();
// print_r($q);


echo memory_get_usage() . "<br>";


// close the database connection
$db->local->close();
// test if DB is closed... should print an error message
// $db->local->query("UPDATE test_table SET random = '".(time()+mt_rand(99,99999))."' LIMIT 20");


echo memory_get_usage() . "<br>";