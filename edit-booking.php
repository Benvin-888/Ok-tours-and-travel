<?php
$conn = new mysqli("localhost", "root", "", "oktours");

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $result = $conn->query("SELECT * FROM bookings WHERE id=$id");
  $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $place = $_POST['place'];
  $contact = $_POST['contact'];
  $people = $_POST['num_people'];
  $days = $_POST['num_days'];
  $date = $_POST['travel_date'];

  $conn->query("UPDATE bookings SET name='$name', place='$place', contact='$contact', num_people=$people, num_days=$days, travel_date='$date' WHERE id=$id");

  header("Location: admin-home.html"); // or bookings.php
  exit();
}
?>

<form method="POST">
  <label>Name: <input type="text" name="name" value="<?= $row['name'] ?>"></label><br>
  <label>Place: <input type="text" name="place" value="<?= $row['place'] ?>"></label><br>
  <label>Contact: <input type="text" name="contact" value="<?= $row['contact'] ?>"></label><br>
  <label>People: <input type="number" name="num_people" value="<?= $row['num_people'] ?>"></label><br>
  <label>Days: <input type="number" name="num_days" value="<?= $row['num_days'] ?>"></label><br>
  <label>Date: <input type="date" name="travel_date" value="<?= $row['travel_date'] ?>"></label><br>
  <button type="submit">Update Booking</button>
</form>
