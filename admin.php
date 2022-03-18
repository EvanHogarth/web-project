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
      <ul>
        <?php foreach($categories as $category): ?>
          <li>ID: <?= $category['category_id'] ?></li>
          <li><?= $category['category_name'] ?></li>
          <br/>
        <?php endforeach ?>
      </ul>

      <a href="#"><button>Add Category</button></a>

      <h3>Products</h3>
      <?php
        $productQuery = "SELECT * FROM products";
        $productStatement = $db->prepare($productQuery);
        // $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $productStatement->execute();
        $products = $productStatement->fetchAll();
      ?>
      <ul>
        <?php foreach($products as $product): ?>
          <li>Product ID: <?= $product['id'] ?></li>
          <li><?= $product['product_name'] ?></li>
          <br/>
        <?php endforeach ?>
      </ul>

      <a href="#"><button>Add Product</button></a>
      
      <!-- <form class="create-product-form" action="create_product.php" method="post">
        <label for="title">Product Name</label>
        <input id="title" type="text" name="title" value="">

        <label for="category">Category</label>
        <input id="title" type="text" name="category" value="">

        <label for="content">Description</label>
        <textarea id="content" name="content" rows="8" cols="80"></textarea>

        <div class="spread">
          <div class="">
            <label for="price">Price</label>
            <input id="price" type="number" name="price" value="">
          </div>

          <div class="">
            <label for="stock">Stock</label>
            <input id="stock" type="number" name="stock" value="">
          </div>
        </div>


        <button type="submit" name="button">SUBMIT</button>
      </form> -->
    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
