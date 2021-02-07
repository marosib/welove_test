<?php
  include_once 'header.php';

?>

  <div class="container">
    <form action="./includes/new_project.inc.php" method="POST">
      <p>Cím</p>
      <input name="title" type="text">

      <p>Leírás</p>
      <textarea name="description" id=""></textarea>

      <p>Státusz</p>
      <select name="status_id" id="">
        <option value="1">Fejlesztésre vár</option>
        <option value="2">Folyamatban</option>
        <option value="3">Kész</option>
      </select>

      <p>Kapcsolattartó neve</p>
      <input name="owner_name" type="">
      
      <p>Kapcsolattartó e-mail címe</p>
      <input name="owner_email" type="text">
      <p></p>
      <button type="submit" name="submit">Mentés</button>
    </form>
  </div>

</body>
</html>