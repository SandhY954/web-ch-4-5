<?php
if(isset($_COOKIE['username'])) {
    echo "Username Cookie: " . $_COOKIE['username'] . "<br>";
} else {
    echo "Cookie 'username' not found.<br>";
}
echo "<a href='destroy_cookie.php'>Destroy Cookie</a>";
?>
