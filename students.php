<?php
require 'header.php';

if (file_exists("students.txt")) {
    $students = file("students.txt");

    foreach ($students as $student) {
        list($name, $email, $skills) = explode("|", $student);
        $skillsArray = explode(",", $skills);

        echo "<h3>$name</h3>";
        echo "Email: $email<br>";
        echo "Skills:<ul>";

        foreach ($skillsArray as $skill) {
            echo "<li>$skill</li>";
        }

        echo "</ul>";
    }
} else {
    echo "No student records found";
}

require 'footer.php';
?>
