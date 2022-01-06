<?php

session_start();

require 'connect.php';
require 'functions.php';

if (isset($_POST['login'])) {

  $uname = clean($_POST['username']);
  $pword = clean($_POST['password']);

  $query = "SELECT * FROM students WHERE username = '$uname' AND password = '$pword'";

  $result = mysqli_query($con, $query);

  if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $_SESSION['userid'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['password'] = $row['password'];

    header("location:profile.php");
    exit;
  } else {

    $_SESSION['errprompt'] = "Wrong username or password.";
  }
}

if (!isset($_SESSION['username'], $_SESSION['password'])) {

?>

  <!DOCTYPE html>
  <html>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Student Information System</title>
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
  </head>

  <body>

    <?php include 'header.php'; ?>

    <section class="center-text">



      <div class="login-form box-center">
        <div class="container" style="width: inherit; margin-bottom: 20px;">
          <strong class="title">Log In</strong>
        </div>
        <?php

        if (isset($_SESSION['prompt'])) {
          showPrompt();
        }

        if (isset($_SESSION['errprompt'])) {
          showError();
        }

        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">


          <div class="form-group">
            <label for="username" class="sr-only">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
          </div>

          <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>

          <a href="register.php">Need an account?</a>
          <input class="btn btn-primary" type="submit" name="login" value="Log In">

        </form>
      </div>

    </section>


    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>

  </html>

<?php

} else {
  header("location:profile.php");
  exit;
}

unset($_SESSION['prompt']);
unset($_SESSION['errprompt']);

mysqli_close($con);

?>