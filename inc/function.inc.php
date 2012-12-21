<?php
function retrieveEntries($db, $id=NULL, $page)
{	
	$dis = array('allWall'=>0,'singleWall'=>1, 'invalid'=>2,'about'=>3,'noPage'=>4);
	$sql = "SELECT page FROM wall WHERE page=?";
	$stm=$db->prepare($sql);
	$stm->execute(array($page));
	$p = $stm->fetch();
	
	if ($p['page']==''){
		$e = array('entry'=>"no page exist");
		$fulldisp=$dis['noPage'];
	}
	
	else{
		/*
		* If an entry ID was supplied, load the associated entry
		*/
		if(isset($id))
		{
			// Load specified entry
			$sql="SELECT entry, id FROM wall WHERE id =? LIMIT 1";;
			$stm = $db->prepare($sql);
			$stm->execute(array($_GET['id']));
			
			$e = $stm->fetch();
			
			$fulldisp=$dis['singleWall'];
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
			if ($p['page']=="about"){
				$fulldisp =$dis['about'];
				
				// Load all entry
				$sql="SELECT entry, id FROM wall WHERE page=? ORDER BY created ASC";
				$stm = $db->prepare($sql);
				$stm->execute(array($page));
				foreach($stm as $row){
					$e[] = array ('entry'=>$row['entry'],
									'id'=>$row['id']);
				}
			}elseif ($p['page']=="index"){
				$fulldisp =$dis['allWall'];
			
				// Load all entry
				$sql="SELECT entry, id FROM wall WHERE page=? ORDER BY created DESC";
				$stm = $db->prepare($sql);
				$stm->execute(array($page));
				foreach($stm as $row){
					$e[] = array ('entry'=>$row['entry'],
									'id'=>$row['id']);
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