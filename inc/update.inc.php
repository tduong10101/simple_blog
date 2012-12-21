<?php
/*1. Verify that information was submitted via the POST method
2. Verify that the post was pressed
3. Verify that wall is filled out*/
if($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['post']=='post'
&& !empty($_POST['wall']))
{
	// Include database credentials and connect to the database
	include_once 'db.inc.php';
	$db = new PDO(DB_INFO, DB_USER, DB_PASS);
	// Save the entry into the database
	$sql = "INSERT INTO wall  (entry) VALUES (?)";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($_POST['wall']));
	$stmt->closeCursor();
	header('Location: ../');
	exit;
}
// If both conditions aren't met, sends the user back to the main page
else
{
header('Location: ../');
exit;
}
?>