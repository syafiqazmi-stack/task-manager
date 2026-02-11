<?php
include "../config/connection.php";
mysqli_query($conn, "DELETE FROM tasks WHERE id=$_GET[id]");
header("Location: ../dashboard.php");
