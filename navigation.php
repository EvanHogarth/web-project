<?php
  session_start();

  $navQuery = "SELECT * FROM categories";

  $navStatement = $db->prepare($navQuery);

  $navStatement->execute();
?>

<nav>
  <a href="index.php"><h2 id="logo">Silver Lotus</h2></a>
  <!-- <a href="index.php"><img id="logo" src="images/logo.svg" alt="logo"></a> -->

  <div class="dropdown">
    <button class="dropdown-button">Categories ▼</button>
    <div class="dropdown-content">
      <!-- <?php if(isset($_SESSION["logged_in_email"])): ?>
        <a class="nav-links" href="all_products.php">All Products</a>
      <?php endif ?> -->
      <a class="nav-links" href="all_products.php">All Products</a>
      <?php while($category = $navStatement->fetch()): ?>
        <a class="nav-links" href="category_page.php?id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?></a>
      <?php endwhile ?>
    </div>
  </div>

  <form id="search-bar" action="search_products.php">
    <input id="search-input" type="text" placeholder="Search..." name="search">

    <?php
      $category_query = "SELECT * FROM categories";
      $category_statement = $db->prepare($category_query);
      $category_statement->execute();
      $categories = $category_statement->fetchAll();
    ?>
    <select id="category-search" name="category">
      <option selected="selected" value="-1">All Categories</option>
      <?php foreach($categories as $category): ?>
        <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
      <?php endforeach ?>
    </select>

    <button id="search-button" type="submit"><img id="search-icon" src="images/search-symbol.png" alt=""></button>
  </form>

  <?php if(isset($_SESSION["logged_in_email"])): ?>
    <a class="nav-links" href="logout.php">Log Out</a>
  <?php else: ?>
    <a class="nav-links" href="login_page.php">Log In</a>
  <?php endif ?>

  <a id="admin-link" class="nav-links" href="admin.php">CMS</a>

  <img id="cart-icon" src="images/icon-cart.svg" alt="cart">
</nav>
