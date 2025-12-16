<?php
require 'header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $skills = trim($_POST['skills']);

        if (empty($name) || empty($email)) {
            throw new Exception("All fields are required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Convert skills string to array
        $skillsArray = explode(",", $skills);

        // Save to file
        $data = $name . "|" . $email . "|" . implode(",", $skillsArray) . PHP_EOL;
        file_put_contents("students.txt", $data, FILE_APPEND);

        $message = "Student information saved successfully";
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

<h2>Add Student Info</h2>
<p><?php echo $message; ?></p>

<form method="post">
    Name: <input type="text" name="name"><br><br>
    Email: <input type="text" name="email"><br><br>
    Skills: <input type="text" name="skills" placeholder="PHP, HTML, CSS"><br><br>
    <button type="submit">Save</button>
</form>

<?php require 'footer.php'; ?>
