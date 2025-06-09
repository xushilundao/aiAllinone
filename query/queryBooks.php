<a href="logout.php">Logout</a>
<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}
$servername = "localhost";
$username = "nuclear";
$password = "Ericsson@1234";
$dbname = "nuclear";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current page, default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 200;  // number of records per page
$offset = ($page - 1) * $limit;

// Get the query parameters for bookName and ISBN
$bookName = isset($_GET['bookName']) ? $_GET['bookName'] : '';
$ISBN = isset($_GET['ISBN']) ? $_GET['ISBN'] : '';

// Prepare the query with the filtering conditions
$sql = "SELECT * FROM books WHERE 1";

if ($bookName != '') {
    $sql .= " AND bookName LIKE '%$bookName%'";
}

if ($ISBN != '') {
    $sql .= " AND ISBN LIKE '%$ISBN%'";
}

$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// Display the query form
echo "<form method='get' action='queryBooks.php'>
    <label for='bookName'>Book Name:</label>
    <input type='text' id='bookName' name='bookName' value='$bookName'>
    <label for='ISBN'>ISBN:</label>
    <input type='text' id='ISBN' name='ISBN' value='$ISBN'>
    <input type='submit' value='Query'>
</form>";

// Display results in a table
echo "<table border='1'>
<tr>
    <th>Book Name</th>
    <th>ISBN</th>
    <th>Price</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["bookName"] . "</td>
                <td>" . $row["ISBN"] . "</td>
                <td>" . $row["price"] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No results found</td></tr>";
}

echo "</table>";

// Pagination logic
$sql_count = "SELECT COUNT(*) FROM books WHERE 1";
if ($bookName != '') {
    $sql_count .= " AND bookName LIKE '%$bookName%'";
}
if ($ISBN != '') {
    $sql_count .= " AND ISBN LIKE '%$ISBN%'";
}

$count_result = $conn->query($sql_count);
$count_row = $count_result->fetch_row();
$total_records = $count_row[0];
$total_pages = ceil($total_records / $limit);

echo "<br><br>Pages: ";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='?page=$i&bookName=$bookName&ISBN=$ISBN'>$i</a> ";
}

$conn->close();
?>

