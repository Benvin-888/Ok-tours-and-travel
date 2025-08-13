<?php
$conn = new mysqli("localhost", "root", "", "oktours");

$ids = $_POST['ids'];
$titles = $_POST['titles'];

foreach ($ids as $i => $id) {
    $title = $titles[$i];
    $imagePath = null;
    $videoPath = null;

    // Upload new image if provided
    if ($_FILES['images']['name'][$i]) {
        $imageName = basename($_FILES['images']['name'][$i]);
        $imagePath = "images/" . $imageName;
        move_uploaded_file($_FILES['images']['tmp_name'][$i], $imagePath);
    }

    // Upload new video if provided
    if ($_FILES['videos']['name'][$i]) {
        $videoName = basename($_FILES['videos']['name'][$i]);
        $videoPath = "images/videos/" . $videoName;
        move_uploaded_file($_FILES['videos']['tmp_name'][$i], $videoPath);
    }

    // Build update SQL
    $sql = "UPDATE gallery_items SET title=?, ";
    if ($imagePath) $sql .= "image_path='$imagePath', ";
    if ($videoPath) $sql .= "video_path='$videoPath', ";
    $sql = rtrim($sql, ', ') . " WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $title, $id);
    $stmt->execute();
}

header("Location: manage_gallery.php");
exit;
