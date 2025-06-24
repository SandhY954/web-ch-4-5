<?php
session_start(); // Start the session

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'project');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Look for the user in the registrations table
    $stmt = $conn->prepare("SELECT id, name, password FROM registrations WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If user exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            echo "<p style='color:green;'>Login successful! Welcome, $name.</p>";
            echo "<a href='login.html'>Try Next</a>";
        } else {
            echo "<p style='color:red;'>Incorrect password.</p>";
            echo "<a href='login.html'>Try Again</a>";
        }
    } else {
        echo "<p style='color:red;'>User not found.</p>";
        echo "<a href='login.html'>Try Again</a>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
   <title>User Login</title>
</head>

<body>
   <h2>Login</h2>
   <form method="post" action="login.php">
      <label>Email:</label>
      <input type="email" name="email" required><br><br>

      <label>Password:</label>
      <input type="password" name="password" required><br><br>

      <button type="submit" name="login">Login</button>
   </form>
</body>

</html>