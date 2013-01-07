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

$dis = array('main'=>0,'entry'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5,'noEntry'=>6);
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

	
	<div class="container" id="right"> 
		<a  href="/simple_blog/feeds/rss.php"><img src="/simple_blog/img/rss.png" /></a> <a class="link"  href="/simple_blog/feeds/rss.php">feed me </a>
		<br>
		<a  href="http://www.facebook.com/tduong10101"><img src="/simple_blog/img/facebook.png" /></a> <a class="link"  href="http://www.facebook.com/tduong10101">like me </a>
		<br>
		<a  href="https://twitter.com/Terry_Duong"><img src="/simple_blog/img/twitter.png" /></a> <a class="link"  href="https://twitter.com/Terry_Duong">follow me </a>
		<br>
		<a  href="http://www.linkedin.com/profile/view?id=221700470"><img src="/simple_blog/img/linkedin.png" /></a> <a class="link"  href="http://www.linkedin.com/profile/view?id=221700470"> connect me </a>
		<br>
		<a  href="https://github.com/tduong10101"><img src="/simple_blog/img/github.png" /></a> <a class="link"  href="https://github.com/tduong10101"> watch me </a>
	</div>
<?php if ($fulldis==$dis['about']){

	?>
	<div class="body">
		<h1>About Author</h1>
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
		
			<h1>Error</h1>
		
		<?php } else{?>
		
			<h1>Blog</h1>
		<?php }?>
		<div class="container">
		<?php
		if($fulldis == $dis['entry']||$fulldis == $dis['invalid']||$fulldis == $dis['noPage']||$fulldis == $dis['noEntry']){
			?>
			<div class="entry">
				<h2>
				<?php echo $e['title']; ?>
				</h2>
				<?php if ($fulldis == $dis['entry']){?><span class="created">created on: <?php 
				echo date("l jS F , Y, g:i a", strtotime($e['created']));?></span><?php }?>
				<?php if($fulldis == $dis['entry']&&$e['image']!="/simple_blog/img/no_img.jpg"){?>
				<img class="main" alt="" src="<?php echo $e['image']?>" />
				<?php }?>
				<br>
				<p class="entry">
				<?php echo nl2br($e['entry']);
				?>
				</p>
				<?php if($fulldis != $dis['noEntry']){?>
				<form method="post" action="/simple_blog/inc/update.inc.php"><fieldset>
				<?php if($fulldis == $dis['entry']){?>
					<input type="submit" name="edit" class="button" value="edit" />
					<?php }?>
					<input type="submit" name="back" class="button" value="back" /> <input
						type="hidden" name="url" value="<?php echo $e['url'];?>">
				</fieldset>
				</form>
			</div>	
			<?php } } elseif ($fulldis==$dis['main']){
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
					<fieldset><input type="submit" name="edit" class="button" value="edit" /> <input
						type="submit" name="view" class="button" value="view" /> <input
						type="hidden" name="url" value="<?php echo $e[$i]['url'];?>">
				</fieldset></form>

			</div>
			<?php if ((count($e)-1)==$i){break;}}?>
			<div class="pagelegend">
				Page:
				<?php 
				if (!isset($_GET['ipage'])){
					$_GET['ipage']=1;
				} 
				if ($_GET['ipage']==1) {
					$d=1;	
				} else{ 
					if ($_GET['ipage']==2){
						$d=2;
					}
					else if ($_GET['ipage']>2){
						$d = 3;
					} if ($_GET['ipage']>5){
						if ($totalPage-$_GET['ipage']==1){
							$d = 4;
						} else if ($totalPage-$_GET['ipage']==0){
							$d = 5;
						}
					}
					?><a href="/simple_blog/">first</a><?php
				}
				$sloop = ($_GET['ipage']-$d);
				$loop = ($_GET['ipage']-$d)+5;
				for ($i=$sloop;$i<$loop;$i++){ ?> <a <?php if ($ipage==$i){?> id="current"<?php } 
					if( $i == $totalPage){
						break;
					}?>
					
					<?php if ($ipage!=$i){?>href="/simple_blog/page/<?php echo $i+1;?>"<?php }?>><?php echo ($i+1);?> </a>
					<?php }	
				if ($_GET['ipage']!=$totalPage){
					?><a href="/simple_blog/page/<?php echo $totalPage;?>">last</a><?php
				}?>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<?php if ($fulldis==$dis["entry"]){
		?><div class="container">
		<div class="entry"><?php
			include_once 'inc/comments.inc.php';
			$comment = new Comments();
			$commentShow = $comment->showCommentForm($e['id']);
			echo $commentShow;
			$c = $comment->retrieveComments($e['id']);?></div>
		</div>
		<div class="container">
			<div class="entry">
				<?php foreach ($c as $cl){?>
				<?php if ($cl['name']!=NULL){?>
				<div id="comment">
					<span id="name">
					<?php
					echo $cl['name'];?></span>
					<span class="date"> Posted on: <?php echo date("l jS F , Y, g:i a", strtotime($cl['date']));?> </span><br>
				</div> <?php }?>
				<p><?php  
				echo $cl['comment'];?><br> </p>
					<?php if ($cl['name']!=NULL){?>
					<form method="post" action="/simple_blog/inc/update.inc.php">
					<fieldset>
						<input type="submit" name="delete_comment" value="delete" class="button"/>
						<input type="hidden" name="cId" value="<?php echo $cl['id'];?>"/>
						<input type="hidden" name="url" value="<?php echo $e['url'];?>"/>
					</fieldset>
					</form><?php
					}
				}?>
			</div>
		</div>
		
			<?php  
		}
}?>
</body>
</html>
