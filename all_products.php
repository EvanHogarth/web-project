<?php
  require('connect.php');

  // $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  if($_POST && isset($_POST['sorting'])) {
    if($_POST['sort_by'] === "product_name") {
      $query = "SELECT * FROM products ORDER BY product_name";
      $statement = $db->prepare($query);
      $statement->execute();

      $current_sort = "product name";
    }
    elseif($_POST['sort_by'] === "category_name") {
      $query = "SELECT * FROM products ORDER BY category_id";
      $statement = $db->prepare($query);
      $statement->execute();

      $current_sort = "category";
    }
    elseif($_POST['sort_by'] === "price_desc") {
      $query = "SELECT * FROM products ORDER BY price";
      $statement = $db->prepare($query);
      $statement->execute();

      $current_sort = "price - lowest first";
    }
    else {
      $query = "SELECT * FROM products";
      $statement = $db->prepare($query);
      $statement->execute();

      $current_sort = "none";
    }

  }
  else {
    $query = "SELECT * FROM products";
    $statement = $db->prepare($query);
    $statement->execute();

    $current_sort = "none";
  }


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

    <?php if(isset($_SESSION["logged_in_email"])): ?>
      <h3>Sorted by: <?= $current_sort ?></h3>

      <form class="" method="post">
        <select class="" name="sort_by">
          <option value="product_name">Product Name</option>
          <option value="category_name">Category</option>
          <option value="price_desc">Price - Lowest First</option>
        </select>
        <input type="submit" name="sorting">
      </form>
    <?php endif ?>



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
