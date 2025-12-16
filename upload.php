<?php
require 'header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $file = $_FILES['portfolio'];
        $allowed = ["application/pdf", "image/jpeg", "image/png"];
        $maxSize = 2 * 1024 * 1024;

        if ($file['error'] != 0) {
            throw new Exception("Upload error");
        }

        if (!in_array($file['type'], $allowed)) {
            throw new Exception("Only PDF, JPG, PNG allowed");
        }

        if ($file['size'] > $maxSize) {
            throw new Exception("File size must be under 2MB");
        }

        if (!is_dir("uploads")) {
            throw new Exception("Uploads folder not found");
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = "portfolio_" . time() . "." . $ext;

        move_uploaded_file($file['tmp_name'], "uploads/" . $newName);
        $message = "File uploaded successfully";
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
?>

<h2>Upload Portfolio</h2>
<p><?php echo $message; ?></p>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="portfolio"><br><br>
    <button type="submit">Upload</button>
</form>

<?php require 'footer.php'; ?>
