<?php include 'get_background.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Enquiry - OK Tours and Travel</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Pacifico&display=swap" rel="stylesheet" />
  
  <style>
    /* Reset and base */
    * {
      box-sizing: border-box;
    }
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', Arial, sans-serif;
      color: #fff;
      overflow-x: hidden;
    }
    
    /* Background Image + Overlay */
    body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
    header {
      font-family: 'Pacifico', cursive;
      background: transparent;
      text-align: center;
      font-size: 3.8rem;
      padding: 40px 20px 10px;
      color: #00ffe7;
      text-shadow: 2px 2px 10px rgba(0, 255, 231, 0.8);
      user-select: none;
    }
    
    nav {
      text-align: center;
      margin-bottom: 40px;
    }
    
    nav a {
      margin: 0 20px;
      text-decoration: none;
      font-weight: 600;
      color: #00ffe7;
      font-size: 1.15rem;
      letter-spacing: 0.05em;
      transition: color 0.3s ease;
      text-shadow: 0 0 6px rgba(0, 255, 231, 0.7);
    }
    nav a:hover {
      color: #fff;
      text-shadow: 0 0 12px #00ffe7;
    }
    
    .container {
      background: rgba(255, 255, 255, 0.1);
      max-width: 520px;
      margin: 0 auto 60px;
      padding: 40px 35px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 255, 231, 0.3);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 255, 231, 0.4);
    }
    
    .container h2 {
      font-family: 'Pacifico', cursive;
      font-size: 3rem;
      margin-bottom: 25px;
      text-align: center;
      color: #00ffe7;
      text-shadow: 0 0 12px rgba(0, 255, 231, 0.9);
      user-select: none;
    }
    
    label {
      font-weight: 600;
      font-size: 1.1rem;
      color: #ccf9fa;
      margin-top: 18px;
      display: block;
      text-shadow: 0 0 3px rgba(0, 255, 231, 0.7);
    }
    
    input[type="text"],
    input[type="tel"],
    textarea {
      width: 100%;
      padding: 14px 18px;
      margin-top: 6px;
      border-radius: 12px;
      border: 2px solid #00ffe7;
      background: rgba(0, 255, 231, 0.1);
      color: #e0f7f7;
      font-size: 1.1rem;
      font-weight: 400;
      font-family: 'Poppins', sans-serif;
      transition: border-color 0.3s ease, background 0.3s ease;
      resize: vertical;
      box-shadow: 0 0 8px rgba(0, 255, 231, 0.3);
    }
    input[type="text"]:focus,
    input[type="tel"]:focus,
    textarea:focus {
      outline: none;
      background: rgba(0, 255, 231, 0.2);
      border-color: #00ccaa;
      box-shadow: 0 0 15px rgba(0, 204, 170, 0.7);
    }
    
    button {
      margin-top: 30px;
      width: 100%;
      padding: 16px 0;
      border: none;
      border-radius: 14px;
      background: linear-gradient(45deg, #00ffe7, #00ccaa);
      color: #001f20;
      font-size: 1.3rem;
      font-weight: 700;
      letter-spacing: 0.05em;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(0, 255, 231, 0.7);
      transition: background 0.4s ease, box-shadow 0.4s ease;
      user-select: none;
    }
    button:hover {
      background: linear-gradient(45deg, #00ccaa, #008877);
      box-shadow: 0 8px 28px rgba(0, 204, 170, 0.9);
      color: #e0f7f7;
    }
    
    .contact-info {
      margin-top: 35px;
      background: rgba(0, 255, 231, 0.2);
      padding: 20px 25px;
      border-radius: 12px;
      border-left: 5px solid #00ffe7;
      font-size: 1.1rem;
      font-weight: 600;
      color: #ccf9fa;
      box-shadow: 0 0 12px rgba(0, 255, 231, 0.5);
      user-select: none;
    }
    
    /* Confirmation and error messages */
    .message-box {
      margin-top: 20px;
      padding: 15px 20px;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 4px 10px rgba(0, 255, 231, 0.25);
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.5s ease;
      user-select: none;
    }
    .message-box.show {
      opacity: 1;
      pointer-events: auto;
    }
    .message-box.success {
      border: 1.5px solid #4BB543;
      background-color: rgba(75, 181, 67, 0.15);
      color: #b4f4b0;
      box-shadow: 0 4px 15px rgba(75, 181, 67, 0.5);
    }
    .message-box.error {
      border: 1.5px solid #d9534f;
      background-color: rgba(217, 83, 79, 0.15);
      color: #f7b0ac;
      box-shadow: 0 4px 15px rgba(217, 83, 79, 0.5);
    }
    .message-box svg {
      flex-shrink: 0;
      width: 26px;
      height: 26px;
      stroke-width: 2.5;
    }
  </style>
</head>
<body>

<header>OK Tours and Travel</header>

<nav>
  <a href="home-screen.html">Home/Logout</a>
  <a href="booking.php">Book Now</a>
  <a href="gallery.php">Gallery</a>
  <a href="enquiry.php">Enquiry</a>
  <a href="user-comments.html">comment section</a>
</nav>

<div class="container">
  <h2>Make an Enquiry</h2>
  <form id="enquiryForm" novalidate>
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your full name" required />

    <label for="phone">Contact Number</label>
    <input type="tel" id="phone" name="phone" placeholder="Enter your contact number" required />

    <label for="message">Message / Question</label>
    <textarea id="message" name="message" rows="4" placeholder="Type your enquiry here..."></textarea>

    <button type="submit">Submit Enquiry</button>
  </form>

  <div id="confirmation" class="message-box" style="display:none;"></div>

  <div class="contact-info" aria-label="Contact Information">
    <strong>Need help?</strong><br />
    Contact: <b>0706467999</b><br />
    Name: <b>Ephantus Kagai Njogu</b>
  </div>
</div>

<script>
  const form = document.getElementById('enquiryForm');
  const confirmation = document.getElementById('confirmation');

  const icons = {
    success: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>`,
    error: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>`
  };

  function showMessage(type, message) {
  confirmation.className = 'message-box ' + type + ' show';
  confirmation.innerHTML = `${icons[type]} ${message}`;
  confirmation.style.display = 'flex'; // Ensure it’s visible

  setTimeout(() => {
    confirmation.classList.remove('show');
    setTimeout(() => {
      confirmation.style.display = 'none';
    }, 500);
  }, 4000);
}


  form.addEventListener('submit', async function(event) {
    event.preventDefault();

    const name = form.name.value.trim();
    const phone = form.phone.value.trim();
    const message = form.message.value.trim();

    if (!name || !phone) {
      showMessage('error', 'Please fill in all required fields (name and contact number).');
      return;
    }

    try {
      const res = await fetch('submit_enquiry.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name, phone, message })
      });

      const result = await res.json();

      if (result.success) {
        showMessage('success', `Thank you for your enquiry, <strong>${name}</strong>! We will contact you soon.`);
        form.reset();
      } else {
        showMessage('error', result.error || 'Something went wrong.');
      }
    } catch (err) {
      showMessage('error', 'Failed to submit. Please try again later.');
    }
  });
</script>


</body>
</html>
