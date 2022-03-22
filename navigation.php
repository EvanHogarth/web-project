<?php
  $navQuery = "SELECT * FROM categories";

  $navStatement = $db->prepare($navQuery);

  $navStatement->execute();
?>

<nav>
  <a href="index.php"><h2 id="logo">Logo</h2></a>
  <!-- <a href="index.php"><img id="logo" src="images/logo.svg" alt="logo"></a> -->

  <?php while($category = $navStatement->fetch()): ?>
    <a class="nav-links" href="category_page.php?id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?></a>
  <?php endwhile ?>

  <a id="admin-link" class="nav-links" href="admin.php">CMS</a>

  <img id="cart-icon" src="images/icon-cart.svg" alt="cart">
</nav>
