<?php
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES["background"])) {
    $fileName = basename($_FILES["background"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["background"]["tmp_name"], $targetFile)) {
        $conn = new mysqli("localhost", "root", "", "oktours");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Optional: delete previous background entries if only one is allowed
        $conn->query("DELETE FROM website_background");

        $stmt = $conn->prepare("INSERT INTO website_background (image_path) VALUES (?)");
        $stmt->bind_param("s", $targetFile);
        $stmt->execute();

        echo json_encode(["status" => "success", "path" => $targetFile]);
    } else {
        echo json_encode(["status" => "error", "message" => "Upload failed."]);
    }
}
?>
