<?php

  //PRINT COUNT
  function print_count($conn, $query, $type){
    if ($lists = mysqli_query($conn, $query)) {
  		$row = mysqli_fetch_array($lists);
  	  print "<b>Number of " . $type . "</b>: {$row[0]}<br>";
  	}
  }

  //PRINT TOTAL TRACK LENGTH
  function total_length($conn){
    $total = 0;
    $query = "SELECT tckLength FROM Track";
    $stmt = $conn->prepare($query);
    $executed = $stmt->execute();

    if ($executed){
      $result = $stmt->get_result();
      while ($row = $result->fetch_array()) {
        $total += $row['tckLength'];
      }
      print "<b>Total length of all tracks</b>: " . sec_to_min($total, 1) . " minutes";

    } else {
      echo "ERROR - Failed to get total track length";
    }
  }

  //ADD ARTIST
  function add_artist($conn, $artist){

    $sql = "INSERT INTO Artist (artName) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $artist);
    $result = $stmt->execute();
    if ($result){
      echo "Successfully added artist: " . $artist;
    } else {
      echo "failed to insert record";
    }
  }

  //SEARCH ARTIST
  function search_artist($conn, $artist_name) {
    $query = "SELECT * FROM Artist WHERE artName LIKE ? ORDER BY artID";

    $artist_name = '%' . $artist_name . '%';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $artist_name);
    $executed = $stmt->execute();

    if ($executed) {
      $result = $stmt->get_result();
      while ($row = $result->fetch_array()){
        print "<tr>
               <td>{$row['artID']}</td>
               <td>{$row['artName']}</td>
               <td> <a href='edit_artist.php?artID={$row['artID']}'>Edit</a> | <a href='albums.php?artID={$row['artID']}'>Albums</a> </td>
               </tr>";
      }
    } else {
      echo "ERROR - failed to search for artist: " . $artist_name;
    }
  }

  //EDIT ARTIST NAME
  function edit_artist($conn, $artID, $new_artist) {

    $query = "UPDATE Artist SET artName = ? WHERE artID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $new_artist, $artID);
    $executed = $stmt->execute();
    if ($executed){
      echo "Successfully edited artist: " . $new_artist;
    } else {
      echo "ERROR - Failed to edit artist: " . $new_artist;
    }
  }

  //DELETE ARTIST
  function delete_artist($conn, $artID) {
    $query = "DELETE FROM Artist WHERE artID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $artID);
    $executed = $stmt->execute();
    if ($executed){
      echo "Successfully deleted artist with id: " . $artID;
    } else {
      echo "ERROR - Failed to delete artist with id: " . $artID;
    }
  }

  //GET ARTIST NAME GIVEN ID
  function get_artist ($conn, $id) {
    $query = "SELECT artName FROM Artist WHERE artID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $executed = $stmt->execute();

    if ($executed) {
      $answer = $stmt->get_result();
      $row = $answer->fetch_array();
      return $row['artName'];
    }
  }

  //SEARCH ALBUM
  function search_album($conn, $album_name) {
    $query = "SELECT * FROM CD WHERE cdTitle LIKE ? ORDER BY cdID";
    $album_name_q = '%' . $album_name . '%';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $album_name_q);
    $executed = $stmt->execute();

    if ($executed) {
      $result = $stmt->get_result();
      while ($row = $result->fetch_array()){
        print "<tr>
                <td>{$row['cdID']}</td>
                <td>{$row['artID']}</td>
                <td>{$row['cdTitle']}</td>
                <td>{$row['cdPrice']}</td>
                <td>{$row['cdGenre']}</td>
                <td>";

        num_tracks($conn, $row['cdID']);

        print  "</td>
                <td><a href='edit_album.php?cdID={$row['cdID']}'>Edit</a> | <a href='tracks.php?cdID={$row['cdID']}'>Tracks</a></td>
                </tr>";
      }
    } else {
      echo "ERROR - failed to search for album: " . $album_name;
    }
  }

  //ADD ALBUM
  function add_album ($conn, $artID, $album, $price, $genre) {
    $sql = "INSERT INTO CD (artID, cdTitle, cdPrice, cdGenre) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isds', $artID, $album, $price, $genre);
    $result = $stmt->execute();
    if ($result){
      echo "Successfully added album: " . $album;
    } else {
      echo "failed to add album: " . $album;
    }
  }

  //EDIT ALBUM INFO
  function edit_album($conn, $cdID, $artID, $cdTitle, $cdGenre, $cdPrice) {

    $query = "UPDATE CD SET cdTitle = ?, artID = ?, cdGenre = ?, cdPrice = ? WHERE cdID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sisdi', $cdTitle, $artID, $cdGenre, $cdPrice, $cdID);
    $executed = $stmt->execute();
    if ($executed){
      echo "Successfully edited album: " . $cdTitle;
    } else {
      echo "ERROR - Failed to edit album: " . $cdTitle . mysqli_error($conn);
      echo $cdID . "\n" . $artID . "\n" . $cdTitle . "\n" . $cdGenre . "\n" . $cdPrice;
    }
  }

  //DELETE AN ALBUM
  function delete_album ($conn, $cdID) {
    $query = "DELETE FROM CD WHERE cdID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cdID);
    $executed = $stmt->execute();
    if ($executed){
      echo "Successfully deleted album where cdID: " . $cdID;
    } else {
      echo "ERROR - Failed to delete album where cdID: " . $cdID;
    }
  }

  //GET ALL INFO ABOUT A CD
  function get_cd ($conn, $cdID) {
    $query = "SELECT * FROM CD WHERE cdID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cdID);
    $executed = $stmt->execute();

    if ($executed) {
      $answer = $stmt->get_result();
      while ($row = $answer->fetch_array()) {

        $query_2 = "SELECT artName FROM Artist WHERE artID = ?";
        $stmt = $conn->prepare($query_2);
        $stmt->bind_param('i', $row['artID']);
        $executed_2 = $stmt->execute();

        if ($executed_2) {
          $result = $stmt->get_result();
          $row_2 = $result->fetch_array();
          $artName = $row_2['artName'];
        } else {
          echo "ERROR - Failed to get artist name with id: " . $row['artID'];
        }

        $cdTitle = $row['cdTitle'];
        $artID = $row['artID'];
        $cdArtist = $artName;
        $cdGenre = $row['cdGenre'];
        $cdPrice = $row['cdPrice'];

        return array ($cdTitle, $cdArtist, $cdGenre, $cdPrice, $artID);
      }
    } else {
      echo "ERROR - Failed to get cd information with id: " . $cdID;
    }
  }

  //ADD TRACK
  function add_track($conn, $tckName, $cdID, $length) {

    $tckLength = intval($length);

    $query = "INSERT INTO Track (tckName, cdID, tckLength) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sii', $tckName, $cdID, $tckLength);
    $executed = $stmt->execute();
    if ($executed){
      echo "Successfully added track: " . $tckName;
    } else {
      echo " ERROR - Failed to add track: " . $tckName;
    }
  }

  //SEARCH TRACK
  function search_track($conn, $tckName) {
    $query = "SELECT * FROM Track, CD WHERE tckName LIKE ? AND CD.cdID = Track.cdID ORDER BY CD.cdID";
    $tckName_q = '%' . $tckName . '%';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $tckName_q);
    $executed = $stmt->execute();

    if ($executed) {
      $result = $stmt->get_result();
      while ($row = $result->fetch_array()) {

        $get_artist = "SELECT artName FROM Artist WHERE artID = ?";
        $stmt = $conn->prepare($get_artist);
        $stmt->bind_param('i', $row['artID']);
        $executed_1 = $stmt->execute();

        if ($executed_1) {
          $result_1 = $stmt->get_result();
          $row_art = $result_1->fetch_array();
          $artName = $row_art['artName'];
        } else {
          echo "ERROR - Failed to get artist name where id = " . $row['artID'];
        }

        $get_CD = "SELECT cdTitle FROM CD WHERE cdID = ?";
        $stmt = $conn->prepare($get_CD);
        $stmt->bind_param('i', $row['cdID']);
        $executed_2 = $stmt->execute();

        if ($executed_2) {
          $result_2 = $stmt->get_result();
          $row_CD = $result_2->fetch_array();
          $cdTitle= $row_CD['cdTitle'];
        } else {
          echo "ERROR - Failed to get cd title where id = " . $row['cdID'];
        }

        print 	"<tr>
                <td>{$row['tckID']}</td>
                <td>";

                echo $artName . "</td><td>";
                echo $cdTitle . "</td>";

        print		"<td>{$row['tckName']}</td>
                <td>{$row['tckLength']}</td>
                <td> <a href=edit_track.php?tckID={$row['tckID']}&artID={$row['artID']}'>Edit</a></td>
                </tr>";
      }
    } else {
      echo "ERROR - Failed to search tracks where query: " . $tckName . " " . mysqli_error($conn);
    }
  }

  //GET TRACK INFORMATION
  function get_track($conn, $id) {
    $query = "SELECT * FROM Track WHERE tckID = $id";

    if ($r = mysqli_query($conn, $query)) {
		  while ($row = mysqli_fetch_array($r)) {
        $get_CD = "SELECT cdTitle FROM CD WHERE cdID = '{$row['cdID']}'";
        $row2 = mysqli_fetch_array(mysqli_query($conn, $get_CD));

        $track_name = $row['tckName'];
        $track_album = $row2['cdTitle'];
        $track_duration = $row['tckLength'];

        return array ($track_name, $track_album, $track_duration);
      }
    }
  }

  //DELETE TRACK
  function delete_track($conn, $tckID) {
    $query = "DELETE FROM Track WHERE tckID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $tckID);
    $executed = $stmt->execute();
    if ($executed){
      echo "Successfully deleted track where tckID: " . $tckID;
    } else {
      echo "ERROR - Failed to delete track where tckID: " . $tckID;
    }
  }

  //EDIT TRACK NAME
  function edit_track($conn, $tckID, $tckName, $cdTitle, $tckLength) {

    //GET CD ID
    $cdID_query = "SELECT cdID FROM CD WHERE cdTitle = ?";
    $stmt = $conn->prepare($cdID_query);
    $stmt->bind_param('s', $cdTitle);
    $executed = $stmt->execute();

    if ($executed) {
      $result = $stmt->get_result();
      $row = $result->fetch_array();
      $cdID = $row['cdID'];
    } else {
      echo "ERROR - failed to get cdID: " . $cdID . mysqli_error();
    }

    $query = "UPDATE Track SET tckName = ?, cdID = ?, tckLength = ? WHERE tckID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('siii', $tckName, $cdID, $tckLength, $tckID);
    $result = $stmt->execute();
    if ($result){
      echo "Successfully edited track: " . $tckName;
    } else {
      echo "ERROR - Failed to edit track: " . $tckName . mysqli_error();
    }
  }

  function num_tracks($conn, $cdID) {

    $query = "SELECT count(*) FROM Track WHERE cdID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cdID);
    $executed = $stmt->execute();

    if ($executed) {
      $result = $stmt->get_result();
      $row = $result->fetch_array();
      print $row[0];
    }
  }

  function sec_to_min($seconds, $r) {
    $min = floor($seconds/60);
    $sec = $seconds%60;

    if ($sec < 10) {
      $sec = "0" . $sec;
    }

    if ($r == 1) {
      return $min . ":" . $sec;
    } else {
      echo $min . ":" . $sec;
    }
  }

  function alert() {
    print "<script type='text/javascript'>
    	     alert('Successfully added artist');
           </script>";
  }
?>
