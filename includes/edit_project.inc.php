<?php
  if (isset($_POST["update"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $status_id = $_POST["status_id"];
    $owner_name = $_POST["owner_name"];
    $owner_email = $_POST["owner_email"];
    $project_id = $_POST["project_id"];
    $owner_id = $_POST["owner_id"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if (emptyInputEditProject($title, $description, $owner_name, $owner_email) !== false) {
      header("location: ../edit_project.php?id=" . $project_id . "&error=emptyinput");
      exit();
    }

    if (checkOwnerExists($conn, $owner_name) > 0) {
      $owner_id = checkOwnerExists($conn, $owner_name);
    } else {
      header("location: ../edit_project.php?id=" . $project_id . "&error=ownerdoesnotexist");
      exit();
    }
    if (invalidOwnerEmail($owner_email) !== false) {
      header("location: ../new_project.php?error=invalidemail");
      exit();
    }
    if (checkEmailCorrect($conn, $owner_email, $owner_id)) {
      $owner_email = checkEmailCorrect($conn, $owner_email, $owner_id);
    } else {
      header("location: ../edit_project.php?id=" . $project_id . "&error=wrongemail");
      exit();
    }

    updateProject($conn, $project_id, $title, $description);

    updatePOPivot($conn, $project_id, $owner_id);

    updateEmail($conn, $owner_id, $owner_email);

    updatePSPivot($conn, $project_id, $status_id);

  } else {
    header("location: ./new_project.php");
  }
