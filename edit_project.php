<?php
  include_once 'header.php';

  require_once './includes/dbh.inc.php';
  require_once './includes/functions.inc.php';

  if (isset($_GET["id"])) {
    $project_id = $_GET["id"];
  }

  $project = getOneProjectById($conn, $project_id);
  $owner_id = $project["owner_id"];
?>

  <div class="container">
    <form action="./includes/edit_project.inc.php" method="POST">
      <input type="text" hidden name="project_id" value="<?php echo $project_id?>">
      <input type="text" hidden name="owner_id" value="<?php echo $project["owner_id"]?>">

      <p>Cím</p>
      <input name="title" type="text" value="<?php echo $project["title"] ?>">

      <p>Leírás</p>
      <textarea name="description" id=""><?php echo $project["description"]?></textarea>

      <p>Státusz</p>
      <select name="status_id" id="">
        <option value="1" <?= ($project["status_id"] == 1) ? 'selected="selected"' : '' ?>>Fejlesztésre vár</option>
        <option value="2" <?= ($project["status_id"] == 2) ? 'selected="selected"' : '' ?>>Folyamatban</option>
        <option value="3" <?= ($project["status_id"] == 3) ? 'selected="selected"' : '' ?>>Kész</option>
      </select>

      <p>Kapcsolattartó neve</p>
      <input name="owner_name" type="" value="<?php echo $project["name"]?>">
      
      <p>Kapcsolattartó e-mail címe</p>
      <input name="owner_email" type="text" value="<?php echo $project["email"]?>">
      <p></p>
      <button type="submit" name="update">Mentés</button>
    </form>
  </div>

</body>
</html>