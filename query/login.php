<?php
session_start();

// 如果已登录，自动跳转
if (isset($_SESSION['userID'])) {
    header("Location: queryBooks.php");
    exit();
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "nuclear";
    $password = "Ericsson@1234";
    $dbname = "nuclear";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $userID = $_POST['userID'];
    $passwd = md5($_POST['passwd']);  // md5加密

    $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ? AND passwd = ? AND isActive = 1");
    $stmt->bind_param("ss", $userID, $passwd);
    $stmt->execute();
    $result = $stmt->get_result();

    // 验证用户
    if ($result->num_rows == 1) {
        $_SESSION['userID'] = $userID;
        header("Location: queryBooks.php");
        exit();
    } else {
        $error = "Invalid credentials or inactive user.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post" action="login.php">
        <label for="userID">User ID:</label>
        <input type="text" id="userID" name="userID" required><br><br>

        <label for="passwd">Password:</label>
        <input type="password" id="passwd" name="passwd" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>

