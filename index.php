<?php
  include_once 'header.php';

  require_once './includes/dbh.inc.php';
  require_once './includes/functions.inc.php';
?>
  <div class="wrapper">
    <?php 
        //var_dump(getAllProjects($conn));
        $projects = getAllProjects($conn);
        foreach($projects as $project) {
          echo "<div class='project'>";
          echo "<h1>" . $project["title"] . "</h1>";
          echo "<p>" . $project["owner_name"] . " " . $project["email"] . "</p>";
          echo "<p class='status' >" . $project["status_name"] . "</p>";
          echo "<a href='edit_project.php?id=" . $project["id"] . "'>Szerkesztés</a>";
          echo "<form action='./includes/delete.inc.php' method='POST' >";
          echo "<input type='text' hidden name='project_id' value='" . $project["id"] . "'>";
          echo "<button class='delete-button' type='submit' name='delete'>Törlés</button>";
          echo "</form>";
          echo "</div>";
        }
      ?>
  </div>

</body>
</html>