<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="/simple_blog/global.css">
<link rel="alternate" type="application/rss+xml"
title="My Simple Blog - RSS 2.0"
href="/simple_blog/feeds/rss.php" />
<title>My Blog</title>

</head>
<body>

<?php 

$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5,'noEntry'=>6);
include_once 'inc/function.inc.php';
include_once 'inc/db.inc.php';
headerCreate();
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

$url = (isset($_GET['url'])) ? (int) $_GET['url'] : NULL;

$e = retrieveEntries($db,$url,$page);
$e = sanitiseData($e);

$t = retrieveEntries($db);
$t = sanitiseData($t);
$fulldis = array_pop($t);
$fulldis = array_pop($e);
?>

	<div class="container" id="left">
		<div id="left" class="entry">
			<h2> 10 Recent Post</h2>
			<ol id="left">
			<?php for($i=0;$i<10;$i++){ ?>
				<li>
					<a class="title" title="<?php echo $t[$i]['title'];?>" href="/simple_blog/blog/<?php echo $t[$i]['url'];?>"><?php echo cutEntry($t[$i]['title'],40); ?></a>
					<?php if (count($t)==($i+1)){
						break;
					}?>
				</li>
			<?php }?>
			</ol>
		</div>
	</div>

<?php if ($fulldis==$dis['about']){

	?>
	<div class="body">
		<div class="h1">
			<h1>About Author</h1>
		</div>
		<?php
		foreach($e as $entries){ ?>
		<div class="container">
			<div class="entry"><?php list($width,$height) = getimagesize($_SERVER['DOCUMENT_ROOT']."/simple_blog/img/t.jpg");?> 
			<img class="main" alt="" src="/simple_blog/img/t.jpg" width="<?php echo (width*(150/$height))?>" height="150" />
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
		if($fulldis == $dis['singleWall']||$fulldis == $dis['invalid']||$fulldis == $dis['noPage']||$fulldis == $dis['noEntry']){
			?>
			<div class="entry">
				<h2>
				<?php echo $e['title']; ?>
				</h2>
				<?php if ($fulldis == $dis['singleWall']){?><span class="created">created on: <?php 
				echo date("l jS F , Y, g:i a", strtotime($e['created']));?></span><?php }?>
				<?php if($fulldis == $dis['singleWall']&&$e['image']!="/simple_blog/img/no_img.jpg"){?>
				<img class="main" alt="" src="<?php echo $e['image']?>" />
				<?php }?>
				<br>
				<p class="entry">
				<?php echo nl2br($e['entry']);
				?>
				</p>
				<?php if($fulldis != $dis['noEntry']){?>
				<form method="post" action="/simple_blog/inc/update.inc.php">
				<?php if($fulldis == $dis['singleWall']){?>
					<input type="submit" name="edit" class="button" value="edit" />
					<?php }?>
					<input type="submit" name="back" class="button" value="back" /> <input
						type="hidden" name="url" value="<?php echo $e['url'];?>">
				</form>
				<?php }?>
			</div>


			<?php } elseif ($fulldis==$dis['allWall']){
				//display 4 entry in a page
				$numEntry=4;
				$totalPage= ceil(count($e)/$numEntry);
				if (!isset($_GET['ipage'])||($_GET['ipage']>$totalPage)){
					$ipage = 0;
				} else {
					$ipage = $_GET['ipage']-1;
				}

				$sloop=$ipage*$numEntry;
				$eloop=($ipage+1)*$numEntry;
				for($i=$sloop;$i<$eloop;$i++){ ?>
			<div class="entry">

				<h2>
				<a class="title" href="/simple_blog/blog/<?php echo $e[$i]['url'];?>"><?php echo $e[$i]['title']; ?></a>
				</h2>
				<span class="created">created on: <?php 
				echo date("l jS F , Y, g:i a", strtotime($e[$i]['created']));
				list($width,$height) = getimagesize($_SERVER['DOCUMENT_ROOT'].$e[$i]['image']);?> </span> <br> <img class="main" alt=""
					src="<?php echo $e[$i]['image']?>" width="<?php echo (width*(100/$height))?>" height="100" />
				<p>

				<?php echo cutEntry($e[$i]['entry']);
				?>


				</p>
				<form method="post" action="/simple_blog/inc/update.inc.php">
					<input type="submit" name="edit" class="button" value="edit" /> <input
						type="submit" name="view" class="button" value="view" /> <input
						type="hidden" name="url" value="<?php echo $e[$i]['url'];?>">
				</form>

			</div>
			<?php if ((count($e)-1)==$i){break;}}?>
			<div class="pagelegend">
				Page:
				<?php for ($i=0;$i<$totalPage;$i++){ ?> <a <?php if (($ipage)==$i){?> id="current"<?php } ?>
					<?php if (($ipage)!=$i){?>href="/simple_blog/page/<?php echo $i+1;?>"<?php }?>><?php echo ($i+1);?> </a>
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
