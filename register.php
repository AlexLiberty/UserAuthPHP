<?php
$conn = new mysqli('localhost', 'root', '', 'user');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password))
    {
        // Перевіряємо, чи зайнятий логін
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $checkStmt->bind_param('s', $username);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0)
        {
            echo "taken";
        }
        else
        {

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insertStmt = $conn->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
            $insertStmt->bind_param('ss', $username, $password_hash);

            if ($insertStmt->execute())
            {
                echo "success";
            } else {
                echo "error";
            }
            $insertStmt->close();
        }

        $checkStmt->close();
    }
    else
    {
        echo "error";
    }
}
$conn->close();
?>
