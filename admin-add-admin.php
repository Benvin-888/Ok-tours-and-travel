<?php include 'get_background.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add New Admin - OK Tours and Travel</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@400;700&family=Roboto:wght@300;500&display=swap');

    * {
      box-sizing: border-box;
    }

    body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }

    nav {
      background-color: rgba(0, 0, 0, 0.4);
      padding: 15px 0;
      text-align: center;
      font-weight: 600;
      font-size: 16px;
      font-family: 'Montserrat', sans-serif;
    }

    nav a {
      color: #f3f4f6;
      text-decoration: none;
      margin: 0 22px;
    }

    nav a:hover {
      color: #ffd369;
    }

    .container {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      max-width: 580px;
      margin: 40px auto;
      padding: 50px 45px;
    }

    h1 {
      font-family: 'Great Vibes', cursive;
      font-size: 3rem;
      text-align: center;
      color: #ffd369;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
      font-family: 'Montserrat', sans-serif;
    }

    label {
      font-weight: 700;
      font-size: 1rem;
      color: #ffeaa7;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      padding: 12px 14px;
      border-radius: 8px;
      border: none;
      font-size: 1rem;
      color: #333;
    }

    button {
      background: #ffd369;
      border: none;
      padding: 14px;
      font-size: 1.1rem;
      font-weight: bold;
      color: #3a2f0b;
      border-radius: 10px;
      cursor: pointer;
    }

    button:hover {
      background-color: #f1c40f;
    }

    hr {
      border: 0;
      height: 1px;
      background: #ffd369;
    }
  </style>
</head>
<body>

  <nav>
    <a href="admin-dashboard.php">Dashboard Home</a>
     <a href="admin-background.php" class="active">Change Background</a>
    <a href="admin-logo.php">Logo Settings</a>
    <a href="admin-add-admin.php" style="text-decoration: underline;">Add Admin</a>
    <a href="admin-bookings.php">Bookings</a>
    <a href="admin-enquiries.html">Enquiries</a>
    <a href="admin-comments.html">Comments</a>
    <a href="index.html">Main Site</a>
  </nav>

  <div class="container">
    <h1>Add New Admin</h1>

    <form id="addAdminForm" action="add-admin.php" method="POST">
      <label for="mainAdminUsername">Your Admin Username</label>
      <input type="text" id="mainAdminUsername" name="mainAdminUsername" required>

      <label for="mainAdminPassword">Your Admin Password</label>
      <input type="password" id="mainAdminPassword" name="mainAdminPassword" required>

      <hr>

      <label for="newAdminUsername">New Admin Username</label>
      <input type="text" id="newAdminUsername" name="newAdminUsername" required>

      <label for="newAdminPassword">New Admin Password</label>
      <input type="password" id="newAdminPassword" name="newAdminPassword" required>

      <button type="submit">Add Admin</button>
    </form>
  </div>

</body>
</html>
