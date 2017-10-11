<?php

  include('../functions.php');

  $id = $_GET['artID'];
  //if post method is called
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['submit'] == 'Save') {
      $problem = FALSE;
      if (!empty($_POST['name'])) { //if artist name bar is filled in then store the string
        $new_artist = trim(strip_tags($_POST['name']));
      } else { //if no name entered then return error
        print '<p style="color: red;">Please enter an artist name</p>';
        $problem = TRUE;
      }

      //if no problem
      if (!$problem) {

        include '../db.php'; //include database connection

        edit_artist($conn, $id, $new_artist); //edit artist in database

        mysqli_close($conn); //close the database connection

        header('Location: artists.php');
      }
    }

    else if ($_POST['submit'] == 'Delete') {

      include '../db.php'; //include database connection

      delete_artist($conn, $id); //delete artist from database

      mysqli_close($conn); //close the database connection

      header('Location: artists.php');
    }
  }
?>
