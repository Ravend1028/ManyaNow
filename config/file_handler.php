<?php include 'database.php'; ?>

<?php 
  $fileErr = '';
  $message = '';
  
  if (isset($_POST['submit'])) {
      if ($_FILES['file-upload']['error'] === UPLOAD_ERR_OK) {
          // Check if the uploaded file is of allowed types
          $allowedExtensions = array('jpg', 'gif', 'png', 'txt', 'pdf', 'doc', 'docx');
          $fileTmpPath = $_FILES['file-upload']['tmp_name'];
          $fileName = $_FILES['file-upload']['name'];
          $fileSize = $_FILES['file-upload']['size'];
          $fileType = $_FILES['file-upload']['type'];
          $fileNameCmps = explode(".", $fileName);
          $fileExtension = strtolower(end($fileNameCmps));
  
          // Validate file extension
          if (!in_array($fileExtension, $allowedExtensions)) {
              $fileErr = 'Error: Only ' . implode(', ', $allowedExtensions) . ' files are allowed';
          } elseif ($fileSize == 0) {
              $fileErr = 'Error: Empty file uploaded';
          } else {
              // Insert file information into the database
              $fileName = mysqli_real_escape_string($conn, $fileName); // Sanitize file name
              $sql = "INSERT INTO files (file) VALUES ('$fileName')";
  
              if (mysqli_query($conn, $sql)) {
                  $message = 'File is successfully uploaded and saved to the database.';
                  // Redirect to the user dashboard after successful upload
                  header('Location: ../user_dashboard.php?upload_success');
                  exit();
              } else {
                  $fileErr = 'Failed to save the file information to the database.';
              }
          }
      } elseif ($_FILES['file-upload']['error'] === UPLOAD_ERR_NO_FILE) {
          // No file was selected
          $fileErr = 'Error: Please select a file to upload';
      } else {
          $fileErr = 'Error uploading file';
      }
  }
  
  if (!empty($fileErr)) {
    echo "<script>alert('$fileErr');</script>";
    // Redirect to user_dashboard.php with a delay
    echo "<script>setTimeout(function(){ window.location.href = '../user_dashboard.php'; }, 500);</script>";
    exit();
  }
?>