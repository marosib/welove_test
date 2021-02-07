<?php
  if (isset($_POST["delete"])) {
    $project_id = $_POST["project_id"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    deletePSPivot($conn, $project_id);

    deletePOPivot($conn, $project_id);

    deleteProject($conn, $project_id);

  } else {
    header("location: ./index.php");
  }