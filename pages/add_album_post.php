<?php
  include('../functions.php');

  //if post method is called
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $problem = FALSE;

    if (!empty($_POST['name'])) { //if album name bar is filled in then store the string
      $album = $_POST['name'];
		}	else { //if no name entered then return error
	    print '<p style="color: red;">Please enter an album name</p>';
	    $problem = TRUE;
	   }

    if ($_POST['artist'] != 'na'){ //if an artist is selected
      $artist = $_POST['artist'];
		} else { //if no artist selected
			print '<p style="color: red;">Please select an artist</p>';
			$problem = TRUE;
		}

		if ($_POST['genre'] != 'na'){ //if a genre is selected
      $genre = $_POST['genre'];
		} else { //if no genre selected
			print '<p style="color: red;">Please select an album genre</p>';
			$problem = TRUE;
		}

		if (trim(strip_tags($_POST['price'])) != ''){ //if price selected
      $price = trim(strip_tags($_POST['price']));
    } else { //if no price selected
      print '<p style="color: red;">Please enter an album price</p>';
      $problem = TRUE;
    }

    //if no problem
    if (!$problem) {
      include '../db.php'; //include database connection

      $get_artid = "SELECT artID FROM Artist WHERE artName = '$artist'"; //get artist id
      $r = mysqli_query($conn, $get_artid);
      $row = mysqli_fetch_array($r);
      $artID = $row['artID'];

      add_album($conn, $artID, $album, $price, $genre); //add album to database

      mysqli_close($conn); //close the database connection

			header("Location: albums.php");
    }
  }

	include('../templates/footer.html');
?>
