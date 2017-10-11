<?php
	$title = "Edit Track";
	include('../templates/header.php');
	$type = "track";
	echo "<script src=\"../assets/js/validate_" . $type . ".js\"></script>";
	include('../functions.php');

  $track_id = $_GET['tckID'];
  $art_id = $_GET['artID'];

  include '../db.php'; //include database connection

  list ($name, $album, $duration) = get_track($conn, $track_id);
?>

<fieldset>
	<legend>Edit Track</legend>
  <form class="track-name" action="change_track.php?tckID=<?php echo $track_id?>" method="post" onsubmit="return validate(this)">
  	<p>Track name:</p>
    <input class="form-group" type="text" name="name" size="30" maxlength="50" value="<?php echo $name?>" pattern="[a-zA-Z0-9$_/'.\s&]{3,}" title="Please enter a minimum of 3 characters for the track."><br>
    <?php
      echo '<p>Select CD:</p><select class="form-group" name="CD">
            <option value=' . $album .  '>' . $album . '</option>';

      include '../db.php'; //include database connection
      $query = "SELECT cdTitle FROM CD WHERE cdTitle != '$album' AND artID = '$art_id'";

      if ($r = mysqli_query($conn, $query)) { //turn this into a function
        while ($row = mysqli_fetch_array($r)) {
          print "<option value='{$row['cdTitle']}'>{$row['cdTitle']}</option>";
        }
      }
		mysqli_close($conn);

    echo '</select><br>';
    ?>

    <p>Track Length:</p>
    <input class="form-group" type="text" name="length" size="30" maxlength="50" value=<?php echo $duration?> pattern="[0-9]{0,}" title="Please enter integer numbers for the title length.">
    <p>Seconds</p>
    <input class="form-group button" type="submit" name="submit" value="Save">
    <input class="form-group button" type="submit" name="submit" value="Delete">
  </form>
	<button class="button" type="button" name="button"><a href="tracks.php">Back</a></button>
</fieldset>

<?php
	include('../templates/footer.html');
?>
