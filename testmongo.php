<?php

	$dbConnection = new Mongo();
	
	$users = $dbConnection->playability->users->find();
	
	$uidindex = $dbConnection->playability->uidindex->find();

	$username = "j";

	$findusers = $dbConnection->playability->users->find(array('name'=>new MongoRegex('/'.$username.'/i')));

	
	foreach($findusers as $user){
	if($user["name"]==$username){
		print_r($user['name']);
		echo "<br />";
	}}
	
?>