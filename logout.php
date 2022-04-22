<?php

  session_start();

  $_SESSION = [];

  echo '<script>alert("Logged Out"); window.location.href="index.php";</script>';
  exit;

?>
