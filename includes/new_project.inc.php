<?php
  if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $status_id = $_POST["status_id"];
    $owner_name = $_POST["owner_name"];
    $owner_email = $_POST["owner_email"];
    $owner_id;
    $project_id;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputNewProject($title, $description, $owner_name, $owner_email) !== false) {
      header("location: ../new_project.php?error=emptyinput");
      exit();
    }
    if (invalidOwnerName($owner_name) !== false) {
      header("location: ../new_project.php?error=invaliduid");
      exit();
    }
    if (invalidOwnerEmail($owner_email) !== false) {
      header("location: ../new_project.php?error=invalidemail");
      exit();
    }

    if (checkOwnerExists($conn, $owner_name) > 0) {
      $owner_id = checkOwnerExists($conn, $owner_name);
    } else {
      createOwner($conn, $owner_name, $owner_email);
      $owner_id = checkOwnerExists($conn, $owner_name);
    }

    createProject($conn, $title, $description);
    $project_id = getProjectId($conn);

    createPOPivot($conn, $project_id, $owner_id);

    createPSPivot($conn, $project_id, $status_id);
  } else {
    header("location: ./new_project.php");
  }


