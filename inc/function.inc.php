<?php
function retrieveEntries($db, $url=NULL, $page='entry')
{
	$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5, 'noEntry'=>6);
	if ($page=='index'||$page=='edit'){
		$table='entry';
	}else {
		$table=$page;
	}

	$sql = "SELECT id FROM ".$table;
	if (!$db->query($sql)){
		$e=array('title'=>"No page",
		'entry'=>"This page does not exist!",'created'=>NULL);
		$fulldisp=$dis['noPage'];
	}

	else{
		/*
		 * If an entry url was supplied, load the associated entry
		 */
		if(isset($url))
		{
			// Load specified entry
			$sql="SELECT * FROM ".$table." WHERE url =? LIMIT 1";;
			$stm = $db->prepare($sql);
			$stm->execute(array($_GET['url']));
				
			$e = $stm->fetch();
			if ($page=="edit"){
				$fulldisp=$dis['edit'];
			} else{
				$fulldisp=$dis['singleWall'];
			}
			// Set the fulldisp flag for single entry
			if ($e==''){
				$e=array('title'=>"Invalid url",
							'entry'=>"This entry does not exist!",
							'created'=>NULL);
				$fulldisp=$dis['invalid'];
			}
				
		}
		/*
		 * If no entry ID was supplied, load all entry titles
		 */
		else{
				
			if ($page=="user"){
				$fulldisp =$dis['about'];

				// Load all entry
				$sql="SELECT * FROM ".$table;

				foreach($db->query($sql) as $row){
					$e[] = $row;
				}
			}elseif ($page=="index"||$page=="entry"){
				$fulldisp =$dis['allWall'];
					
				// Load all entry
				$sql="SELECT * FROM ".$table." ORDER BY created DESC";

				foreach($db->query($sql) as $row){
					$e[] = $row;
				}
					
			}
		}
		if (!isset($e)){
			$e = array('entry'=>"There is no entry! Please <a href= 'http://localhost/simple_blog/admin'>post something</a>! " 
			,'created'=>NULL,'title'=>"Welcome to tBlog!",'image'=>("/simple_blog/img/no_img.jpg"));
			$fulldisp=$dis['noEntry'];
		}
	}

	array_push($e, $fulldisp);
	return $e;
}
function sanitiseData($data)
{
	// If $data is not an array, run strip_tags()
	if(!is_array($data))
	{
		// Remove all tags except <a> tags
		return strip_tags($data, "<a>");
	}
	// If $data is an array, process each element
	else
	{
		// Call sanitizeData recursively for each array element
		return array_map('sanitiseData', $data);
	}
}
function headerCreate (){
	?> <div align="center"><img src="/simple_blog/img/bg.jpg" class="bg"></div>
	<div class="wrap">
<div class="header">
	<h3 class="header">tBlog</h3>
	<div class="navi">
		<ul class="navi" >
			<li class="navi"> <a class="navi" href="/simple_blog/user">About Author</a>
			<li class="navi">|
			<li class="navi"> <a class="navi" href="/simple_blog/">Blog</a>
			<li class="navi">|
			<li class="navi"> <a class="navi" href="/simple_blog/admin">New Entry</a>
		</ul>
	</div>
</div><?php 
}
function makeUrl($title)
{
$patterns = array(
'/\s+/',
'/(?!-)\W+/'
);
$replacements = array('-', '');
return preg_replace($patterns, $replacements, strtolower($title));
}
function cutEntry ($entry,$position=500){
$str =  (substr( $entry,0 , $position ));
					
				if (strrpos($str, "<")>strrpos($str, "</")){
					$str1 =  (substr( $str,0 , strrpos($str, "<")));
				} else {
					$str1 =  (substr( $str,0 , strrpos($str, " ") ));
				}
				if (strlen($str)<$position){
					return nl2br($str);
				}else { return nl2br($str1)."...";}
}

?>