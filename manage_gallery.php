<?php
// update-gallery.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "oktours");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$ids = $_POST['ids'] ?? [];
$titles = $_POST['titles'] ?? [];
$images = $_FILES['images'] ?? null;
$videos = $_FILES['videos'] ?? null;

$error = false;

for ($i = 0; $i < count($ids); $i++) {
    $id = intval($ids[$i]);
    $title = $titles[$i];

    // Get current DB paths
    $res = $conn->query("SELECT image_path, video_path FROM gallery_items WHERE id=$id");
    $row = $res->fetch_assoc();
    $imagePath = $row['image_path'];
    $videoPath = $row['video_path'];

    // Handle new image
    if (!empty($images['name'][$i])) {
        $newImage = handleUpload([
            'name' => $images['name'][$i],
            'tmp_name' => $images['tmp_name'][$i],
            'type' => $images['type'][$i],
        ], 'images', ['image/jpeg','image/png','image/gif'], 'img_');
        if ($newImage) $imagePath = $newImage;
        else $error = true;
    }

    // Handle new video
    if (!empty($videos['name'][$i])) {
        $newVideo = handleUpload([
            'name' => $videos['name'][$i],
            'tmp_name' => $videos['tmp_name'][$i],
            'type' => $videos['type'][$i],
        ], 'images/videos', ['video/mp4','video/webm','video/ogg'], 'vid_');
        if ($newVideo) $videoPath = $newVideo;
        else $error = true;
    }

    $stmt = $conn->prepare("UPDATE gallery_items SET title=?, image_path=?, video_path=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $imagePath, $videoPath, $id);
    if (!$stmt->execute()) $error = true;
    $stmt->close();
}

$conn->close();

// Redirect back with success or error message
if ($error) {
    header("Location: manage-gallery.php?error=1");
} else {
    header("Location: manage-gallery.php?success=1");
}
exit;

function handleUpload($file, $dir, $allowedTypes, $prefix) {
    $tmp = $file['tmp_name'];
    $name = uniqid($prefix) . "_" . basename($file['name']);
    $targetDir = __DIR__ . "/$dir/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $targetPath = $targetDir . $name;

    $mimeType = mime_content_type($tmp);
    if (!in_array($mimeType, $allowedTypes)) return false;

    if (move_uploaded_file($tmp, $targetPath)) return "$dir/$name";
    return false;
}
