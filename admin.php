<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link
	rel="stylesheet" type="text/css" href="/simple_blog/global.css">
<link rel="alternate" type="application/rss+xml"
title="My Simple Blog - RSS 2.0"
href="/simple_blog/feeds/rss.php" />
<title>My Blog</title>

</head>
<body>

<?php
include_once 'inc/function.inc.php';
headerCreate();
if (isset($_GET['page'])){
	include_once 'inc/function.inc.php';
	include_once 'inc/db.inc.php';
	$db = new PDO(DB_INFO, DB_USER, DB_PASS);
	$url = (isset($_GET['url'])) ? (int) $_GET['url'] : NULL;
	$e = retrieveEntries($db,$url,$_GET['page']);
	$e = sanitiseData($e);
	$fulldis = array_pop($e);
	$bvalue = "edit";
	$image=$e['image'];
	$text= $e['entry'];
	$title = $e['title'];
}else{
	$text= ("What's on your mind?");
	$bvalue = "post";
	$image="/simple_blog/img/no_img.jpg";}?>
	<div class="body">
	<?php if (isset($_GET['page'])){
		?>
		<h1>Edit</h1>
		<?php
	} else {
		?>
		<h1>New Entry</h1>
		<?php
	}?>
		<div class="container">
			<div class="entry">
				<form class="entry" method="post" action="/simple_blog/inc/update.inc.php"
					enctype="multipart/form-data">
					<fieldset>
						<label>Title <br> <input type="text" name="title" maxlength="150"
							style="width: 70%;"
							value="<?php if (isset($_GET['page'])){ echo $title;}?>" /> </label>
						<br>
						<div class="upload">
							<label>Image <br> <?php 
								list($width,$height) = getimagesize($_SERVER['DOCUMENT_ROOT'].$image);?> <img class="edit" alt=""
					src="<?php echo $image?>" width="<?php echo (width*(100/$height))?>" height="100" /> <input
								type="file" name="image" /> </label>
						</div>
						<label>Entry <textarea name="wall" class="text" rows="15"><?php echo $text;?>
							</textarea><br> </label>
							<?php if (isset($_GET['page'])){?>
						<input type="hidden" name="url" value="<?php echo $e['url'];?>">
						<?php }?>
						<input type="submit" name="post" class="button"
							value="<?php echo $bvalue; ?>" />
							<?php if (isset($_GET['page'])){?>
						<input type="submit" name="del" class="button" value="delete" />
						<?php }?>
						<input type="submit" name="cancel" class="button" value="cancel" />
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>
