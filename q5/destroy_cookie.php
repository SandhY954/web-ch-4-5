<?php
setcookie("username", "", time() - 3600, "/"); // Expire the cookie
echo "Cookie 'username' destroyed.<br>";
echo "<a href='store_cookie.php'>Store Cookie Again</a>";
?>
