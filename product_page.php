<?php
  require('connect.php');

  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $slug = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $slug = str_replace("-", " ", $slug);

  $query = "SELECT * FROM products WHERE id = :id AND product_name = :slug";

  $statement = $db->prepare($query);

  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->bindValue(':slug', $slug);

  $statement->execute();

  $row = $statement->fetch();

  if(empty($row)) {
    $error_msg = "Sorry no product was found.";
  }

  //Handle comment form submission
  if($_POST && isset($_POST['submit']) && !empty($_POST['comment'])){
    // Sanitize the input
    $product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $review_comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $slug = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Create INSERT query
    $query = "INSERT INTO reviews (product_id, user_name, comment) values (:product_id, :user_name, :comment)";
    $statement = $db->prepare($query);

    // Bind values to query
    $statement->bindValue(':product_id', $product_id);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':comment', $review_comment);

    // Execute statement
    $statement->execute();

    header("Location:product_page.php?id=".$product_id."&p=".str_replace("%20", " ", $slug));
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

    <div class="product-page">
      <?php if(isset($error_msg)): ?>
        <h2><?= $error_msg ?></h2>

      <?php else: ?>

            <?php if(!empty($row['image_url'])): ?>
              <div class="product-images">
                <img class="product-image" src="<?= $row['image_url'] ?>" alt="product image">
              </div>
            <?php endif ?>

            <div class="product-info">
              <h2><?= $row['product_name'] ?></h2>
              <p><?= $row['description'] ?></p>
              <p class="product-price">$<?= $row['price'] ?></p>

              <!-- If stock is greater than 0, allow to add to cart -->
              <?php if($row['stock'] > 0): ?>
                <button type="button" name="button">Add to cart</button>
              <?php else: ?>
                <h4>Out of stock</h4>
              <?php endif ?>
            </div>

          </div>

          <div class="comment-container">
            <h4>Comments</h4>

            <?php
              $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
              $comment_query = "SELECT * FROM reviews WHERE product_id = :id ORDER BY created_on DESC";
              $comment_statement = $db->prepare($comment_query);
              $comment_statement->bindValue(':id', $id, PDO::PARAM_INT);
              $comment_statement->execute();
              $comments = $comment_statement->fetchAll();
            ?>
            <?php if(empty($comments)): ?>
              <p>There are no reviews for this product.</p>
            <?php else: ?>
              <?php foreach($comments as $comment): ?>
                <div class="comment-block">
                  <h5>Name: <?= $comment['user_name'] ?></h5>
                  <p>Created on: <?= $comment['created_on'] ?></p>
                  <p>Comment: <?= $comment['comment'] ?></p>
                </div>
              <?php endforeach ?>
            <?php endif ?>


            <form id="comment-form" class="comment-form" action="" method="post">
              <h4>Add a comment</h4>

              <label for="user_name">Name:</label>
              <input id="user_name" type="text" name="user_name" value="">

              <label for="comment">Comment:</label>
              <textarea id="comment" name="comment" rows="8" cols="80"></textarea>

              <button type="submit" name="submit">Submit</button>
            </form>


    <?php endif ?>
    </div>



    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
