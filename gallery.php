<?php include 'get_background.php'; ?>
<?php
// Database connection
$host = 'localhost';
$dbname = 'oktours';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
 
// Fetch attractions from database
$stmt = $pdo->prepare("SELECT * FROM gallery_items ORDER BY created_at DESC");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert to JSON for JavaScript usage
$attractions_json = json_encode($attractions);

// get_background.php simulation for the demo
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>World Tourist Attractions Gallery</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #1abc9c;
      --secondary-color: #3498db;
      --dark-color: #2c3e50;
      --light-color: #ecf0f1;
      --overlay-color: rgba(0, 0, 0, 0.85);
      --transition: all 0.3s ease;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      background-image: url('<?php echo $background; ?>');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-attachment: fixed;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      color: var(--light-color);
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
      z-index: 1000;
      backdrop-filter: blur(5px);
    }

    nav a {
      color: #ecf0f1;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 8px 16px;
      border-radius: 6px;
      transition: var(--transition);
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      position: relative;
      overflow: hidden;
    }

    nav a:before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: 0.5s;
    }

    nav a:hover:before {
      left: 100%;
    }

    nav a:hover,
    nav a.active {
      background-color: var(--primary-color);
      color: #fff;
      box-shadow: 0 4px 14px rgba(26, 188, 156, 0.6);
      transform: translateY(-2px);
    }

    .search-container {
      display: flex;
      justify-content: center;
      margin: 20px auto;
      max-width: 500px;
      width: 90%;
    }

    .search-box {
      display: flex;
      width: 100%;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50px;
      padding: 8px 20px;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .search-box input {
      background: transparent;
      border: none;
      outline: none;
      width: 100%;
      padding: 8px 0;
      color: var(--light-color);
      font-size: 1rem;
    }

    .search-box input::placeholder {
      color: rgba(236, 240, 241, 0.7);
    }

    .search-box button {
      background: transparent;
      border: none;
      color: var(--light-color);
      cursor: pointer;
      transition: var(--transition);
    }

    .search-box button:hover {
      color: var(--primary-color);
    }

    .filter-buttons {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px;
      margin: 10px auto 30px;
      max-width: 800px;
      padding: 0 15px;
    }

    .filter-btn {
      background: rgba(255, 255, 255, 0.15);
      border: none;
      color: var(--light-color);
      padding: 8px 16px;
      border-radius: 50px;
      cursor: pointer;
      transition: var(--transition);
      backdrop-filter: blur(5px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .filter-btn:hover, .filter-btn.active {
      background-color: var(--primary-color);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(26, 188, 156, 0.4);
    }

    .container {
      max-width: 1200px;
      margin: 0 auto 50px;
      padding: 0 15px;
      flex-grow: 1;
    }

    h1 {
      font-weight: 700;
      font-size: 3rem;
      text-align: center;
      margin: 20px 0 30px;
      color: #ecf0f1;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.9);
      letter-spacing: 2px;
      position: relative;
      padding-bottom: 15px;
    }

    h1:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 30px;
    }

    .gallery-item {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
      transition: var(--transition);
      backdrop-filter: blur(5px);
      position: relative;
    }

    .gallery-item:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 18px 28px rgba(0, 0, 0, 0.7);
    }

    .gallery-item-header {
      padding: 20px 20px 10px;
    }

    .gallery-item h2 {
      margin-top: 0;
      color: #ecf0f1;
      font-weight: 600;
      font-size: 1.5rem;
      margin-bottom: 10px;
      letter-spacing: 0.5px;
    }

    .gallery-item .location {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9rem;
      color: rgba(236, 240, 241, 0.8);
      margin-bottom: 10px;
    }

    .gallery-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      display: block;
      transition: var(--transition);
      cursor: pointer;
    }

    .gallery-item:hover img {
      transform: scale(1.05);
    }

    .gallery-item-content {
      padding: 15px 20px 20px;
    }

    .gallery-item p {
      margin-bottom: 15px;
      line-height: 1.5;
      font-size: 0.95rem;
    }

    .gallery-item .read-more {
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: var(--transition);
    }

    .gallery-item .read-more:hover {
      gap: 8px;
    }

    .actions {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 15px;
    }

    .action-btn {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: var(--light-color);
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9rem;
    }

    .action-btn:hover {
      background: var(--primary-color);
      transform: translateY(-2px);
    }

    .video-container {
      position: relative;
      width: 100%;
      padding-top: 56.25%;
      overflow: hidden;
      border-radius: 0 0 12px 12px;
      margin-top: 15px;
    }

    .video-container video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      border: none;
    }

    .lightbox {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: var(--overlay-color);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .lightbox.show {
      opacity: 1;
      visibility: visible;
    }

    .lightbox-content {
      position: relative;
      max-width: 90%;
      max-height: 90%;
    }

    .lightbox-content img {
      max-width: 100%;
      max-height: 80vh;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .close-lightbox {
      position: absolute;
      top: -40px;
      right: 0;
      background: var(--primary-color);
      color: white;
      border: none;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      font-size: 1.2rem;
      transition: var(--transition);
    }

    .close-lightbox:hover {
      transform: rotate(90deg);
    }

    .to-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: var(--primary-color);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      z-index: 999;
    }

    .to-top.show {
      opacity: 1;
      visibility: visible;
    }

    .to-top:hover {
      transform: translateY(-5px);
    }

    footer {
      background: rgba(0, 0, 0, 0.65);
      color: #ecf0f1;
      text-align: center;
      padding: 20px;
      font-size: 1rem;
      letter-spacing: 1px;
      box-shadow: 0 -4px 10px rgba(0,0,0,0.5);
      backdrop-filter: blur(5px);
    }

    .loading {
      text-align: center;
      padding: 30px;
      font-size: 1.2rem;
      color: var(--light-color);
    }

    .no-results {
      text-align: center;
      padding: 40px;
      grid-column: 1 / -1;
      font-size: 1.2rem;
      color: var(--light-color);
    }

    @media (max-width: 768px) {
      nav {
        flex-wrap: wrap;
        gap: 10px;
      }
      
      h1 {
        font-size: 2.5rem;
      }
      
      .gallery-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 2rem;
      }
      
      .filter-buttons {
        gap: 5px;
      }
      
      .filter-btn {
        padding: 6px 12px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <nav>
    <a href="home-screen.html">Home</a>
    <a href="gallery.php" class="active">Gallery</a>
    <a href="booking.php">Booking</a>
    <a href="videos.php">Videos</a>
    <a href="enquiry.php">Enquiry</a>
  </nav>
  
  <div class="search-container">
    <div class="search-box">
      <input type="text" id="search-input" placeholder="Search attractions..." />
      <button id="search-btn"><i class="fas fa-search"></i></button>
    </div>
  </div>
  
  <div class="filter-buttons">
    <button class="filter-btn active" data-filter="all">All</button>
    <button class="filter-btn" data-filter="europe">Europe</button>
    <button class="filter-btn" data-filter="asia">Asia</button>
    <button class="filter-btn" data-filter="americas">Americas</button>
    <button class="filter-btn" data-filter="oceania">Oceania</button>
  </div>

  <div class="container">
    <h1>World Tourist Attractions</h1>
    
    <div class="gallery-grid" id="gallery-container">
      <div class="loading">Loading attractions...</div>
    </div>
  </div>
  
  <div class="lightbox" id="lightbox">
    <div class="lightbox-content">
      <img id="lightbox-img" src="" alt="">
      <button class="close-lightbox">&times;</button>
    </div>
  </div>
  
  <div class="to-top" id="to-top">
    <i class="fas fa-arrow-up"></i>
  </div>

  <footer>
    &copy; 2025 World Tourist Attractions Gallery. All rights reserved.
  </footer>

  <script>
    // Pass PHP data to JavaScript
    const attractionsFromDB = <?php echo $attractions_json; ?>;
    
    // DOM elements
    const galleryContainer = document.getElementById('gallery-container');
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const closeLightbox = document.querySelector('.close-lightbox');
    const toTopBtn = document.getElementById('to-top');

    // Display attractions
    function displayAttractions(attractionsArray) {
      galleryContainer.innerHTML = '';
      
      if (attractionsArray.length === 0) {
        galleryContainer.innerHTML = '<div class="no-results">No attractions found matching your criteria</div>';
        return;
      }
      
      attractionsArray.forEach(attraction => {
        const attractionEl = document.createElement('div');
        attractionEl.classList.add('gallery-item');
        attractionEl.setAttribute('data-category', attraction.continent || 'all');
        
        attractionEl.innerHTML = `
          <div class="gallery-item-header">
            <h2>${attraction.title}</h2>
            <div class="location">
              <i class="fas fa-map-marker-alt"></i>
              <span>${attraction.location || 'Worldwide'}</span>
            </div>
          </div>
          <img src="${attraction.image_path}" alt="${attraction.title}" />
          <div class="gallery-item-content">
            <p>${attraction.description}</p>
            <a href="#" class="read-more">Read more <i class="fas fa-arrow-right"></i></a>
            <div class="actions">
              <button class="action-btn view-image" data-image="${attraction.image_path}">
                <i class="fas fa-expand"></i> View Image
              </button>
              ${attraction.video_path ? `
                <button class="action-btn view-video" data-video="${attraction.video_path}">
                  <i class="fas fa-play-circle"></i> Watch Video
                </button>
              ` : ''}
            </div>
          </div>
          ${attraction.video_path ? `
            <div class="video-container" style="display: none;">
              <video controls>
                <source src="${attraction.video_path}" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          ` : ''}
        `;
        
        galleryContainer.appendChild(attractionEl);
      });
      
      // Add event listeners to view buttons
      document.querySelectorAll('.view-image').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const imageUrl = btn.getAttribute('data-image');
          openLightbox(imageUrl);
        });
      });
      
      document.querySelectorAll('.view-video').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.preventDefault();
          const videoContainer = btn.closest('.gallery-item').querySelector('.video-container');
          videoContainer.style.display = videoContainer.style.display === 'none' ? 'block' : 'none';
        });
      });
    }

    // Open lightbox
    function openLightbox(imageUrl) {
      lightboxImg.src = imageUrl;
      lightbox.classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    // Close lightbox
    function closeLightboxHandler() {
      lightbox.classList.remove('show');
      document.body.style.overflow = 'auto';
    }

    // Filter attractions
    function filterAttractions() {
      const searchValue = searchInput.value.toLowerCase();
      const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');
      
      const filteredAttractions = attractionsFromDB.filter(attraction => {
        const matchesSearch = attraction.title.toLowerCase().includes(searchValue) || 
                             (attraction.location && attraction.location.toLowerCase().includes(searchValue)) ||
                             (attraction.description && attraction.description.toLowerCase().includes(searchValue));
        const matchesFilter = activeFilter === 'all' || attraction.continent === activeFilter;
        
        return matchesSearch && matchesFilter;
      });
      
      displayAttractions(filteredAttractions);
    }

    // Show/hide scroll to top button
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        toTopBtn.classList.add('show');
      } else {
        toTopBtn.classList.remove('show');
      }
    });

    // Scroll to top
    toTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Event listeners
    searchInput.addEventListener('input', filterAttractions);
    searchBtn.addEventListener('click', filterAttractions);
    
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelector('.filter-btn.active').classList.remove('active');
        btn.classList.add('active');
        filterAttractions();
      });
    });
    
    closeLightbox.addEventListener('click', closeLightboxHandler);
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        closeLightboxHandler();
      }
    });

    // Initialize
    displayAttractions(attractionsFromDB);
  </script>
</body>
</html>