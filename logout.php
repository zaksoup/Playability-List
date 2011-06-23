<?php

	
		// Initialize the session.
		session_start();
		
		// Unset all of the session variables.
		$_SESSION = array();
		
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}
		
		// Finally, destroy the session.
		session_destroy();
		
		header('Location: signin');
		
		exit;

?>