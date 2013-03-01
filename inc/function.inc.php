<?php
function disableMagicQuote(){
	if (get_magic_quotes_gpc()) {
		$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
		while (list($key, $val) = each($process)) {
			foreach ($val as $k => $v) {
				unset($process[$key][$k]);
				if (is_array($v)) {
					$process[$key][stripslashes($k)] = $v;
					$process[] = &$process[$key][stripslashes($k)];
				} else {
					$process[$key][stripslashes($k)] = stripslashes($v);
				}
			}
		}
		unset($process);
	}
}

function retrieveEntries($db, $url=NULL, $page='entry')
{
	$dis = array('main'=>0,'entry'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5, 'noEntry'=>6);
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
				$fulldisp=$dis['entry'];
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
				$fulldisp =$dis['main'];
					
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

	//if entry is shorter than setted main entry display full entry
	if (strlen($entry)<$position){
		return nl2br($entry);
	}else { 
		$str =  substr( $entry,0 , $position );
		if (strrpos($str, "<a")>strrpos($str, "</")){
			$str1 =  trim(substr( $str,0 , strrpos($str, "<a")));
		} else {
			$str1 =  trim( $str);
		}
		return nl2br($str1)."...";
	}
}
function createUserForm()
{
	return <<<FORM
<form action="/simple_blog/inc/update.inc.php" method="post">
<fieldset>
<h3>Create User</h3>
<label>Username
<input type="text" name="username" maxlength="75" />
</label>
<label>Password
<input type="password" name="password" />
</label>
<input type="submit" name="submit" value="Create" class="button"/>
<input type="submit" name="submit" value="Cancel" class="button"/>
<input type="hidden" name="action" value="createuser" />
</fieldset>
</form>
FORM;
}
?>