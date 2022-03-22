<?php
  require('connect.php');

  // Checks that POST has been sent and that the title and content are not empty.
  if($_POST && !empty($_POST['title']) && !empty($_POST['content'])){

    // Sanitize the input
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Create INSERT query
    $query = "INSERT INTO products (category_id, product_name, description, stock, price) values (:category_id, :product_name, :description, :stock, :price)";
    $statement = $db->prepare($query);

    // Bind values to query
    $statement->bindValue(':category_id', $category);
    $statement->bindValue(':product_name', $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':stock', $stock);
    $statement->bindValue(':price', $price);

    // Execute statement
    $statement->execute();

    // Redirect back to admin page and exit script.
    header("Location: admin.php");
    exit;
  }
  // If form was POSTed with empty data, redirect to error page.
  else if($_POST && (empty($_POST['title']) || empty($_POST['content']))){
    header("Location: error.html");
    exit;
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Product</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Create Product</h1>
      </div>

      <form class="create-product-form" action="create_product.php" method="post">
        <label for="title">Product Name</label>
        <input id="title" type="text" name="title" value="">

        <label for="category">Category</label>
        <input id="category" type="text" name="category" value="">

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
      </form>
    </main>

  </body>
</html>
