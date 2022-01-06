<?php

session_start();

require 'connect.php';
require 'functions.php';

if (isset($_POST['update'])) {

  $fname = clean($_POST['firstname']);
  $lname = clean($_POST['lastname']);
  $course = clean($_POST['course']);
  $yrlevel = clean($_POST['yrlevel']);

  $query = "UPDATE students SET firstname = '$fname', lastname = '$lname', course = '$course', yrlevel = '$yrlevel'
    WHERE id='" . $_SESSION['userid'] . "'";

  if ($result = mysqli_query($con, $query)) {

    $_SESSION['prompt'] = "Profile Updated";
    header("location:profile.php");
    exit;
  } else {

    die("Error with the query");
  }
}

if (isset($_SESSION['username'], $_SESSION['password'])) {

  $qry = mysqli_query($con, "SELECT * FROM students where id = {$_SESSION['userid']} ");
  $data = mysqli_fetch_array($qry);
  extract($data);

?>

  <!DOCTYPE html>
  <html>

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./assets/img/logo.png" type="image/x-icon">
    <title>Edit Profile - Student Information System</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

  </head>

  <body>

    <?php include 'header.php'; ?>

    <section>



      <div class="edit-form box-left clearfix box-center">
        <div class="container">
          <strong class="title">Edit Profile</strong>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

          <div class="form-group">
            <label>Student No:</label>

            <?php
            $query = "SELECT studentno FROM students WHERE id = '" . $_SESSION['userid'] . "'";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_row($result);

            echo "<p>" . $row[0] . "</p>";
            ?>

          </div>


          <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" name="firstname" value="<?php echo $firstname ?>" placeholder="First Name" required>
          </div>


          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" name="lastname" value="<?php echo $lastname ?>" placeholder="Last Name" required>
          </div>


          <div class="form-group">
            <label for="course">Course</label>

            <select class="form-control" name="course">

              <option value="BTECH" <?php echo $course == 'BTECH' ? "selected" : ""; ?>>BTECH</option>
              <option value="MTECH" <?php echo $course == 'MTECH' ? "selected" : ""; ?>>MTECH</option>
              <option value="MBA" <?php echo $course == 'MBA' ? "selected" : ""; ?>>MBA</option>
              <option value="MCA" <?php echo $course == 'MCA' ? "selected" : ""; ?>>MCA</option>
              <option value="PhD" <?php echo $course == 'PhD' ? "selected" : ""; ?>>PhD</option>
            </select>

          </div>


          <div class="form-group">
            <label for="yrlevel">Year Level</label>

            <select class="form-control" name="yrlevel">
              <option <?php echo $yrlevel == '1st year' ? "selected" : ""; ?>>1st year</option>
              <option <?php echo $yrlevel == '2nd year' ? "selected" : ""; ?>>2nd year</option>
              <option <?php echo $yrlevel == '3rd year' ? "selected" : ""; ?>>3rd year</option>
              <option <?php echo $yrlevel == '4th year' ? "selected" : ""; ?>>4th year</option>
            </select>

          </div>

          <div class="form-footer">
            <a href="profile.php">Go back</a>
            <input class="btn btn-primary" type="submit" name="update" value="Update Profile">
          </div>


        </form>
      </div>

    </section>


    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>

  </html>

<?php

} else {
  header("location:profile.php");
}

mysqli_close($con);

?>