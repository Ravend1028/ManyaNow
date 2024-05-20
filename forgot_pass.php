<?php include 'incs/header.php'; ?>

<?php 
  $username = $password = $repassword = $hashedPassword =  '';
  $usernameErr = $passwordErr = $repasswordErr =  $mismatchPw = $userNotExist = '';

  if(isset($_POST['submit'])) {

    if(empty($_POST['username'])) {
      $usernameErr = 'Username is required';
    } else {
      $username = filter_input(
        INPUT_POST,
        'username',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_POST['password'])) {
      $passwordErr = 'Password is required';
    } else {
      $password = $_POST["password"];
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    if(empty($_POST['repassword'])) {
      $passwordErr = 'Password is required';
    } else {
      $repassword = password_hash('repassword', PASSWORD_DEFAULT); 
    }

    if (empty($usernameErr) && empty($passwordErr) && empty($repasswordErr)) {

      $sql = "SELECT * FROM accounts WHERE username = '$username'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0) {
        if($_POST['password'] == $_POST['repassword']) {
          $sql = "UPDATE accounts SET password = '$hashedPassword' WHERE username = '$username'";
          if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Password Changed Successfully'); window.location='login.php';</script>";
          } else {
            echo 'Error: ' . mysqli_error($conn);
          }
        } else {
          $mismatchPw = 'The passwords do not match. Please try again.';
        }
      } else {
        $userNotExist = 'The username does not exist. Please try again.';
      }
    }
  }
?>

  <section class="p-5">
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-5">
          <div class="card">
            <div class="card-body text-center">
              <div class="mb-4">
                <h2>Forgot Password</h2>
              </div>
              <form method="POST" action="">
                <div class="mb-3 d-flex flex-column">
                  <label for="username" class="form-label align-self-start ms-5 ps-1 ps-sm-3">Username</label>
                  <input type="text" class="form-control <?php echo !$usernameErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="username" placeholder="Enter your username">
                  <span class="text-danger m-0 p-0"><?php echo $usernameErr ?></span>
                </div>
                <div class="mb-3 d-flex flex-column">
                  <label for="password" class="form-label align-self-start ms-5 ps-1 ps-sm-3">Password</label>
                  <input type="password" class="form-control <?php echo !$passwordErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="password" placeholder="Enter new password">
                  <span class="text-danger m-0 p-0"><?php echo $passwordErr ?></span>
                </div>
                <div class="mb-4 d-flex flex-column">
                  <label for="repassword" class="form-label align-self-start ms-5 ps-1 ps-sm-3">Retype Password</label>
                  <input type="password" class="form-control <?php echo !$passwordErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="repassword" placeholder="Retype new password">
                  <span class="text-danger m-0 p-0"><?php echo $passwordErr ?></span>
                  <span class="text-danger m-0 p-0"><?php echo $mismatchPw ?></span>
                  <span class="text-danger m-0 p-0"><?php echo $userNotExist ?></span>
                </div>
                <div class="mb-3">
                  <input type="submit" name="submit" value="Confirm" class="btn btn-dark btn-md rounded-pill w-75">
                </div>
              </form>
              <hr>
              <div class="mb-3">
                <a href="login.php">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'incs/footer.php'; ?>