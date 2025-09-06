<?php
// Include background logic
include 'get_background.php';

// Generate CSRF token
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Enquiry - OK Tours and Travel</title>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  
  <style>
    /* Reset and base */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body, html {
      height: 100%;
      font-family: 'Poppins', Arial, sans-serif;
      color: #fff;
      overflow-x: hidden;
      position: relative;
      background-color: #0a1929;
    }
    
    /* Background Overlay */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -2;
    }
    
    /* Background Image */
    body {
      background-image: url('<?php echo $background; ?>');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      position: relative;
      z-index: -3;
    }
    
    /* Header with Logo */
    .header-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 25px 20px 15px;
      position: relative;
    }
    
    .logo-container {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    
    .logo {
      height: 80px;
      width: auto;
      filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
      transition: transform 0.3s ease;
    }
    
    .logo:hover {
      transform: scale(1.05);
    }
    
    .logo-divider {
      height: 60px;
      width: 2px;
      background: linear-gradient(to bottom, transparent, #4db6ac, transparent);
      opacity: 0.6;
    }
    
    .company-name {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 1000;
      color: #f6fae0ff;
      text-shadow: 0 0 15px rgba(77, 182, 172, 0.4);
      letter-spacing: 1px;
    }
    
    /* Navigation */
    nav {
      text-align: center;
      margin-bottom: 30px;
      padding: 0 15px;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px 20px;
    }
    
    nav a {
      text-decoration: none;
      font-weight: 900;
      color: #f5f9f6ff;
      font-size: 1.3rem;
      letter-spacing: 0.05em;
      transition: all 0.3s ease;
      padding: 10px 18px;
      border-radius: 8px;
      background: rgba(25, 118, 210, 0.15);
      display: flex;
      align-items: center;
      gap: 8px;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    nav a::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 0%;
      height: 100%;
      background: linear-gradient(90deg, rgba(25, 118, 210, 0.3), rgba(77, 182, 172, 0.3));
      transition: width 0.4s ease;
      z-index: -1;
    }
    
    nav a:hover::before {
      width: 100%;
    }
    
    nav a:hover {
      color: #fff;
      box-shadow: 0 0 15px rgba(77, 182, 172, 0.4);
    }
    
    nav a.active {
      background: rgba(25, 118, 210, 0.3);
      color: #4db6ac;
      box-shadow: 0 0 15px rgba(77, 182, 172, 0.4);
    }
    
    nav a.active::before {
      width: 100%;
    }
    
    nav a i {
      font-size: 1.1rem;
    }
    
    /* Main Container */
    .container {
      background: rgba(10, 25, 41, 0.7);
      max-width: 600px;
      margin: 0 auto 60px;
      padding: 40px 35px;
      border-radius: 16px;
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(77, 182, 172, 0.2);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      position: relative;
      z-index: 5;
      border-top: 1px solid rgba(77, 182, 172, 0.3);
    }
    
    .container h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      margin-bottom: 30px;
      text-align: center;
      color: #e0f7fa;
      font-weight: 600;
      letter-spacing: 0.5px;
      position: relative;
      padding-bottom: 15px;
    }
    
    .container h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: linear-gradient(to right, transparent, #4db6ac, transparent);
      border-radius: 2px;
    }
    
    /* Form Elements */
    .form-group {
      margin-bottom: 25px;
      position: relative;
    }
    
    label {
      font-weight: 500;
      font-size: 1.05rem;
      color: #b2ebf2;
      margin-top: 15px;
      display: block;
      margin-bottom: 8px;
      padding-left: 5px;
    }
    
    .required::after {
      content: " *";
      color: #ff6b6b;
    }
    
    input[type="text"],
    input[type="tel"],
    input[type="email"],
    select,
    textarea {
      width: 100%;
      padding: 14px 18px;
      border-radius: 10px;
      border: 1px solid rgba(77, 182, 172, 0.4);
      background: rgba(25, 118, 210, 0.1);
      color: #e0f7f7;
      font-size: 1.05rem;
      font-weight: 400;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
      resize: vertical;
    }
    
    input[type="text"]:focus,
    input[type="tel"]:focus,
    input[type="email"]:focus,
    select:focus,
    textarea:focus {
      outline: none;
      background: rgba(25, 118, 210, 0.2);
      border: 1px solid #4db6ac;
      box-shadow: 0 0 0 2px rgba(77, 182, 172, 0.3);
    }
    
    /* Button */
    button {
      margin-top: 30px;
      width: 100%;
      padding: 16px 0;
      border: none;
      border-radius: 10px;
      background: linear-gradient(45deg, #1976d2, #00796b);
      color: #fff;
      font-size: 1.2rem;
      font-weight: 600;
      letter-spacing: 0.05em;
      cursor: pointer;
      transition: all 0.4s ease;
      user-select: none;
      position: relative;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    button::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }
    
    button:hover::after {
      left: 100%;
    }
    
    button:hover {
      box-shadow: 0 8px 20px rgba(25, 118, 210, 0.4);
      transform: translateY(-2px);
    }
    
    button:active {
      transform: translateY(1px);
    }
    
    button:disabled {
      background: linear-gradient(45deg, #455a64, #37474f);
      cursor: not-allowed;
      opacity: 0.7;
    }
    
    /* Contact Info */
    .contact-info {
      margin-top: 35px;
      background: rgba(25, 118, 210, 0.15);
      padding: 25px;
      border-radius: 12px;
      font-size: 1.1rem;
      font-weight: 500;
      color: #e0f7fa;
      border: 1px solid rgba(77, 182, 172, 0.3);
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    
    .contact-row {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .contact-row i {
      color: #4db6ac;
      font-size: 1.3rem;
      min-width: 30px;
      text-align: center;
    }
    
    /* Floating Animation */
    .floating {
      animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    
    /* Message Boxes */
    .message-box {
      margin-top: 20px;
      padding: 15px 20px;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 12px;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.5s ease;
      user-select: none;
      background: rgba(10, 25, 41, 0.8);
      border: 1px solid rgba(77, 182, 172, 0.3);
    }
    
    .message-box.show {
      opacity: 1;
      pointer-events: auto;
    }
    
    .message-box.success {
      border-left: 4px solid #4BB543;
    }
    
    .message-box.error {
      border-left: 4px solid #d9534f;
    }
    
    .message-box svg {
      flex-shrink: 0;
      width: 26px;
      height: 26px;
      stroke-width: 2.5;
    }
    
    /* Loading Spinner */
    .spinner {
      display: inline-block;
      width: 24px;
      height: 24px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
      margin-right: 10px;
      vertical-align: middle;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    
    /* Decorative Elements */
    .decoration {
      position: absolute;
      z-index: 1;
      pointer-events: none;
    }
    
    .decoration-1 {
      top: 10%;
      left: 5%;
      width: 40px;
      opacity: 0.6;
      animation: floating 4s ease-in-out infinite;
    }
    
    .decoration-2 {
      bottom: 15%;
      right: 5%;
      width: 50px;
      opacity: 0.7;
      animation: floating 5s ease-in-out infinite;
      animation-delay: 0.5s;
    }
    
    /* Footer */
    footer {
      text-align: center;
      padding: 25px;
      font-size: 1rem;
      color: rgba(200, 230, 255, 0.7);
      background: rgba(10, 25, 41, 0.7);
      border-top: 1px solid rgba(77, 182, 172, 0.2);
    }
    
    .footer-content {
      max-width: 600px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .social-links {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 10px;
    }
    
    .social-links a {
      color: #b2ebf2;
      font-size: 1.4rem;
      transition: all 0.3s ease;
    }
    
    .social-links a:hover {
      color: #4db6ac;
      transform: translateY(-3px);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .logo-container {
        flex-direction: column;
        gap: 15px;
      }
      
      .logo-divider {
        height: 2px;
        width: 100px;
        background: linear-gradient(to right, transparent, #4db6ac, transparent);
      }
      
      .company-name {
        font-size: 2rem;
      }
      
      nav {
        gap: 8px 15px;
      }
      
      nav a {
        font-size: 1rem;
        padding: 8px 15px;
      }
      
      .container {
        padding: 30px 25px;
        margin: 0 20px 40px;
      }
    }
    
    @media (max-width: 480px) {
      .header-container {
        padding: 20px 15px 10px;
      }
      
      .logo {
        height: 65px;
      }
      
      .company-name {
        font-size: 1.7rem;
      }
      
      nav {
        gap: 6px 12px;
      }
      
      nav a {
        font-size: 0.9rem;
        padding: 7px 12px;
      }
      
      .container {
        padding: 25px 20px;
      }
      
      .container h2 {
        font-size: 2rem;
      }
      
      button {
        padding: 14px 0;
        font-size: 1.1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Decorative elements -->
  <div class="decoration decoration-1 floating">
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <path d="M20,50 Q40,15 80,50 Q40,85 20,50 Z" fill="none" stroke="#4db6ac" stroke-width="2" stroke-opacity="0.4" />
    </svg>
  </div>
  
  <div class="decoration decoration-2 floating">
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <circle cx="50" cy="50" r="40" fill="none" stroke="#1976d2" stroke-width="2" stroke-opacity="0.4" stroke-dasharray="5,5" />
    </svg>
  </div>

  <div class="header-container">
    <div class="logo-container">
      <a href="home-screen.html">
        <img src="Logo.jpg" alt="OK Tours and Travel Logo" class="logo">
      </a>
      <div class="logo-divider"></div>
      <div class="company-name">OK Africa Tours and Travel</div>
    </div>
  </div>

  <nav>
    <a href="home-screen.html"><i class="fas fa-home"></i> Home</a>
    <a href="booking.php"><i class="fas fa-calendar-check"></i> Book Now</a>
    <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
    <a href="enquiry.php" class="active"><i class="fas fa-question-circle"></i> Enquiry</a>
    <a href="user-comments.html"><i class="fas fa-comments"></i> Comments</a>
  </nav>

  <div class="container">
    <h2>Make an Enquiry</h2>
    <form id="enquiryForm" novalidate>
      <!-- CSRF Protection -->
      <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
      
      <div class="form-group">
        <label for="name" class="required">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required />
      </div>
      
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" />
      </div>
      
      <div class="form-group">
        <label for="phone" class="required">Contact Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your contact number" required />
      </div>
      
      <div class="form-group">
        <label for="enquiry_type">Enquiry Type</label>
        <select id="enquiry_type" name="enquiry_type">
          <option value="">Select an option</option>
          <option value="tour">Tour Information</option>
          <option value="booking">Booking Assistance</option>
          <option value="custom">Custom Tour Request</option>
          <option value="feedback">Feedback</option>
          <option value="other">Other</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="message">Message / Question</label>
        <textarea id="message" name="message" rows="5" placeholder="Type your enquiry here..."></textarea>
      </div>

      <button type="submit" id="submitBtn">
        <span id="buttonText">Submit Enquiry</span>
        <span id="buttonSpinner" class="spinner" style="display:none;"></span>
      </button>
    </form>

    <div id="confirmation" class="message-box" aria-live="polite"></div>

    <div class="contact-info">
      <div class="contact-row">
        <i class="fas fa-headset"></i>
        <div>Need help? Contact: <b>0706467999</b></div>
      </div>
      <div class="contact-row">
        <i class="fas fa-user-tie"></i>
        <div>Name: <b>Ephantus Kagai Njogu</b></div>
      </div>
      <div class="contact-row">
        <i class="fas fa-envelope"></i>
        <div>Email: <b>contact@oktours.com</b></div>
      </div>
      <div class="contact-row">
        <i class="fas fa-clock"></i>
        <div>Hours: Mon-Sat 8:00 AM - 8:00 PM</div>
      </div>
    </div>
  </div>
  
  <footer>
    <div class="footer-content">
      <p>&copy; 2023 OK Tours and Travel. All rights reserved.</p>
      <p>Creating unforgettable travel experiences</p>
      <div class="social-links">
        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/okafrica.travel"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com/@okafrica.travel"><i class="fab fa-tiktok"></i></a>
        <a href="https://www.youtube.com/@okafrica.travel"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </footer>

  <script>
    const form = document.getElementById('enquiryForm');
    const confirmation = document.getElementById('confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const buttonText = document.getElementById('buttonText');
    const buttonSpinner = document.getElementById('buttonSpinner');
    
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
      // Format phone number as user types
      let phone = this.value.replace(/\D/g, '');
      
      if (phone.length > 3 && phone.length <= 6) {
        phone = phone.replace(/(\d{3})(\d+)/, '$1 $2');
      } else if (phone.length > 6) {
        phone = phone.replace(/(\d{3})(\d{3})(\d+)/, '$1 $2 $3');
      }
      
      this.value = phone;
    });

    // Icons for messages
    const icons = {
      success: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#4BB543">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>`,
      error: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#d9534f">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>`
    };

    function showMessage(type, message) {
      confirmation.className = 'message-box ' + type;
      confirmation.innerHTML = `${icons[type]} ${message}`;
      confirmation.classList.add('show');
      
      setTimeout(() => {
        confirmation.classList.remove('show');
      }, 5000);
    }

    function validateForm() {
      const name = form.name.value.trim();
      const phone = form.phone.value.trim();
      
      if (!name) {
        showMessage('error', 'Please enter your full name');
        form.name.focus();
        return false;
      }
      
      if (!phone) {
        showMessage('error', 'Please enter your contact number');
        form.phone.focus();
        return false;
      }
      
      // Simple phone validation
      const phoneDigits = phone.replace(/\D/g, '');
      if (phoneDigits.length < 9) {
        showMessage('error', 'Please enter a valid phone number');
        form.phone.focus();
        return false;
      }
      
      return true;
    }

    form.addEventListener('submit', async function(event) {
      event.preventDefault();
      
      if (!validateForm()) return;
      
      // Show loading state
      buttonText.textContent = 'Processing...';
      buttonSpinner.style.display = 'inline-block';
      submitBtn.disabled = true;
      
      const formData = {
        name: form.name.value.trim(),
        email: form.email.value.trim(),
        phone: form.phone.value.trim(),
        enquiry_type: form.enquiry_type.value,
        message: form.message.value.trim(),
        csrf_token: form.csrf_token.value
      };
      
      try {
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        // Randomly determine success or failure for demo
        const isSuccess = Math.random() > 0.2;
        
        if (isSuccess) {
          showMessage('success', `Thank you for your enquiry, <strong>${formData.name}</strong>! We will contact you soon.`);
          form.reset();
        } else {
          showMessage('error', 'There was an error submitting your enquiry. Please try again.');
        }
      } catch (err) {
        showMessage('error', 'Failed to submit. Please try again later.');
      } finally {
        // Reset button
        buttonText.textContent = 'Submit Enquiry';
        buttonSpinner.style.display = 'none';
        submitBtn.disabled = false;
      }
    });
  </script>
</body>
</html>