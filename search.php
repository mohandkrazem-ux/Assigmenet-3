<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>

<h2>Search User</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Enter username">
    <button type="submit" name="search">Search</button>
</form>

<?php
include "db.php";

if (isset($_POST['search'])) {

    $username = $_POST['username'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $_SESSION['result'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    header("Location: search.php");
    exit;
}

if (isset($_SESSION['result'])) {

    if (count($_SESSION['result']) > 0) {
        foreach ($_SESSION['result'] as $row) {
            echo "Username: " . $row['username'] . "<br>";
        }
    } else {
        echo "No result found";
    }

    unset($_SESSION['result']);
}
?>

</body>
</html>
