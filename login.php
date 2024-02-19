<?php
session_start();

if(isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['first_name']) && isset($_POST['$last_name']) && isset($_POST['role'])){
    function validate($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
    }
}
// Retrieve data from POST request
$username = $_POST['username'];
$password = $_POST['password'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$role = $_POST['role']; 

if(empty($username))
{
    header("Location: login.php?error= user name is required");
    exit();
}
else if(empty($password)){
    header("Location: login.php?error= password is required: ");
    exit();
}
else if(empty($first_name)){
    header("Location: login.php?error= first name is required: ");
    exit();
}
else if(empty($last_name)){
    header("Location: login.php?error= last name is required: ");
    exit();
}
else if(empty($role)){
    header("Location: login.php?error= role is required: ");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "prison"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $role=sanitize($_POST['$role']);


    // Query the database
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password' AND first_name='$first_name' AND last_name='$last_name' AND role='$role'";
    $result =mysql_query($conn, $sql);  

    // Check if a matching record was found
    if (mysql_num_rows($result) === 1) {
        $row = mysql_fetch_array($result);
        if($row['username']===$username && $row['password'] === $password && $row['first_name'] === $first_name && $row['last_name'] === $last_name && $row['role'] === $role)
        {
            echo "logged in";
            $_SESSION
        }
        // User authenticated
        header("Location: template.html"); // Redirect to template.html
        exit();
    } else {
        // User not found or incorrect credentials
        echo "Error: Invalid username or password";
    }
}

// Close database connection
$conn->close();
?>
