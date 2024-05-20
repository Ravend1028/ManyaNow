<?php include 'incs/header.php'; ?>

<?php 
  $title = $startDate = $endDate = '';
  $titleErr = $startDateErr = $endDateErr = '';

  if(isset($_POST['submit'])) {

    if(empty($_POST['title'])) {
      $titleErr = 'Title is required';
    } else {
      $title = filter_input(
        INPUT_POST,
        'title',
        FILTER_SANITIZE_FULL_SPECIAL_CHARS
      );
    }

    if(empty($_POST['start-date-time'])) {
      $startDateErr = 'Start date is required';
    } else {
        $startDate = filter_input(
          INPUT_POST,
          'start-date-time',
          FILTER_UNSAFE_RAW
        );
    }
  
    if(empty($_POST['end-date-time'])) {
      $endDateErr = 'End date is required';
    } else {
      $endDate = filter_input(
        INPUT_POST,
        'end-date-time',
        FILTER_UNSAFE_RAW
    );
    }

    if (empty($titleErr) && empty($startDateErr) && empty($endDateErr)) {
      $sql = "INSERT INTO tasks (title, start_date, end_date) VALUES ('$title', '$startDate', '$endDate')";
      if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Task Created Successfully'); window.location='user_dashboard.php';</script>";
      } else {
        echo 'Error: ' . mysqli_error($conn);
      }
    }
  }
?>

  <section class="p-3 pb-0">
    <div class="container">
      <h2>Hi, <?php echo $_SESSION['username'] . "!" ?></h2>
      <p class="lead">
        Let's get things done today
      </p>
      <hr class="m-0">
    </div>
  </section>

  <section class="p-2 options-section">
    <div class="container">
      <h4 class="my-3">Organize Tasks</h4>
      <div id="calendar"></div>
    </div>
  </section>

  <div class="container">
    <hr>
  </div>

  <section class="p-2">
    <div class="container">
      <h4 class="my-3">Take Notes</h4>
        <div class="row g-3 mb-4 input_container">
          <input class="col-md-3 me-2 input_field" type="text" placeholder="Add Something">
          <input class="col-md-3 me-2 time_field" type="time">
          <input class="col-md-3 me-2 date_field" type="date">
          <button class="col-md-2 me-2 add_something" style="border: 1px solid black">
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
        <div class="row g-3 text-center task_container"></div>
    </div>
  </section>
  
  <div class="container">
    <hr>
  </div>

  <section class="p-2">
    <div class="container">
      <div class="row g-3">
        <h4 class="my-3">
          Upload Files
        </h4>
        <div class="col-md">
          <form method="POST" action="config/file_handler.php" enctype="multipart/form-data">
            <input type="file" name="file-upload" class="mb-2">
            <input type="submit" name="submit"  value="Upload" class="d-block">
          </form>
        </div>
        <div class="col-md text-center">

          <?php 
             $sql = 'SELECT * FROM files';
             $result = mysqli_query($conn, $sql);
             $files = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
             if (empty($files)) {
              echo "<p class='lead mt-3'>There are no files yet.</p>";
            } else {
                echo "<ul>";
                foreach ($files as $file) {
                    $filePath = './uploaded_files/' . htmlspecialchars($file['file']);
                    echo "<li>";
                    echo "<a href='" . $filePath . "' download>" . htmlspecialchars($file['file']) . "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            }
          ?>

        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registrationModalLabel">Add Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" >
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" placeholder="Enter your Task Title">
            </div>

            <div class="mb-3">
              <label for="start-date-time" class="form-label">Start Date</label>
              <input type="datetime-local" name="start-date-time" class="form-control" placeholder="Enter Task Start Date">
            </div>

            <div class="mb-3">
              <label for="end-date-time" class="form-label">End Date</label>
              <input type="datetime-local" name="end-date-time" class="form-control" placeholder="Enter Task Start Date">
            </div>
            <div class="modal-footer pb-0">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="submit" class="btn btn-dark">Add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php include 'incs/footer.php'; ?>