<?php
include "header.php";
?>

<div class="container">
    <h2>Upload Student File</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_FILES["file"]) || $_FILES["file"]["error"] != 0) {
        echo "<p style='color:red;'>❌ File not selected or upload error.</p>";
    } else {

        $fileName = $_FILES["file"]["name"];
        $fileTmp  = $_FILES["file"]["tmp_name"];
        $fileSize = $_FILES["file"]["size"];
        $fileType = mime_content_type($fileTmp);

        $allowed = ["application/pdf", "image/jpeg", "image/png"];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($fileType, $allowed)) {
            echo "<p style='color:red;'>❌ Only PDF, JPG, PNG allowed.</p>";
        } elseif ($fileSize > $maxSize) {
            echo "<p style='color:red;'>❌ File must be less than 2MB.</p>";
        } else {

            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = time() . "_" . basename($fileName);

            if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                echo "<p style='color:green;'>✅ File uploaded successfully!</p>";
                echo "<p>Saved as: <b>$newFileName</b></p>";
            } else {
                echo "<p style='color:red;'>❌ Upload failed.</p>";
            }

        } // ← closes inner else
    } // ← closes file check else
} // ← closes REQUEST_METHOD if
?>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>
</div>

<?php
include "footer.php";
?>