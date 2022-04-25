<?php
  require('connect.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Shop</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="homepage-content">
      <h2>Welcome!</h2>
      <h3>Shop by Category</h3>
      <?php
        $category_query = "SELECT * FROM categories";
        $category_statement = $db->prepare($category_query);
        // $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $category_statement->execute();
        $categories = $category_statement->fetchAll();
      ?>
      <?php foreach($categories as $category): ?>
        <div>
          <h4><a href="category_page.php?id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?></a></h4>
        </div>
      <?php endforeach ?>
    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
