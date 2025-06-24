<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $principal = isset($_POST['principal']) ? floatval($_POST['principal']) : 0;
    $rate = isset($_POST['rate']) ? floatval($_POST['rate']) : 0;
    $time = isset($_POST['time']) ? floatval($_POST['time']) : 0;

    echo "<h2>Calculation Result</h2>";

    if (isset($_POST['simple'])) {
        // Simple Interest
        $simple_interest = ($principal * $rate * $time) / 100;
        echo "Simple Interest: <b>" . number_format($simple_interest, 2) . "</b>";
    }

    if (isset($_POST['compound'])) {
        // Compound Interest
        $compound_interest = $principal * pow((1 + $rate/100), $time) - $principal;
        echo "Compound Interest: <b>" . number_format($compound_interest, 2) . "</b>";
    }

    echo "<br><br><a href='interest.html'>Calculate Again</a>";
} else {
    // Redirect if accessed directly
    header('Location: interest.html');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
   <title>Interest Calculator</title>
</head>

<body>
   <h2>Simple & Compound Interest Calculator</h2>
   <form method="post" action="interest.php">
      <label>Principal:</label>
      <input type="number" step="any" name="principal" required><br><br>
      <label>Rate (%):</label>
      <input type="number" step="any" name="rate" required><br><br>
      <label>Time (years):</label>
      <input type="number" step="any" name="time" required><br><br>
      <button type="submit" name="simple">Calculate Simple Interest</button>
      <button type="submit" name="compound">Calculate Compound Interest</button>
   </form>
</body>

</html>