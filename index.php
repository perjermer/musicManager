<?php
	$title = "Home";
	include('templates/header.php');
	include('functions.php');
?>

	<h1 class="title">Database Metrics</h1>

	<div id="metrics">

<?php
	include 'db.php'; // include our database connection
	$query_artist_count = "SELECT count(*) FROM Artist";
	$query_cd_count = "SELECT count(*) FROM CD";
	$query_track_count = "SELECT count(*) FROM Track";


	print_count($conn, $query_artist_count, "Artists");
	print_count($conn, $query_cd_count, "CDs");
	print_count($conn, $query_track_count, "Tracks");

	total_length($conn);

	mysqli_close($conn);
?>

<?php
	include('templates/footer.html');
?>
