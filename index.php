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
if ($fulldis==$dis['about']){

	?>
	<div class="body">
		<div class="h1">
			<h1>About Author</h1>
		</div>
		<?php
		foreach($e as $entries){ ?>
		<div class="container">
			<div class="entry"><?php list($width,$height) = getimagesize($_SERVER['DOCUMENT_ROOT']."/simple_blog/img/t.jpg");?> 
			<img class="main" alt="" src="/simple_blog/img/t.jpg" width="<?php echo (width*(200/$height))?>" height="200" />
				<p>
					Name:
					<?php echo $entries['name']; ?>
					<br> <br>Address:
					<?php echo $entries['address']; ?>
					<br> <br>Education:
					<?php echo $entries['education']; ?>
					<br> <br>About me:<br> <br>
					<?php echo nl2br($entries['about']); ?>
					<br>
					<br>
				</p>
			</div>
		</div>
	</div>
	<?php
		}
}
else{?>

	<div class="body">
	<?php if ($fulldis == $dis['invalid']||$fulldis == $dis['noPage']){?>
		<div class="h1">
			<h1>Error</h1>
		</div>
		<?php } else{?>
		<div class="h1">
			<h1>Blog</h1>
		</div>
		<?php }?>
		<div class="container">
		<?php
		if($fulldis == $dis['singleWall']||$fulldis == $dis['invalid']||$fulldis == $dis['noPage']){
			?>
			<div class="entry">
				<h2>
				<?php echo $e['title']; ?>
				</h2>
				<span class="created">created on: <?php 
				echo $e['created'];?></span>
				<?php if($fulldis == $dis['singleWall']&&$e['image']!="/simple_blog/img/no_img.jpg"){?>
				<img class="main" alt="" src="<?php echo $e['image']?>" />
				<?php }?>
				<br>
				<p class="entry">
				<?php echo nl2br($e['entry']);
				?>
				</p>
				<form method="post" action="inc/update.inc.php">
				<?php if($fulldis == $dis['singleWall']){?>
					<input type="submit" name="edit" class="button" value="edit" />
					<?php }?>
					<input type="submit" name="back" class="button" value="back" /> <input
						type="hidden" name="id" value="<?php echo $e['id'];?>">
				</form>
			</div>


			<?php } elseif ($fulldis==$dis['allWall']){
				//display 4 entry in a page
				$numEntry=4;
				$totalPage= ceil(count($e)/$numEntry);
				if (!isset($_GET['ipage'])||($_GET['ipage']>$totalPage)){
					$ipage = 0;
				} else {
					$ipage = $_GET['ipage'];
				}

				$sloop=$ipage*$numEntry;
				$eloop=($ipage+1)*$numEntry;
				for($i=$sloop;$i<$eloop;$i++){ ?>
			<div class="entry">

				<h2>
				<?php echo $e[$i]['title']; ?>
				</h2>
				<span class="created">created on: <?php 
				echo $e[$i]['created'];
				list($width,$height) = getimagesize($_SERVER['DOCUMENT_ROOT'].$e[$i]['image']);?> </span> <br> <img class="main" alt=""
					src="<?php echo $e[$i]['image']?>" width="<?php echo (width*(100/$height))?>" height="100" />
				<p>

				<?php $str =  (substr( $e[$i]['entry'],0 , 500 ));
					
				if (strrpos($str, "<")>strrpos($str, "</")){
					$str1 =  (substr( $str,0 , strrpos($str, "<")));
				} else {
					$str1 =  (substr( $str,0 , strrpos($str, " ") ));
				}
				if (strlen($str)<500){
					echo nl2br($str);
				}else { echo nl2br($str1)."...";}
				?>


				</p>
				<form method="post" action="inc/update.inc.php">
					<input type="submit" name="edit" class="button" value="edit" /> <input
						type="submit" name="view" class="button" value="view" /> <input
						type="hidden" name="id" value="<?php echo $e[$i]['id'];?>">
				</form>

			</div>
			<?php if ((count($e)-1)==$i){break;}}?>
			<div class="pagelegend">
				Page:
				<?php for ($i=0;$i<$totalPage;$i++){ ?> <a <?php if (($ipage)==$i){?> id="current"<?php } ?>
					<?php if (($ipage)!=$i){?>href="/simple_blog/?ipage=<?php echo $i;?>"<?php }?>><?php echo ($i+1);?> </a>
					<?php
			}


			?>
			</div>
		</div>
		<?php
			
}

?>
	</div>
	<?php
}?>
</body>
</html>
