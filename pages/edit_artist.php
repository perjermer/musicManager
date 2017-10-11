<?php
	$title = "Edit Artist";
	include('../templates/header.php');
	$type = "artist";
	echo "<script src=\"../assets/js/validate_" . $type . ".js\"></script>";
	include('../functions.php');
	include('../db.php');

  $artID = $_GET['artID'];

	$artName = get_artist($conn, $artID);

?>

	<fieldset>
		<legend>Edit Artist</legend>
	  <form class="artist-name" action="change_artist.php?artID=<?php echo $artID?>" method="post" onsubmit="return validate(this)">
	  	<p>Artist name:</p>
	    <input class="form-group" type="text" name="name" size="30" maxlength="50" value="<?php echo $artName?>" pattern="[a-zA-Z0-9$_/'\s&]{3,}" title="Please enter a minimum of 3 characters for the artist."><br>
	    <input class="form-group button" type="submit" name="submit" value="Save">
	    <input class="form-group button" type="submit" name="submit" value="Delete">
			<button class="button" type="button" name="button"><a href="artists.php">Back</a></button>
	  </form>
	</fieldset>

<?php
	include('../templates/footer.html');
?>
