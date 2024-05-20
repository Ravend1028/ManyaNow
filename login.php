<?php include 'incs/header.php'; ?>

<?php 
  $username = $password = '';
  $usernameErr = $passwordErr = '';
  $incorrectPw = $unrecognizedUser = '';

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
      //$password = password_hash($password, PASSWORD_DEFAULT);
      //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $password = $_POST["password"];
    }

    if (empty($usernameErr) && empty($passwordErr)) {
      // search db
      $sql = "SELECT password FROM accounts WHERE username = '$username'";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPasswordFromDb = $row['password'];
    
            // Verify the entered password with the hashed password from the database
            if (password_verify($password, $hashedPasswordFromDb)) {
              session_start();
              $_SESSION['username'] = $username;
              header('Location: user_dashboard.php');
            } else {
              $incorrectPw = 'Incorrect Username or Password';
            }

        } else {
          $unrecognizedUser = 'Incorrect Username or Password';
        }
      } else {
        echo 'Error: ' . mysqli_error($conn);
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
                <h2>Login</h2>
              </div>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3 d-flex flex-column">
                  <label for="username" class="form-label align-self-start ms-5 ps-1 ps-sm-3">Username</label>
                  <input type="text" class="form-control <?php echo !$usernameErr ?: 'is-invalid'; ?> w-75 mx-auto rounded-pill" name="username" placeholder="Enter your username">
                  <span class="text-danger m-0 p-0"><?php echo $usernameErr ?></span>
                </div>
                <div class="mb-4 d-flex flex-column">
                  <label for="password" class="form-label align-self-start ms-5 ps-1 ps-sm-3">Password</label>
                  <input type="password" class="form-control <?php echo !$passwordErr ?: 'is-invalid'; ?>  w-75 mx-auto rounded-pill" name="password" placeholder="Enter your password">
                  <span class="text-danger m-0 p-0"><?php echo $passwordErr ?></span>
                  <span class="text-danger m-0 p-0"><?php echo $incorrectPw ?></span>
                  <span class="text-danger m-0 p-0"><?php echo $unrecognizedUser ?></span>
                </div>
                <div class="mb-3">
                  <input type="submit" name="submit" value="Login" class="btn btn-dark btn-md rounded-pill w-75">
                </div>
              </form>
              <div class="mb-3">
                <a href="forgot_pass.php">Forgot Password</a>
              </div>
              <hr>
              <div class="mb-3">
                <a href="signup.php">Create an Account</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include 'incs/footer.php'; ?>