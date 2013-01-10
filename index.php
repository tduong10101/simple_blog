<?php 
session_start();
?>
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
		foreach($e as $entries){ 
		$absPath = '/home/a6944098/public_html'."/simple_blog/img/t.jpg";?>
		<div class="container">
			<div class="entry"><?php list($width,$height) = getimagesize($absPath);?> 
			<img class="main" alt="" src="/simple_blog/img/t.jpg" width="<?php echo ($width*(200/$height))?>px" height="200px" />
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
				<?php if(($fulldis == $dis['entry'])&&(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1)){?>
					<input type="submit" name="edit" class="button" value="Edit" />
					<?php }?>
					<input type="submit" name="back" class="button" value="Back" /> <input
						type="hidden" name="url" value="<?php echo $e['url'];?>">
				</fieldset>
				</form>
			</div>	
			<?php } } elseif ($fulldis==$dis['main']){
				//display 4 entry in a page
				$numbEntry=4;
				$totalPage= ceil(count($e)/$numbEntry);
				if (!isset($_GET['ipage'])||($_GET['ipage']>$totalPage)){
					$ipage = 0;
				} else {
					$ipage = $_GET['ipage']-1;
				}

				$sloop=$ipage*$numbEntry;
				$eloop=($ipage+1)*$numbEntry;
				for($i=$sloop;$i<$eloop;$i++){ ?>
			<div class="entry">

				<h2>
				<a class="title" href="/simple_blog/blog/<?php echo $e[$i]['url'];?>"><?php echo $e[$i]['title']; ?></a>
				</h2>
				<span class="created">created on: <?php 
				echo date("l jS F , Y, g:i a", strtotime($e[$i]['created']));?> 
				</span> 
				<br> 
				<?php $Path = '/home/a6944098/public_html'.$e[$i]['image'];?>
				<?php list($width,$height) = getimagesize($Path);
						$width = ($width*(150/$height));?>
				<img class="main" alt=""
					src="<?php echo $e[$i]['image']?>" width="<?php echo $width;?>px" height="150px" />
				<p>

				<?php echo cutEntry($e[$i]['entry']);
				?>


				</p>
				<form method="post" action="/simple_blog/inc/update.inc.php">
					<fieldset>
					<?php  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1){ ?>
					<input type="submit" name="edit" class="button" value="Edit" /> <?php }?> 
					<input type="submit" name="view" class="button" value="View" /> 
					<input type="hidden" name="url" value="<?php echo $e[$i]['url'];?>">
					<input type="hidden" name="ipage" value="<?php echo $_GET['ipage'];?>">
				</fieldset></form>

			</div>
			<?php if ((count($e)-1)==$i){break;}}?>
			<div class="pagelegend">
				Page:
				<?php 
				if (!isset($_GET['ipage'])){
					$_GET['ipage']=1;
				} 
				$sloop = $_GET['ipage']-3;
				$loop = $_GET['ipage']+3;
				if ($loop>$totalPage){
					$sloop=$_GET['ipage']-5;
				}
				if ($sloop<0){
					$sloop=0;
					$loop = $loop+abs($_GET['ipage']-3);
				}
				if ($_GET['ipage']>1){
					?><a href="/simple_blog/">first</a><?php
								}
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
						<?php  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1){ ?>
						<input type="submit" name="delete_comment" value="Delete" class="button"/><?php }?>
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
