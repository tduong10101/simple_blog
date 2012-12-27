<?php
function retrieveEntries($db, $id=NULL, $page)
{	
	$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4,'edit'=>5);
	if ($page=='index'||$page=='edit'){
		$table='entry';
	}else {
		$table=$page;
	}
	
	$sql = "SELECT id FROM ".$table;
	if (!$db->query($sql)){
		$e=array('entry'=>"This page is not exist");
				$fulldisp=$dis['noPage'];
	}
	
	else{
		/*
		* If an entry ID was supplied, load the associated entry
		*/
		if(isset($id))
		{
			// Load specified entry
			$sql="SELECT * FROM ".$table." WHERE id =? LIMIT 1";;
			$stm = $db->prepare($sql);
			$stm->execute(array($_GET['id']));
			
			$e = $stm->fetch();
			if ($page=="edit"){
				$fulldisp=$dis['edit'];
			} else{
				$fulldisp=$dis['singleWall'];
			}
			// Set the fulldisp flag for single entry
			if ($e==''){
				$e=array('entry'=>"Invalid id");
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
			}elseif ($page=="index"){
				$fulldisp =$dis['allWall'];
			
				// Load all entry
				$sql="SELECT * FROM ".$table." ORDER BY created DESC";
				
				foreach($db->query($sql) as $row){
					$e[] = $row;
				}
			
			}
		}
		if (!isset($e)){
			$e = array('entry'=>"There is no entry! Please post something!");
			$fulldisp=$dis['invalid'];
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
?>