<?php
  require('connect.php');
  require('authenticate.php');

  if(!$_POST && isset($_GET['id'])) {
    // Sanatize GET id
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM categories WHERE category_id = :id";

    $statement = $db->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $row = $statement->fetch();

    // If the query did not return a result,
    // (if the GET id does not match a valid id in the db)
    // then it routes back to the home page.
    if(empty($row['category_name'])){
      header("Location: admin.php");
      exit;
    }
  }
  // UPDATE
  else if($_POST && isset($_POST['update']) && !empty($_POST['title'])) {
    // Sanatize and validate inputs
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // UPDATE Query
    $query = "UPDATE categories SET category_name = :title WHERE category_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

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
    <title><?= $row['category_name'] ?></title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Edit Category</h1>
      </div>

      <form class="create-product-form" method="post">
        <input type="hidden" name="id" value="<?= $row['category_id'] ?>">

        <label for="title">Category Name</label>
        <input id="title" type="text" name="title" value="<?= $row['category_name'] ?>">

        <div class="edit-post-buttons">
          <button type="submit" name="update">UPDATE</button>
          <!-- <button type="submit" name="delete">DELETE</button> -->
        </div>
      </form>
    </main>
  </body>
</html>
