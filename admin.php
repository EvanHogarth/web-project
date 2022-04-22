<?php
  require('connect.php');
  require('authenticate.php');

  // DELETE PRODUCT
  if($_POST && isset($_POST['delete_product'])) {
    // Sanatize and validate int
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM products WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin.php");
    exit;
  }

  // DELETE CATEGORY
  if($_POST && isset($_POST['delete_category'])) {
    // Sanatize and validate int
    $id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM categories WHERE category_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin.php");
    exit;
  }

  // DELETE USER
  if($_POST && isset($_POST['delete_user'])) {
    // Sanatize and validate int
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM users WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

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

      <div class="admin-spread">
        <h3>Products</h3>
        <div class="">
          <p>Sorted by</p>
          <select class="" name="">
            <option value="">Product ID</option>
            <option value="">Category</option>
            <option value="">Product Name</option>
          </select>
        </div>
      </div>

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


      <h3>Users</h3>
      <?php
        $query = "SELECT * FROM users";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
      ?>
      <table class="admin-tables">
        <thead>
          <tr>
            <th>ID</th>
            <th>Email</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach($users as $user): ?>
            <tr>
              <td><?= $user['user_id'] ?></td>
              <td><?= $user['user_email'] ?></td>
              <td class="remove"><a href="update_user.php?id=<?= $user['user_id'] ?>">Edit</a></td>
              <td class="remove">
                <form class="" action="admin.php" method="post">
                  <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">

                  <button class="remove-button" type="submit" name="delete_user">Remove</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

      <a href="create_user.php"><button class="admin-buttons">Add User</button></a>
    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
