<?php
session_start();
//'/home/a6944098/public_html'
$ROOT_DIR = $_SERVER['DOCUMENT_ROOT'];
// If the user is logged in, we can continue
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1){
	include_once 'inc/function.inc.php';
	if(isset($_GET['page']))
	{
		$page = htmlentities(strip_tags($_GET['page']));
		if ($page=='edit'){
			include_once 'inc/function.inc.php';
			include_once 'inc/db.inc.php';
			$db = new PDO(DB_INFO, DB_USER, DB_PASS);
			$url = (isset($_GET['url'])) ? (int) $_GET['url'] : NULL;
			$e = retrieveEntries($db,$url,$_GET['page']);
			$e = sanitiseData($e);
			$fulldis = array_pop($e);
			$bvalue = "Edit";
			$image=$e['image'];
			$text= $e['entry'];
			$title = $e['title'];
			$url =  $e['url'];
			$id = $e['id'];
			$h1 = "Edit";
		} elseif ($page=='create'){
			$createAdmin = createUserForm();
			$h1="Manage User";
		}
	}
	else
	{
		$page = '';
		$text= ("What's on your mind?");
		$bvalue = "Post";
		$image="/simple_blog/img/no_img.jpg";
		$title = NULL;
		$url =  NULL;
		$id = NULL;
		$h1 = "New Entry";
	}
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link
	rel="stylesheet" type="text/css" href="/simple_blog/global.css">
<link rel="alternate" type="application/rss+xml"
title="My Simple Blog - RSS 2.0"
href="/simple_blog/feeds/rss.php" />
<title>Admin</title>

</head>
<body>
<div align="center"><img src="/simple_blog/img/bg.jpg" class="bg"></div>
	<div class="wrap">
<div class="header">
	<h3 class="header">tBlog</h3>
	<div class="navi">
		<ul class="navi" >
			<li class="navi"> <a class="navi" href="/simple_blog/user">About Me</a>
			<li class="navi">
			<li class="navi"> <a class="navi" href="/simple_blog/">Blog</a>
			<li class="navi"> 
			<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1)
			{
				?><li class="navi"> <a class="navi" href="/simple_blog/admin">Post Entry</a>
				<li class="navi"> <a class="navi" href="/simple_blog/admin/create">Manage User</a><li class="navi">  
				<li class="navi"> <a class="navi" href="/simple_blog/inc/update.inc.php?action=logout">Logout</a><?php
			} else {
				?><li class="navi"> <a class="navi" href="/simple_blog/admin">Login</a><?php
			}?>
			
			
		</ul>
	</div>
</div>
	<div class="body">
	
	<?php 
	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1){
	if ($page=='create'){
		?>
		<h1><?php echo $h1 ?></h1>
		<div class="container">
			<div class="entry">
				<?php echo $createAdmin;?>
			</div>
		</div>
		<?php 
	} else {
				
			?><h1><?php echo $h1 ?></h1>
			<div class="container">
				<div class="entry">
					<form class="entry" method="post" action="/simple_blog/inc/update.inc.php"
						enctype="multipart/form-data">
						<fieldset>
							<label>Title  <input type="text" name="title" maxlength="150"
								value="<?php echo $title;?>" /> </label>
							
							<div class="upload">
								<label>Image  <?php 
									list($width,$height) = getimagesize($ROOT_DIR.$image);?>  
									<input type="file" name="image" /> </label>
									<img class="edit" alt="" src="<?php echo $image?>" width="<?php echo ($width*(100/$height))?>" height="100" />
									
							</div>
							<br>
							<label>Entry <textarea name="wall" class="text" rows="20"><?php echo $text;?>
								</textarea> </label>
							<input type="hidden" name="url" value="<?php echo $url?>">
							<input type="submit" name="post" class="button"
								value="<?php echo $bvalue; ?>" />
								
							<input type="submit" name="del" class="button" value="Delete" />
							<input type="hidden" name="id" value="<?php echo $id;?>">
							<input type="submit" name="cancel" class="button" value="Cancel" />
						</fieldset>
					</form>
				</div>
			</div>
		<?php }  }else{
/*
* If we get here, the user is not logged in. Display a form
* and ask them to log in.
*/
?>
		
		<h1>Login</h1>
			<div class="container">
				<div class="entry">
					<form method="post"
					action="/simple_blog/inc/update.inc.php"
					enctype="multipart/form-data">
					<fieldset>
						<label>Username
						<input type="text" name="username" maxlength="75" />
						</label>
						<label>Password
						<input type="password" name="password"
						maxlength="150" />
						</label>
						<input type="hidden" name="action" value="login"/>
						<input type="submit" name="submit" value="Log In" class="button"/>
					</fieldset>
					</form>
				</div>
			</div>
		
<?php } ?>
	</div>
	</div>
</body>
</html>
