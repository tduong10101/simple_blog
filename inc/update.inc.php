<?php
/*1. Verify that information was submitted via the POST method
2. Verify that the post was pressed
3. Verify that wall is filled out*/
// Include database credentials and connect to the database
include_once 'db.inc.php';
$db = new PDO(DB_INFO, DB_USER, DB_PASS);
// Include the image handling class
include_once 'img.inc.php';
if($_SERVER['REQUEST_METHOD']=='POST'
&& ($_POST['post']=='post'||$_POST['post']=='edit')
&& !empty($_POST['wall'])
&& !empty($_POST['title'])){
	if(!empty($_FILES['image']['type']))
	{ 
		try 
		{
			
	// Instantiate the class and set a save path
		$img = new ImageHandler("/simple_blog/img");
		// Process the file and store the returned path
		$img_path = $img->processUploadedImage($_FILES['image']);
		}
			catch(Exception $e)
		{
	// If an error occurred, output your custom error message
			die($e->getMessage());
		}
	}
	else
	{
	// Avoids a notice if no image was uploaded
		$img_path = NULL;
	}
	
	
	if (!empty($_POST['id'])&&($img_path!=NULL)){
		$sql = "UPDATE entry SET entry=?, title=?, image=? WHERE id = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_POST['wall'],$_POST['title'],$img_path,$_POST['id']));
	} elseif (!empty($_POST['id'])&&($img_path==NULL)){
		$sql = "UPDATE entry SET entry=?, title=? WHERE id = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_POST['wall'],$_POST['title'],$_POST['id']));
	}else{
		// Save the entry into the database
		$sql = "INSERT INTO entry  (entry,title,image) VALUES (?,?,?)";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_POST['wall'],$_POST['title']),$img_path);
	}
	$stmt->closeCursor();
	header('Location: ../');
	exit;
}elseif($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['del']=='delete')
{	
	
	// Save the entry into the database
	$sql = "DELETE FROM entry
		WHERE id = ?
		LIMIT 1";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($_POST['id']));
	$stmt->closeCursor();
	header('Location: ../');
	exit;
}
elseif ($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['edit']=='edit'){
	
	header('Location: /simple_blog/admin.php?page=edit&id='.$_POST['id']);
	exit;
}
elseif ($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['view']=='view'){
	
	header('Location: /simple_blog/?id='.$_POST['id']);
	exit;
}
else
{
	header('Location: ../');
	exit;
}
?>