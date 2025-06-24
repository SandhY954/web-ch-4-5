<?php
$conn = new mysqli('localhost', 'root', '', 'project');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM books");

if ($result->num_rows > 0) {
    echo "<h2>Book List</h2>";
    echo "<table border='1' cellpadding='8'>";
    echo "<tr>
            <th>ID</th>
            <th>Title</th>
            <th>Publisher</th>
            <th>Author</th>
            <th>Edition</th>
            <th>No. of Pages</th>
            <th>Price</th>
            <th>Publish Date</th>
            <th>ISBN</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['publisher']}</td>
                <td>{$row['author']}</td>
                <td>{$row['edition']}</td>
                <td>{$row['no_of_page']}</td>
                <td>{$row['price']}</td>
                <td>{$row['publish_date']}</td>
                <td>{$row['isbn']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No books found.";
}

$conn->close();
?>
