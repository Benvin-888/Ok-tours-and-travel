<?php include 'get_background.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Change Logo | OK Tours and Travel</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap');

    body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }

    nav {
      background-color: #1a3e72;
      padding: 15px 25px;
      display: flex;
      gap: 20px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
      font-weight: 600;
    }
    nav a {
      color: #dce6f0;
      text-decoration: none;
      font-size: 16px;
      padding: 6px 10px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    nav a:hover {
      background-color: #fdd835;
      color: #1a3e72;
    }
    nav a.active {
      background-color: #fdd835;
      color: #1a3e72;
    }

    header {
      text-align: center;
      padding: 30px 20px 15px;
      background: white;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      font-weight: 700;
      font-size: 2rem;
      color: #1a3e72;
    }

    main {
      flex-grow: 1;
      max-width: 700px;
      margin: 30px auto 50px;
      background: white;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      padding: 30px 40px;
      text-align: center;
    }

    h2 {
      color: #1a3e72;
      font-weight: 700;
      margin-bottom: 30px;
      border-bottom: 3px solid #fdd835;
      padding-bottom: 8px;
    }

    form {
      margin-bottom: 30px;
    }

    label {
      font-size: 1.2rem;
      font-weight: 600;
      color: #34495e;
      display: block;
      margin-bottom: 12px;
    }

    input[type="file"] {
      padding: 10px;
      font-size: 1rem;
      border-radius: 8px;
      border: 1.8px solid #ccc;
      cursor: pointer;
      transition: border-color 0.3s ease;
      width: 100%;
      max-width: 320px;
      margin: 0 auto 20px;
      display: block;
    }
    input[type="file"]:focus {
      outline: none;
      border-color: #fdd835;
    }

    button {
      background-color: #1a3e72;
      color: white;
      padding: 14px 30px;
      font-weight: 700;
      font-size: 1.1rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin: 10px 8px;
    }
    button:hover {
      background-color: #fdd835;
      color: #1a3e72;
    }
    button.delete-btn {
      background-color: #e74c3c;
    }
    button.delete-btn:hover {
      background-color: #b72f26;
    }

    .logo-preview {
      margin-top: 20px;
    }
    .logo-preview img {
      max-width: 200px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .logo-preview img:hover {
      transform: scale(1.05);
    }

    footer {
      background-color: #1a3e72;
      color: #dce6f0;
      text-align: center;
      padding: 18px 12px;
      font-size: 14px;
      margin-top: auto;
      user-select: none;
    }

    @media (max-width: 480px) {
      main {
        padding: 25px 20px;
      }
      button {
        width: 100%;
        max-width: 300px;
        margin: 12px 0;
      }
      input[type="file"] {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

     <nav>
    <a href="admin-dashboard.php">Dashboard</a>
    <a href="admin-background.php">Change Background</a>
    <a href="admin-logo.php" class="active">Change Logo</a>
    <a href="admin-add-admin.php">Add Admin</a>
    <a href="admin-bookings.php">View Bookings</a>
    <a href="admin-enquiries.html">View Enquiries</a>
    <a href="admin-comments.html">Manage Comments</a>
    <a href="index.html">Logout</a>
  </nav>

  <header>
    Manage Website Logo
  </header>

  <main>
    <section>
      <h2>Upload New Logo</h2>
      <form id="logoForm">
        <label for="logoUpload">Select Logo Image</label>
        <input type="file" id="logoUpload" accept="image/*" required />
        <button type="submit">Upload Logo</button>
      </form>
      <button id="deleteLogoBtn" class="delete-btn">Delete Current Logo</button>

      <div class="logo-preview" id="logoPreviewContainer" style="display:none;">
        <h3>Current Logo Preview:</h3>
        <img id="logoPreviewImage" src="" alt="Logo Preview" />
      </div>
    </section>
  </main>

  <footer>
    © 2025 OK Tours and Travel Admin Dashboard
  </footer>

  <script>
    const logoInput = document.getElementById('logoUpload');
    const logoPreviewContainer = document.getElementById('logoPreviewContainer');
    const logoPreviewImage = document.getElementById('logoPreviewImage');
    const deleteLogoBtn = document.getElementById('deleteLogoBtn');

    // Simulated current logo url (in real app, fetch from server)
    let currentLogoUrl = 'https://via.placeholder.com/200x80?text=Current+Logo';

    // Show current logo on page load
    function showCurrentLogo() {
      if (currentLogoUrl) {
        logoPreviewImage.src = currentLogoUrl;
        logoPreviewContainer.style.display = 'block';
        deleteLogoBtn.style.display = 'inline-block';
      } else {
        logoPreviewContainer.style.display = 'none';
        deleteLogoBtn.style.display = 'none';
      }
    }

    showCurrentLogo();

    logoInput.addEventListener('change', () => {
      const file = logoInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          logoPreviewImage.src = e.target.result;
          logoPreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        showCurrentLogo();
      }
    });

    document.getElementById('logoForm').addEventListener('submit', e => {
      e.preventDefault();
      const file = logoInput.files[0];
      if (!file) {
        alert('Please select a logo image to upload.');
        return;
      }
      // TODO: Add backend upload logic here

      // Simulate successful upload by setting currentLogoUrl to preview
      const reader = new FileReader();
      reader.onload = e => {
        currentLogoUrl = e.target.result;
        alert('Logo uploaded successfully! (In a real app, this would upload to the server)');
        logoPreviewImage.src = currentLogoUrl;
        logoInput.value = '';
        logoPreviewContainer.style.display = 'block';
        deleteLogoBtn.style.display = 'inline-block';
      };
      reader.readAsDataURL(file);
    });

    deleteLogoBtn.addEventListener('click', () => {
      if (confirm('Are you sure you want to delete the current logo?')) {
        // TODO: Add backend delete logic here
        currentLogoUrl = '';
        logoPreviewImage.src = '';
        logoPreviewContainer.style.display = 'none';
        deleteLogoBtn.style.display = 'none';
        alert('Logo deleted successfully! (In a real app, this would delete on the server)');
      }
    });
  </script>
</body>
</html>
