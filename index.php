<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="global.css">
<title>My Blog</title>

</head>
<body>
	
	<?php include_once '/inc/header.inc.php';
	
	 		$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5);
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
					?><div class="body"><div class="container"><h1><?php echo $e['entry']?></h1></div></div><?php  	
				} elseif ($fulldis==$dis['about']){
					
					?><div class="body"><div class="h1"><h1>About Author</h1></div>
					<?php 
					foreach($e as $entries){ ?>
						<div id="about" class="container"><p id="about">Name: <?php echo $entries['name']; ?><br>
						<br>Address: <?php echo $entries['address']; ?><br>
						<br>Education: <?php echo $entries['education']; ?><br>
						<br>About me:<br> <br><?php echo $entries['about']; ?><br></p></div></div><?php
					} 
				}
				else{?>
					
					<div class="body">
					<div class="h1"><h1>Blog</h1></div>
					<div class="container">
				<?php				
				if($fulldis == $dis['singleWall']){
					?><div class="entry">
					<h2><?php echo $e['title']; ?></h2>
					<p class="entry">
					<?php echo nl2br($e['entry']);
					?>
					</p>
					<form method="post" action="inc/update.inc.php">
							<input type="submit" name="edit" class="button" value="edit" />
							<input type="submit" name="back" class="button" value="back" />
							<input type="hidden" name="id" value="<?php echo $e['id'];?>">
							
					</form>
					</div>
					
					
				<?php } elseif ($fulldis==$dis['allWall']){
					
					foreach($e as $entries){?><div class="entry">
						
						<h2><?php echo $entries['title']; ?></h2>
						<p>		
							<span class="created">created on: <?php 
							echo $entries['created'];?> </span>
							<br>
							<?php $str =  substr( $entries['entry'],0 , 300 );
							$str =  nl2br(substr( $str,0 , strrpos($str, " ") ));
							if (strlen($str)<200){
								echo $str;
							}else { echo $str."...";}
							?>
							<form method="post" action="inc/update.inc.php">
									<input type="submit" name="edit" class="button" value="edit" />
									<input type="submit" name="view" class="button" value="view" />
									<input type="hidden" name="id" value="<?php echo $entries['id'];?>">	
							</form>
						</p>
					</div>
					<?php }
				 } 
				// Format the entries from the database
				 }?>
		</div>
	</div>
	</div>
</body>
</html>