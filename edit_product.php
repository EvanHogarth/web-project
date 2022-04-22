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

    // Checkbox for deleting image
    if(isset($_POST['delete_image'])) {
      $query = "UPDATE products SET image_url = NULL WHERE id = :id";
      $statement = $db->prepare($query);
      $statement->bindValue(':id', $id, PDO::PARAM_INT);
      $statement->execute();

      unlink($_POST['delete_image']);
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    if ($image_upload_detected) {
      $image_filename       = $_FILES['image']['name'];
      $temporary_image_path = $_FILES['image']['tmp_name'];
      $new_image_path       = "uploads/" . $image_filename;

      if (file_is_an_image($temporary_image_path, $new_image_path)) {
          move_uploaded_file($temporary_image_path, $new_image_path);

          // Create INSERT query
          $query = "UPDATE products SET image_url = :image_path WHERE id = :id";
          $statement = $db->prepare($query);
          $statement->bindValue(':image_path', $new_image_path);
          $statement->bindValue(':id', $id, PDO::PARAM_INT);
          $statement->execute();
        }
    }

    // Go back to admin page after complete
    header("Location: admin.php");
    exit;
  }


  function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
    $current_folder = dirname(__FILE__);
    $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
    return join(DIRECTORY_SEPARATOR, $path_segments);
  }

  function file_is_an_image($temporary_path, $new_path) {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
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

      <form class="create-product-form" enctype="multipart/form-data" method="post">
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

        <label for="image">Image</label>
        <input type="file" name="image" id="image">

        <?php if(!empty($row['image_url'])): ?>
          <p>Current image: <?= $row['image_url'] ?></p>
          <label for="delete_image">Delete image</label>
          <input type="checkbox" id="delete_image" name="delete_image" value="<?= $row['image_url'] ?>">
        <?php endif ?>

        <div class="edit-post-buttons">
          <button type="submit" name="update">UPDATE</button>
          <!-- <button type="submit" name="delete">DELETE</button> -->
        </div>
      </form>
    </main>
  </body>
</html>
