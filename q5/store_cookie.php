<?php
setcookie("username", "JohnDoe", time() + 3600, "/"); // Expires in 1 hour
echo "Cookie 'username' stored.<br>";
echo "<a href='retrieve_cookie.php'>Retrieve Cookie</a><br>";
echo "<a href='destroy_cookie.php'>Destroy Cookie</a>";
?>
