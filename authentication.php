<?php

	$dbConnection = new Mongo();
	
	$users = $dbConnection->playability->users->find();
	
	//$uidindex = $dbConnection->playability->uidindex->find();
	
	$username = trim(stripslashes($_POST['user']));
	$password = trim(stripslashes($_POST['pass']));
	$email = trim(stripslashes($_POST['email']));
	$code = trim(stripslashes($_POST['code']));
	$action = trim(stripslashes($_POST['action']));
	$first = $dbConnection->playability-> //add stuff for has been in stalled here
		//echo $email;
	
	function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	function authenticate($username, $password)
	{ 
		$salt  = 'abcdzak123';
	    
	    global $dbConnection;
	    $findusers = $dbConnection->playability->users->find(array('name'=>new MongoRegex('/^'.$username.'$/i')));
	    if(isset($findusers)){
	    
		    foreach($findusers as $user){
		    
		    	if(strtolower($user["name"]) == strtolower($username) && $user["password"] == sha1($salt . $password)){
		    	
		    		session_start();
		        	
		        	$_SESSION['username'] = $user['name'];
		        	$_SESSION['password'] = sha1($salt . $password);
		        	
		        	return true;
		        	
		        }else if(strtolower($user["name"]) == strtolower($username)){
		        
		        	echo "password ";
		        	return false;
		        }else{
		        	echo "no user ";
		        	return false;
		        };
		    };
		    
		}else{
			echo "no user ";
			return false;
		};
	    
	    echo "no user ";
	    return false;
	    
	};
	
	function checkCode($code){
	
		global $dbConnection;
		
		
		foreach($dbConnection->playability->codes->find(array("code" => $code)) as $bcode){
		
			if($bcode['code'] == $code){
				
				return true;
			}else{
		
				echo "code ";
				return false;
			};
		};
	
	};
	
	
	function addUser($username, $password, $email, $first){
	
		global $dbConnection;
		
		global $code;
		
	    $salt = 'abcdzak123';
	
	    $username = preg_replace('/\r|\n|\:/', '', $username);
	
	    $password = sha1($salt . $password);
	    
	    if(!(isValidEmail($email))){
	    	echo "email ";
	    	return false;
	    };
	    
	    foreach($dbConnection->playability->users->find(array('name' => $username)) as $user){
			if($user['name']==$username){
				echo "name ";
				return false;
			};
		};
		
		foreach($dbConnection->playability->users->find(array('email' => $email)) as $user){
		
			if($user['email']==$email){
				echo "email ";
				return false;
			};
		};
		
		$dbConnection->playability->users->insert(array('name' => $username, 'password' => $password, 'email' => $email));
		$dbConnection->playability->codes->remove(array("code" => $code));
		
		return true;
		
	};
	
	//echo $email;
	
	
	
	if($action == "add"){
		
		if(checkCode($code)){
	
			if(addUser($username, $password, $email)){
			
				echo "success";
				
			}else{
			
				echo "fail";
				
			};
		}else{
		
			echo "fail";
			
		};
		
	}else if($action == "auth"){
	
		//echo $username . $password;
		if(authenticate($username, $password)){
			echo "success";
			
		}else{
		
			echo "fail";
			
		};
		
	};
		

?>