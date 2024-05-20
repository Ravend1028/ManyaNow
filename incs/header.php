<?php include 'config/database.php'; ?>

<?php 
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ManyaNow</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark z-2 p-3 border border-dark border-top-0 border-start-0 border-end-0">
    <div class="container">
        <a href="base.php" class="navbar-brand">
          ManyaNow
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navmenu">
          <span class="navbar-toggler-icon">
          </span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="base.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="about.php" class="nav-link">About</a>
            </li>
            

            <?php 
              if(isset($_SESSION['username'])) {
                $user = $_SESSION['username'];
                echo " 
                  <li class='nav-item'>
                    <a href='user_dashboard.php' class='nav-link'>$user</a>
                  </li>
                  <li class='nav-item'>
                    <a href='logout.php' class='nav-link'>Logout</a>
                  </li>
                  " ; 
              } else {
                echo "
                  <li class='nav-item'>
                    <a href='login.php' class='nav-link'>Login</a>
                  </li>";
              }
            ?>

          </ul>
        </div>
      </div>
   </nav>