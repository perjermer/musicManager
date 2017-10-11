<?php
	$title = "Tracks";
	include('../templates/header.php');
	include('../functions.php');
?>

<form class="search-track" action="tracks.php" method="post">
	<input type="text" name="name" size="30" maxlength="50" placeholder="Search...">
	<input class="button" type="submit" name="submit" value="Search Tracks">
</form>

<table align="center">
	<tr>
		<th>Track ID</th>
		<th>Artist</th>
		<th>Album</th>
		<th>Track Title</th>
		<th>Track Length</th>
		<th></th>
	</tr>

<?php

	if (empty($_GET)) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$track = $_POST['name'];

			include '../db.php'; //include database connection

			search_track($conn, $track); //search artist from database

			mysqli_close($conn); //close the database connection

		} else {

			include '../db.php'; //include database connection
			$query = "SELECT * FROM Track, CD WHERE CD.cdID = Track.cdID ORDER BY CD.artID, CD.cdID";

			if ($r = mysqli_query($conn, $query)) {

			  while ($row = mysqli_fetch_array($r)) {


					$get_artist = "SELECT artName FROM Artist WHERE artID = '{$row['artID']}'";
					$get_CD = "SELECT cdTitle FROM CD WHERE cdID = '{$row['cdID']}'";


			  print 	"<tr>
								<td>{$row['tckID']}</td>
								<td>";

								$row2 = mysqli_fetch_array(mysqli_query($conn, $get_artist));
								echo $row2['artName'] . "</td><td>";
								$row3 = mysqli_fetch_array(mysqli_query($conn, $get_CD));
								echo $row3['cdTitle'] . "</td>";


				print		"<td>{$row['tckName']}</td>
								<td>";

				sec_to_min($row['tckLength'], 0);

				print		"</td>
								<td> <a href=edit_track.php?tckID={$row['tckID']}&artID={$row['artID']}>Edit</a></td>
								</tr>";
			  }
			}

			mysqli_close($conn);
		}
		print "</table>";
	} else {

		$cdID = $_GET['cdID'];

		include '../db.php'; //include database connection
		$query = "SELECT * FROM Track, CD WHERE CD.cdID = $cdID AND CD.cdID = Track.cdID ORDER BY CD.artID";

		if ($r = mysqli_query($conn, $query)) {

			while ($row = mysqli_fetch_array($r)) {

				$get_artist = "SELECT artName FROM Artist WHERE artID = '{$row['artID']}'";
				$get_CD = "SELECT cdTitle FROM CD WHERE cdID = $cdID";

			print 	"<tr>
							<td>{$row['tckID']}</td>
							<td>";

							$row2 = mysqli_fetch_array(mysqli_query($conn, $get_artist));
							echo $row2['artName'] . "</td><td>";
							$row3 = mysqli_fetch_array(mysqli_query($conn, $get_CD));
							echo $row3['cdTitle'] . "</td>";

			print		"<td>{$row['tckName']}</td>
							<td>";

			sec_to_min($row['tckLength'], 0);

			print		"</td>
							<td> <a href=edit_track.php?tckID={$row['tckID']}&artID={$row['artID']}>Edit</a></td>
							</tr>";
			}
		}

		mysqli_close($conn);
	}
	print "</table>";
	?>

<button type="button" class="add-button button"><a href="add_track.php">Add Track</a></button>

<?php
	include('../templates/footer.html');
?>
