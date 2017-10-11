<?php
  include('../functions.php');

  //if post method is called
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $cdID = $_GET["cdID"];
    $artID = $_POST["artist"];
    $cdGenre = $_POST["genre"];

    if ($_POST['submit'] == 'Save') {
      $problem = FALSE;

      if (!empty($_POST['name'])) { //if album title bar is filled in then store the string
        $cdTitle = trim(strip_tags($_POST["name"]));
      } else { //if no cd title entered then return error
        print '<p style="color: red;">Please enter a CD title</p>';
        $problem = TRUE;
      }

      if (!empty($_POST['price'])) { //if cd price entered
        $cdPrice = $_POST["price"];
      } else { //if no cd price is entered
        print '<p style="color: red;">Please enter a valid CD price</p>';
      }

      //if no problem
      if (!$problem) {
        include '../db.php'; //include database connection

        edit_album($conn, $cdID, $artID, $cdTitle, $cdGenre, $cdPrice); //edit album in database

        mysqli_close($conn); //close the database connection

        header('Location: albums.php');
      }
    } else if ($_POST['submit'] == 'Delete') {

      include '../db.php'; //include database connection

      delete_album($conn, $cdID); //delete album from database

      mysqli_close($conn); //close the database connection

      header('Location: albums.php');
    }
  }
?>
