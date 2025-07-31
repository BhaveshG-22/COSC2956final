<?php
include 'header.php';

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO string_info (message) VALUES (?)");
        $stmt->execute([$_POST['message']]);
        
        echo "<p style='color: green;'>Message saved successfully!</p>";
    } catch(PDOException $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<h1>Final Exam</h1>

<form method="POST" action="">
    <label for="message">Enter your message:</label><br>
    <input type="text" id="message" name="message" maxlength="50" required><br><br>
    <input type="submit" value="Submit">
</form>

<br>
<a href="showAll.php">Show all records</a>

</body>
</html>