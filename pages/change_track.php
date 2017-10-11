<?php
  include('../functions.php');

  //if post method is called
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_GET["tckID"];
    //$name = $_POST["name"];
    $CD = $_POST["CD"];
    //$duration = $_POST["length"];

    if ($_POST['submit'] == 'Save') {
      $problem = FALSE;

      if (!empty($_POST['name'])) { //if artist name bar is filled in then store the string
        $new_artist = trim(strip_tags($_POST['name']));
      } else { //if no name entered then return error
        print '<p style="color: red;">Please enter an artist name</p>';
        $problem = TRUE;
      }

      if (!empty($_POST['length'])) {
        $duration = trim(strip_tags($_POST['length']));
      } else {
        print '<p style="color: red;">Please enter a track length</p>';
        $problem = TRUE;
      }

      //if no problem
      if (!$problem) {
        include '../db.php'; //include database connection

        edit_track($conn, $id, $new_artist, $CD, $duration); //edit track in database

        mysqli_close($conn); //close the database connection

        header('Location: tracks.php');
      }
    } else if ($_POST['submit'] == 'Delete') {

      include '../db.php'; //include database connection

      delete_track($conn, $id); //delete track from database

      mysqli_close($conn); //close the database connection

      header('Location: tracks.php');
    }
  }
?>
