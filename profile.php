<?php

session_start();

require 'connect.php';
require 'functions.php';

if (isset($_SESSION['username'], $_SESSION['password'])) {

?>

  <!DOCTYPE html>
  <html>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">
    <title>Profile - Student Information System</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
  </head>

  <body>

    <?php include 'header.php'; ?>

    <section>




      <div class="profile-box box-center box-left">
        <div class="container" style="margin: 0px; padding: 0px">
          <strong class="title">My Profile</strong>
        </div>

        <?php

        if (isset($_SESSION['prompt'])) {
          showPrompt();
        }


        $query = "SELECT * FROM students WHERE username = '" . $_SESSION['username'] . "' AND password = '" . $_SESSION['password'] . "'";;

        if ($result = mysqli_query($con, $query)) {

          $row = mysqli_fetch_assoc($result);

          echo "<div class='info'><strong>Student No:</strong> <span>" . ($row['studentno'] + 112212121) . "</span></div>";
          echo "<div class='info'><strong>Student Name:</strong> <span>" . $row['firstname'] . " " . $row['lastname'] . "</span></div>";
          echo "<div class='info'><strong>Course:</strong> <span>" . $row['course'] . "</span></div>";
          echo "<div class='info'><strong>Year Level:</strong> <span>" . $row['yrlevel'] . "</span></div>";

          $query_date = "SELECT DATE_FORMAT(date_joined, '%m/%d/%Y') FROM students WHERE id = '" . $_SESSION['userid'] . "'";
          $result = mysqli_query($con, $query_date);

          $row = mysqli_fetch_row($result);

          echo "<div class='info'><strong>Date Joined:</strong> <span>" . $row[0] . "</span></div>";
        } else {

          die("Error with the query in the database");
        }

        ?>

        <div class="options">
          <a class="btn btn-primary" href="editprofile.php">Edit Profile</a>
          <a class="btn btn-success" href="changepassword.php">Change Password</a>
        </div>


      </div>

    </section>


    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>

  </html>

<?php


} else {
  header("location:index.php");
  exit;
}

unset($_SESSION['prompt']);
mysqli_close($con);

?>