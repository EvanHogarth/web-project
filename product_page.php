<?php
  require('connect.php');

  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  $query = "SELECT * FROM products WHERE id = :id";

  $statement = $db->prepare($query);

  $statement->bindValue(':id', $id, PDO::PARAM_INT);

  $statement->execute();

  $row = $statement->fetch();
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

    <div class="product-page">

      <div class="product-images">
        <!-- <img class="product-image" src="images/<?= $row['image_url'] ?>" alt="product image"> -->
      </div>

      <div class="product-info">
        <!-- Category -->
        <h3>Bracelets</h3>

        <!-- Product Name -->
        <h2><?= $row['product_name'] ?></h2>

        <!-- Product Description -->
        <p><?= $row['description'] ?></p>

        <!-- Product Price -->
        <p class="product-price">$<?= $row['price'] ?></p>

        <!-- If stock is greater than 0, allow to add to cart -->
        <?php if($row['stock'] > 0): ?>
          <button type="button" name="button">Add to cart</button>
        <?php else: ?>
          <h4>Out of stock</h4>
        <?php endif ?>
      </div>

    </div>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
