<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $faculty = trim($_POST['faculty']);

    // Validate (simple)
    $errors = [];
    if (empty($name) || empty($email) || empty($password) || empty($phone) || empty($gender) || empty($faculty)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match("/^\d{10,15}$/", $phone)) {
        $errors[] = "Phone must be 10-15 digits.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (count($errors) > 0) {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<a href='registration.html'>Go Back</a>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Store in database
    $stmt = $conn->prepare("INSERT INTO registrations (name, email, password, phone, gender, faculty) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $gender, $faculty);
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Registration successful!</p>";
        echo "<a href='registration.html'>Register Another</a>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
   <title>Registration Form</title>
</head>

<body>
   <h2>User Registration</h2>
   <form method="post" action="register.php">
      <label>Name:</label>
      <input type="text" name="name" required><br><br>

      <label>Email:</label>
      <input type="email" name="email" required><br><br>

      <label>Password:</label>
      <input type="password" name="password" required><br><br>

      <label>Phone:</label>
      <input type="text" name="phone" required pattern="\d{10,15}"><br><br>

      <label>Gender:</label>
      <input type="radio" name="gender" value="Male" required>Male
      <input type="radio" name="gender" value="Female">Female<br><br>

      <label>Faculty:</label>
      <input type="text" name="faculty" required><br><br>

      <button type="submit" name="register">Register</button>
   </form>
</body>

</html>