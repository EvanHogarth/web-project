<?php
  require('connect.php');

  // Checks that POST has been sent and that the title and content are not empty.
  if($_POST && !empty($_POST['user_email']) && !empty($_POST['user_password'])) {

    // Sanitize the input
    $user_email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Create INSERT query
    $query = "INSERT INTO users (user_email, user_password) values (:user_email, :user_password)";
    $statement = $db->prepare($query);

    // Bind values to query
    $statement->bindValue(':user_email', $user_email);
    $statement->bindValue(':user_password', $user_password);

    // Execute statement
    $statement->execute();

    // Redirect back to admin page and exit script.
    header("Location: admin.php");
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create User</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Create Category</h1>
      </div>

      <form class="create-product-form" method="post">
        <label for="user_email">Email</label>
        <input id="user_email" type="text" name="user_email" value="">

        <label for="user_password">Password</label>
        <input id="user_password" type="text" name="user_password" value="">

        <button type="submit" name="button">SUBMIT</button>
      </form>
    </main>

  </body>
</html>
