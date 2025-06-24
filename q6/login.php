<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'project');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM registrations WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password. <a href='login.html'>Try again</a>";
        }
    } else {
        echo "User not found. <a href='login.html'>Try again</a>";
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
      Email: <input type="email" name="email" required><br><br>
      Password: <input type="password" name="password" required><br><br>
      <button type="submit">Login</button>
   </form>
   <br>
   <a href="registration.html">Don't have an account? Register</a>
</body>

</html>