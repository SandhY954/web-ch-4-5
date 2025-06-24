<?php
session_start();
$_SESSION['username'] = 'reekha';
$_SESSION['email'] = 'reekha@gmail.com';
echo "Session data stored.<br>";
echo "<a href='retrieve_session.php'>Retrieve Session Data</a><br>";
echo "<a href='destroy_session.php'>Destroy Session Data</a>";
?>
