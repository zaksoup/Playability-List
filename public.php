<?php

$publicView = $_GET['public'];

$publicView = new MongoRegex('/^'.$publicView.'$/i');

$dbConnection = new Mongo("mongodb://zaksoup:m545b;FedorA@flame.mongohq.com:27097/playability");
//$dbConnection = new Mongo();

$users = iterator_to_array($dbConnection->playability->users->find(array('name'=>$publicView)));

if(empty($users)){

	header("Location: http://playability.me");

}

$unplayed = $dbConnection->playability->unplayed;

$unbeaten = $dbConnection->playability->unbeaten;

$beaten = $dbConnection->playability->beaten;

$abandoned = $dbConnection->playability->abandoned;

$quips = $dbConnection->playability->quips;

$unplayedGames = $unplayed->find(array('user' => $publicView));

$unbeatenGames = $unbeaten->find(array('user' => $publicView));

$beatenGames = $beaten->find(array('user' => $publicView));

$abandonedGames = $abandoned->find(array('user' => $publicView));

$quipsList = $quips->find(array('user' => $publicView));



function getQuips($type) {

	global $quipsList;

	foreach ($quipsList as $quip){
	
	$unplayedQuip = $quip[$type];

	echo ' <p>' . $unplayedQuip . '</p>';
	
	}

}

function logInOut() {

if (!(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret']))) {
    echo '<a class="login" href="clearsessions.php">log out</a>';
}else{

	echo '<a class="login" href="login.php">login or signup</a>';

}

}

function getGames($type, $category) {

	
	
	foreach ($type as $game) {
	
		$name = $game['name'];
		$platform = $game['platform'];
		$note = $game['note'];
		
		
		
		echo " <li>" . $name . "  <span>" . $platform . "</span><span>" . $note . "</span></li>";
	
	}

}


?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Playability</title>
<meta name="viewport" content="width=320, initial-scale=1, minimum-scale=0.45" />
<link rel="stylesheet" type="text/css" media="screen" href="styles/style.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>
<script src="scripts/scripts.js" type="text/javascript"></script>
</head>
<body>
<div>
<h1>Unplayed<span class="unplayed new"><a href="#">+</a></span></h1>


<?php getQuips('unplayed'); getGames($unplayedGames, 'unplayed');?>
</div>

<div>
<h1>Unbeaten<span class="unbeaten new"><a href="#">+</a></span></h1>


<?php getQuips('unbeaten'); getGames($unbeatenGames, 'unbeaten');?>
</div>

<div>
<h1>Beaten<span class="beaten new"><a href="#">+</a></span></h1>

<?php getQuips('beaten'); getGames($beatenGames, 'beaten');?>
</div>

<div>
<h1>Abandoned<span class="abandoned new"><a href="#">+</a></span></h1>


<?php getQuips('abandoned'); getGames($abandonedGames, 'abandoned');?>
</div>

<div id="footer"><a href="http://shauninman.com/">Shaun Inman</a> gave me this idea. Powered by <a href="http://www.google.com/search?q=love">&#9829;</a> , <a href="http://www.mongodb.org/"><img style="width : 7px; height : 14px; position: relative; top: 2px;" src="images/mongoleaf.png" /></a> , <a href="http://mongohq.com"><img style="width : 12px; height : 12px; position: relative; top: 1px;" src="images/mongohq.png" /></a> , <a href="http://zaksoup.com"><img style="width:15px;height:11px;" src="images/cupa.png" /></a> , and a <a href="http://support.apple.com/kb/sp13"><img style="position:relative;top:3px;" src="images/mbp.png" /></a> . <a href="http://shauninman.com/archive/2011/04/18/unplayed">More info</a></div>

</body>
</html>