<?php
$conn = new mysqli('localhost', 'root', '', 'user');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = trim($_POST['username']);

    if (!empty($username)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0)
        {
            echo "taken";
        } else {
            echo "available";
        }
        $stmt->close();
    } else {
        echo "error";
    }
}
$conn->close();
?>
