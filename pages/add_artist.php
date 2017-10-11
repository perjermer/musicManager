<?php
	$title = "Add Artist";
	include('../templates/header.php');
	$type = "artist";
	echo "<script src=\"../assets/js/validate_" . $type . ".js\"></script>";
	include('../functions.php');
?>

<fieldset> <!-- form to add artist to the database -->
	<legend>Add Artist</legend>
  <form class="artist-name" action="add_artist.php" method="post" onsubmit="return validate(this)">
  	<input type="text" name="name" size="30" maxlength="50" placeholder="Enter artist name..." pattern="[a-zA-Z0-9$_/'\s&]{3,}" title="Please enter a minimum of 3 characters for the artist.">
    <input class="button" type="submit" name="submit" value="Add Artist">
  </form>
	<button class="button" type="button" name="button"><a href="artists.php">Back</a></button>
</fieldset>

<?php

  //if post method is called
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $problem = FALSE;
    if (!empty($_POST['name'])) { //if artist name bar is filled in then store the string
      $artist = trim(strip_tags($_POST['name']));
    }
    else { //if no name entered then return error
      print '<p style="color: red;">Please enter an artist name</p>';
      $problem = TRUE;
    }

    //if no problem
    if (!$problem) {
      include '../db.php'; //include database connection

      add_artist($conn, $artist); //add artist to database

      mysqli_close($conn); //close the database connection

			header("Location: artists.php");
    }
  }
?>

<?php
	include('../templates/footer.html');
?>
