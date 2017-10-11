<?php
	$title = "Add Album";
	include('../templates/header.php');
	$type = "album";
	echo "<script src=\"../assets/js/validate_" . $type . ".js\"></script>";
	include('../functions.php');
?>

	<fieldset> <!-- form to add an album to an artist -->
		<legend>Add Album</legend>
	  <form class="track-name" action="add_album_post.php" method="post" onsubmit="return validate(this)">
	  	<p>Album name:</p>
	    <input class="form-group" type="text" name="name" size="30" maxlength="50" placeholder="Enter album name..." pattern="[a-zA-Z0-9$_/'.\s&]{3,}" title="Please enter a minimum of 3 characters for the album.">
	    <?php

	    $genres = array("Electronica", "Rock", "Electro House", "Alternative Rock", "Pop", "Rap", "Hip-Hop", "Jazz", "Opera", "R&B", "Indie Pop", "Folk", "Country");

	      echo '<p>Select Artist:</p><select class="form-group" name="artist">
	            <option value="na">Select artist</option>';
	      include '../db.php'; //include database connection
	      $query = "SELECT artName FROM Artist";

	      if ($r = mysqli_query($conn, $query)) { // display each artist in select box
	        while ($row = mysqli_fetch_array($r)) {
	          print "<option value='{$row['artName']}'>{$row['artName']}</option>";
	        }
	      }
	      mysqli_close($conn);

	    echo '</select><br>';

	    echo '<p>Select Genre</p><select class="form-group" name="genre">
	          <option value="na">Select genre</option>';
	    for ($x = 0; $x < sizeof($genres); $x++){ //display each genre available
	      echo '<option value=' . $genres[$x] . '>' . $genres[$x] . '</option>';
	    }
	    echo '</select><br>';
	    ?>

	    <p>CD Price (£):</p>
	    <input class="form-group" type="number" step="0.01" min=0 name="price" size="30" maxlength="50" placeholder="Enter CD price..." pattern="[0-9]{1,}[.]{1}[0-9]{1,2}" title="Please enter a valid price.">
	    <input class="form-group button" type="submit" name="submit" value="Add Album">
			<button class="button" type="button" name="button"><a href="albums.php">Back</a></button>
	  </form>
	</fieldset>
