
<?php include 'get_background.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>World Tourist Attractions Gallery</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
  body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }

    nav {
      background-color: rgba(0, 0, 0, 0.65);
      padding: 14px 20px;
      display: flex;
      justify-content: center;
      gap: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.6);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    nav a {
      color: #ecf0f1;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 8px 16px;
      border-radius: 6px;
      transition: background-color 0.3s ease, color 0.3s ease;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    nav a:hover,
    nav a.active {
      background-color: #1abc9c;
      color: #fff;
      box-shadow: 0 4px 14px #1abc9caa;
    }

    .container {
      max-width: 960px;
      margin: 30px auto 50px;
      padding: 0 15px;
      flex-grow: 1;
    }

    h1 {
      font-weight: 700;
      font-size: 3rem;
      text-align: center;
      margin-bottom: 50px;
      color: #ecf0f1;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.9);
      letter-spacing: 2px;
    }

    .gallery-item {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      margin-bottom: 50px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
      padding: 25px;
      transition: transform 0.3s ease;
    }

    .gallery-item:hover {
      transform: translateY(-8px);
      box-shadow: 0 18px 28px rgba(0, 0, 0, 0.7);
    }

    .gallery-item h2 {
      margin-top: 0;
      color: #ecf0f1;
      font-weight: 600;
      font-size: 1.8rem;
      margin-bottom: 15px;
      letter-spacing: 0.5px;
    }

    .gallery-item img {
      max-width: 100%;
      border-radius: 12px;
      display: block;
      margin: 0 auto;
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.4);
      transition: box-shadow 0.3s ease;
    }

    .gallery-item img:hover {
      box-shadow: 0 10px 22px rgba(0, 0, 0, 0.7);
    }

    .video-container {
  position: relative;
  width: 100%;
  padding-top: 56.25%; /* 16:9 Aspect Ratio (9/16 = 0.5625) */
  overflow: hidden;
  border-radius: 16px;
  margin-top: 20px;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.4);
  transition: box-shadow 0.3s ease;
}

.video-container video {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border: none;
  border-radius: 16px;
}


    .video-container:hover {
      box-shadow: 0 10px 26px rgba(0, 0, 0, 0.7);
    }

    .video-container iframe {
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 16px;
    }

    footer {
      background: rgba(0, 0, 0, 0.65);
      color: #ecf0f1;
      text-align: center;
      padding: 14px 20px;
      font-size: 1rem;
      letter-spacing: 1px;
      box-shadow: 0 -4px 10px rgba(0,0,0,0.5);
    }

    @media (min-width: 768px) {
      .gallery-item {
        padding: 35px;
      }
      .gallery-item h2 {
        font-size: 2.2rem;
      }
      h1 {
        font-size: 3.8rem;
      }
    }
  </style>
</head>
<body>
  <nav>
    <a href="home-screen.html">Home</a>
    <a href="gallery.php" class="active">Gallery</a>
    <a href="booking.php">Booking</a>
    <a href="videos.html">Videos</a>
    <a href="enquiry.php">Enquiry</a>
  </nav>
  <div class="container">
    <h1>World Tourist Attractions Gallery</h1>
  
    <div class="gallery-item">
      <h2>Eiffel Tower, Paris</h2>
      <img src="images/eiffel.jpeg" alt="Eiffel Tower" />
      <div class="video-container">
        <video controls>
          <source src="images/videos/eiffel.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  
    <div class="gallery-item">
      <h2>Great Wall of China</h2>
      <img src="images/greatwall.jpeg" alt="Great Wall of China" />
      <div class="video-container">
        <video controls>
          <source src="images/videos/greatwall.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  
    <div class="gallery-item">
      <h2>Grand Canyon, USA</h2>
      <img src="images/grandcanyon.jpeg" alt="Grand Canyon" />
      <div class="video-container">
        <video controls>
          <source src="images/videos/grandcanyon.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  
    <div class="gallery-item">
      <h2>Taj Mahal, India</h2>
      <img src="images/tajmahal.jpeg" alt="Taj Mahal" />
      <div class="video-container">
        <video controls>
          <source src="images/videos/tajmahal.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  
    <div class="gallery-item">
      <h2>Sydney Opera House, Australia</h2>
      <img src="images/sydney.jpeg" alt="Sydney Opera House" />
      <div class="video-container">
        <video controls>
          <source src="images/videos/sydney.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  </div>
  

  <footer>
    &copy; 2025 World Tourist Attractions Gallery. All rights reserved.
  </footer>
</body>
</html>
