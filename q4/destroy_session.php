<?php
session_start();
session_unset();    // Remove all session variables
session_destroy();  // Destroy the session
echo "Session destroyed.<br>";
echo "<a href='store_session.php'>Store Session Again</a>";
?>
