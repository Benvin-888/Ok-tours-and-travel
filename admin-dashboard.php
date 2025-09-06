<?php include 'get_background.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - OK Tours and Travel</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <style>
    /* CSS Variables for easy theme management */
    :root {
        --primary-blue: #3498db;
        --dark-blue: #2c3e50;
        --accent-green: #2ecc71;
        --accent-red: #e74c3c;
        --light-bg: #f5f7fa;
        --card-bg: rgba(255, 255, 255, 0.95);
        --text-color: #333;
        --subtle-text: #555;
        --border-color: rgba(255, 255, 255, 0.3);
        --shadow-light: rgba(0, 0, 0, 0.1);
        --shadow-medium: rgba(0, 0, 0, 0.15);
        --shadow-strong: rgba(0, 0, 0, 0.25);
    }

    /* Base Styles */
    body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }


    @keyframes gradientBackground {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Navigation Bar */
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

    /* Main Content Area */
    main {
      flex-grow: 1;
      padding: 40px 30px;
      max-width: 900px;
      width: 90%;
      margin: 30px auto;
      background: var(--card-bg);
      border-radius: 18px;
      box-shadow: 0 12px 35px var(--shadow-strong);
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      overflow: hidden;
      box-sizing: border-box;
    }

    /* Heading and Paragraph */
    h1 {
      /* New Title Font and Size */
      font-family: 'Playfair Display', serif; /* Elegant serif font */
      font-weight: 700; /* Bold */
      font-size: 3.5em; /* Larger, more impactful size */
      margin-bottom: 25px;
      color: var(--dark-blue);
      text-align: center;
      transition: color 0.5s ease-in-out;
      text-shadow: 3px 3px 6px rgba(0,0,0,0.15); /* More prominent shadow */
      letter-spacing: -1px; /* Slightly tighter letter spacing */
    }
    p {
      font-size: 18px;
      line-height: 1.6;
      text-align: center;
      margin-bottom: 40px;
      color: var(--subtle-text);
    }

    /* Logout Button */
    .logout-btn {
      margin-left: auto;
      background-color: var(--accent-red);
      padding: 10px 18px;
      border-radius: 8px;
      border: none;
      color: white;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px var(--shadow-medium);
      flex-shrink: 0;
    }
    .logout-btn:hover {
      background-color: #b03025;
      transform: translateY(-2px);
    }

    /* Dashboard Buttons Grid */
    .dashboard-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      width: 100%;
      max-width: 750px;
      margin-top: 30px;
      padding: 0 15px;
      justify-content: center;
      box-sizing: border-box;
    }

    /* Individual Dashboard Button */
    .dashboard-btn {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: linear-gradient(145deg, var(--accent-green), #27ae60);
      color: white;
      text-decoration: none;
      padding: 25px 15px;
      border-radius: 15px;
      font-size: 1.1em;
      font-weight: 600;
      text-align: center;
      box-shadow: 0 8px 20px var(--shadow-medium);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      border: none;
      transform: perspective(1px) translateZ(0);
      box-sizing: border-box;
      min-height: 150px;
    }

    .dashboard-btn:hover {
      background: linear-gradient(145deg, #27ae60, #229954);
      transform: translateY(-8px);
      box-shadow: 0 15px 35px var(--shadow-strong);
    }

    /* Glow effect using a pseudo-element */
    .dashboard-btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.4);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      opacity: 0;
      transition: all 0.5s ease-out;
      z-index: 0;
    }

    .dashboard-btn:hover::before {
      width: 250%;
      height: 250%;
      opacity: 1;
    }

    /* Icons (using modern unicode) */
    .dashboard-btn .icon {
      font-size: 2.8em;
      margin-bottom: 10px;
      line-height: 1;
      filter: drop-shadow(2px 2px 3px rgba(0,0,0,0.2));
    }
    .icon-logo::before { content: '✨'; }
    .icon-admin::before { content: '👥'; }
    .icon-bookings::before { content: '🗓️'; }
    .icon-enquiries::before { content: '📧'; }
    .icon-comments::before { content: '📝'; }

    /* Dashboard Form Styles (Example - Uncomment if needed) */
    .dashboard-form {
        width: 100%;
        max-width: 500px;
        /* Beautiful Form Background */
        background: linear-gradient(145deg, rgba(240, 248, 255, 0.98), rgba(220, 235, 250, 0.98)); /* Soft, light blue gradient */
        border: 1px solid rgba(255, 255, 255, 0.5); /* Subtle white border */
        backdrop-filter: blur(10px); /* Stronger frosted glass effect */
        padding: 30px;
        border-radius: 20px; /* More rounded */
        box-shadow: 0 10px 30px rgba(0,0,0,0.15); /* Modern shadow */
        margin-top: 30px;
        box-sizing: border-box;
    }

    .dashboard-form h2 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: var(--dark-blue);
        margin-bottom: 25px;
        text-align: center;
        font-size: 1.8em;
    }

    .dashboard-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--dark-blue);
    }

    .dashboard-form input[type="text"],
    .dashboard-form input[type="email"],
    .dashboard-form input[type="password"],
    .dashboard-form textarea,
    .dashboard-form select {
        width: calc(100% - 24px); /* Account for padding + border */
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #dcdcdc; /* Lighter border */
        border-radius: 10px; /* More rounded inputs */
        font-size: 1em;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        background-color: white;
        box-sizing: border-box;
    }

    .dashboard-form input:focus,
    .dashboard-form textarea:focus,
    .dashboard-form select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 10px rgba(52, 152, 219, 0.4); /* Larger focus shadow */
        outline: none;
        background-color: #f8fcff; /* Slightly lighter background on focus */
    }

    .dashboard-form textarea {
        resize: vertical;
        min-height: 100px;
    }

    .dashboard-form .submit-btn {
        background-color: var(--primary-blue);
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.1em;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 10px var(--shadow-light);
        width: 100%; /* Make submit button full width */
    }

    .dashboard-form .submit-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px var(--shadow-medium);
    }


    /* Media Queries for Mobile Responsiveness */
    /* Target smaller phones first */
    @media (max-width: 480px) {
        nav {
            padding: 10px 15px;
            gap: 10px;
            justify-content: center;
        }
        nav a {
            font-size: 0.85em;
            padding: 5px 5px;
        }
        .logout-btn {
            padding: 6px 12px;
            font-size: 0.8em;
            margin-top: 10px;
            flex-basis: 100%;
        }

        main {
            padding: 25px 15px;
            margin: 20px auto;
            width: 95%;
            border-radius: 15px;
        }

        h1 {
            font-size: 2.2em; /* Adjusted for smaller screens */
            margin-bottom: 15px;
        }
        p {
            font-size: 0.95em;
            margin-bottom: 25px;
        }

        .dashboard-buttons {
            grid-template-columns: 1fr;
            gap: 15px;
            padding: 0 10px;
        }

        .dashboard-btn {
            padding: 20px 15px;
            font-size: 1em;
            min-height: 120px;
            border-radius: 12px;
        }

        .dashboard-btn .icon {
            font-size: 2.5em;
            margin-bottom: 8px;
        }

        .dashboard-form {
            padding: 20px;
            border-radius: 15px;
        }
        .dashboard-form h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .dashboard-form input, .dashboard-form textarea, .dashboard-form select {
            width: calc(100% - 20px); /* Adjust for smaller padding */
            border-radius: 8px;
        }
    }

    /* Target tablets and larger phones */
    @media (min-width: 481px) and (max-width: 768px) {
        nav {
            padding: 12px 20px;
            gap: 20px;
        }
        nav a {
            font-size: 0.95em;
            padding: 5px 10px;
        }
        .logout-btn {
            padding: 8px 15px;
            font-size: 0.9em;
        }

        main {
            padding: 30px 20px;
            margin: 25px auto;
            width: 90%;
            border-radius: 16px;
        }

        h1 {
            font-size: 2.8em; /* Adjusted for larger phones/tablets */
        }
        p {
            font-size: 1.05em;
        }

        .dashboard-buttons {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            padding: 0 15px;
        }

        .dashboard-btn {
            padding: 22px 18px;
            font-size: 1.05em;
            min-height: 140px;
        }
        .dashboard-btn .icon {
            font-size: 2.7em;
            margin-bottom: 10px;
        }

        .dashboard-form {
            padding: 25px;
        }
        .dashboard-form h2 {
            font-size: 1.6em;
        }
    }

    /* General desktop adjustments (larger screens than 768px) */
    @media (min-width: 769px) {
        nav {
            padding: 15px 30px;
        }
        nav a {
            font-size: 1em;
            padding: 5px 0;
        }
        .logout-btn {
            padding: 10px 18px;
            font-size: 1em;
        }
        main {
            padding: 40px 30px;
            max-width: 900px;
            margin: 30px auto;
        }
        h1 {
            font-size: 3.5em; /* Desktop size */
        }
        p {
            font-size: 1.1em;
        }
        .dashboard-buttons {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            max-width: 750px;
            padding: 0 20px;
        }
        .dashboard-btn {
            padding: 30px 20px;
            font-size: 1.15em;
            min-height: 150px;
        }
        .dashboard-btn .icon {
            font-size: 3em;
        }
        .dashboard-form {
            padding: 30px;
        }
        .dashboard-form h2 {
            font-size: 1.8em;
        }
    }
    
  </style>
</head>
<body>
  <nav>
    <a href="admin-dashboard.php">Home</a>
    <a href="admin-background.php">Background</a>
    <a href="admin-add-admin.php">Add Admin</a>
    <a href="admin-bookings.php">Bookings</a>
    <a href="admin-enquiries.html">Enquiries</a>
    <a href="admin-comments.html">Comments</a>
    <a href="admin-manage-gallery.php">gallery</a>
    <button class="logout-btn" onclick="logout()">Logout</button>
  </nav>

  <main>
    <h1 id="dashboardTitle">Admin Dashboard</h1>
    <p>Welcome, Admin! Select an option below to manage the website.</p>

    <div class="dashboard-buttons">
      <a href="admin-background.php" class="dashboard-btn">
        <span class="icon icon-logo"></span>
        Change Background
      </a>
      <a href="admin-add-admin.php" class="dashboard-btn">
        <span class="icon icon-admin"></span>
        Add Admin
      </a>

      <!-- <a href="manage_gallery.php" class="dashboard-btn">
        <span class="icon icon-admin"></span>
        Add images
      </a> -->



      
      <a href="manage-users.php" class="dashboard-btn">
        <span class="icon icon-admin"></span>
        manage users
      </a>
      <a href="admin-bookings.php" class="dashboard-btn">
        <span class="icon icon-bookings"></span>
        View Bookings
      </a>
      <a href="admin-enquiries.html" class="dashboard-btn">
        <span class="icon icon-enquiries"></span>
        View Enquiries
      </a>
      <a href="admin-comments.html" class="dashboard-btn">
        <span class="icon icon-comments"></span>
        Moderate Comments
      </a>
    </div>

    <div class="dashboard-form">
        <h2>Add New User</h2>
        <form action="create_user.php" method="POST" enctype="multipart/form-data">
          <!-- Name -->
          <label for="name">Full Name:</label>
          <input type="text" id="name" name="name" required>
      
          <!-- Email -->
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
      
          <!-- Password -->
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
      
          <!-- Profile Photo -->
          <label for="profile_photo">Profile Photo:</label>
          <input type="file" id="profile_photo" name="profile_photo" accept="image/*" required>
      
          <!-- ID Number -->
          <label for="id_number">ID Number:</label>
          <input type="text" id="id_number" name="id_number" required>
      
          <!-- Phone -->
          <label for="phone">Phone Number:</label>
          <input type="text" id="phone" name="phone" required>
      
          <!-- Submit Button -->
          <button type="submit" class="submit-btn">Create User</button>
      </form>
      
    </div>

    <div id="successModal" style="display:none; position:fixed; top:40%; left:50%; transform:translate(-50%, -50%);
    background:#fff; padding:20px 30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.3); z-index:1000;">
    <p>User created successfully.</p>
</div>

  </main>
  <script>
    document.getElementById("adminForm").addEventListener("submit", function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
    
        fetch("create_user.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            if (response.includes("User created successfully")) {
                // Show modal
                document.getElementById("successModal").style.display = "block";
                setTimeout(() => {
                    // Hide modal and reload
                    document.getElementById("successModal").style.display = "none";
                    location.reload();
                }, 2000);
            } else {
                alert(response);
            }
        })
        .catch(err => {
            alert("An error occurred: " + err);
        });
    });
    </script>
  <script>
    function logout() {
      // Clear admin session here if implemented
      alert('You have been logged out.');
      window.location.href = 'admin-home.html';
    }

    document.addEventListener('DOMContentLoaded', function() {
      const dashboardTitle = document.getElementById('dashboardTitle');
      const colors = ['#3498db', '#e74c3c', '#f1c40f', '#9b59b6', '#1abc9c', '#d35400']; // A set of vibrant colors
      let currentColorIndex = 0;

      function changeTitleColor() {
        dashboardTitle.style.color = colors[currentColorIndex];
        currentColorIndex = (currentColorIndex + 1) % colors.length;
      }

      setTimeout(() => {
        changeTitleColor();
        setInterval(changeTitleColor, 2000); // Continue changing every 2 seconds
      }, 3000); // Initial change after 3 seconds
    });
  </script>
</body>
</html>