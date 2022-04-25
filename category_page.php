<?php
  require('connect.php');

  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  $query = "SELECT * FROM products WHERE category_id = :id";
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->execute();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product title</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="category-page">
      <?php while($row = $statement->fetch()): ?>
        <div class="cp-product-block">
          <?php if(!empty($row['image_url'])): ?>
            <img class="cp-product-image" src="<?= $row['image_url'] ?>" alt="product image">
          <?php endif ?>
          <a class="link-product" href="product_page.php?id=<?= $row['id'] ?>&p=<?= str_replace(" ", "-", $row['product_name']) ?>"><h3><?= $row['product_name'] ?></h3></a>
          <p>$<?= $row['price'] ?></p>
        </div>
      <?php endwhile ?>
    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
