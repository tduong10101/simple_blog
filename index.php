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
				<li class="navi"> <a class="navi" href="/simple_blog/?page=about">About Author</a>
				<li class="navi">|
				<li class="navi"> <a class="navi" href="/simple_blog/">Wall</a>
				<li class="navi">|
				<li class="navi"> <a class="navi" href="">Blog</a>
			</ul>
		</div>
	</div>
	<?php 		$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4);
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
					?><h1><?php echo $e['entry']?></h1><?php  	
				} elseif ($fulldis==$dis['about']){
					
					?><h1>About Author</h1>
					<br>
					<?php 
					foreach($e as $entries){ ?>
						<div class="container"><p><br><?php echo ($entries['entry']); ?></p></div><?php
					} 
				}
				else{
				?>
					<div class="body">
						<div class="container">
							<form method="post" action="inc/update.inc.php">
								<fieldset>
									<textarea name="wall" class="text" rows="3" > What's on your mind?</textarea><br>
									<input type="submit" name="post" class="button" value="post" />
								</fieldset>
							</form>
						</div>
					<div class="container">
				<?php				
				if($fulldis==1){
					?><div class="entry">
					<p class="entry">
					<?php echo $e['entry'];
					?>
					</p>
					<form method="post" action="inc/delete.inc.php">
							<input type="submit" name="del" class="dbutton" value="delete" />
					</form>
					</div>
					
					
				<?php } elseif ($fulldis==0){
					
					foreach($e as $entries){?><div class="entry">
					<p><?php 
					echo $entries['entry'];?>
					
					</p>
					<form method="post" action="inc/delete.inc.php">
							<input type="hidden" name="id" value="<?php echo $entries['id'];?>">
							<input type="submit" name="del" class="dbutton" value="delete" />
					</form>
					</div>
					<?php }
				 } elseif ($fulldis==2){
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