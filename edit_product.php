<?php
  require('connect.php');
  require('authenticate.php');

  if(!$_POST && isset($_GET['id'])) {
    // Sanatize GET id
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM products WHERE id = :id";

    $statement = $db->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $row = $statement->fetch();

    // If the query did not return a result,
    // (if the GET id does not match a valid id in the db)
    // then it routes back to the home page.
    if(empty($row['product_name']) && empty($row['description'])){
      header("Location: admin.php");
      exit;
    }
  }
  // UPDATE
  else if($_POST && isset($_POST['update']) && !empty($_POST['title'])) {
    // Sanatize and validate inputs
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);

    // UPDATE Query
    $query = "UPDATE products SET product_name = :title, description = :content, price = :price, stock = :stock WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':stock', $stock);
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
    <title><?= $row['product_name'] ?></title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Edit Product</h1>
      </div>

      <form class="create-product-form" method="post">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <label for="title">Product Name</label>
        <input id="title" type="text" name="title" value="<?= $row['product_name'] ?>">

        <?php
          $category_query = "SELECT * FROM categories";
          $category_statement = $db->prepare($category_query);
          // $statement->bindValue(':id', $id, PDO::PARAM_INT);
          $category_statement->execute();
          $categories = $category_statement->fetchAll();
        ?>
        <label for="category">Category</label>
        <!-- <input id="category" type="text" name="category" value=""> -->
        <select id="category" name="category">
          <?php foreach($categories as $category): ?>
            <?php if($row['category_id'] == $category['category_id']): ?>
              <option selected="selected" value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
            <?php else: ?>
              <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
            <?php endif ?>
          <?php endforeach ?>
        </select>

        <label for="content">Description</label>
        <textarea id="content" name="content" rows="8" cols="80"><?= $row['description'] ?></textarea>

        <div class="spread">
          <div class="">
            <label for="price">Price</label>
            <input id="price" type="number" name="price" value="<?= $row['price'] ?>">
          </div>

          <div class="">
            <label for="stock">Stock</label>
            <input id="stock" type="number" name="stock" value="<?= $row['stock'] ?>">
          </div>
        </div>

        <div class="edit-post-buttons">
          <button type="submit" name="update">UPDATE</button>
          <!-- <button type="submit" name="delete">DELETE</button> -->
        </div>
      </form>
    </main>
  </body>
</html>
