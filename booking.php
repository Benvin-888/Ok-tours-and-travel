<?php include 'get_background.php'; ?>
<?php
// Enhanced session management with security headers
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

// Regenerate session ID for security
if (empty($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Simple rate limiting
if (!isset($_SESSION['last_request'])) {
    $_SESSION['last_request'] = time();
} else {
    $current_time = time();
    if ($current_time - $_SESSION['last_request'] < 2) { // 2 seconds between requests
        die('Too many requests. Please wait a moment.');
    }
    $_SESSION['last_request'] = $current_time;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booking - OK Tours and Travel</title>
  <meta name="description" content="Book your dream vacation with OK Tours and Travel. Explore amazing destinations worldwide." />
  <meta name="robots" content="index, follow" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Pacifico&display=swap" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    :root {
      --primary: #2a7de1;
      --primary-dark: #1e5fbf;
      --secondary: #ffde59;
      --accent: #ff6b6b;
      --text: #2a2a2a;
      --light: #f8f9fa;
      --white: #ffffff;
      --success: #28a745;
      --error: #dc3545;
      --input-bg: #f5f8fa;
      --label-color: #4a5568;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      height: 100%;
      scroll-behavior: smooth;
    }

    body {
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: var(--text);
      background: url('<?php echo $background; ?>') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      display: flex;
      flex-direction: column;
      line-height: 1.6;
    }
    
    .skip-to-content {
      position: absolute;
      top: -40px;
      left: 0;
      background: var(--primary);
      color: white;
      padding: 8px;
      z-index: 100;
      transition: top 0.3s;
    }
    
    .skip-to-content:focus {
      top: 0;
    }
    
    nav {
      background-color: rgba(255, 255, 255, 0.15);
      padding: 15px 0;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      z-index: 10;
      backdrop-filter: blur(10px);
      position: relative;
    }

    nav a {
      color: var(--white);
      text-decoration: none;
      margin: 0 22px;
      font-size: 18px;
      font-weight: 600;
      letter-spacing: 0.8px;
      transition: var(--transition);
      position: relative;
      padding: 5px 0;
    }

    nav a:hover, nav a:focus {
      color: var(--secondary);
      outline: none;
    }

    nav a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: var(--secondary);
      transition: var(--transition);
    }

    nav a:hover::after, nav a:focus::after {
      width: 100%;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      margin: 50px auto;
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
      width: 90%;
      max-width: 650px;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      flex: 1;
      animation: fadeIn 0.8s ease-out;
    }

    h1 {
      font-family: 'Pacifico', cursive;
      font-size: 3.5rem;
      color: var(--primary);
      margin-bottom: 30px;
      text-align: center;
      text-shadow: 0 3px 10px rgba(42, 125, 225, 0.3);
      position: relative;
      display: inline-block;
      width: 100%;
    }

    h1::after {
      content: '';
      display: block;
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      margin: 15px auto 0;
      border-radius: 2px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    label {
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--label-color);
      font-size: 0.95rem;
      letter-spacing: 0.5px;
      display: block;
    }

    .required::after {
      content: '*';
      color: var(--error);
      margin-left: 4px;
    }

    select,
    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="date"],
    input[type="tel"],
    textarea {
      width: 100%;
      padding: 15px 20px;
      padding-left: 50px;
      border-radius: 12px;
      border: 2px solid #e0e0e0;
      font-size: 1rem;
      color: var(--text);
      background-color: var(--input-bg);
      transition: var(--transition);
      font-family: 'Poppins', sans-serif;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    textarea {
      min-height: 100px;
      resize: vertical;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 42px;
      color: var(--primary);
      font-size: 1.2rem;
      transition: var(--transition);
    }

    select:focus,
    input:focus,
    textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(42, 125, 225, 0.2);
      background-color: var(--white);
    }

    select:focus + .input-icon,
    input:focus + .input-icon {
      color: var(--primary-dark);
      transform: scale(1.1);
    }

    .form-row {
      display: flex;
      gap: 20px;
    }

    .form-row .form-group {
      flex: 1;
    }

    /* Modern Button Styles */
    .btn {
      padding: 16px 24px;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: var(--transition);
      letter-spacing: 0.5px;
      font-family: 'Poppins', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      transition: var(--transition);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      box-shadow: 0 4px 15px rgba(42, 125, 225, 0.3);
    }

    .btn-secondary {
      background: linear-gradient(135deg, #6c757d, #5a6268);
      color: white;
      box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn:hover, .btn:focus {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(30, 95, 191, 0.4);
      outline: none;
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn i {
      transition: var(--transition);
    }

    .btn-primary:hover i, .btn-primary:focus i {
      transform: translateX(3px);
    }

    .btn-secondary:hover i, .btn-secondary:focus i {
      transform: translateX(-3px);
    }

    .btn .spinner {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }

    .btn:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none !important;
    }

    .success-message {
      background-color: rgba(40, 167, 69, 0.9);
      color: white;
      padding: 15px;
      margin: 20px 0;
      border-radius: 8px;
      text-align: center;
      display: none;
      animation: fadeIn 0.5s ease-out;
    }

    .error-message {
      color: var(--error);
      font-size: 0.85rem;
      margin-top: 8px;
      display: none;
    }

    .form-group.invalid .error-message {
      display: block;
    }

    .form-group.invalid input,
    .form-group.invalid select,
    .form-group.invalid textarea {
      border-color: var(--error);
    }

    .form-group.invalid .input-icon {
      color: var(--error);
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: rgba(42, 125, 225, 0.9);
      color: white;
      font-size: 14px;
      letter-spacing: 0.8px;
      font-weight: 500;
      font-family: 'Poppins', sans-serif;
      box-shadow: 0 -5px 15px rgba(42, 125, 225, 0.7);
      margin-top: auto;
    }

    .payment-methods {
      display: flex;
      gap: 15px;
      margin: 20px 0;
      justify-content: center;
    }

    .payment-method {
      width: 50px;
      height: 30px;
      background-color: white;
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 5px;
      transition: var(--transition);
    }

    .payment-method:hover, .payment-method:focus {
      transform: translateY(-3px);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      outline: none;
    }

    .payment-method img {
      max-width: 100%;
      max-height: 100%;
    }

    .progress-steps {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
      position: relative;
    }

    .progress-steps::before {
      content: '';
      position: absolute;
      top: 15px;
      left: 0;
      right: 0;
      height: 2px;
      background-color: #e0e0e0;
      z-index: 1;
    }

    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      z-index: 2;
      cursor: pointer;
    }

    .step-number {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: #e0e0e0;
      color: #999;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-bottom: 5px;
      transition: var(--transition);
      border: 3px solid white;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .step.active .step-number {
      background-color: var(--primary);
      color: white;
      transform: scale(1.1);
    }

    .step.completed .step-number {
      background-color: var(--success);
      color: white;
    }

    .step-text {
      font-size: 0.85rem;
      color: #999;
      text-align: center;
      transition: var(--transition);
    }

    .step.active .step-text {
      color: var(--primary);
      font-weight: 600;
    }

    .step.completed .step-text {
      color: var(--success);
    }

    .form-section {
      display: none;
      animation: fadeIn 0.5s ease-out;
    }

    .form-section.active {
      display: block;
    }

    .navigation-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    
    .payment-details {
      display: none;
      margin-top: 20px;
      padding: 20px;
      background-color: var(--input-bg);
      border-radius: 12px;
      border-left: 4px solid var(--primary);
    }
    
    .payment-details.active {
      display: block;
      animation: fadeIn 0.5s ease-out;
    }
    
    .estimated-cost {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      padding: 15px;
      border-radius: 12px;
      margin: 20px 0;
      text-align: center;
      display: none;
    }
    
    .estimated-cost.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Floating labels */
    .floating-label-group {
      position: relative;
      margin-bottom: 25px;
    }

    .floating-label {
      position: absolute;
      left: 50px;
      top: 16px;
      color: #777;
      font-size: 1rem;
      pointer-events: none;
      transition: var(--transition);
      background: var(--input-bg);
      padding: 0 5px;
    }

    input:focus ~ .floating-label,
    input:not(:placeholder-shown) ~ .floating-label,
    select:focus ~ .floating-label,
    select:not([value=""]):valid ~ .floating-label {
      top: -10px;
      left: 45px;
      font-size: 0.75rem;
      color: var(--primary);
      background: linear-gradient(to bottom, rgba(245,248,250,0.9), rgba(245,248,250,0.7));
      font-weight: 600;
    }
    
    /* Toast notification */
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 15px 20px;
      border-radius: 8px;
      color: white;
      z-index: 1000;
      display: flex;
      align-items: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      transform: translateY(100px);
      opacity: 0;
      transition: all 0.3s ease;
    }
    
    .toast.show {
      transform: translateY(0);
      opacity: 1;
    }
    
    .toast.success {
      background-color: var(--success);
    }
    
    .toast.error {
      background-color: var(--error);
    }
    
    .toast i {
      margin-right: 10px;
      font-size: 1.2rem;
    }
    
    /* Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .modal.show {
      display: flex;
      opacity: 1;
    }
    
    .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 15px;
      max-width: 500px;
      width: 90%;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      transform: translateY(-50px);
      transition: transform 0.3s ease;
    }
    
    .modal.show .modal-content {
      transform: translateY(0);
    }
    
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .modal-title {
      font-size: 1.5rem;
      color: var(--primary);
    }
    
    .modal-close {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: #777;
    }
    
    .cost-breakdown {
      margin: 15px 0;
      padding: 15px;
      background-color: var(--input-bg);
      border-radius: 10px;
    }
    
    .cost-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }
    
    .cost-total {
      font-weight: bold;
      border-top: 2px solid #ddd;
      padding-top: 8px;
      margin-top: 8px;
    }
    
    /* Save progress button */
    .save-progress {
      text-align: center;
      margin-top: 20px;
      display: none;
    }
    
    .save-btn {
      background: transparent;
      border: 2px solid var(--primary);
      color: var(--primary);
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: var(--transition);
      font-weight: 600;
    }
    
    .save-btn:hover {
      background-color: var(--primary);
      color: white;
    }
    
    /* Print styles */
    @media print {
      nav, footer, .navigation-buttons, .btn {
        display: none !important;
      }
      
      body {
        background: white !important;
      }
      
      .container {
        box-shadow: none;
        background: white;
        width: 100%;
        max-width: 100%;
      }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2.5rem;
      }
      nav a {
        font-size: 16px;
        margin: 0 12px;
      }
      .container {
        padding: 30px 25px;
        width: 95%;
      }
      .form-row {
        flex-direction: column;
        gap: 0;
      }
      .btn {
        padding: 14px 20px;
        font-size: 0.95rem;
      }
      
      .progress-steps {
        margin-bottom: 20px;
      }
      
      .step-text {
        font-size: 0.75rem;
      }
    }
    
    @media (max-width: 480px) {
      h1 {
        font-size: 2rem;
      }
      
      nav a {
        font-size: 14px;
        margin: 0 8px;
      }
      
      .step-text {
        display: none;
      }
      
      .navigation-buttons {
        flex-direction: column;
        gap: 10px;
      }
      
      .navigation-buttons button {
        width: 100%;
      }
    }

    /* Loading spinner */
    .spinner {
      display: none;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <a href="#main-content" class="skip-to-content">Skip to main content</a>

  <nav>
    <a href="home-screen.html">Home</a>
    <a href="booking.php">Book Now</a>
    <a href="gallery.php">Gallery</a>
    <a href="enquiry.php">Enquiry</a>
    <a href="user-comments.html">comment section</a>
  </nav>

  <div class="container" id="main-content" tabindex="-1">
    <h1>Travel Booking</h1>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == '1') {
      echo '<div class="success-message animate__animated animate__fadeIn" style="display:block;">
              <i class="fas fa-check-circle" style="margin-right:8px;"></i>
              Your booking has been submitted successfully! We will contact you shortly.
            </div>';
    }
    ?>

    <div class="progress-steps">
      <div class="step active" data-step="1" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3">
        <div class="step-number">1</div>
        <div class="step-text">Trip Details</div>
      </div>
      <div class="step" data-step="2" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="3">
        <div class="step-number">2</div>
        <div class="step-text">Personal Info</div>
      </div>
      <div class="step" data-step="3" role="progressbar" aria-valuenow="0" aria-valuemin="1" aria-valuemax="3">
        <div class="step-number">3</div>
        <div class="step-text">Review & Pay</div>
      </div>
    </div>

    <form id="bookingForm" method="POST" action="submit_booking.php" novalidate>
      <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
      
      <!-- Step 1: Trip Details -->
      <div class="form-section active" data-step="1">
        <div class="form-group">
          <label for="place" class="required">Destination</label>
          <i class="fas fa-globe-africa input-icon"></i>
          <select id="place" name="place" required aria-describedby="place-error">
            <option value="" disabled selected>Select a destination</option>
            <optgroup label="🌍 African Countries">
              <option value="Kenya" data-price="1200">Kenya</option>
              <option value="Egypt" data-price="1500">Egypt</option>
              <option value="South Africa" data-price="1400">South Africa</option>
              <option value="Morocco" data-price="1300">Morocco</option>
              <option value="Tanzania" data-price="1100">Tanzania</option>
            </optgroup>
            <optgroup label="🌎 Other Countries">
              <option value="France" data-price="2000">France</option>
              <option value="Japan" data-price="2200">Japan</option>
              <option value="Australia" data-price="2500">Australia</option>
              <option value="Brazil" data-price="1800">Brazil</option>
              <option value="USA" data-price="2300">USA</option>
            </optgroup>
          </select>
          <div class="error-message" id="place-error">Please select a destination</div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="numPeople" class="required">Travelers</label>
            <i class="fas fa-users input-icon"></i>
            <input type="number" id="numPeople" name="num_people" min="1" max="20" required placeholder=" " aria-describedby="numPeople-error" />
            <span class="floating-label">Number of people</span>
            <div class="error-message" id="numPeople-error">Please enter a valid number (1-20)</div>
          </div>
          <div class="form-group">
            <label for="numDays" class="required">Duration</label>
            <i class="fas fa-calendar-day input-icon"></i>
            <input type="number" id="numDays" name="num_days" min="1" max="30" required placeholder=" " aria-describedby="numDays-error" />
            <span class="floating-label">Number of days</span>
            <div class="error-message" id="numDays-error">Please enter a valid duration (1-30 days)</div>
          </div>
        </div>

        <div class="form-group">
          <label for="travelDate" class="required">Travel Date</label>
          <i class="fas fa-calendar-alt input-icon"></i>
          <input type="date" id="travelDate" name="travel_date" required aria-describedby="travelDate-error" />
          <div class="error-message" id="travelDate-error">Please select a valid date</div>
        </div>
        
        <div class="form-group">
          <label for="specialRequests">Special Requests</label>
          <i class="fas fa-comment input-icon"></i>
          <textarea id="specialRequests" name="special_requests" placeholder="Any special requirements or requests" aria-describedby="specialRequests-info"></textarea>
          <div class="error-message" id="specialRequests-error"></div>
        </div>
        
        <div class="estimated-cost" id="estimatedCost">
          <i class="fas fa-dollar-sign"></i>
          Estimated Cost: Ksh<span id="costValue">0</span>
          <button type="button" class="save-btn" id="viewBreakdown" style="margin-left: 15px; font-size: 0.8rem;">
            View Breakdown
          </button>
        </div>

        <div class="navigation-buttons">
          <button type="button" class="btn btn-secondary" disabled>
            <i class="fas fa-arrow-left"></i> Previous
          </button>
          <button type="button" class="btn btn-primary next-step">
            Next <i class="fas fa-arrow-right"></i>
          </button>
        </div>
        
        <div class="save-progress">
          <button type="button" class="save-btn" id="saveProgress">
            <i class="fas fa-save"></i> Save Progress
          </button>
        </div>
      </div>

      <!-- Step 2: Personal Info -->
      <div class="form-section" data-step="2">
        <div class="form-group">
          <label for="name" class="required">Full Name</label>
          <i class="fas fa-user input-icon"></i>
          <input type="text" id="name" name="name" required placeholder=" " aria-describedby="name-error" />
          <span class="floating-label">Your full name</span>
          <div class="error-message" id="name-error">Please enter your full name</div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="contact" class="required">Phone Number</label>
            <i class="fas fa-phone input-icon"></i>
            <input type="tel" id="contact" name="contact" required placeholder=" " aria-describedby="contact-error" />
            <span class="floating-label">Phone number</span>
            <div class="error-message" id="contact-error">Please enter a valid phone number</div>
          </div>
          <div class="form-group">
            <label for="email" class="required">Email</label>
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" required placeholder=" " aria-describedby="email-error" />
            <span class="floating-label">Email address</span>
            <div class="error-message" id="email-error">Please enter a valid email</div>
          </div>
        </div>

        <div class="form-group">
          <label for="idNumber" class="required">ID/Passport Number</label>
          <i class="fas fa-id-card input-icon"></i>
          <input type="text" id="idNumber" name="id_number" required placeholder=" " aria-describedby="idNumber-error" />
          <span class="floating-label">ID or passport number</span>
          <div class="error-message" id="idNumber-error">Please enter your ID/passport number</div>
        </div>
        
        <div class="form-group">
          <label for="emergencyContact">Emergency Contact</label>
          <i class="fas fa-phone-alt input-icon"></i>
          <input type="tel" id="emergencyContact" name="emergency_contact" placeholder=" " aria-describedby="emergencyContact-info" />
          <span class="floating-label">Emergency contact number</span>
          <div class="error-message" id="emergencyContact-error"></div>
        </div>

        <div class="navigation-buttons">
          <button type="button" class="btn btn-secondary prev-step">
            <i class="fas fa-arrow-left"></i> Previous
          </button>
          <button type="button" class="btn btn-primary next-step">
            Next <i class="fas fa-arrow-right"></i>
          </button>
        </div>
        
        <div class="save-progress">
          <button type="button" class="save-btn" id="saveProgress2">
            <i class="fas fa-save"></i> Save Progress
          </button>
        </div>
      </div>

      <!-- Step 3: Review & Payment -->
      <div class="form-section" data-step="3">
        <h3 style="color: var(--primary); margin-bottom: 20px; text-align: center;">
          <i class="fas fa-clipboard-check" style="margin-right: 10px;"></i>
          Review Your Booking
        </h3>
        
        <div style="background: var(--input-bg); padding: 20px; border-radius: 10px; margin-bottom: 25px;">
          <h4 style="margin-bottom: 15px; color: var(--primary);">Trip Summary</h4>
          <div id="reviewContent" style="line-height: 1.8;">
            <!-- Dynamically populated with JS -->
          </div>
        </div>

        <div class="form-group">
          <label for="paymentMethod" class="required">Payment Method</label>
          <i class="fas fa-credit-card input-icon"></i>
          <select id="paymentMethod" name="payment_method" required aria-describedby="paymentMethod-error">
            <option value="" disabled selected>Select payment method</option>
            <option value="credit_card">Credit Card</option>
            <option value="mpesa">M-Pesa</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
          </select>
          <div class="error-message" id="paymentMethod-error">Please select a payment method</div>
        </div>
        
        <!-- Payment details (shown based on selection) -->
        <div class="payment-details" id="creditCardDetails">
          <h4>Credit Card Details</h4>
          <div class="form-group">
            <label for="cardNumber" class="required">Card Number</label>
            <input type="text" id="cardNumber" name="card_number" placeholder="XXXX XXXX XXXX XXXX" pattern="[0-9]{16}" maxlength="16" />
            <div class="error-message" id="cardNumber-error">Please enter a valid card number</div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="expiryDate" class="required">Expiry Date</label>
              <input type="text" id="expiryDate" name="expiry_date" placeholder="MM/YY" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" maxlength="5" />
              <div class="error-message" id="expiryDate-error">Please enter a valid expiry date (MM/YY)</div>
            </div>
            <div class="form-group">
              <label for="cvv" class="required">CVV</label>
              <input type="text" id="cvv" name="cvv" placeholder="XXX" pattern="[0-9]{3,4}" maxlength="4" />
              <div class="error-message" id="cvv-error">Please enter a valid CVV</div>
            </div>
          </div>
        </div>
        
        <div class="payment-details" id="mpesaDetails">
          <h4>M-Pesa Payment</h4>
          <p>You will receive a prompt on your phone to complete the payment</p>
          <div class="form-group">
            <label for="mpesaNumber" class="required">M-Pesa Phone Number</label>
            <input type="tel" id="mpesaNumber" name="mpesa_number" placeholder="07XX XXX XXX" pattern="07[0-9]{8}" maxlength="10" />
            <div class="error-message" id="mpesaNumber-error">Please enter a valid M-Pesa number</div>
          </div>
        </div>
        
        <div class="payment-details" id="bankTransferDetails">
          <h4>Bank Transfer Instructions</h4>
          <p>Please transfer the payment to the following account:</p>
          <p><strong>Bank:</strong> Kenya Commercial Bank</p>
          <p><strong>Account Name:</strong> OK Africa Tours and Travel</p>
          <p><strong>Account Number:</strong> 1234567890</p>
          <p><strong>Branch:</strong> Nairobi Main Branch</p>
          <p><strong>Swift Code:</strong> KCBLKENX</p>
          <p>Please use your name as the reference.</p>
        </div>
        
        <div class="payment-details" id="paypalDetails">
          <h4>PayPal Payment</h4>
          <p>You will be redirected to PayPal to complete your payment</p>
          <div class="form-group">
            <label for="paypalEmail" class="required">PayPal Email</label>
            <input type="email" id="paypalEmail" name="paypal_email" placeholder="Your PayPal email" />
            <div class="error-message" id="paypalEmail-error">Please enter your PayPal email</div>
          </div>
        </div>

        <div class="payment-methods">
          <div class="payment-method">
            <i class="fab fa-cc-visa" style="color: #1a1f71; font-size: 1.5rem;"></i>
          </div>
          <div class="payment-method">
            <i class="fab fa-cc-mastercard" style="color: #eb001b; font-size: 1.5rem;"></i>
          </div>
          <div class="payment-method">
            <i class="fas fa-mobile-alt" style="color: #32CD32; font-size: 1.5rem;"></i>
          </div>
          <div class="payment-method">
            <i class="fab fa-paypal" style="color: #003087; font-size: 1.5rem;"></i>
          </div>
        </div>

        <div class="navigation-buttons">
          <button type="button" class="btn btn-secondary prev-step">
            <i class="fas fa-arrow-left"></i> Previous
          </button>
          <button type="submit" class="btn btn-primary" id="submitBtn">
            <span class="spinner"></span>
            <span>Confirm Booking</span>
          </button>
        </div>
        
        <div class="save-progress">
          <button type="button" class="save-btn" id="printSummary">
            <i class="fas fa-print"></i> Print Summary
          </button>
        </div>
      </div>
    </form>
  </div>

  <footer>
    © <?php echo date("Y"); ?> OK AFRICA TOURS AND TRAVEL. All rights reserved.
  </footer>
  
  <!-- Toast notification -->
  <div class="toast" id="toastNotification">
    <i class="fas fa-check-circle"></i>
    <span id="toastMessage"></span>
  </div>
  
  <!-- Cost Breakdown Modal -->
  <div class="modal" id="costModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Cost Breakdown</h3>
        <button class="modal-close" aria-label="Close modal">&times;</button>
      </div>
      <div id="costBreakdownContent">
        <!-- Content will be populated by JavaScript -->
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Set minimum date to today
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('travelDate').min = today;
      
      // Multi-step form functionality
      const formSections = document.querySelectorAll('.form-section');
      const steps = document.querySelectorAll('.step');
      const nextButtons = document.querySelectorAll('.next-step');
      const prevButtons = document.querySelectorAll('.prev-step');
      const submitBtn = document.getElementById('submitBtn');
      const spinner = submitBtn.querySelector('.spinner');
      const paymentMethod = document.getElementById('paymentMethod');
      const paymentDetails = document.querySelectorAll('.payment-details');
      const estimatedCost = document.getElementById('estimatedCost');
      const viewBreakdownBtn = document.getElementById('viewBreakdown');
      const costModal = document.getElementById('costModal');
      const modalClose = document.querySelector('.modal-close');
      const costBreakdownContent = document.getElementById('costBreakdownContent');
      const saveProgressBtns = document.querySelectorAll('#saveProgress, #saveProgress2');
      const printSummaryBtn = document.getElementById('printSummary');
      
      let currentStep = 1;

      // Initialize form
      updateFormDisplay();
      loadSavedProgress(); // Try to load saved form data

      // Next button click handler
      nextButtons.forEach(button => {
        button.addEventListener('click', function() {
          if (validateStep(currentStep)) {
            currentStep++;
            updateFormDisplay();
          }
        });
      });

      // Previous button click handler
      prevButtons.forEach(button => {
        button.addEventListener('click', function() {
          currentStep--;
          updateFormDisplay();
        });
      });

      // Step click handler (for navigation)
      steps.forEach(step => {
        step.addEventListener('click', function() {
          const stepNumber = parseInt(this.getAttribute('data-step'));
          if (stepNumber < currentStep) {
            currentStep = stepNumber;
            updateFormDisplay();
          }
        });
      });
      
      // Payment method change handler
      paymentMethod.addEventListener('change', function() {
        const method = this.value;
        // Hide all payment details first
        paymentDetails.forEach(detail => {
          detail.classList.remove('active');
        });
        
        // Show the selected payment method details
        if (method) {
          const detailElement = document.getElementById(method + 'Details');
          if (detailElement) {
            detailElement.classList.add('active');
          }
        }
      });
      
      // Calculate estimated cost when inputs change
      const costInputs = ['place', 'numPeople', 'numDays'];
      costInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
          input.addEventListener('change', calculateEstimatedCost);
          input.addEventListener('input', calculateEstimatedCost);
        }
      });
      
      // View cost breakdown
      viewBreakdownBtn.addEventListener('click', showCostBreakdown);
      
      // Modal close handler
      modalClose.addEventListener('click', function() {
        costModal.classList.remove('show');
      });
      
      // Close modal when clicking outside
      window.addEventListener('click', function(event) {
        if (event.target === costModal) {
          costModal.classList.remove('show');
        }
      });
      
      // Save progress buttons
      saveProgressBtns.forEach(btn => {
        btn.addEventListener('click', saveFormProgress);
      });
      
      // Print summary
      printSummaryBtn.addEventListener('click', function() {
        window.print();
      });
      
      // Real-time validation for inputs
      setupRealTimeValidation();

      // Initial cost calculation
      calculateEstimatedCost();

      // Form submission handler - FIXED VERSION
      document.getElementById('bookingForm').addEventListener('submit', function(e) {
        // Don't prevent default submission if validation passes
        if (!validateStep(currentStep)) {
          e.preventDefault();
          return false;
        }
        
        // Additional validation for payment details
        if (currentStep === 3 && !validatePaymentDetails()) {
          e.preventDefault();
          return false;
        }
        
        // Show loading spinner
        submitBtn.disabled = true;
        spinner.style.display = 'block';
        submitBtn.querySelector('span:not(.spinner)').style.display = 'none';
        
        // Form will submit naturally to submit-booking.php
        // Clear saved progress on successful submission
        localStorage.removeItem('bookingFormData');
      });

      // Update form display based on current step
      function updateFormDisplay() {
        formSections.forEach(section => {
          section.classList.remove('active');
          if (parseInt(section.getAttribute('data-step')) === currentStep) {
            section.classList.add('active');
            // Focus on first input for accessibility
            const firstInput = section.querySelector('input, select');
            if (firstInput) firstInput.focus();
          }
        });

        steps.forEach(step => {
          step.classList.remove('active', 'completed');
          const stepNumber = parseInt(step.getAttribute('data-step'));
          
          if (stepNumber === currentStep) {
            step.classList.add('active');
            step.setAttribute('aria-valuenow', stepNumber);
          } else if (stepNumber < currentStep) {
            step.classList.add('completed');
          }
        });

        // Update review section if we're on step 3
        if (currentStep === 3) {
          updateReviewSection();
        }
      }

      // Validate current step
      function validateStep(step) {
        let isValid = true;
        const currentSection = document.querySelector(`.form-section[data-step="${step}"]`);
        
        // Validate required fields in current section
        const requiredInputs = currentSection.querySelectorAll('[required]');
        requiredInputs.forEach(input => {
          const formGroup = input.closest('.form-group');
          formGroup.classList.remove('invalid');
          
          if (!input.value) {
            formGroup.classList.add('invalid');
            isValid = false;
          } else if (input.type === 'email' && !validateEmail(input.value)) {
            formGroup.classList.add('invalid');
            formGroup.querySelector('.error-message').textContent = 'Please enter a valid email';
            isValid = false;
          } else if (input.type === 'number') {
            const min = parseInt(input.getAttribute('min')) || 0;
            const max = parseInt(input.getAttribute('max')) || Infinity;
            const value = parseInt(input.value);
            
            if (isNaN(value)) {
              formGroup.classList.add('invalid');
              formGroup.querySelector('.error-message').textContent = 'Please enter a valid number';
              isValid = false;
            } else if (value < min || value > max) {
              formGroup.classList.add('invalid');
              formGroup.querySelector('.error-message').textContent = `Please enter a number between ${min} and ${max}`;
              isValid = false;
            }
          } else if (input.id === 'contact' && !validatePhone(input.value)) {
            formGroup.classList.add('invalid');
            formGroup.querySelector('.error-message').textContent = 'Please enter a valid phone number';
            isValid = false;
          }
        });

        return isValid;
      }
      
      // Validate payment details based on selected method
      function validatePaymentDetails() {
        const method = document.getElementById('paymentMethod').value;
        let isValid = true;
        
        if (method === 'credit_card') {
          const cardNumber = document.getElementById('cardNumber');
          const expiryDate = document.getElementById('expiryDate');
          const cvv = document.getElementById('cvv');
          
          if (!cardNumber.value || !validateCardNumber(cardNumber.value)) {
            document.getElementById('cardNumber-error').style.display = 'block';
            isValid = false;
          }
          
          if (!expiryDate.value || !validateExpiryDate(expiryDate.value)) {
            document.getElementById('expiryDate-error').style.display = 'block';
            isValid = false;
          }
          
          if (!cvv.value || !validateCVV(cvv.value)) {
            document.getElementById('cvv-error').style.display = 'block';
            isValid = false;
          }
        } else if (method === 'mpesa') {
          const mpesaNumber = document.getElementById('mpesaNumber');
          if (!mpesaNumber.value || !validatePhone(mpesaNumber.value)) {
            document.getElementById('mpesaNumber-error').style.display = 'block';
            isValid = false;
          }
        } else if (method === 'paypal') {
          const paypalEmail = document.getElementById('paypalEmail');
          if (!paypalEmail.value || !validateEmail(paypalEmail.value)) {
            document.getElementById('paypalEmail-error').style.display = 'block';
            isValid = false;
          }
        }
        
        return isValid;
      }

      // Email validation
      function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
      }
      
      // Phone validation
      function validatePhone(phone) {
        const re = /^[+]?[0-9]{8,15}$/;
        return re.test(phone.replace(/\s/g, ''));
      }
      
      // Card number validation
      function validateCardNumber(number) {
        const re = /^[0-9]{16}$/;
        return re.test(number.replace(/\s/g, ''));
      }
      
      // Expiry date validation
      function validateExpiryDate(date) {
        const re = /^(0[1-9]|1[0-2])\/[0-9]{2}$/;
        if (!re.test(date)) return false;
        
        const [month, year] = date.split('/');
        const now = new Date();
        const currentYear = now.getFullYear() % 100;
        const currentMonth = now.getMonth() + 1;
        
        if (parseInt(year) < currentYear) return false;
        if (parseInt(year) === currentYear && parseInt(month) < currentMonth) return false;
        
        return true;
      }
      
      // CVV validation
      function validateCVV(cvv) {
        const re = /^[0-9]{3,4}$/;
        return re.test(cvv);
      }
      
      // Calculate estimated cost
      function calculateEstimatedCost() {
        const destination = document.getElementById('place');
        const numPeople = document.getElementById('numPeople');
        const numDays = document.getElementById('numDays');
        
        if (destination.value && numPeople.value && numDays.value) {
          const basePrice = parseInt(destination.options[destination.selectedIndex].getAttribute('data-price')) || 1000;
          const people = parseInt(numPeople.value) || 1;
          const days = parseInt(numDays.value) || 1;
          
          const totalCost = basePrice * people * days;
          document.getElementById('costValue').textContent = totalCost.toLocaleString();
          estimatedCost.classList.add('active');
        } else {
          estimatedCost.classList.remove('active');
        }
      }
      
      // Show cost breakdown modal
      function showCostBreakdown() {
        const destination = document.getElementById('place');
        const numPeople = document.getElementById('numPeople');
        const numDays = document.getElementById('numDays');
        
        if (!destination.value || !numPeople.value || !numDays.value) {
          showToast('Please complete trip details first', 'error');
          return;
        }
        
        const basePrice = parseInt(destination.options[destination.selectedIndex].getAttribute('data-price')) || 1000;
        const people = parseInt(numPeople.value) || 1;
        const days = parseInt(numDays.value) || 1;
        const subtotal = basePrice * people * days;
        const tax = subtotal * 0.16; // 16% tax
        const total = subtotal + tax;
        
        costBreakdownContent.innerHTML = `
          <div class="cost-breakdown">
            <div class="cost-item">
              <span>${people} person(s) x ${days} day(s) @ $${basePrice}</span>
              <span>$${subtotal.toLocaleString()}</span>
            </div>
            <div class="cost-item">
              <span>Tax (16%)</span>
              <span>$${tax.toLocaleString()}</span>
            </div>
            <div class="cost-item cost-total">
              <span>Total</span>
              <span>$${total.toLocaleString()}</span>
            </div>
          </div>
          <p><small>Note: This is an estimate. Final price may vary based on additional services and seasonal rates.</small></p>
        `;
        
        costModal.classList.add('show');
      }

      // Update review section with form data
      function updateReviewSection() {
        const reviewContent = document.getElementById('reviewContent');
        const formData = new FormData(document.getElementById('bookingForm'));
        
        let html = `
          <p><strong>Destination:</strong> ${formData.get('place')}</p>
          <p><strong>Travelers:</strong> ${formData.get('num_people')} person(s)</p>
          <p><strong>Duration:</strong> ${formData.get('num_days')} days</p>
          <p><strong>Travel Date:</strong> ${formatDate(formData.get('travel_date'))}</p>
        `;
        
        if (formData.get('special_requests')) {
          html += `<p><strong>Special Requests:</strong> ${formData.get('special_requests')}</p>`;
        }
        
        html += `
          <hr style="margin: 15px 0; border-color: #eee;">
          <p><strong>Name:</strong> ${formData.get('name')}</p>
          <p><strong>Contact:</strong> ${formData.get('contact')}</p>
          <p><strong>Email:</strong> ${formData.get('email')}</p>
          <p><strong>ID/Passport:</strong> ${formData.get('id_number')}</p>
        `;
        
        if (formData.get('emergency_contact')) {
          html += `<p><strong>Emergency Contact:</strong> ${formData.get('emergency_contact')}</p>`;
        }
        
        // Add cost information
        const costValue = document.getElementById('costValue').textContent;
        if (costValue !== '0') {
          html += `<hr style="margin: 15px 0; border-color: #eee;">
                  <p><strong>Estimated Cost:</strong> $${costValue}</p>`;
        }
        
        reviewContent.innerHTML = html;
      }

      // Format date for display
      function formatDate(dateString) {
        if (!dateString) return '';
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
      }
      
      // Show toast notification
      function showToast(message, type) {
        const toast = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');
        
        toastMessage.textContent = message;
        toast.className = 'toast ' + type;
        toast.classList.add('show');
        
        // Hide toast after 5 seconds
        setTimeout(() => {
          toast.classList.remove('show');
        }, 5000);
      }
      
      // Save form progress to local storage
      function saveFormProgress() {
        const formData = new FormData(document.getElementById('bookingForm'));
        const formObject = {};
        
        for (let [key, value] of formData.entries()) {
          formObject[key] = value;
        }
        
        localStorage.setItem('bookingFormData', JSON.stringify(formObject));
        showToast('Progress saved successfully!', 'success');
      }
      
      // Load saved form progress from local storage
      function loadSavedProgress() {
        const savedData = localStorage.getItem('bookingFormData');
        
        if (savedData) {
          try {
            const formObject = JSON.parse(savedData);
            
            for (const key in formObject) {
              const input = document.querySelector(`[name="${key}"]`);
              if (input && formObject[key]) {
                input.value = formObject[key];
                
                // Trigger change event for select elements to update UI
                if (input.tagName === 'SELECT') {
                  input.dispatchEvent(new Event('change'));
                }
              }
            }
            
            // Recalculate cost
            calculateEstimatedCost();
          } catch (e) {
            console.error('Error loading saved data:', e);
          }
        }
      }
      
      // Setup real-time validation for inputs
      function setupRealTimeValidation() {
        const inputs = document.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
          // Validate on blur
          input.addEventListener('blur', function() {
            const formGroup = this.closest('.form-group');
            if (formGroup) {
              validateField(this);
            }
          });
          
          // Clear error on input
          input.addEventListener('input', function() {
            const formGroup = this.closest('.form-group');
            if (formGroup && formGroup.classList.contains('invalid')) {
              formGroup.classList.remove('invalid');
            }
            
            // Hide specific error messages for payment fields
            if (this.id === 'cardNumber') {
              document.getElementById('cardNumber-error').style.display = 'none';
            } else if (this.id === 'expiryDate') {
              document.getElementById('expiryDate-error').style.display = 'none';
            } else if (this.id === 'cvv') {
              document.getElementById('cvv-error').style.display = 'none';
            } else if (this.id === 'mpesaNumber') {
              document.getElementById('mpesaNumber-error').style.display = 'none';
            } else if (this.id === 'paypalEmail') {
              document.getElementById('paypalEmail-error').style.display = 'none';
            }
          });
        });
      }
      
      // Validate individual field
      function validateField(field) {
        const formGroup = field.closest('.form-group');
        if (!formGroup) return true;
        
        let isValid = true;
        let errorMessage = '';
        
        if (field.hasAttribute('required') && !field.value) {
          isValid = false;
          errorMessage = 'This field is required';
        } else if (field.type === 'email' && field.value && !validateEmail(field.value)) {
          isValid = false;
          errorMessage = 'Please enter a valid email';
        } else if (field.type === 'tel' && field.value && !validatePhone(field.value)) {
          isValid = false;
          errorMessage = 'Please enter a valid phone number';
        } else if (field.id === 'cardNumber' && field.value && !validateCardNumber(field.value)) {
          isValid = false;
          errorMessage = 'Please enter a valid card number';
        } else if (field.id === 'expiryDate' && field.value && !validateExpiryDate(field.value)) {
          isValid = false;
          errorMessage = 'Please enter a valid expiry date (MM/YY)';
        } else if (field.id === 'cvv' && field.value && !validateCVV(field.value)) {
          isValid = false;
          errorMessage = 'Please enter a valid CVV';
        }
        
        if (!isValid) {
          formGroup.classList.add('invalid');
          const errorElement = formGroup.querySelector('.error-message');
          if (errorElement) {
            errorElement.textContent = errorMessage;
          }
        } else {
          formGroup.classList.remove('invalid');
        }
        
        return isValid;
      }
    });
  </script>

</body>
</html>