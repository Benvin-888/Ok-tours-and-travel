<?php include 'get_background.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booking - OK Tours and Travel</title>
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

    nav a:hover {
      color: var(--secondary);
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

    nav a:hover::after {
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
    input[type="date"] {
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

    .input-icon {
      position: absolute;
      left: 18px;
      top: 42px;
      color: var(--primary);
      font-size: 1.2rem;
      transition: var(--transition);
    }

    select:focus,
    input:focus {
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

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(30, 95, 191, 0.4);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn i {
      transition: var(--transition);
    }

    .btn-primary:hover i {
      transform: translateX(3px);
    }

    .btn-secondary:hover i {
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
    .form-group.invalid select {
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

    .payment-method:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
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

  <nav>
    <a href="home-screen.html">Home</a>
    <a href="booking.php">Book Now</a>
    <a href="gallery.php">Gallery</a>
    <a href="enquiry.php">Enquiry</a>
    <a href="user-comments.html">comment section</a>
  </nav>

  <div class="container">
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
      <div class="step active" data-step="1">
        <div class="step-number">1</div>
        <div class="step-text">Trip Details</div>
      </div>
      <div class="step" data-step="2">
        <div class="step-number">2</div>
        <div class="step-text">Personal Info</div>
      </div>
      <div class="step" data-step="3">
        <div class="step-number">3</div>
        <div class="step-text">Review & Pay</div>
      </div>
    </div>

    <form id="bookingForm" method="POST" action="submit_booking.php">
      <!-- Step 1: Trip Details -->
      <div class="form-section active" data-step="1">
        <div class="form-group">
          <label for="place" class="required">Destination</label>
          <i class="fas fa-globe-africa input-icon"></i>
          <select id="place" name="place" required>
            <option value="" disabled selected>Select a destination</option>
            <optgroup label="🌍 African Countries">
              <option value="Kenya">Kenya</option>
              <option value="Egypt">Egypt</option>
              <option value="South Africa">South Africa</option>
              <option value="Morocco">Morocco</option>
              <option value="Tanzania">Tanzania</option>
            </optgroup>
            <optgroup label="🌎 Other Countries">
              <option value="France">France</option>
              <option value="Japan">Japan</option>
              <option value="Australia">Australia</option>
              <option value="Brazil">Brazil</option>
              <option value="USA">USA</option>
            </optgroup>
          </select>
          <div class="error-message">Please select a destination</div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="numPeople" class="required">Travelers</label>
            <i class="fas fa-users input-icon"></i>
            <input type="number" id="numPeople" name="num_people" min="1" max="20" required placeholder=" " />
            <span class="floating-label">Number of people</span>
            <div class="error-message">Please enter a valid number (1-20)</div>
          </div>
          <div class="form-group">
            <label for="numDays" class="required">Duration</label>
            <i class="fas fa-calendar-day input-icon"></i>
            <input type="number" id="numDays" name="num_days" min="1" max="30" required placeholder=" " />
            <span class="floating-label">Number of days</span>
            <div class="error-message">Please enter a valid duration (1-30 days)</div>
          </div>
        </div>

        <div class="form-group">
          <label for="travelDate" class="required">Travel Date</label>
          <i class="fas fa-calendar-alt input-icon"></i>
          <input type="date" id="travelDate" name="travel_date" required />
          <div class="error-message">Please select a valid date</div>
        </div>

        <div class="navigation-buttons">
          <button type="button" class="btn btn-secondary" disabled>
            <i class="fas fa-arrow-left"></i> Previous
          </button>
          <button type="button" class="btn btn-primary next-step">
            Next <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- Step 2: Personal Info -->
      <div class="form-section" data-step="2">
        <div class="form-group">
          <label for="name" class="required">Full Name</label>
          <i class="fas fa-user input-icon"></i>
          <input type="text" id="name" name="name" required placeholder=" " />
          <span class="floating-label">Your full name</span>
          <div class="error-message">Please enter your full name</div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="contact" class="required">Phone Number</label>
            <i class="fas fa-phone input-icon"></i>
            <input type="text" id="contact" name="contact" required placeholder=" " />
            <span class="floating-label">Phone number</span>
            <div class="error-message">Please enter a valid phone number</div>
          </div>
          <div class="form-group">
            <label for="email" class="required">Email</label>
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" required placeholder=" " />
            <span class="floating-label">Email address</span>
            <div class="error-message">Please enter a valid email</div>
          </div>
        </div>

        <div class="form-group">
          <label for="idNumber" class="required">ID/Passport Number</label>
          <i class="fas fa-id-card input-icon"></i>
          <input type="text" id="idNumber" name="id_number" required placeholder=" " />
          <span class="floating-label">ID or passport number</span>
          <div class="error-message">Please enter your ID/passport number</div>
        </div>

        <div class="navigation-buttons">
          <button type="button" class="btn btn-secondary prev-step">
            <i class="fas fa-arrow-left"></i> Previous
          </button>
          <button type="button" class="btn btn-primary next-step">
            Next <i class="fas fa-arrow-right"></i>
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
          <select id="paymentMethod" name="payment_method" required>
            <option value="" disabled selected>Select payment method</option>
            <option value="credit_card">Credit Card</option>
            <option value="mpesa">M-Pesa</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
          </select>
          <div class="error-message">Please select a payment method</div>
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
      </div>
    </form>
  </div>

  <footer>
    © <?php echo date("Y"); ?> OK AFRICA TOURS AND TRAVEL. All rights reserved.
  </footer>

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
      
      let currentStep = 1;

      // Initialize form
      updateFormDisplay();

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

      // Form submission handler
      document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (validateStep(currentStep)) {
          // Show loading spinner
          submitBtn.disabled = true;
          spinner.style.display = 'block';
          submitBtn.querySelector('span:not(.spinner)').style.display = 'none';
        } else {
          e.preventDefault();
        }
      });

      // Update form display based on current step
      function updateFormDisplay() {
        formSections.forEach(section => {
          section.classList.remove('active');
          if (parseInt(section.getAttribute('data-step')) === currentStep) {
            section.classList.add('active');
          }
        });

        steps.forEach(step => {
          step.classList.remove('active', 'completed');
          const stepNumber = parseInt(step.getAttribute('data-step'));
          
          if (stepNumber === currentStep) {
            step.classList.add('active');
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
          }
        });

        return isValid;
      }

      // Email validation
      function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
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
          <hr style="margin: 15px 0; border-color: #eee;">
          <p><strong>Name:</strong> ${formData.get('name')}</p>
          <p><strong>Contact:</strong> ${formData.get('contact')}</p>
          <p><strong>Email:</strong> ${formData.get('email')}</p>
          <p><strong>ID/Passport:</strong> ${formData.get('id_number')}</p>
        `;
        
        reviewContent.innerHTML = html;
      }

      // Format date for display
      function formatDate(dateString) {
        if (!dateString) return '';
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
      }
    });
  </script>

</body>
</html>