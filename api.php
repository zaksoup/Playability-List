<?php

	session_start();

	$dbConnection = new Mongo("mongodb://zaksoup:m545b;FedorA@flame.mongohq.com:27097/playability");

	//$dbConnection = new Mongo();
	
	$users = $dbConnection->playability->users;
	$unplayed = $dbConnection->playability->unplayed;
	$unbeaten = $dbConnection->playability->unbeaten;
	$beaten = $dbConnection->playability->beaten;
	$abandoned = $dbConnection->playability->abandoned;
	$quips = $dbConnection->playability->quips;


	$action = $_POST['action'];
	

	session_start();
	
	function getGames($type, $category) {
	
		$games = '';
		
		foreach ($type as $game) {
		
			$name = $game['name'];
			$platform = $game['platform'];
			$note = $game['note'];
			
			
			
			$games .= " <li>" . $name . " <a href=\"remove.php?id=" . $game['_id'] . "&category=" . $category . "\"><span class='deleteButton'>&#x2716;</span></a> <span>" . $platform . "</span><span>" . $note . "</span></li>";
			echo $games;
			
		}
	
	}
	
	if($action == 'add'){
	
		if(addGame()){
			echo "success";
		}else{
			echo "fail";
		};
	
	};
	if($action == 'remove'){
	
		if(removeGame()){
			
			echo "success";
		
		}else{
		
			echo "fail";
		
		};
	
	};
	if($action == 'read'){
	
		getGames($_POST['type'], $_POST['category']);
	
	
	};
	
	function addGame(){
	
			global $dbConnection;
			
	
			$name = Trim(stripslashes($_POST['name']));
			$platform = Trim(stripslashes($_POST['platform']));
			$note = Trim(stripslashes($_POST['note']));
			$category = $_POST['category'];
			$user = $_SESSION['username'];

			$game = iterator_to_array($dbConnection->playability->$category->find(array('name'=>$name, 'user'=>$user)));
			
			if(!empty($game)){
				return false;
			};
		
			$dbConnection->playability->$category->insert(array('name' => $name, 'platform' => $platform, 'note' => $note, 'user' => $user));
			
			return true;
	
	};
	
	function removeGame(){
	
			global $dbConnection;
	
			$name = Trim(stripslashes($_POST['name']));
			$category = $_POST['category'];
			$user = $_SESSION['username'];
			
			$dbConnection->playability->$category->remove(array('name' => $name, 'user' => $user));
			
			return true;
	
	};


?>