<?php include 'get_background.php'; ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "oktours");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bgResult = $conn->query("SELECT image_path FROM website_background ORDER BY uploaded_at DESC LIMIT 1");
$background = '';
if ($bgResult && $bgResult->num_rows > 0) {
    $row = $bgResult->fetch_assoc();
    $background = $row['image_path'];
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Manage Background & Enquiries | OK Tours and Travel</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap');
  
  body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }


    body {
      font-family: 'Montserrat', 'Roboto', sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 0;
      color: #2a3d66;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      max-width: 900px;
      margin: 30px auto 50px;
      background: white;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      padding: 30px 40px;
    }

    section {
      margin-bottom: 50px;
    }

    h2 {
      color: #1a3e72;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 3px solid #fdd835;
      padding-bottom: 6px;
    }

    /* Background upload form */
    form#backgroundForm {
      display: flex;
      flex-direction: column;
      gap: 18px;
      max-width: 400px;
      margin-bottom: 10px;
    }
    label {
      font-size: 1.1rem;
      font-weight: 600;
      color: #34495e;
    }
    input[type="file"] {
      padding: 8px;
      font-size: 1rem;
      border-radius: 6px;
      border: 1.8px solid #ccc;
      cursor: pointer;
      transition: border-color 0.3s ease;
    }
    input[type="file"]:focus {
      outline: none;
      border-color: #fdd835;
    }
    button.upload-btn {
      background-color: #1a3e72;
      color: white;
      padding: 14px;
      font-weight: 700;
      font-size: 1.1rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      width: 150px;
      align-self: flex-start;
      transition: background-color 0.3s ease;
    }
    button.upload-btn:hover {
      background-color: #fdd835;
      color: #1a3e72;
      font-weight: 800;
    }

    .preview {
      margin-top: 20px;
      text-align: center;
    }
    .preview img {
      max-width: 100%;
      max-height: 300px;
      border-radius: 14px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
      transition: transform 0.3s ease;
    }
    .preview img:hover {
      transform: scale(1.03);
    }

    /* Enquiry Management */
    #enquirySection {
      max-width: 100%;
    }
    form#enquiryForm {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 25px;
    }
    form#enquiryForm input[type="text"],
    form#enquiryForm input[type="tel"] {
      flex: 1 1 40%;
      padding: 12px 14px;
      font-size: 1rem;
      border-radius: 10px;
      border: 1.6px solid #ccc;
      transition: border-color 0.3s ease;
    }
    form#enquiryForm input[type="text"]:focus,
    form#enquiryForm input[type="tel"]:focus {
      outline: none;
      border-color: #fdd835;
    }
    form#enquiryForm button {
      flex: 1 1 15%;
      padding: 14px;
      background-color: #1a3e72;
      color: white;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 1.1rem;
    }
    form#enquiryForm button:hover {
      background-color: #fdd835;
      color: #1a3e72;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 1rem;
    }
    table th, table td {
      border: 1.5px solid #ddd;
      padding: 12px 15px;
      text-align: left;
      vertical-align: middle;
    }
    table th {
      background-color: #fdd835;
      color: #1a3e72;
      font-weight: 700;
    }
    table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    /* Buttons in table */
    .edit-btn, .delete-btn {
      padding: 6px 14px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background-color 0.3s ease;
      color: white;
    }
    .edit-btn {
      background-color: #3498db;
      margin-right: 10px;
    }
    .edit-btn:hover {
      background-color: #217dbb;
    }
    .delete-btn {
      background-color: #e74c3c;
    }
    .delete-btn:hover {
      background-color: #b72f26;
    }

    /* Responsive */
    @media (max-width: 720px) {
      form#enquiryForm {
        flex-direction: column;
      }
      form#enquiryForm input, form#enquiryForm button {
        flex: 1 1 100%;
      }
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

  </style>
</head>
<body>

  <nav>
    <a href="admin-dashboard.php">Dashboard</a>
    <a href="admin-background.php" class="active">Change Background</a>
    <a href="admin-logo.php">Change Logo</a>
    <a href="admin-add-admin.php">Add Admin</a>
    <a href="admin-bookings.php">View Bookings</a>
    <a href="admin-enquiries.html">View Enquiries</a>
    <a href="admin-comments.html">Manage Comments</a>
    <a href="index.html">Logout</a>
  </nav>

  <header>
    Manage Website Background & Enquiry Info
  </header>

  <main>
    <section>
      <h2>Change Website Background</h2>
      <form id="backgroundForm" method="post" enctype="multipart/form-data" action="upload_background.php">
        <label for="backgroundUpload">Upload New Background Image</label>
        <input type="file" id="backgroundUpload" name="background" accept="image/*" required />
        <button type="submit" class="upload-btn">Upload Background</button>
      </form>
      
      <div class="preview" id="previewContainer" style="display:none;">
        <h3>Preview:</h3>
        <img id="previewImage" src="" alt="Background Preview" />
      </div>
    </section>


  </main>

  <footer>
    © 2025 OK Tours and Travel Admin Dashboard
  </footer>

  <script>

    
    // Background preview logic
    const backgroundInput = document.getElementById('backgroundUpload');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    backgroundInput.addEventListener('change', () => {
      const file = backgroundInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          previewImage.src = e.target.result;
          previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        previewContainer.style.display = 'none';
        previewImage.src = '';
      }
    });




    document.getElementById('backgroundForm').addEventListener('submit', e => {
  // Don't prevent default here — allow actual form submission
  // Let server handle the upload and then reload the page
});

    // document.getElementById('backgroundForm').addEventListener('submit', e => {
    //   e.preventDefault();
    //   // TODO: Add backend upload functionality here
    //   alert('Background image uploaded successfully! (In a real app, this would upload to the server)');
    //   backgroundInput.value = '';
    //   previewContainer.style.display = 'none';
    //   previewImage.src = '';
    // });








    document.getElementById('backgroundForm').addEventListener('submit', e => {
  e.preventDefault();

  const formData = new FormData(e.target);

  fetch('upload_background.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      document.body.style.backgroundImage = `url('${data.path}')`;

      backgroundInput.value = '';
      previewContainer.style.display = 'none';
      previewImage.src = '';
    } else {
      alert('Upload failed. Please try again.');
    }
  })
  .catch(err => {
    console.error('Upload error:', err);
    alert('An error occurred during upload.');
  });
});







    

    // Enquiry management logic
    const enquiryForm = document.getElementById('enquiryForm');
    const nameInput = document.getElementById('nameInput');
    const contactInput = document.getElementById('contactInput');
    const addBtn = document.getElementById('addBtn');
    const updateBtn = document.getElementById('updateBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const enquiryTableBody = document.querySelector('#enquiryTable tbody');

    // We'll store enquiries in-memory for demo
    let enquiries = [];
    let editIndex = null;

    function renderEnquiries() {
      enquiryTableBody.innerHTML = '';
      enquiries.forEach((enq, i) => {
        const tr = document.createElement('tr');

        const tdIndex = document.createElement('td');
        tdIndex.textContent = i + 1;
        tr.appendChild(tdIndex);

        const tdName = document.createElement('td');
        tdName.textContent = enq.name;
        tr.appendChild(tdName);

        const tdContact = document.createElement('td');
        tdContact.textContent = enq.contact;
        tr.appendChild(tdContact);

        const tdActions = document.createElement('td');

        const editBtn = document.createElement('button');
        editBtn.textContent = 'Edit';
        editBtn.className = 'edit-btn';
        editBtn.onclick = () => startEdit(i);
        tdActions.appendChild(editBtn);

        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.className = 'delete-btn';
        deleteBtn.onclick = () => deleteEnquiry(i);
        tdActions.appendChild(deleteBtn);

        tr.appendChild(tdActions);
        enquiryTableBody.appendChild(tr);
      });

      if (enquiries.length === 0) {
        enquiryTableBody.innerHTML = `<tr><td colspan="4" style="text-align:center; font-style:italic; color:#777;">No enquiries added yet.</td></tr>`;
      }
    }

    function startEdit(index) {
      editIndex = index;
      nameInput.value = enquiries[index].name;
      contactInput.value = enquiries[index].contact;
      addBtn.style.display = 'none';
      updateBtn.style.display = 'inline-block';
      cancelBtn.style.display = 'inline-block';
    }

    function cancelEdit() {
      editIndex = null;
      enquiryForm.reset();
      addBtn.style.display = 'inline-block';
      updateBtn.style.display = 'none';
      cancelBtn.style.display = 'none';
    }

    function deleteEnquiry(index) {
      if (confirm(`Delete enquiry for "${enquiries[index].name}"?`)) {
        enquiries.splice(index, 1);
        renderEnquiries();
        cancelEdit();
      }
    }

    enquiryForm.addEventListener('submit', e => {
      e.preventDefault();
      const name = nameInput.value.trim();
      const contact = contactInput.value.trim();

      if (!name || !contact) {
        alert('Please fill in both fields.');
        return;
      }

      if (editIndex === null) {
        // Add new enquiry
        enquiries.push({ name, contact });
      } else {
        // Update existing enquiry
        enquiries[editIndex] = { name, contact };
      }

      renderEnquiries();
      enquiryForm.reset();
      cancelEdit();
    });

    updateBtn.addEventListener('click', () => {
      enquiryForm.dispatchEvent(new Event('submit'));
    });

    cancelBtn.addEventListener('click', () => {
      cancelEdit();
    });

    // Initial render
    renderEnquiries();

  </script>
</body>












<!-- <section id="enquirySection">
  <h2>Manage Enquiry Contact Info</h2>

  <form id="enquiryForm">
    <input type="text" id="nameInput" placeholder="Customer Name" required />
    <input type="tel" id="contactInput" placeholder="Contact Number" pattern="[0-9+()-\s]{6,20}" required />
    <button type="submit" id="addBtn">Add Enquiry</button>
    <button type="button" id="updateBtn" style="display:none; background-color: #27ae60;">Update Enquiry</button>
    <button type="button" id="cancelBtn" style="display:none; background-color: #95a5a6;">Cancel</button>
  </form>

  <table id="enquiryTable" aria-label="Enquiry contacts table">
    <thead>
      <tr>
        <th>#</th>
        <th>Customer Name</th>
        <th>Contact Number</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Enquiry rows will appear here -->
    </tbody>
  </table>
</section> -->












</html>
