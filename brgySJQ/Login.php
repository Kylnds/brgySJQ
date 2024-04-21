<?php
// Replace with your database credentials
$host = 'localhost';
$db   = 'db_brgy';
$user = 'username';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
    

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect value of input fields
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    if (empty($username) || empty($password)) {
        echo 'username or password is empty';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM login_table WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            echo 'Logged in successfully';
            // Perform actions after successful login
        } else {
            echo 'Incorrect username or password';
        }
    }
}
?>
