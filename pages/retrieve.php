<?php
  include '../db.php'; // include our database connection
  $query = "SELECT cdTitle FROM CD";

  if ($r = mysqli_query($conn, $query)) {

    while ($row = mysqli_fetch_array($r)) {
    print "<p><h3>{$row['cdTitle']}</h3>
    </p><hr>\n";
    }
  }

  mysqli_close($conn);
?>
