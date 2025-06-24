<?php
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM books");
echo "<h2>Edit Books</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>";
    echo "<tr>
            <th>Title</th>
            <th>Author</th>
            <th>Edit</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['title']}</td>
                <td>{$row['author']}</td>
                <td><a href='editbook.php?id={$row['id']}'>Edit</a></td>
                <td><a href='./../q10.php?id={$row['id']}'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No books found.";
}
$conn->close();
?>
