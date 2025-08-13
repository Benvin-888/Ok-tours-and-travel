<?php include 'get_background.php'; ?>

<?php
// Database connection
$host = 'localhost';
$db = 'oktours';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  header('Content-Type: application/json');

  $action = $_POST['action'];

  if ($action === 'delete') {
    $id = $_POST['id'] ?? null;
    if ($id) {
      $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
      $stmt->execute([$id]);
      echo json_encode(['success' => true]);
    }
    exit;
  }

  if ($action === 'update') {
    $id = $_POST['id'] ?? null;
    $username = trim($_POST['username'] ?? '');
    if ($id && $username) {
      $stmt = $pdo->prepare("UPDATE admins SET username = ? WHERE id = ?");
      $stmt->execute([$username, $id]);
      echo json_encode(['success' => true]);
    }
    exit;
  }
  exit;
}

// Fetch admins for display
$admins = $pdo->query("SELECT * FROM admins")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manage Admins - OK Tours and Travel</title>
<style>
  /* Reset */
  *, *::before, *::after {
    box-sizing: border-box;
  }

  /* Body & Background */
  body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  /* Dark overlay for readability */
  body::before {
    content: "";
    position: fixed;
    inset: 0;
    background-color: rgba(0,0,0,0.6);
    z-index: -1;
  }

  /* Header */
  header {
    background-color: #2c3e50cc; /* slightly transparent */
    padding: 18px 30px;
    text-align: center;
    font-size: 2.1rem;
    font-weight: 700;
    letter-spacing: 1.2px;
    color: #e1e9f0;
    user-select: none;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
  }

  /* Navigation */
  nav {
    background: linear-gradient(135deg, #2980b9, #6dd5fa);
    padding: 12px 25px;
    display: flex;
    justify-content: center;
    gap: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    margin-bottom: 35px;
    flex-wrap: wrap;
    border-radius: 8px;
    user-select: none;
    transition: background-color 0.3s ease;
  }
  nav a {
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    padding: 8px 18px;
    border-radius: 6px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    font-size: 1rem;
  }
  nav a:hover,
  nav a:focus {
    background-color: rgba(255, 255, 255, 0.25);
    border-color: #fff;
    outline: none;
  }
  nav a[aria-current="page"] {
    background-color: #fff;
    color: #2980b9;
    border-color: #fff;
    pointer-events: none;
  }

  /* Main container */
  main {
    max-width: 1100px;
    margin: 0 auto 50px auto;
    background: rgba(44, 62, 80, 0.9);
    border-radius: 15px;
    padding: 30px 40px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
  }

  h1 {
    color: #f0f2f5;
    font-size: 2rem;
    margin-bottom: 30px;
    text-align: center;
    text-shadow: 0 0 8px #2ecc71;
  }

  /* Admins table */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
  }
  th, td {
    padding: 12px 16px;
    border-bottom: 1px solid #3a4a5a;
    text-align: left;
    font-size: 1rem;
    color: #d0d7de;
  }
  th {
    background-color: #27ae60;
    color: #e9f7ef;
    font-weight: 700;
  }
  tbody tr:hover {
    background-color: #2ecc7150;
  }

  /* Buttons inside table */
  .btn {
    cursor: pointer;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 600;
    border: none;
    transition: background-color 0.3s ease;
  }
  .btn-edit {
    background-color: #3498db;
    color: white;
  }
  .btn-edit:hover,
  .btn-edit:focus {
    background-color: #2980b9;
    outline: none;
  }
  .btn-delete {
    background-color: #e74c3c;
    color: white;
  }
  .btn-delete:hover,
  .btn-delete:focus {
    background-color: #c0392b;
    outline: none;
  }

  /* Editable input */
  input.admin-username {
    border: none;
    background: #f9f9f9;
    padding: 5px;
    font-weight: 600;
    color: #34495e;
    width: 100%;
    box-sizing: border-box;
  }
  input.admin-username.editable {
    background: #fff;
    border: 1px solid #ccc;
  }

  /* Add admin form */
  form {
    background-color: #34495e;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    max-width: 600px;
    margin: 0 auto;
  }
  form h2 {
    color: #2ecc71;
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
    text-shadow: 0 0 6px #27ae60;
  }
  .form-group {
    margin-bottom: 18px;
  }
  label {
    display: block;
    color: #a9c8db;
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 1.1rem;
  }
  input[type="text"],
  input[type="email"],
  select {
    width: 100%;
    padding: 12px 15px;
    border-radius: 8px;
    border: none;
    font-size: 1rem;
    font-weight: 600;
    color: #34495e;
  }
  input[type="text"]:focus,
  input[type="email"]:focus,
  select:focus {
    outline: 2px solid #2ecc71;
  }
  button[type="submit"] {
    background-color: #2ecc71;
    color: #fff;
    font-weight: 700;
    font-size: 1.1rem;
    border: none;
    padding: 14px 0;
    width: 100%;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  button[type="submit"]:hover,
  button[type="submit"]:focus {
    background-color: #27ae60;
    outline: none;
  }

  /* Responsive */
  @media (max-width: 700px) {
    main {
      padding: 20px 25px;
      margin-bottom: 40px;
    }
    nav {
      gap: 10px;
      padding: 10px 15px;
    }
    nav a {
      font-size: 0.9rem;
      padding: 7px 12px;
    }
    form {
      padding: 20px;
      max-width: 100%;
    }
    table {
      font-size: 0.9rem;
    }
  }
</style>
</head>
<body>

<header>Manage Admins - OK Tours and Travel</header>

<nav>
  <a href="admin-dashboard.php">Home</a>
  <a href="admin-background.php">Change Logo/Background</a>
  <a href="admin-add-admin.php">Add Admin</a>
  <a href="admin-bookings.php">Bookings</a>
  <a href="admin-enquiries.html">Enquiries</a>
  <a href="admin-comments.html">Comments</a>
</nav>

<main>
  <h1>Manage Admins</h1>

  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="adminsTableBody">
      <?php foreach ($admins as $admin): ?>
        <tr data-id="<?= $admin['id'] ?>">
          <td>
            <input class="admin-username" value="<?= htmlspecialchars($admin['username']) ?>" disabled />
          </td>
          <td>••••••</td>
          <td>
            <button class="btn btn-edit edit-btn">Edit</button>
            <button class="btn btn-delete delete-btn">Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', async () => {
    const row = btn.closest('tr');
    const input = row.querySelector('.admin-username');
    const id = row.dataset.id;

    if (input.disabled) {
      // Enable editing
      input.disabled = false;
      input.classList.add('editable');
      input.focus();
      btn.textContent = 'Save';
    } else {
      // Save changes
      const username = input.value.trim();
      if (!username) {
        alert('Username cannot be empty.');
        input.focus();
        return;
      }
      const formData = new FormData();
      formData.append('action', 'update');
      formData.append('id', id);
      formData.append('username', username);

      try {
        const res = await fetch('', { method: 'POST', body: formData });
        const result = await res.json();

        if (result.success) {
          input.disabled = true;
          input.classList.remove('editable');
          btn.textContent = 'Saved';
          setTimeout(() => {
            btn.textContent = 'Edit';
          }, 1500); // Show "Saved" for 1.5 seconds
        } else {
          alert('Failed to update admin');
        }
      } catch (error) {
        alert('Error updating admin');
      }
    }
  });
});

document.querySelectorAll('.delete-btn').forEach(btn => {
  btn.addEventListener('click', async () => {
    const row = btn.closest('tr');
    const id = row.dataset.id;
    const name = row.querySelector('.admin-username').value;

    if (confirm(`Are you sure you want to delete "${name}"?`)) {
      const formData = new FormData();
      formData.append('action', 'delete');
      formData.append('id', id);

      try {
        const res = await fetch('', { method: 'POST', body: formData });
        const result = await res.json();

        if (result.success) {
          row.remove();
        } else {
          alert('Failed to delete admin');
        }
      } catch (error) {
        alert('Error deleting admin');
      }
    }
  });
});
</script>

</body>
</html>
