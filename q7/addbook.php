<?php
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $publisher = trim($_POST['publisher']);
    $author = trim($_POST['author']);
    $edition = trim($_POST['edition']);
    $no_of_page = $_POST['no_of_page'] !== "" ? intval($_POST['no_of_page']) : NULL;
    $price = $_POST['price'] !== "" ? floatval($_POST['price']) : NULL;
    $publish_date = $_POST['publish_date'] !== "" ? $_POST['publish_date'] : NULL;
    $isbn = trim($_POST['isbn']);

    // Use prepared statements for safety
    $stmt = $conn->prepare(
        "INSERT INTO books (title, publisher, author, edition, no_of_page, price, publish_date, isbn)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssssidsd",
        $title,
        $publisher,
        $author,
        $edition,
        $no_of_page,
        $price,
        $publish_date,
        $isbn
    );
    if ($stmt->execute()) {
        echo "Book added successfully! <a href='addbook.html'>Add another book</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
   <title>Add Book</title>
</head>

<body>
   <h2>Add a New Book</h2>
   <form method="post" action="addbook.php">
      Title: <input type="text" name="title" required><br><br>
      Publisher: <input type="text" name="publisher"><br><br>
      Author: <input type="text" name="author"><br><br>
      Edition: <input type="text" name="edition"><br><br>
      No. of Pages: <input type="number" name="no_of_page"><br><br>
      Price: <input type="number" step="0.01" name="price"><br><br>
      Publish Date: <input type="date" name="publish_date"><br><br>
      ISBN: <input type="text" name="isbn"><br><br>
      <button type="submit">Add Book</button>
   </form>
</body>

</html>