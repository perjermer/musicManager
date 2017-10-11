<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="/coursework2/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <script src="/coursework2/assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="/coursework2/assets/bower_components/tether/dist/js/tether.min.js"></script>
  <script src="/coursework2/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/coursework2/assets/css/styles.css">
  <title><?php echo $title ?></title>
</head>

<!-- HEADER -->
<body>
  <div id="container">
    <header container class="site-header">
      <div id="header">
        <h1 class="display-1 main"><?php echo $title ?></h1>

        <div id="navbar">
          <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="http://localhost/coursework2/index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="http://localhost/coursework2/pages/artists.php">Artists</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="http://localhost/coursework2/pages/albums.php">Albums</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="http://localhost/coursework2/pages/tracks.php">Tracks</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>

    <main container class="site-content">
      <div id="body">
    <!-- CHANGEABLE CONTENT -->
