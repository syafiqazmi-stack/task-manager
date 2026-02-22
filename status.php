<?php
include "../config/connection.php";
mysqli_query($conn, "UPDATE tasks SET status='Completed' WHERE id=$_GET[id]");
header("Location: ../dashboard.php");
