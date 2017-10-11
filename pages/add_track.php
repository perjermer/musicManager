<?php
	$title = "Add Track";
	include('../templates/header.php');
	$type = "track";
	echo "<script src=\"../assets/js/validate_" . $type . ".js\"></script>";
	include('../functions.php');
?>

	<fieldset> <!-- form to add track to database -->
	  <form class="track-name" action="add_track.php" method="post" onsubmit="return validate(this)">
	  	<p>Track name:</p>
	    <input class="form-group" type="text" name="name" size="30" maxlength="50" placeholder="Enter track name..." pattern="[a-zA-Z0-9$_/'.\s&]{3,}" title="Please enter a minimum of 3 characters for the track.">
	    <?php
	      echo '<p>Select CD:</p><select class="form-group" name="CD">
	            <option value=0>Select option</option>';
	      include '../db.php'; //include database connection
	      $query = "SELECT cdTitle, cdID FROM CD ORDER BY cdTitle";

	      if ($r = mysqli_query($conn, $query)) { //display each CD in the CD table
	        while ($row = mysqli_fetch_array($r)) {
	          print "<option value='{$row['cdID']}'>{$row['cdTitle']}</option>";
	        }
	      }
	      mysqli_close($conn);
	    echo '</select><br>';
	    ?>
	    <p>Track Length:</p>
	    <input class="form-group" type="number" min=0 name="length" size="30" maxlength="50" placeholder="Enter track length..." pattern="[0-9]{0,}" title="Please enter integer numbers for the title length.">
			<p>Seconds</p>
	    <input class="form-group button" type="submit" name="submit" value="Add Track">
			<button class="button" type="button" name="button"><a href="tracks.php">Back</a></button>
	  </form>
	</fieldset>

<?php
  //if post method is called
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $problem = FALSE;

    if (!empty($_POST['name'])) { //if artist name bar is filled in then store the string
      $track = trim(strip_tags($_POST['name']));
		} else { //if no name entered then return error
			print '<p style="color: red;">Please enter a track name</p>';
			$problem = TRUE;
		}

    if ($_POST['CD'] != 0){ //if CD selected
      $cdID = $_POST['CD'];
		} else { //if no CD selected
			print '<p style="color: red;">Please select a CD</p>';
			$problem = TRUE;
		}

		if (trim(strip_tags($_POST['length'])) != ''){ //if length entered
      $length = trim(strip_tags($_POST['length']));
    } else { //if no length entered
      print '<p style="color: red;">Please enter a track length</p>';
      $problem = TRUE;
    }

    //if no problem
    if (!$problem) {
      include '../db.php'; //include database connection

      add_track($conn, $track, $cdID, $length); //add track to database

      mysqli_close($conn); //close the database connection

			header('Location: tracks.php');
    }
  }

	include('../templates/footer.html');
?>
