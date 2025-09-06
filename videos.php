<?php include 'get_background.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tourism Attraction Videos</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Great+Vibes&display=swap" rel="stylesheet" />
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    :root {
      --primary-color: #3cb371;
      --primary-dark: #2e8b57;
      --accent-color: #ff7e5f;
      --text-color: #fff;
      --card-bg: rgba(0, 0, 0, 0.75);
      --nav-bg: rgba(0, 0, 0, 0.85);
      --glow-color-1: #6ad7a7;
      --glow-color-2: #4aa46f;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: 
        linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
        url('<?php echo $background; ?>') no-repeat center center fixed;
      background-size: cover;
      color: var(--text-color);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }
    
    /* Animated background elements */
    .bg-elements {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }
    
    .bg-element {
      position: absolute;
      border-radius: 50%;
      opacity: 0.1;
      animation: float 15s infinite linear;
    }
    
    @keyframes float {
      0% {
        transform: translateY(0) rotate(0deg);
      }
      100% {
        transform: translateY(-100vh) rotate(360deg);
      }
    }
    
    nav {
      background-color: var(--nav-bg);
      padding: 15px 25px;
      display: flex;
      justify-content: center;
      gap: 30px;
      box-shadow: 0 4px 14px rgba(0,0,0,0.75);
      width: 100%;
      max-width: 1200px;
      position: sticky;
      top: 0;
      z-index: 100;
      margin-bottom: 30px;
      border-radius: 12px;
      backdrop-filter: blur(10px);
    }
    
    nav a {
      color: var(--text-color);
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 8px 18px;
      border-radius: 7px;
      transition: all 0.3s ease;
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    nav a:hover,
    nav a.active {
      background-color: var(--primary-color);
      color: #fff;
    }
    
    nav a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--accent-color);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }
    
    nav a:hover::after {
      width: 70%;
    }
    
    h1 {
      font-family: 'Great Vibes', cursive;
      font-size: 5rem;
      font-weight: 700;
      margin-bottom: 45px;
      letter-spacing: 4px;
      text-align: center;
      user-select: none;
      cursor: default;
      text-shadow:
        0 0 8px var(--glow-color-1),
        0 0 20px var(--glow-color-1),
        0 0 30px var(--glow-color-2);
      transition: text-shadow 1s ease;
      position: relative;
    }
    
    h1::after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 3px;
      background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
    }
    
    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      max-width: 1400px;
      width: 100%;
      justify-content: center;
    }
    
    .main-content {
      flex: 1;
      min-width: 300px;
      max-width: 900px;
    }
    
    .video-card {
      width: 100%;
      background: var(--card-bg);
      border-radius: 18px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.85);
      overflow: hidden;
      margin-bottom: 20px;
      text-align: center;
      padding-bottom: 15px;
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .video-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.9);
    }
    
    .video-title {
      margin: 0;
      padding: 20px 10px 15px;
      font-size: 2rem;
      font-weight: 600;
      color: var(--primary-color);
      text-shadow: 1px 1px 8px rgba(0,0,0,0.9);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    
    .video-info {
      padding: 0 20px 15px;
      text-align: left;
      color: #ddd;
      font-size: 0.9rem;
      line-height: 1.5;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 15px;
    }
    
    .video-player-container {
      position: relative;
    }
    
    video {
      width: 100%;
      max-height: 480px;
      border-radius: 0 0 18px 18px;
      box-shadow: inset 0 0 10px rgba(0,0,0,0.7);
      background-color: black;
      outline: none;
    }
    
    .custom-controls {
      position: absolute;
      bottom: 10px;
      left: 10px;
      right: 10px;
      background: rgba(0, 0, 0, 0.7);
      border-radius: 8px;
      padding: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .video-player-container:hover .custom-controls {
      opacity: 1;
    }
    
    .custom-controls button {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 1.2rem;
    }
    
    .progress-bar {
      flex: 1;
      height: 5px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
      overflow: hidden;
      cursor: pointer;
    }
    
    .progress {
      height: 100%;
      background: var(--primary-color);
      width: 0%;
    }
    
    .volume-control {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .volume-control input {
      width: 60px;
    }
    
    .playlist-sidebar {
      flex: 0 0 300px;
      background: var(--card-bg);
      border-radius: 18px;
      padding: 20px;
      backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      max-height: 600px;
      overflow-y: auto;
    }
    
    .playlist-sidebar h3 {
      margin-bottom: 15px;
      padding-bottom: 10px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--primary-color);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .playlist-item {
      display: flex;
      gap: 10px;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    
    .playlist-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }
    
    .playlist-item.active {
      background: rgba(60, 179, 113, 0.2);
    }
    
    .playlist-item-thumb {
      width: 60px;
      height: 40px;
      border-radius: 4px;
      overflow: hidden;
      position: relative;
    }
    
    .playlist-item-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .playlist-item-thumb::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
    }
    
    .playlist-item-info {
      flex: 1;
    }
    
    .playlist-item-title {
      font-size: 0.9rem;
      font-weight: 600;
    }
    
    .playlist-item-duration {
      font-size: 0.7rem;
      color: #aaa;
    }
    
    .nav-buttons {
      display: flex;
      justify-content: center;
      gap: 25px;
      margin-top: 10px;
    }
    
    .nav-buttons button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 12px 28px;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 5px 18px rgba(60, 179, 113, 0.67);
      transition: all 0.3s ease;
      user-select: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .nav-buttons button:hover:not(:disabled) {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(60, 179, 113, 0.8);
    }
    
    .nav-buttons button:disabled {
      background-color: #555;
      cursor: not-allowed;
      box-shadow: none;
      transform: none;
    }
    
    .video-stats {
      display: flex;
      justify-content: space-around;
      padding: 15px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: 15px;
    }
    
    .stat {
      text-align: center;
    }
    
    .stat-number {
      font-size: 1.5rem;
      font-weight: bold;
      color: var(--primary-color);
    }
    
    .stat-label {
      font-size: 0.8rem;
      color: #aaa;
    }
     footer { 
      background: var(--nav-bg);
      color: #f0f0f0;
      text-align: center;
      padding: 15px 20px;
      font-size: 1rem;
      letter-spacing: 1px;
      box-shadow: 0 -4px 12px rgba(0,0,0,0.7);
      width: 100%;
      max-width: 1200px;
      margin: auto; /* centers horizontally and pushes to bottom if inside a flex container */
      border-radius: 12px;
      backdrop-filter: blur(10px);
      display: flex;
      flex-direction: column;
      gap: 10px; /* choose the gap you want */
      position: relative;
      bottom: 0;}
    footer div {
      margin: 0;
    } 
    
    .social-links {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 10px;
    }
    
    .social-links a {
      color: #fff;
      font-size: 1.5rem;
      transition: color 0.3s ease;
    }
    
    .social-links a:hover {
      color: var(--primary-color);
    }
    
    /* Loading animation */
    .loader {
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50px;
      height: 50px;
      border: 5px solid rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      border-top: 5px solid var(--primary-color);
      animation: spin 1s linear infinite;
      z-index: 10;
    }
    
    @keyframes spin {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      
      .playlist-sidebar {
        flex: 1;
        width: 100%;
      }
      
      nav {
        flex-wrap: wrap;
        gap: 10px;
      }
      
      h1 {
        font-size: 3.5rem;
      }
      
      .video-title {
        font-size: 1.5rem;
      }
    }
    
    @media (min-width: 768px) {
      h1 {
        font-size: 6rem;
      }
      
      .video-title {
        font-size: 2.4rem;
      }
      
      .nav-buttons button {
        padding: 14px 38px;
        font-size: 1.3rem;
      }
    }
  </style>
</head>
<body>
  <!-- Animated background elements -->
  <div class="bg-elements" id="bgElements"></div>
  
  <nav>
    <a href="home-screen.html"><i class="fas fa-home"></i> Home</a>
    <a href="gallery.php"><i class="fas fa-image"></i> Gallery</a>
    <a href="booking.php"><i class="fas fa-ticket-alt"></i> Booking</a>
    <a href="videos.html" class="active"><i class="fas fa-play-circle"></i> Videos</a>
    <a href="enquiry.php"><i class="fas fa-question-circle"></i> Enquiry</a>
  </nav>

  <h1 id="glowTitle">World Tourism Highlights</h1>

  <div class="container">
    <div class="main-content">
      <div class="video-card">
        <h2 class="video-title"><i class="fas fa-play"></i> <span id="videoTitle">Loading...</span></h2>
        
        <div class="video-info">
          <div id="videoDescription">Experience the beauty of world's most amazing destinations</div>
        </div>
        
        <div class="video-player-container">
          <div class="loader" id="loader"></div>
          <video id="videoPlayer" controls preload="metadata" playsinline>
            <source id="videoSource" src="" type="video/mp4" />
            Your browser does not support the video tag.
          </video>
          
          <div class="custom-controls">
            <button id="playPauseBtn"><i class="fas fa-play"></i></button>
            <div class="progress-bar" id="progressBar">
              <div class="progress" id="progress"></div>
            </div>
            <div class="volume-control">
              <button id="muteBtn"><i class="fas fa-volume-up"></i></button>
              <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="1">
            </div>
          </div>
        </div>
        
        <div class="video-stats">
          <div class="stat">
            <div class="stat-number" id="viewCount">0</div>
            <div class="stat-label">Views</div>
          </div>
          <div class="stat">
            <div class="stat-number" id="likeCount">0</div>
            <div class="stat-label">Likes</div>
          </div>
          <div class="stat">
            <div class="stat-number"><i class="fas fa-share-alt"></i></div>
            <div class="stat-label">Share</div>
          </div>
        </div>
      </div>

      <div class="nav-buttons">
        <button id="prevBtn" disabled><i class="fas fa-arrow-left"></i> Previous</button>
        <button id="nextBtn">Next <i class="fas fa-arrow-right"></i></button>
      </div>
    </div>
    
    <div class="playlist-sidebar">
      <h3><i class="fas fa-list"></i> Video Playlist</h3>
      <div id="playlistContainer"></div>
    </div>
  </div>

  <footer>
    <div>&copy; 2025 World Tourism Highlights. All rights reserved.</div>
    <div class="social-links">
      <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.tiktok.com/@okafrica.travel"><i class="fab fa-tiktok"></i></a>
      <a href="https://www.instagram.com/okafrica.travel"><i class="fab fa-instagram"></i></a>
      <a href="https://www.youtube.com/@okafrica.travel"><i class="fab fa-youtube"></i></a>
    </div>
  </footer>

  <script>
    // Enhanced videos data with more information
    const videos = [
      {
        title: "Kenya deep diving Indian Safari",
        src: "images/videos/indianocean.mp4",
        thumb: "https://www.dresseldivers.com/wp-content/uploads/Deep-water-diving-buceo-profundo-5.jpg",
        duration: "2:45",
        description: "Explore the magnificent underwater world of the Indian Ocean off the coast of Kenya.",
        views: 1245,
        likes: 342
      },
      {
        title: "Eiffel Tower - Paris",
        src: "images/videos/eiffel.mp4",
        thumb: "https://s3.us-west-2.amazonaws.com/images.unsplash.com/small/photo-1732046495089-e9637e960e3f",
        duration: "1:52",
        description: "The iconic Eiffel Tower stands tall in the heart of Paris, France.",
        views: 3856,
        likes: 1024
      },
      {
        title: "Niagara Falls - Canada/USA",
        src: "images/videos/fall.mp4",
        thumb: "https://images.unsplash.com/photo-1515586838455-8f8f940d6853?auto=format&fit=crop&w=200&q=80",
        duration: "3:15",
        description: "Witness the breathtaking power and beauty of Niagara Falls.",
        views: 2897,
        likes: 876
      },
      {
        title: "Grand Canyon - USA",
        src: "images/videos/grandcanyon.mp4",
        thumb: "https://images.unsplash.com/photo-1509316785289-025f5b846b35?auto=format&fit=crop&w=200&q=80",
        duration: "4:20",
        description: "The majestic Grand Canyon offers stunning views and hiking adventures.",
        views: 3124,
        likes: 945
      },
      {
        title: "Wild Beast Kenya-Tanzania Migration",
        src: "images/videos/bufallo.mp4",
        thumb: "https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=200&q=80",
        duration: "3:50",
        description: "Experience the great wildebeest migration across the Serengeti.",
        views: 1987,
        likes: 632
      },
      {
        title: "King of the Jungle - Lions",
        src: "images/videos/lions.mp4",
        thumb: "https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=200&q=80",
        duration: "2:18",
        description: "Get up close with the majestic lions in their natural habitat.",
        views: 2453,
        likes: 789
      },
      {
        title: "Great Wall of China",
        src: "images/videos/greatwall.mp4",
        thumb: "https://images.unsplash.com/photo-1539987225288-7d998989461e?fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000",
        duration: "3:32",
        description: "Walk along the historic Great Wall of China, a marvel of ancient engineering.",
        views: 4215,
        likes: 1256
      },
      {
        title: "Sydney Opera House - Australia",
        src: "images/videos/sydney.mp4",
        thumb: "https://images.unsplash.com/photo-1528072164453-f4e8ef0d475a?auto=format&fit=crop&w=200&q=80",
        duration: "2:05",
        description: "The architectural masterpiece on Sydney Harbour is a sight to behold.",
        views: 3321,
        likes: 987
      },
      {
        title: "Taj Mahal - India",
        src: "images/videos/tajmahal.mp4",
        thumb: "https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&w=200&q=80",
        duration: "2:55",
        description: "The magnificent Taj Mahal stands as a symbol of eternal love.",
        views: 3765,
        likes: 1124
      }
    ];

    // DOM elements
    const videoPlayer = document.getElementById('videoPlayer');
    const videoSource = document.getElementById('videoSource');
    const videoTitle = document.getElementById('videoTitle');
    const videoDescription = document.getElementById('videoDescription');
    const viewCount = document.getElementById('viewCount');
    const likeCount = document.getElementById('likeCount');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const playlistContainer = document.getElementById('playlistContainer');
    const loader = document.getElementById('loader');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const progressBar = document.getElementById('progressBar');
    const progress = document.getElementById('progress');
    const muteBtn = document.getElementById('muteBtn');
    const volumeSlider = document.getElementById('volumeSlider');
    
    let currentIndex = 0;
    let isPlaying = false;

    // Initialize the page
    function init() {
      loadVideo(currentIndex);
      generatePlaylist();
      createBackgroundElements();
      setupCustomControls();
    }

    // Load video function
    function loadVideo(index) {
      const video = videos[index];
      loader.style.display = 'block';
      
      videoTitle.textContent = video.title;
      videoDescription.textContent = video.description;
      viewCount.textContent = formatNumber(video.views);
      likeCount.textContent = formatNumber(video.likes);
      
      videoSource.src = video.src;
      videoPlayer.load();
      
      // Update active state in playlist
      const playlistItems = document.querySelectorAll('.playlist-item');
      playlistItems.forEach((item, i) => {
        if (i === index) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      });
      
      // Update navigation buttons
      prevBtn.disabled = index === 0;
      nextBtn.disabled = index === videos.length - 1;
      
      // Play the video when it's ready
      videoPlayer.onloadeddata = function() {
        loader.style.display = 'none';
        videoPlayer.play().then(() => {
          isPlaying = true;
          playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        }).catch(() => {
          // Autoplay was prevented, handle it here
          isPlaying = false;
          playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        });
      };
      
      // Increment view count (simulated)
      videos[index].views++;
    }

    // Generate playlist items
    function generatePlaylist() {
      playlistContainer.innerHTML = '';
      
      videos.forEach((video, index) => {
        const item = document.createElement('div');
        item.className = 'playlist-item';
        if (index === currentIndex) item.classList.add('active');
        
        item.innerHTML = `
          <div class="playlist-item-thumb">
            <img src="${video.thumb}" alt="${video.title}">
          </div>
          <div class="playlist-item-info">
            <div class="playlist-item-title">${video.title}</div>
            <div class="playlist-item-duration">${video.duration}</div>
          </div>
        `;
        
        item.addEventListener('click', () => {
          currentIndex = index;
          loadVideo(currentIndex);
        });
        
        playlistContainer.appendChild(item);
      });
    }

    // Setup custom video controls
    function setupCustomControls() {
      // Play/Pause button
      playPauseBtn.addEventListener('click', togglePlayPause);
      
      // Video player play/pause event
      videoPlayer.addEventListener('play', () => {
        isPlaying = true;
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
      });
      
      videoPlayer.addEventListener('pause', () => {
        isPlaying = false;
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
      });
      
      // Progress bar
      videoPlayer.addEventListener('timeupdate', updateProgress);
      
      progressBar.addEventListener('click', (e) => {
        const pos = (e.pageX - progressBar.getBoundingClientRect().left) / progressBar.offsetWidth;
        videoPlayer.currentTime = pos * videoPlayer.duration;
      });
      
      // Volume controls
      muteBtn.addEventListener('click', toggleMute);
      
      volumeSlider.addEventListener('input', () => {
        videoPlayer.volume = volumeSlider.value;
        muteBtn.innerHTML = videoPlayer.volume == 0 ? 
          '<i class="fas fa-volume-mute"></i>' : 
          '<i class="fas fa-volume-up"></i>';
      });
    }

    // Toggle play/pause
    function togglePlayPause() {
      if (isPlaying) {
        videoPlayer.pause();
      } else {
        videoPlayer.play();
      }
    }

    // Update progress bar
    function updateProgress() {
      const value = (videoPlayer.currentTime / videoPlayer.duration) * 100;
      progress.style.width = value + '%';
    }

    // Toggle mute
    function toggleMute() {
      videoPlayer.muted = !videoPlayer.muted;
      muteBtn.innerHTML = videoPlayer.muted ? 
        '<i class="fas fa-volume-mute"></i>' : 
        '<i class="fas fa-volume-up"></i>';
    }

    // Format large numbers
    function formatNumber(num) {
      if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
      } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
      }
      return num;
    }

    // Create animated background elements
    function createBackgroundElements() {
      const colors = ['#3cb371', '#ff7e5f', '#3498db', '#9b59b6', '#f1c40f'];
      
      for (let i = 0; i < 15; i++) {
        const element = document.createElement('div');
        element.className = 'bg-element';
        
        // Random properties
        const size = Math.random() * 100 + 50;
        const color = colors[Math.floor(Math.random() * colors.length)];
        
        element.style.width = size + 'px';
        element.style.height = size + 'px';
        element.style.background = color;
        element.style.left = Math.random() * 100 + 'vw';
        element.style.animationDuration = (Math.random() * 20 + 10) + 's';
        element.style.animationDelay = (Math.random() * 5) + 's';
        
        document.getElementById('bgElements').appendChild(element);
      }
    }

    // Navigation buttons
    prevBtn.addEventListener('click', () => {
      if (currentIndex > 0) {
        currentIndex--;
        loadVideo(currentIndex);
      }
    });

    nextBtn.addEventListener('click', () => {
      if (currentIndex < videos.length - 1) {
        currentIndex++;
        loadVideo(currentIndex);
      }
    });

    // Title glow colors cycling
    const title = document.getElementById('glowTitle');
    const colors = [
      '0 0 8px #6ad7a7, 0 0 20px #6ad7a7, 0 0 30px #4aa46f',
      '0 0 8px #f39c12, 0 0 20px #f39c12, 0 0 30px #d35400',
      '0 0 8px #3498db, 0 0 20px #3498db, 0 0 30px #2980b9',
      '0 0 8px #9b59b6, 0 0 20px #9b59b6, 0 0 30px #8e44ad',
      '0 0 8px #e74c3c, 0 0 20px #e74c3c, 0 0 30px #c0392b'
    ];
    let colorIndex = 0;

    setInterval(() => {
      colorIndex = (colorIndex + 1) % colors.length;
      title.style.textShadow = colors[colorIndex];
    }, 3000);

    // Initialize the page
    window.onload = init;
  </script>
</body>
</html>