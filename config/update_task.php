<?php include 'database.php'; ?>

<?php
  if(isset($_POST['title'])) {
	  $title = $_POST['title'];
	  $start_date = $_POST['start'];
	  $end_date = $_POST['end'];
    $sql = "UPDATE tasks SET title='$title', start_date='$start_date', end_date='$end_date' WHERE title='$title'";
    
    if (mysqli_query($conn, $sql)) {
      echo "Task updated successfully";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
?>