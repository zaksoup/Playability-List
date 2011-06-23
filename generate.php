<?php

session_start();

if(!$_SESSION['username']=='Zaksoup'){
	header('Location: signin');
};

$dbConnection = new Mongo("mongodb://zaksoup:m545b;FedorA@flame.mongohq.com:27097/playability");

$codes = $dbConnection->playability->codes->find();

function genRandomString() {
	
	global $dbConnection;
	
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    
    echo $string . "<br />";
    $dbConnection->playability->codes->insert(array('code' => $string));
	    
    
};

$dbConnection->playability->codes->remove(array('code' => 'abc'));

if($_GET['generate']=='true')
	genRandomString();

foreach($codes as $code){

	echo $code['code'] . "<br />";

}

?>