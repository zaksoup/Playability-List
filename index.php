<?php

/* Load required lib files. */
session_start();

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['username']) || empty($_SESSION['password'])) {
    header('Location: ./logout.php');
}


$userName = $_SESSION['username'];


$dbConnection = new Mongo();
//$dbConnection = new Mongo();

$unplayed = $dbConnection->playability->unplayed;

$unbeaten = $dbConnection->playability->unbeaten;

$beaten = $dbConnection->playability->beaten;

$abandoned = $dbConnection->playability->abandoned;

$quips = $dbConnection->playability->quips;

$unplayedGames = $unplayed->find(array('user' => $userName));

$unbeatenGames = $unbeaten->find(array('user' => $userName));

$beatenGames = $beaten->find(array('user' => $userName));

$abandonedGames = $abandoned->find(array('user' => $userName));

$quipsList = $quips->find();

//$dbConnection->playability->abandoned->insert(array('name' => 'New Game', 'platform' => 'Xbox 360', 'note' => 'A test note for a test game'));



function getQuips($type) {

	global $quipsList;

	foreach ($quipsList as $quip){
	
	$unplayedQuip = $quip[$type];

	echo ' <p></p>';
	
	}

}



function getGames($type, $category) {

	
	
	foreach ($type as $game) {
	
		$name = $game['name'];
		$platform = $game['platform'];
		$note = $game['note'];
		
		
		
		echo " <li title=\"".$name."\">" . $name . " <a class=\"delete_link\" href=\"#\"><span class='deleteButton'>&#x2716;</span></a> <span class=\"platform\">" . $platform . "</span><span class=\"note\">" . $note . "</span></li>";
	
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
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js" type="text/javascript"></script>
<script src="scripts/scripts.js" type="text/javascript"></script>
</head>
<body>
<a class="editLink" href="#">edit</a><a class="login" href="logout.php">log out</a>
<div class="category" id="unplayed">
<h1>Unplayed<span class="unplayed new"><a href="#">+</a></span></h1>

<form method="post" action="add.php" id="addUnplayed" class="add">
<input type="text" name="category" value="unplayed" />
<input type="text" name="name" placeholder="Name" />
<input type="text" name="platform" placeholder="Platform" />
<textarea name="note"></textarea><br />
<input type="submit" name="submit" value="+" />
</form>

<?php  getGames($unplayedGames, 'unplayed');?>
</div>

<div class="category" id="unbeaten">
<h1>Unbeaten<span class="unbeaten new"><a href="#">+</a></span></h1>

<form method="post" action="add.php" id="addUnbeaten" class="add">
<input type="text" name="user" value="<?php echo $userName;?>" style="display:none" />
<input type="text" name="category" value="unbeaten" />
<input type="text" name="name" placeholder="Name" />
<input type="text" name="platform" placeholder="Platform" />
<textarea name="note"></textarea><br />
<input type="submit" name="submit" value="+" />
</form>

<?php  getGames($unbeatenGames, 'unbeaten');?>
</div>

<div class="category" id="beaten">
<h1>Beaten<span class="beaten new"><a href="#">+</a></span></h1>

<form method="post" action="add.php" id="addBeaten" class="add">
<input type="text" name="user" value="<?php echo $userName;?>" style="display:none" />
<input type="text" name="category" value="beaten" />
<input type="text" name="name" placeholder="Name" />
<input type="text" name="platform" placeholder="Platform" />
<textarea name="note"></textarea><br />
<input type="submit" name="submit" value="+" />
</form>

<?php  getGames($beatenGames, 'beaten');?>
</div>

<div class="category" id="abandoned">
<h1>Abandoned<span class="abandoned new"><a href="#">+</a></span></h1>

<form method="post" action="add.php" id="addAbandoned" class="add">
<input type="text" name="user" value="<?php echo $userName;?>" style="display:none" />
<input type="text" name="category" value="abandoned" />
<input type="text" name="name" placeholder="Name" />
<input type="text" name="platform" placeholder="Platform" />
<textarea name="note"></textarea><br />
<input type="submit" name="submit" value="+" />
</form>

<?php  getGames($abandonedGames, 'abandoned');?>
</div>

<div id="footer"><a href="http://shauninman.com/">Shaun Inman</a> gave me this idea. Designed by <a href="http://rickiesherman.com/">Rickie Sherman</a>. Powered by <a href="http://www.google.com/search?q=love">&#9829;</a> , <a href="http://www.mongodb.org/"><img style="width : 7px; height : 14px; position: relative; top: 2px;" src="images/mongoleaf.png" /></a> , <a href="http://mongohq.com"><img style="width : 12px; height : 12px; position: relative; top: 1px;" src="images/mongohq.png" /></a> , <a href="http://zaksoup.com"><img style="width:15px;height:11px;" src="images/cupa.png" /></a> , and a <a href="http://support.apple.com/kb/sp13"><img style="position:relative;top:3px;" src="images/mbp.png" /></a> . <a href="http://shauninman.com/archive/2011/04/18/unplayed">More info</a></div>

</body>
</html>