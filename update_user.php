<?php
  require('connect.php');
  require('authenticate.php');

  if(!$_POST && isset($_GET['id'])) {
    // Sanatize GET id
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM users WHERE user_id = :id";

    $statement = $db->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $row = $statement->fetch();

    if(empty($row['user_email'])){
      header("Location: admin.php");
      exit;
    }
  }
  // UPDATE
  else if($_POST && isset($_POST['update']) && !empty($_POST['user_email'])) {
    // Sanatize and validate inputs
    $user_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $user_email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "UPDATE users SET user_email = :email, user_password = :password WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $user_email);
    $statement->bindValue(':password', $user_password);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    $statement->execute();

    // Go back to admin page after complete
    header("Location: admin.php");
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Edit User</h1>
      </div>

      <form class="create-product-form" method="post">
        <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">

        <label for="user_email">Email</label>
        <input id="user_email" type="text" name="user_email" value="<?= $row['user_email'] ?>">

        <label for="user_password">Password</label>
        <input id="user_password" type="text" name="user_password" value="<?= $row['user_password'] ?>">

        <div class="edit-post-buttons">
          <button type="submit" name="update">UPDATE</button>
        </div>
      </form>
    </main>
  </body>
</html>
