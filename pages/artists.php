<?php
	$title = "Artists";
	include('../templates/header.php');
	include('../functions.php');
?>

<form class="search-artist" action="artists.php" method="post"> <!-- search bar -->
	<input type="text" name="name" size="30" maxlength="50" placeholder="Search...">
	<input class="button" type="submit" name="submit" value="Search Artists">
</form>

<table align="center"> <!-- table for artists -->
	<tr>
		<th>Artist ID</th>
		<th>Artist Title</th>
		<th></th>
	</tr>

<?php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if search submitted to page

		$artist = trim(strip_tags($_POST['name']));

		include '../db.php'; //include database connection
		search_artist($conn, $artist); //search artist from database
		mysqli_close($conn); //close the database connection

	} else { //display all artists

		include '../db.php'; //include database connection
		$query = "SELECT * FROM Artist ORDER BY artID";

		if ($r = mysqli_query($conn, $query)) {

		  while ($row = mysqli_fetch_array($r)) {
		  print "<tr>
							<td>{$row['artID']}</td>
							<td>{$row['artName']}</td>
							<td> <a href='edit_artist.php?artID={$row['artID']}'>Edit</a> | <a href='albums.php?artID={$row['artID']}'>Albums</a> </td>
							</tr>";
		  }
		}
		mysqli_close($conn);
	}
?>
</table>

<button type="button" class="add-button button"><a href="add_artist.php">Add Artist</a></button> <!-- add new artist -->

<?php
	include('../templates/footer.html');
?>
