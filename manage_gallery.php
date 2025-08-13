<?php
$conn = new mysqli("localhost", "root", "", "oktours");
$result = $conn->query("SELECT * FROM gallery_items");
?>

<h2>Manage Gallery</h2>
<form action="update_gallery.php" method="post" enctype="multipart/form-data">
  <?php while($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
      <input type="hidden" name="ids[]" value="<?= $row['id'] ?>">

      <label>Title:</label><br>
      <input type="text" name="titles[]" value="<?= htmlspecialchars($row['title']) ?>"><br><br>

      <label>Current Image:</label><br>
      <img src="<?= $row['image_path'] ?>" width="100"><br>
      <input type="file" name="images[]"><br><br>

      <label>Current Video:</label><br>
      <video width="200" controls>
        <source src="<?= $row['video_path'] ?>" type="video/mp4">
      </video><br>
      <input type="file" name="videos[]"><br>
    </div>
  <?php endwhile; ?>
  <button type="submit">Update Gallery</button>
</form>
