<?php
  require('connect.php');

  $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  // $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
  //
  if($_GET['category'] < 0) {
    $query = "SELECT * FROM products WHERE product_name LIKE :search";
    $statement = $db->prepare($query);
    $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $statement->execute();

    $category_name = "All Categories.";
  }
  else if($_GET['category'] >= 0) {
    $query = "SELECT * FROM products WHERE product_name LIKE :search AND category_id = :category";
    $statement = $db->prepare($query);
    $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $statement->bindValue(':category', $_GET['category'], PDO::PARAM_INT);
    $statement->execute();

    $category_query = "SELECT category_name FROM categories WHERE category_id = :category_id";
    $category_statement = $db->prepare($category_query);
    $statement->bindValue(':category_id', $_GET['category'], PDO::PARAM_INT);
    $category_statement->execute();
    $categories = $category_statement->fetch();
    $category_name = $categories['category_name'];
  }

  // $query = "SELECT * FROM products WHERE product_name LIKE :search";
  // $statement = $db->prepare($query);
  // $statement->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
  // $statement->execute();

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
      <h4>Results for &quot<?= $search ?>&quot from <?= $category_name ?></h3>
      <?php while($row = $statement->fetch()): ?>
        <div class="cp-product-block">
          <!-- <img class="cp-product-image" src="images/<?= $row['image_url'] ?>" alt="product image"> -->
          <a class="link-product" href="product_page.php?id=<?= $row['id'] ?>"><h3><?= $row['product_name'] ?></h3></a>
          <p>$<?= $row['price'] ?></p>
        </div>
      <?php endwhile ?>
    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
