<?php
include_once 'db.inc.php';
class Comments {
	public $db;
	// An array for containing the entries
	public $comments;
	public function __construct(){
		$this->db = new PDO(DB_INFO,DB_USER,DB_PASS);
	}
	public function showCommentForm($blog_id){
		return <<<FORM
				<form action="/simple_blog/inc/update.inc.php"
				method="post" >
				<fieldset>
				<label>Post a Comment:</label>
				<br>
				<label>Name:
				<br>
				<input type="text" name="name" maxlength="75" value="Anonymous"/>
				</label>
				<br>
				<label>Email:
				<br>
				<input type="text" name="email" maxlength="150" value="Anonymous"/>
				</label>
				<br>
				<label>Comment
				<textarea rows="5" class="text"name="comment">Share your thought!</textarea>
				</label>
				<br>
				<input type="hidden" name="blog_id" value="$blog_id" />
				<input type="submit" name="post" class="button" value="Post Comment" />
				<input type="submit" name="post" class="button" value="Cancel" />
				</fieldset>
				</form>
FORM;
	}
	// Save comments to the database
	public function saveComment($p)
	{
		// Sanitize the data and store in variables
		$blog_id = htmlentities(strip_tags($p['blog_id']),ENT_QUOTES);
		$name = htmlentities(strip_tags($p['name']),ENT_QUOTES);
		$email = htmlentities(strip_tags($p['email']),ENT_QUOTES);
		$comment = htmlentities(strip_tags($p['comment']),ENT_QUOTES);
		// Keep formatting of comments and remove extra whitespace
		$comment = nl2br(trim($comment));
		// Generate and prepare the SQL command
		$sql = "INSERT INTO comments (blog_id, name, email, comment)
		VALUES (?, ?, ?, ?)";
		if($stmt = $this->db->prepare($sql))
		{
			// Execute the command, free used memory, and return true
			$stmt->execute(array($blog_id, $name, $email, $comment));
			$stmt->closeCursor();
			return TRUE;
		}
		else
		{
			// If something went wrong, return false
			return FALSE;
		}
	}
	// Load all comments for a blog entry into memory
	public function retrieveComments($blog_id)
	{
		// Get all the comments for the entry
		$sql = "SELECT id, name, email, comment, date
		FROM comments
		WHERE blog_id=?
		ORDER BY date DESC";
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array($blog_id));
		// Loop through returned rows
		while($comment = $stmt->fetch())
		{
			// Store in memory for later use
			$this->comments[] = $comment;
		}
		// Set up a default response if no comments exist
		if(empty($this->comments))
		{
			$this->comments[] = array(
					'id' => NULL,
					'name' => NULL,
					'email' => NULL,
					'comment' => "There are no comments on this entry.",
					'date' => NULL
			);
		}
		return $this->comments;
	}
	// Removes the comment corresponding to $id from the database
	public function deleteComment($id)
	{
		$sql = "DELETE FROM comments
		WHERE id=?
		LIMIT 1";
		if($stmt = $this->db->prepare($sql))
		{
			// Execute the command, free used memory, and return true
			$stmt->execute(array($id));
			$stmt->closeCursor();
			return TRUE;
		}else{
			// If something went wrong, return false
			return FALSE;
		}
	}
	public function deleteAllComment($blog_id)
	{
		$sql = "DELETE FROM comments
		WHERE blog_id=?";
		if($stmt = $this->db->prepare($sql))
		{
			// Execute the command, free used memory, and return true
			$stmt->execute(array($blog_id));
			$stmt->closeCursor();
			return TRUE;
		}else{
			// If something went wrong, return false
			return FALSE;
		}
	}
}

?>