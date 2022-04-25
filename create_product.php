<?php
  require('connect.php');
  require('authenticate.php');
  // require_once('gd_imagestyle.php');

  // Checks that POST has been sent and that the title and content are not empty.
  if($_POST && !empty($_POST['title']) && !empty($_POST['content'])){

    // Sanitize the input
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    if ($image_upload_detected) {
        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = "uploads/" . $image_filename;


        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            move_uploaded_file($temporary_image_path, $new_image_path);

            // Create INSERT query
            $query = "INSERT INTO products (category_id, product_name, description, stock, price, image_url) values (:category_id, :product_name, :description, :stock, :price, :image_path)";
            $statement = $db->prepare($query);

            // Bind values to query
            $statement->bindValue(':category_id', $category);
            $statement->bindValue(':product_name', $title);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':stock', $stock);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':image_path', $new_image_path);

            // Execute statement
            $statement->execute();
        }
        else {
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
        }
    }
    else {
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
    }

    // Redirect back to admin page and exit script.
    header("Location: admin.php");
    exit;
  }
  // If form was POSTed with empty data, redirect to error page.
  else if($_POST && (empty($_POST['title']) || empty($_POST['content']))){
    header("Location: error.html");
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
    <title>Create Product</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="simple-flex">
      <div class="header">
        <h1>Create Product</h1>
      </div>

      <form class="create-product-form" enctype="multipart/form-data" method="post">
        <label for="title">Product Name</label>
        <input id="title" type="text" name="title" value="">

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
            <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
          <?php endforeach ?>
        </select>

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

        <label for="image">Image</label>
        <input type="file" name="image" id="image">

        <button type="submit" name="button">SUBMIT</button>
      </form>
    </main>

  </body>
</html>
