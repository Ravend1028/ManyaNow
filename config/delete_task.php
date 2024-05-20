<?php include 'database.php'; ?>

<?php 
  if(isset($_POST['title'])) {
    $title = $_POST['title'];
    $sql = "DELETE from tasks where title='$title'";
    
    if (mysqli_query($conn, $sql)) {
      echo "Task removed successfully";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
?>

