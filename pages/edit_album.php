<?php
	$title = "Edit Album";
	include('../templates/header.php');
	$type = "album";
	echo "<script src=\"../assets/js/validate_" . $type . ".js\"></script>";
	include('../functions.php');
	include '../db.php'; //include database connection

  $album_id = $_GET['cdID'];

	list ($cdTitle, $cdArtist, $cdGenre, $cdPrice, $artID) = get_cd($conn, $album_id);

	mysqli_close($conn);
?>

	<fieldset>
		<legend>Edit Album</legend>
	  <form class="album-name" action="change_album.php?cdID=<?php echo $album_id?>" method="post" onsubmit="return validate(this)">
	  	<p>Album name:</p>
	    <input class="form-group" type="text" name="name" size="30" maxlength="50" value="<?php echo $cdTitle?>" pattern="[a-zA-Z0-9$_/'.\s&]{3,}" title="Please enter a minimum of 3 characters for the album."><br>

			<?php

				$genres = array("Electronica", "Rock", "Electro House", "Alternative Rock", "Pop", "Rap", "Hip-Hop", "Jazz", "Opera", "R&B", "Indie Pop", "Folk", "Country");

				echo '<p>Select Artist:</p><select class="form-group" name="artist">
							<option value=' . $artID . '>' . $cdArtist . '</option>';
				include '../db.php'; //include database connection
				$query = "SELECT artName, artID FROM Artist WHERE artName != '$cdArtist'";

				if ($r = mysqli_query($conn, $query)) { //turn this into a function
					while ($row = mysqli_fetch_array($r)) {
						print "<option value='{$row['artID']}'>{$row['artName']}</option>";
					}
				}
				mysqli_close($conn);
				echo '</select><br>';

				echo '<p>Select Genre</p><select class="form-group" name="genre">
		          <option value=' . $cdGenre . '>' . $cdGenre . '</option>';

		    for ($x = 0; $x < sizeof($genres); $x++){
					if ($genres[$x] != $cdGenre){
		      	echo '<option value="' . $genres[$x] . '">' . $genres[$x] . '</option>';
					}
		    }
		    echo '</select><br>';
				?>

			<p>CD price:</p>
	    <input class="form-group" type="number" min=0 step="0.01" name="price" size="30" maxlength="10" value="<?php echo $cdPrice?>" pattern="[0-9]{1,}[.]{1}[0-9]{1,2}" title="Please enter a valid price."><br>

	    <input class="form-group button" type="submit" name="submit" value="Save">
	    <input class="form-group button" type="submit" name="submit" value="Delete">
			<button class="button" type="button" name="button"><a href="albums.php">Back</a></button>
	  </form>
	</fieldset>

<?php
	include('../templates/footer.html');
?>
