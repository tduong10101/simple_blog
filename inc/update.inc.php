<?php
/*1. Verify that information was submitted via the POST method
 2. Verify that the post was pressed
 3. Verify that wall is filled out*/
// Include database credentials and connect to the database
include_once 'db.inc.php';
$db = new PDO(DB_INFO, DB_USER, DB_PASS);
// Include the image handling class
include_once 'img.inc.php';
include_once 'function.inc.php';
if($_SERVER['REQUEST_METHOD']=='POST'
&& ($_POST['post']=='post'||$_POST['post']=='edit')
&& !empty($_POST['wall'])
&& !empty($_POST['title'])){
	// Create a URL to save in the database
	$url = makeUrl($_POST['title']);
	
	if(!empty($_FILES['image']['type']))
	{
		try
		{
				
			// Instantiate the class and set a save path
			$img = new ImageHandler("/simple_blog/img",array(600,450));
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


	if (!empty($_POST['url'])&&($img_path!=NULL)){
		//delete old image

		$sql="SELECT image FROM entry WHERE url =?";;
		$stm = $db->prepare($sql);
		$stm->execute(array($_POST['url']));
		$e = $stm->fetch();
		if($e['image']!="/simple_blog/img/no_img.jpg"){
			unlink($_SERVER['DOCUMENT_ROOT'].$e['image']);
		}

		//update new contain
		$sql = "UPDATE entry SET entry=?, title=?, image=?, url=? WHERE url = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_POST['wall'],$_POST['title'],$img_path,$url,$_POST['url']));
	} elseif (!empty($_POST['url'])&&($img_path==NULL)){
		$sql = "UPDATE entry SET entry=?, title=?,url=? WHERE url = ?";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($_POST['wall'],$_POST['title'],$url,$_POST['url']));
	}else{
		// Save the entry into the database
		if ($img_path!=NULL){
			$sql = "INSERT INTO entry  (entry,title,image,url) VALUES (?,?,?,?)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($_POST['wall'],$_POST['title'],$img_path,$url));
		} else{
			$sql = "INSERT INTO entry  (entry,title,url) VALUES (?,?,?)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($_POST['wall'],$_POST['title'],$url));
		}
	}
	$stmt->closeCursor();
	header('Location: ../');
	exit;
}elseif($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['del']=='delete')
{

	// Save the entry into the database
	$sql = "DELETE FROM entry
		WHERE url = ?
		LIMIT 1";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($_POST['url']));
	$stmt->closeCursor();
	header('Location: ../');
	exit;
}
elseif ($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['edit']=='edit'){

	header('Location: /simple_blog/admin/edit/'.$_POST['url']);
	exit;
}
elseif ($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['view']=='view'){

	header('Location: /simple_blog/blog/'.$_POST['url']);
	exit;
}
else
{
	header('Location: ../');
	exit;
}
?>