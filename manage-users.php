
<?php include 'get_background.php'; ?>

<?php

// Connect to database
$conn = new mysqli("localhost", "root", "", "oktours");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// DELETE user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    // Go back to manage page
    header("Location: manage-users.php");
    exit;
}

// UPDATE user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $id_number = $conn->real_escape_string($_POST['id_number']);

    $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', id_number='$id_number' WHERE id=$id");
    // Go back to manage page
    header("Location: manage-users.php");
    exit;
}


// Fetch users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users</title>
  <style>
  body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }

  nav {
      background-color: var(--primary-blue);
      padding: 15px 30px;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      font-weight: 600;
      color: white;
      box-shadow: 0 4px 15px var(--shadow-strong);
      position: sticky;
      top: 0;
      z-index: 1000;
      justify-content: flex-start;
      align-items: center;
    }
    nav a {
      color: white;
      text-decoration: none;
      transition: color 0.2s ease, text-shadow 0.2s ease;
      padding: 5px 8px;
      border-radius: 5px;
    }
    nav a:hover {
      color: #d1e7fd;
      text-shadow: 0 0 8px rgba(255,255,255,0.7);
    }
    h1 {
      text-align: center;
      color: #1a3e72;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background: white;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 12px 15px;
      text-align: left;
    }
    th {
      background-color: #1a3e72;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .btn {
      padding: 6px 12px;
      text-decoration: none;
      border: none;
      cursor: pointer;
      font-weight: bold;
      border-radius: 6px;
    }
    .edit-btn {
      background-color: #3498db;
      color: white;
    }
    .delete-btn {
      background-color: #e74c3c;
      color: white;
    }
    .edit-form {
      display: none;
      background: #fff;
      padding: 20px;
      margin-top: 20px;
      border: 1px solid #ddd;
    }
    .form-group {
      margin-bottom: 15px;
    }
    input[type="text"], input[type="email"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #aaa;
      border-radius: 6px;
    }
    .save-btn {
      background-color: #27ae60;
      color: white;
    }
    .cancel-btn {
      background-color: #95a5a6;
      color: white;
    }
  </style>
</head>
<body>
<nav>
    <a href="admin-dashboard.php">Home</a>
    <a href="admin-background.php">Change Logo/Background</a>
    <a href="admin-add-admin.php">Add Admin</a>
    <a href="admin-bookings.php">Bookings</a>
    <a href="admin-enquiries.html">Enquiries</a>
    <a href="admin-comments.html">Comments</a>
    <!-- <button class="logout-btn" onclick="logout()">Logout</button> -->
  </nav>

<h1>Manage Users</h1>

<table>
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>ID Number</th>
    <th>Phone</th>
    <th>Actions</th>
  </tr>
  <?php if ($users->num_rows > 0): ?>
    <?php while ($user = $users->fetch_assoc()): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['id_number']) ?></td>
        <td><?= htmlspecialchars($user['phone']) ?></td>
        <td>
          <button class="btn edit-btn" onclick="editUser(<?= $user['id'] ?>, '<?= addslashes($user['name']) ?>', '<?= addslashes($user['email']) ?>', '<?= addslashes($user['id_number']) ?>', '<?= addslashes($user['phone']) ?>')">Edit</button>
          <a class="btn delete-btn" href="delete-edit-users.php?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>


        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="6" style="text-align:center;">No users found.</td></tr>
  <?php endif; ?>
</table>

<!-- Edit Form -->
<div class="edit-form" id="editForm">
  <h2>Edit User</h2>
  <form method="post" action="delete-edit-users.php">

    <input type="hidden" name="update_id" id="editId">
    <div class="form-group">
      <label>Name:</label>
      <input type="text" name="name" id="editName" required>
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" id="editEmail" required>
    </div>
    <div class="form-group">
      <label>ID Number:</label>
      <input type="text" name="id_number" id="editIdNumber">
    </div>
    <div class="form-group">
      <label>Phone:</label>
      <input type="text" name="phone" id="editPhone">
    </div>
    <button type="submit" class="btn save-btn">Save</button>
    <button type="button" class="btn cancel-btn" onclick="document.getElementById('editForm').style.display='none'">Cancel</button>
  </form>
</div>

<script>
  function editUser(id, name, email, idNumber, phone) {
    document.getElementById('editForm').style.display = 'block';
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editIdNumber').value = idNumber;
    document.getElementById('editPhone').value = phone;

    window.scrollTo({ top: document.getElementById('editForm').offsetTop - 50, behavior: 'smooth' });
  }
</script>

</body>
</html>
