<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($uname,$umail,$upass)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO users(user_name,user_email,user_pass) 
		                                               VALUES(:uname, :umail, :upass)");
												  
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":upass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	public function doLogin($uname,$umail,$upass)
	{
		try
		{
		  //selects user according to $uname or $umail	
          $stmt = $this->conn->prepare("SELECT user_id, user_name, user_email, user_pass FROM users WHERE user_name=:uname OR user_email=:umail ");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          //checking to see if the account exist by fetching with the PDO connection
			if($stmt->rowCount() == 1)
			{
              //if it exist checks to see if the variable $upass from the form input matches the stored password (that is hashed)
				if(password_verify($upass, $userRow['user_pass']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	//only way to be logged in is to have $_SESSION['user_session'] set to $userRow['user_id']meaning that the account exists
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
 //ADDED QUERY FUNCTIONS 
  public function get_owner_info($selected_league_id){
    $league_id = filter_input(INPUT_POST, 'selected_league_id');
    $query = 'SELECT DISTINCT owner_name FROM owners
              WHERE league_id = :league_id';
    try{
      $stmt = $this->conn->prepare($query);
      $stmt->bindValue (':league_id', $league_id);
      $stmt->execute();
      $results = $stmt->fetchAll();
      $stmt->closeCursor();
      /*return $results;*/
    }catch (PDOException $e){
        $error_message = $e->getMessage();
        echo "$error_message";
       }
  }
}
?>