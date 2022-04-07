<?php
  require('connect.php');
  require('authenticate.php');

  // DELETE
  if($_POST && isset($_POST['delete_product'])) {
    // Sanatize and validate int
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // DELETE Query
    $query = "DELETE FROM products WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Go back to homepage after complete
    header("Location: admin.php");
    exit;
  }

  if($_POST && isset($_POST['delete_category'])) {
    // Sanatize and validate int
    $id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);

    // DELETE Query
    $query = "DELETE FROM categories WHERE category_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Go back to homepage after complete
    header("Location: admin.php");
    exit;
  }
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
      <table class="admin-tables">
        <thead>
          <tr>
            <th>ID</th>
            <th>Category Name</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach($categories as $category): ?>
            <tr>
              <td><?= $category['category_id'] ?></td>
              <td><?= $category['category_name'] ?></td>
              <td class="remove"><a href="edit_category.php?id=<?= $category['category_id'] ?>">Edit</a></td>
              <td class="remove">
                <form class="" action="admin.php" method="post">
                  <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">

                  <button class="remove-button" type="submit" name="delete_category">Remove</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

      <a href="create_category.php"><button class="admin-buttons">Add Category</button></a>

      <h3>Products</h3>
      <?php
        $productQuery = "SELECT * FROM products";
        $productStatement = $db->prepare($productQuery);
        // $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $productStatement->execute();
        $products = $productStatement->fetchAll();
      ?>
      <table class="admin-tables">
        <tr>
          <th>ID</th>
          <th>Product Name</th>
        </tr>

        <?php foreach($products as $product): ?>
          <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['product_name'] ?></td>
            <td class="remove"><a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a></td>

            <td class="remove">
              <form class="" action="admin.php" method="post">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">

                <button class="remove-button" type="submit" name="delete_product">Remove</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </table>

      <a href="create_product.php"><button class="admin-buttons">Add Product</button></a>

    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
