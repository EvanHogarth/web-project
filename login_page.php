<?php
  require('connect.php');

  // LOG IN
  if($_POST && isset($_POST['login-button']) && !empty($_POST['user-email']) && !empty($_POST['user-password'])){
    // Sanitize the input
    $user_email = filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_password = filter_input(INPUT_POST, 'user-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Create INSERT query
    $query = "SELECT * FROM users WHERE user_email = :user_email AND user_password = :user_password";
    $statement = $db->prepare($query);

    // Bind values to query
    $statement->bindValue(':user_email', $user_email);
    $statement->bindValue(':user_password', $user_password);

    // Execute statement
    $statement->execute();

    $row = $statement->fetch();

    // If the query did not return a result (user info didnt match user in db),
    // then trigger error message
    if(empty($row['user_id'])){
      $login_error = "Invalid log in. Please try again.";
    }
    else {
      $login_error = "Success";
      session_start();
      $_SESSION["logged_in_email"] = $row['user_email'];

      // header("Location: index.php");
      echo '<script>alert("Log in success"); window.location.href="index.php";</script>';
      exit;
    }

    // Redirect back to home page and exit script.
    // header("Location: index.php");
    // exit;
  }


  // REGISTER USER
  if($_POST && isset($_POST['register-user']) && !empty($_POST['register-email']) && !empty($_POST['register-password']) && !empty($_POST['register-password2'])){
    // Check that passwords match, strcmp returns 0 if they match
    if(strcmp($_POST['register-password'], $_POST['register-password2']) != 0) {
      $register_error = "Passwords do not match.";
    }
    else {
      $register_error = NULL;

      // Sanitize the input
      $email = filter_input(INPUT_POST, 'register-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password1 = filter_input(INPUT_POST, 'register-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password2 = filter_input(INPUT_POST, 'register-password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      // Create INSERT query
      $query = "INSERT INTO users (user_email, user_password) values (:register_email, :register_password)";
      $statement = $db->prepare($query);

      // Bind values to query
      $statement->bindValue(':register_email', $email);
      $statement->bindValue(':register_password', $password1);

      // Execute statement
      $statement->execute();

      // Redirect back to home page and exit script.
      header("Location: index.php");
      exit;
    }
  }
  // If form was POSTed with empty data, redirect to error page.
  // else if($_POST && (empty($_POST['title']) || empty($_POST['content']))){
  //   header("Location: error.html");
  //   exit;
  // }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <?php require('navigation.php') ?>

    <main class="homepage-content">

      <h2>Log In</h2>
      <form id="login-form" class="create-product-form" method="post">
        <label for="user-email">Email</label>
        <input type="text" id="user-email" name="user-email" value="">

        <label for="user-password">Password</label>
        <input type="password" id="user-password" name="user-password" value="">

        <?php if(isset($login_error)): ?>
          <p class="error-message"><?= $login_error ?></p>
        <?php endif ?>

        <button type="submit" name="login-button" id="login-button">Submit</button>
      </form>

      <br><br>

      <h2>Sign Up</h2>
      <form id="signup-form" class="create-product-form" method="post">
        <label for="register-email">Email</label>
        <input type="text" id="register-email" name="register-email" value="">

        <label for="register-password">Password</label>
        <input type="password" id="register-password" name="register-password" value="">

        <label for="register-password2">Re-enter Password</label>
        <input type="password" id="register-password2" name="register-password2" value="">

        <?php if(isset($register_error)): ?>
          <p class="error-message"><?= $register_error ?></p>
        <?php endif ?>

        <button type="submit" name="register-user" id="register-user">Register</button>
      </form>

    </main>

    <footer>
      <p>Evan Hogarth</p>
    </footer>

  </body>
</html>
