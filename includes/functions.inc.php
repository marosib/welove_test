<?php
/*-----------------*/
/*----index.php----*/
/*-----------------*/

  function getAllProjects($conn) {
    $query = "SELECT p.id, p.title, p.description, o.name as owner_name, o.email, s.key, s.name as status_name
              FROM `projects` as p
              LEFT JOIN `project_owner_pivot` as op ON op.project_id = p.id
              LEFT JOIN `owners` as o ON o.id = op.owner_id
              LEFT JOIN `project_status_pivot`as ps ON ps.project_id = p.id
              LEFT JOIN `statuses`as s ON s.id = ps.status_id";
    $results = mysqli_query($conn, $query);
    $checkResults = mysqli_num_rows($results);

    if ($checkResults > 0) {
      $rows = $results->fetch_all(MYSQLI_ASSOC);
      return $rows;
    }
  }

/*----------------------*/
/*----delete.inc.php----*/
/*----------------------*/

  function deleteProject($conn, $project_id) {
    $query = "DELETE FROM `projects`
              WHERE id='" . $project_id . "'";

    if (mysqli_query($conn, $query)) {
      header("location: ../index.php?erro=none");
    } else {
      header("location: ../edit_project.php?error=stmtfailed");
      exit();
    }
  }

  function deletePOPivot($conn, $project_id) {
    $query = "DELETE FROM `project_owner_pivot` WHERE project_id='" . $project_id . "'";

    if (mysqli_query($conn, $query)) {
    } else {
      header("location: ../edit_project.php?error=stmtfailed");
      exit();
    }
  }

  function deletePSPivot($conn, $project_id) {
    $query = "DELETE FROM `project_status_pivot` WHERE project_id='" . $project_id . "'";

    if (mysqli_query($conn, $query)) {
    } else {
      header("location: ../edit_project.php?error=stmtfailed");
      exit();
    }
  }

/*---------------------------*/
/*----new_project.inc.php----*/
/*---------------------------*/

function emptyInputNewProject($title, $description, $owner_name, $owner_email) {
  $result;
  if (empty($title) || empty($description) || empty($owner_name) || empty($owner_email)) {
    $result = true;
  } else {
    $result = false;
  }
return $result;
}

function invalidOwnerName($owner_name) {
  $result;
  if (!preg_match("/^[a-zA-Z0-9]*$/", $owner_name)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidOwnerEmail($owner_email) {
  $result;
  if (!filter_var($owner_email,FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function checkOwnerExists($conn ,$owner_name) {
  $query = "SELECT o.id FROM `owners` as o WHERE o.name ='" . $owner_name . "'";
  $results = mysqli_query($conn, $query);
  $checkResults = mysqli_num_rows($results);

  if ($checkResults > 0) {
    $row = mysqli_fetch_assoc($results);
    return $row["id"];
  } else {
    return 0;
  }
}

function createOwner($conn, $owner_name, $owner_email) {
  $query = "INSERT INTO `owners` (name, email) VALUES (?, ?)";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: ../new_project.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $owner_name, $owner_email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

function createProject($conn, $title, $description) {
  $query = "INSERT INTO `projects` (title, description) VALUES (?, ?)";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: ../new_project.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $title, $description);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

function getProjectId($conn) {
  $query = "SELECT id FROM `projects` WHERE ID = (SELECT MAX(id) FROM `projects`)";
  $results = mysqli_query($conn, $query);
  $checkResults = mysqli_num_rows($results);

  if ($checkResults > 0) {
    $row = mysqli_fetch_assoc($results);
    return $row["id"];
  } else {
    header("location: ../new_project.php?error=stmtfailed");
    exit();
  }
}

function createPOPivot($conn, $project_id, $owner_id) {
  $query = "INSERT INTO `project_owner_pivot` (project_id, owner_id) VALUES (?, ?)";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: ../new_project.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $project_id, $owner_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

function createPSPivot($conn, $project_id, $status_id) {
  $query = "INSERT INTO `project_status_pivot` (project_id, status_id) VALUES (?, ?)";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: ../new_project.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $project_id, $status_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("location: ../new_project.php?error=none");
  exit();
}


/*---------------------------*/
/*----new_project.inc.php----*/
/*---------------------------*/

function getOneProjectById($conn, $project_id) {
  $query = "SELECT  p.title, p.description, o.id as owner_id, o.name, o.email, ps.status_id
            FROM `projects` as p
            LEFT JOIN `project_owner_pivot` as op ON op.project_id = p.id
            LEFT JOIN `owners` as o ON o.id = op.owner_id
            LEFT JOIN `project_status_pivot`as ps ON ps.project_id = p.id
            LEFT JOIN `statuses`as s ON s.id = ps.status_id
            WHERE p.id =" . $project_id;
  $results = mysqli_query($conn, $query);
  $checkResults = mysqli_num_rows($results);

  if ($checkResults > 0) {
    $row = mysqli_fetch_assoc($results);
    return $row;
  } else {
    header("location: ../index.php?error=stmtfailed");
    exit();
  }
}

function emptyInputEditProject($title, $description, $owner_name, $owner_email) {
  $result;
  if (empty($title) || empty($description) || empty($owner_name) || empty($owner_email)) {
    $result = true;
  } else {
    $result = false;
  }
return $result;
}

function checkEmailCorrect($conn ,$owner_email, $owner_id) {
  $query = "SELECT o.email FROM `owners` as o WHERE o.id ='" . $owner_id . "' AND o.email='" . $owner_email . "'";
  $results = mysqli_query($conn, $query);
  $checkResults = mysqli_num_rows($results);

  if ($checkResults > 0) {
    $row = mysqli_fetch_assoc($results);
    return $row["email"];
  } else {
    return false;
  }
}

function updateEmail($conn, $owner_id, $owner_email) {
  $query = "UPDATE `owners` SET email='" . $owner_email . "' WHERE id='" . $owner_id . "'";

  if (mysqli_query($conn, $query)) {
  } else {
    header("location: ../edit_project.php?id=" . $project_id . "&error=stmtfailed");
    exit();
  }
}

function updateProject($conn, $project_id, $title, $description) {
  $query = "UPDATE `projects` SET title='" . $title . "', description='" . $description . "' WHERE id='" . $project_id . "'";

  if (mysqli_query($conn, $query)) {
  } else {
    header("location: ../edit_project.php?id=" . $project_id . "&error=stmtfailed");
    exit();
  }
}

function updatePOPivot($conn, $project_id, $owner_id) {
  $query = "UPDATE `project_owner_pivot` SET owner_id='" . $owner_id . "' WHERE project_id='" . $project_id . "'";

  if (mysqli_query($conn, $query)) {
  } else {
    header("location: ../edit_project.php?id=" . $project_id . "&error=stmtfailed");
    exit();
  }
}

function updatePSPivot($conn, $project_id, $status_id) {
  $query = "UPDATE `project_status_pivot` SET status_id='" . $status_id . "' WHERE project_id='" . $project_id . "'";

  if (mysqli_query($conn, $query)) {
    header("location: ../edit_project.php?id=" . $project_id . "&error=none");
  } else {
    header("location: ../edit_project.php?id=" . $project_id . "&error=stmtfailed");
    exit();
  }
}
