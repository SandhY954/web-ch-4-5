<?php
$conn = new mysqli('localhost', 'root', '', 'project');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $faculty = trim($_POST['faculty']);

    if ($name && $email && $password && $phone && $gender && $faculty) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO registrations (name, email, password, phone, gender, faculty) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $gender, $faculty);
        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.html'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
   <title>User Registration</title>
</head>

<body>
   <h2>Register</h2>
   <form method="post" action="register.php">
      Name: <input type="text" name="name" required><br><br>
      Email: <input type="email" name="email" required><br><br>
      Password: <input type="password" name="password" required><br><br>
      Phone: <input type="text" name="phone" required pattern="\d{10,15}"><br><br>
      Gender:
      <input type="radio" name="gender" value="Male" required>Male
      <input type="radio" name="gender" value="Female" required>Female<br><br>
      Faculty: <input type="text" name="faculty" required><br><br>
      <button type="submit">Register</button>
   </form>
   <br>
   <a href="login.html">Already have an account? Login</a>
</body>

</html>