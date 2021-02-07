<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WeLove test</title>
  <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

  <header>
    <span>WeLove Test</span>
    <a href="index.php" <?= strpos($_SERVER['REQUEST_URI'], 'index.php') ? 'style="opacity:0.5;"' : "" ?> >Projektlista</a>
    <a href="new_project.php" <?= strpos($_SERVER['REQUEST_URI'], 'edit_project.php') || strpos($_SERVER['REQUEST_URI'], 'new_project.php') ? 'style="opacity:0.5;"' : "" ?> >Szerkesztés/Létrehozás</a>
  </header>