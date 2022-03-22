<?php
  require('connect.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="admin-content">
      <h2>Admin Panel</h2>

      <h3>Categories</h3>
      <?php
        $query = "SELECT * FROM categories";
        $statement = $db->prepare($query);
        // $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $categories = $statement->fetchAll();
      ?>
      <div>
        <?php foreach($categories as $category): ?>
          <p>
            ID: <?= $category['category_id'] ?>
            <br />
            <?= $category['category_name'] ?>
          </p>

        <?php endforeach ?>
      </div>

      <a href="create_category.php"><button>Add Category</button></a>

      <h3>Products</h3>
      <?php
        $productQuery = "SELECT * FROM products";
        $productStatement = $db->prepare($productQuery);
        // $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $productStatement->execute();
        $products = $productStatement->fetchAll();
      ?>
      <div>
        <?php foreach($products as $product): ?>
          <p>
            Product ID: <?= $product['id'] ?>
            <br />
            <?= $product['product_name'] ?>
          </p>
        <?php endforeach ?>
      </div>

      <a href="create_product.php"><button>Add Product</button></a>


    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
