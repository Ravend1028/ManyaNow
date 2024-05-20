<?php
  $sql = 'SELECT * FROM tasks';
  $result = mysqli_query($conn, $sql);

  $events = '[';

  while ($row = mysqli_fetch_assoc($result)) {
    $events .= "{";
    $events .= "title: '" . addslashes($row['title']) . "',";
    $events .= "start: '" . $row['start_date'] . "',";
    $events .= "end: '" . $row['end_date'] . "',";
    $events .= "color: 'yellow',";
    $events .= "textColor: 'black'";
    $events .= "},";
  }

  $events .= ']'; 

  echo $events; 
?>
