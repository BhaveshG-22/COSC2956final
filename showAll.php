<?php
include 'header.php';

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("DELETE FROM string_info WHERE string_id = ?");
        $result = $stmt->execute([$_POST['delete_id']]);
        
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>Record deleted successfully!</p>";
        } else {
            echo "<p style='color: orange;'>No record found with that ID.</p>";
        }
    } catch(PDOException $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<h1>All Records</h1>

<?php
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch all records
    $stmt = $pdo->prepare("SELECT string_id, message FROM string_info ORDER BY string_id");
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($records) > 0) {
        echo "<div style='margin-bottom: 20px;'>";
        foreach ($records as $record) {
            echo "ID: " . htmlspecialchars($record['string_id']) . " - Message: " . htmlspecialchars($record['message']) . "<br>";
        }
        echo "</div>";
    } else {
        echo "<p>No records found.</p>";
    }
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<h2>Delete Record</h2>
<form method="POST" action="">
    <label for="delete_id">Enter string_id to delete:</label><br>
    <input type="number" id="delete_id" name="delete_id" min="1" required><br><br>
    <input type="submit" value="Delete">
</form>

<br>
<a href="index.php">Back to home</a>

</body>
</html>