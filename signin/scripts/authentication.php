<?php

	$dbConnection = new Mongo();
	
	$users = $dbConnection->authtest->users->find();
	
	$uidindex = $dbConnection->authtest->uidindex->find();
	
	$username = trim(stripslashes($_POST['user']));
	$password = trim(stripslashes($_POST['pass']));
	$email = trim(stripslashes($_POST['email']));
	$code = trim(stripslashes($_POST['code']));
	$action = trim(stripslashes($_POST['action']));
		//echo $email;
	
	function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	function authenticate($username, $password)
	{
		
		
		$salt = 'voDeaFWckErOPPGwiapYBwEoc4O2d1M60m2QsYc7A15PUshrLafkljzilLILIDFlIJSFildidjLIDSjsdmoVioG1wUmEgF';
	    
	    global $dbConnection;
	    global $users;
	    
	    foreach($users as $user){
	    
	    	if($user["name"] == $username && $user["password"] == sha1($salt . $password)){
	    	
	    		session_start();
	        	
	        	$_SESSION['username'] = $username;
	        	$_SESSION['password'] = sha1($salt . $password);
	        	
	        	return true;
	        	
	        }else if($user["name"] == $username){
	        
	        	echo "password ";
	        	return false;
	        };
	    };
	    
	    return false;
	    
	};
	
	function checkCode($code){
	
		global $dbConnection;
		
		
		foreach($dbConnection->authtest->codes->find(array("code" => $code)) as $bcode){
		
			if($bcode['code'] == $code){
				
				return true;
			}else{
		
				echo "code ";
				return false;
			};
		};
	
	};
	
	
	function addUser($username, $password, $email){
	
		global $dbConnection;
		
		global $code;
		
	    $salt = 'voDeaFWckErOPPGwiapYBwEoc4O2d1M60m2QsYc7A15PUshrLafkljzilLILIDFlIJSFildidjLIDSjsdmoVioG1wUmEgF';
	
	    $username = preg_replace('/\r|\n|\:/', '', $username);
	
	    $password = sha1($salt . $password);
	    
	    if(!(isValidEmail($email))){
	    	echo "email ";
	    	return false;
	    };
	    
	    foreach($dbConnection->authtest->users->find(array('name' => $username)) as $user){
			if($user['name']==$username){
				echo "name ";
				return false;
			};
		};
		
		foreach($dbConnection->authtest->users->find(array('email' => $email)) as $user){
		
			if($user['email']==$email){
				echo "email ";
				return false;
			};
		};
		
		$dbConnection->authtest->users->insert(array('name' => $username, 'password' => $password, 'email' => $email));
		$dbConnection->authtest->codes->remove(array("code" => $code));
		
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