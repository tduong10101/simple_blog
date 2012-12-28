<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="global.css">
<title>My Blog</title>

</head>
<body>
	
<?php 
	include_once '/inc/header.inc.php';				
	if (isset($_GET['page'])){
				include_once 'inc/function.inc.php';
				include_once 'inc/db.inc.php';
				$db = new PDO(DB_INFO, DB_USER, DB_PASS);
				$id = (isset($_GET['id'])) ? (int) $_GET['id'] : NULL;
				$e = retrieveEntries($db,$id,$_GET['page']);
				$e = sanitiseData($e);
				$text= $e['entry'];
				$title = $e['title'];
				$fulldis = array_pop($e);
				$bvalue = "edit";
	}else{
						$text= ("What's on your mind?");
						$bvalue = "post";}?>
<div class="body">
	<?php if (isset($_GET['page'])){
		?> <h1>Edit</h1><?php
	} else {
		?> <h1>New Entry</h1><?php
	}?>
	<div class="container">
		<div class="entry">
			<form class="entry" method="post" action="inc/update.inc.php" enctype="multipart/form-data">
				<fieldset>
					<label>Title
					<br>
					<input type="text" name="title" maxlength="150" style="width:70%;" value="<?php if (isset($_GET['page'])){ echo $title;}?>"/>
					</label>
					<br>
					<label>Image
					<br>
						<input type="file" name="image"/>
					</label>
					<br>
					<label>Entry
						<textarea name="wall" class="text" rows="15"><?php echo $text;?></textarea><br>
					</label>
					<?php if (isset($_GET['page'])){?>
					<input type="hidden" name="id" value="<?php echo $e['id'];?>"><?php }?>
					<input type="submit" name="post" class="button" value="<?php echo $bvalue; ?>" />
					<?php if (isset($_GET['page'])){?><input type="submit" name="del" class="button" value="delete" /><?php }?>
					<input type="submit" name="cancel" class="button" value="cancel" />
				</fieldset>
			</form>
		</div>
	</div>
</div>
</div>
</body>