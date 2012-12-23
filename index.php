<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="global.css">
<title>My Blog</title>

</head>
<body>
	
	<div class="header">
		<h3 class="header">tBlog</h3>
		<div class="navi">
			<ul class="navi" >
				<li class="navi"> <a class="navi" href="/simple_blog/user">About Author</a>
				<li class="navi">|
				<li class="navi"> <a class="navi" href="/simple_blog/">Wall</a>
				<li class="navi">|
				<li class="navi"> <a class="navi" href="">Blog</a>
			</ul>
		</div>
	</div>
	<?php 		$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5);
				include_once 'inc/function.inc.php';
				include_once 'inc/db.inc.php';
				$db = new PDO(DB_INFO, DB_USER, DB_PASS);
				/*
				* Figure out what page is being requested (default is index)
				* Perform basic sanitization on the variable as well
				*/
				if(isset($_GET['page']))
				{
					$page = htmlentities(strip_tags($_GET['page']));
				}
				else
				{
					$page = 'index';
				}
				
				$id = (isset($_GET['id'])) ? (int) $_GET['id'] : NULL;
				
				$e = retrieveEntries($db,$id,$page);
				$e = sanitiseData($e);
				
				$fulldis = array_pop($e);
				if ($fulldis==$dis['noPage']){
					?><div class="container"><h1><?php echo $e['entry']?></h1></div><?php  	
				} elseif ($fulldis==$dis['about']){
					
					?><div class="container"><h1>About Author</h1></div>
					<?php 
					foreach($e as $entries){ ?>
						<div class="container"><p><br>Name: <?php echo $entries['name']; ?>
						<br>Address: <?php echo $entries['address']; ?>
						<br>Education: <?php echo $entries['education']; ?></p>
						<br>About me: <br><?php echo $entries['about']; ?></p></div><?php
					} 
				}
				else{
					if ($fulldis==$dis['edit']){
						$text= $e['entry'];
					}elseif ($fulldis == $dis['singleWall']||$fulldis==$dis['allWall']){
						$text= ("What's on your mind?");}?>
					
					<div class="body">
						<div class="container">
							<form method="post" action="inc/update.inc.php">
								<fieldset>
									
									<textarea name="wall" class="text" rows="3"><?php echo $text;?></textarea><br>
									<?php if ($fulldis==$dis['edit']){?>
									<input type="hidden" name="id" value="<?php echo $e['id'];?>">
									<?php }?>
									<input type="submit" name="post" class="button" value="post" />
								</fieldset>
							</form>
						</div>
					<div class="container">
				<?php				
				if($fulldis == $dis['singleWall']){
					?><div class="entry">
					<p class="entry">
					<?php echo $e['entry'];
					?>
					</p>
					<form method="post" action="inc/delete.inc.php">
							<input type="submit" name="del" class="dbutton" value="delete" />
							<input type="hidden" name="id" value="<?php echo $entries['id'];?>">
							
					</form>
					</div>
					
					
				<?php } elseif ($fulldis==$dis['allWall']){
					
					foreach($e as $entries){?><div class="entry">
					<p><?php 
					echo $entries['entry'];?>
					<br>
					<span class="created">created on: <?php 
					echo $entries['created'];?> </span>
					<br>
					</p>
						
					<form method="post" action="inc/delete.inc.php">
							
							<input type="submit" name="del" class="dbutton" value="delete" />
							<a class="edit" href="/simple_blog/?page=edit&id=<?php echo $entries['id'];?>">edit</a>
							<input type="hidden" name="id" value="<?php echo $entries['id'];?>">
							
					</form>
					
					</div>
					<?php }
				 } elseif ($fulldis==$dis['allWall']){
				 	?><div class="entry">
					<p class="entry">
					<?php echo $e['entry'];
					?>
					</p>
					</div>
				 <?php }
				// Format the entries from the database
				 }?>
		</div>
	</div>
</body>
</html>