<?php
function retrieveEntries($db, $id=NULL)
{
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
		$fulldisp=1;
		// Set the fulldisp flag for single entry
		if (!is_array($e)){
			$e=array('entry'=>"Invalid id");
			$fulldisp=2;
		}
		
	}
	/*
	* If no entry ID was supplied, load all entry titles
	*/
	else
	{
		// Load all entry
		$sql="SELECT entry, id FROM wall ORDER BY created DESC";
		foreach($db->query($sql)as $row){
			$e[] = array ('entry'=>$row['entry'],
							'id'=>$row['id']);
		}
		// Set the fulldisp flag for multiple entries
		$fulldisp = 0;
	}
	if (!isset($e)){
		$e = array('entry'=>"There is no entry! Please post something!");
		$fulldisp=2;
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