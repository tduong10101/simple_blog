<?php
/*1. Verify that information was submitted via the POST method
2. Verify that the post was pressed*/
if($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['del']=='delete')
{	
	// Include database credentials and connect to the database
	include_once 'db.inc.php';
	$db = new PDO(DB_INFO, DB_USER, DB_PASS);
	// Save the entry into the database
	$sql = "DELETE FROM wall
		WHERE id = ?
		LIMIT 1";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($_POST['id']));
	$stmt->closeCursor();
	header('Location: ../wall.php');
	exit;
}
// If both conditions aren't met, sends the user back to the main page
else
{
header('Location: ../wall.php');
exit;
}
?>