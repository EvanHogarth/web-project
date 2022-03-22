<?php
  require('connect.php');

  // Checks that POST has been sent and that the title and content are not empty.
  if($_POST && !empty($_POST['title'])) {

    // Sanitize the input
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Create INSERT query
    $query = "INSERT INTO categories (category_name) values (:category_name)";
    $statement = $db->prepare($query);

    // Bind values to query
    $statement->bindValue(':category_name', $title);

    // Execute statement
    $statement->execute();

    // Redirect back to admin page and exit script.
    header("Location: admin.php");
    exit;
  }
  // If form was POSTed with empty data, redirect to error page.
  else if($_POST && (empty($_POST['title']))) {
    header("Location: error.html");
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Category</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Create Category</h1>
      </div>

      <form class="create-product-form" action="create_category.php" method="post">
        <label for="title">Category Name</label>
        <input id="title" type="text" name="title" value="">

        <button type="submit" name="button">SUBMIT</button>
      </form>
    </main>

  </body>
</html>
