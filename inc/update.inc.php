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

	if (!empty($_POST['url'])){
		
	
		if ($img_path!=NULL){
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
		} elseif ($img_path==NULL){
			$sql = "UPDATE entry SET entry=?, title=?,url=? WHERE url = ?";
			$stmt = $db->prepare($sql);
			$stmt->execute(array($_POST['wall'],$_POST['title'],$url,$_POST['url']));
		}
		$stmt->closeCursor();
		header('Location: /simple_blog/blog/'.$_POST['url']);
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
		$stmt->closeCursor();
		header('Location: ../');
	}
	
	exit;
}elseif($_SERVER['REQUEST_METHOD']=='POST'
&& $_POST['del']=='delete')
{	// delete all comments first
	include_once 'comments.inc.php';
	$comments = new Comments();
	$comments->deleteAllComment($_POST['id']);
	$sql = "DELETE FROM entry
		WHERE url = ?
		LIMIT 1";
	if($e['image']!="/simple_blog/img/no_img.jpg"){
		unlink($_SERVER['DOCUMENT_ROOT'].$e['image']);
	}
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
// If a comment is being posted, handle it here
else if($_SERVER['REQUEST_METHOD'] == 'POST'
		&& $_POST['post'] == 'Post Comment')
{
	// Include and instantiate the Comments class
	include_once 'comments.inc.php';
	$comments = new Comments();
	// Save the comment
	if($comments->saveComment($_POST))
	{
		// If available, store the entry the user came from
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$loc = $_SERVER['HTTP_REFERER'];
		}
		else
		{
			$loc = '../';
		}
		// Send the user back to the entry
		header('Location: '.$loc);
		exit;
	}
	// If saving fails, output an error message
	else
	{
		exit('Something went wrong while saving the comment.');
	}
}
// If the delete link is clicked on a comment, confirm it here
else if($_SERVER['REQUEST_METHOD'] == 'POST'
		&& $_POST['delete_comment'] == 'delete')
{
	// Include and instantiate the Comments class
	include_once 'comments.inc.php';
	$comments = new Comments();
	$comments->deleteComment($_POST['cId']);
	header('Location: /simple_blog/blog/'.$_POST['url']);
	exit;
}
// Go back to the right page
else if($_SERVER['REQUEST_METHOD'] == 'POST'
		&& $_POST['back'] == 'back')
{
	$numb=0;
	$numbEntry=4;
	include_once 'function.inc.php';
	$e = retrieveEntries($db);
	for ($i=0;$i<count($e);$i++){
		if ($e[$i]['url']==$_POST['url']){
			$numb=$i;
			break;
		}
	}
	$ipage = floor($numb/$numbEntry)+1;
	if ($ipage>1){
		header('Location: /simple_blog/page/'.$ipage);
	} else {
		header('Location: ../');
	}
	exit;
}
else
{
	header('Location: ../');
	exit;
}
?>