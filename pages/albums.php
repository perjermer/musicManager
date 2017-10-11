<?php
	$title = "Albums";
	include('../templates/header.php');
	include('../functions.php');
?>

<form class="search-album" action="albums.php" method="post"> <!-- search function -->
	<input type="text" name="name" size="30" maxlength="50" placeholder="Search...">
	<input class="button" type="submit" name="submit" value="Search Albums">
</form>

<table align="center"> <!-- table for displaying albums & information -->
	<tr>
		<th>CD ID</th>
		<th>Artist ID</th>
		<th>CD Title</th>
		<th>CD Price</th>
		<th>CD Genre</th>
		<th>CD Number of Tracks</th>
	</tr>

<?php

	//if get variable empty
	if (empty($_GET)) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if post method called then search
			$album = trim(strip_tags($_POST['name']));

			include '../db.php'; //include database connection
			search_album($conn, $album); //search album from database
			mysqli_close($conn); //close the database connection

		} else { //display all CDs
			include '../db.php'; // include our database connection
			$query = "SELECT * FROM CD ORDER BY cdID";
			//$num_of_tracks = "SELECT count(*) FROM Track WHERE ";

			if ($r = mysqli_query($conn, $query)) {

			  while ($row = mysqli_fetch_array($r)) {
				  print "<tr>
									<td>{$row['cdID']}</td>
									<td>{$row['artID']}</td>
									<td>{$row['cdTitle']}</td>
									<td>{$row['cdPrice']}</td>
									<td>{$row['cdGenre']}</td>
									<td>";

					num_tracks($conn, $row['cdID']); //count number of tracks the CD has

					print  "</td>
									<td><a href='edit_album.php?cdID={$row['cdID']}'>Edit</a> | <a href='tracks.php?cdID={$row['cdID']}'>Tracks</a></td>
									</tr>"; //links to editing an album and checking an album's tracks
			  }
			}
			mysqli_close($conn);
		}
		print "</table>";

	} else { //if artist was selected then display albums with artist
		$artID = $_GET['artID'];

		include '../db.php'; // include our database connection
		$query = "SELECT * FROM CD WHERE artID = $artID ORDER BY cdID";

		if ($r = mysqli_query($conn, $query)) {

			while ($row = mysqli_fetch_array($r)) {
				print "<tr>
								<td>{$row['cdID']}</td>
								<td>{$row['artID']}</td>
								<td>{$row['cdTitle']}</td>
								<td>{$row['cdPrice']}</td>
								<td>{$row['cdGenre']}</td>
								<td>";

				num_tracks($conn, $row['cdID']);

				print 	"</td>
								<td><a href='edit_album.php?cdID={$row['cdID']}'>Edit</a> | <a href='tracks.php?cdID={$row['cdID']}'>Tracks</a></td>
								</tr>";
			}
		}
		mysqli_close($conn);
		print "</table>";
	}

	?>

	<button type="button" class="add-button button"><a href="add_album.php">Add Album</a></button>

<?php
	include('../templates/footer.html');
?>
