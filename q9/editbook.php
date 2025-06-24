<?php
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle update
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $publisher = trim($_POST['publisher']);
    $author = trim($_POST['author']);
    $edition = trim($_POST['edition']);
    $no_of_page = $_POST['no_of_page'] !== "" ? intval($_POST['no_of_page']) : NULL;
    $price = $_POST['price'] !== "" ? floatval($_POST['price']) : NULL;
    $publish_date = $_POST['publish_date'] !== "" ? $_POST['publish_date'] : NULL;
    $isbn = trim($_POST['isbn']);

    $stmt = $conn->prepare(
        "UPDATE books SET title=?, publisher=?, author=?, edition=?, no_of_page=?, price=?, publish_date=?, isbn=? WHERE id=?"
    );
    $stmt->bind_param(
        "ssssidsdi",
        $title,
        $publisher,
        $author,
        $edition,
        $no_of_page,
        $price,
        $publish_date,
        $isbn,
        $id
    );
    if ($stmt->execute()) {
        echo "Book updated successfully! <a href='editbooks.php'>Back to list</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Display form with existing data
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        ?>
        <h2>Edit Book: <?php echo htmlspecialchars($row['title']); ?></h2>
        <form method="post" action="editbook.php">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            Title: <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>
            Publisher: <input type="text" name="publisher" value="<?php echo htmlspecialchars($row['publisher']); ?>"><br><br>
            Author: <input type="text" name="author" value="<?php echo htmlspecialchars($row['author']); ?>"><br><br>
            Edition: <input type="text" name="edition" value="<?php echo htmlspecialchars($row['edition']); ?>"><br><br>
            No. of Pages: <input type="number" name="no_of_page" value="<?php echo htmlspecialchars($row['no_of_page']); ?>"><br><br>
            Price: <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($row['price']); ?>"><br><br>
            Publish Date: <input type="date" name="publish_date" value="<?php echo htmlspecialchars($row['publish_date']); ?>"><br><br>
            ISBN: <input type="text" name="isbn" value="<?php echo htmlspecialchars($row['isbn']); ?>"><br><br>
            <button type="submit">Update Book</button>
        </form>
        <?php
    } else {
        echo "Book not found.";
    }
    $stmt->close();
}
$conn->close();
?>
