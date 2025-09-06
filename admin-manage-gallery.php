<?php
session_start();

// Initialize session data if not set
if (!isset($_SESSION['gallery_items'])) {
    $_SESSION['gallery_items'] = [
        [
            'id' => 1,
            'title' => 'Sydney Opera House',
            'description' => 'Iconic architectural masterpiece in Australia',
            'image_path' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            'video_path' => '',
            'created_at' => '2023-10-15'
        ],
        [
            'id' => 2,
            'title' => 'Eiffel Tower',
            'description' => 'Famous iron tower in Paris, France',
            'image_path' => 'https://images.unsplash.com/photo-1534008897995-27a23e859048?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            'video_path' => '',
            'created_at' => '2023-10-10'
        ],
        [
            'id' => 3,
            'title' => 'Taj Mahal',
            'description' => 'Beautiful mausoleum in India',
            'image_path' => 'https://images.unsplash.com/photo-1564507592333-c60657eea523?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            'video_path' => '',
            'created_at' => '2023-10-05'
        ],
        [
            'id' => 4,
            'title' => 'Grand Canyon',
            'description' => 'Breathtaking canyon in Arizona, USA',
            'image_path' => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80',
            'video_path' => '',
            'created_at' => '2023-10-01'
        ]
    ];
    
    $_SESSION['activities'] = [
        [
            'type' => 'add',
            'title' => 'New Gallery Item Added',
            'description' => 'Sydney Opera House was added to the gallery',
            'time' => '2 hours ago'
        ],
        [
            'type' => 'user',
            'title' => 'User Registration',
            'description' => 'New user "john_doe" registered',
            'time' => '5 hours ago'
        ],
        [
            'type' => 'comment',
            'title' => 'New Comment',
            'description' => 'User left a comment on "Eiffel Tower"',
            'time' => 'Yesterday'
        ]
    ];
}

// PHP Backend Functions
function getGalleryItems() {
    return $_SESSION['gallery_items'] ?? [];
}

function getRecentItems() {
    $items = getGalleryItems();
    $recentItems = [];
    $oneWeekAgo = date('Y-m-d', strtotime('-7 days'));
    
    foreach ($items as $item) {
        if ($item['created_at'] >= $oneWeekAgo) {
            $recentItems[] = $item;
        }
    }
    
    return $recentItems;
}

function getRecentActivities() {
    return $_SESSION['activities'] ?? [];
}

function addActivity($type, $title, $description) {
    $timeText = 'Just now';
    
    $activity = [
        'type' => $type,
        'title' => $title,
        'description' => $description,
        'time' => $timeText
    ];
    
    array_unshift($_SESSION['activities'], $activity);
    
    // Keep only the 10 most recent activities
    if (count($_SESSION['activities']) > 10) {
        array_pop($_SESSION['activities']);
    }
}

function addGalleryItem($title, $description, $imagePath, $videoPath = '') {
    $newItem = [
        'id' => count($_SESSION['gallery_items']) + 1,
        'title' => htmlspecialchars($title),
        'description' => htmlspecialchars($description),
        'image_path' => $imagePath,
        'video_path' => $videoPath,
        'created_at' => date('Y-m-d')
    ];
    
    array_unshift($_SESSION['gallery_items'], $newItem);
    
    addActivity('add', 'New Gallery Item Added', $title . ' was added to the gallery');
    
    return $newItem;
}

function updateGalleryItem($id, $title, $description, $imagePath = null) {
    foreach ($_SESSION['gallery_items'] as &$item) {
        if ($item['id'] == $id) {
            $item['title'] = htmlspecialchars($title);
            $item['description'] = htmlspecialchars($description);
            
            if ($imagePath) {
                $item['image_path'] = $imagePath;
            }
            
            addActivity('edit', 'Gallery Item Updated', $title . ' was updated');
            
            return $item;
        }
    }
    
    return false;
}

function deleteGalleryItem($id) {
    foreach ($_SESSION['gallery_items'] as $key => $item) {
        if ($item['id'] == $id) {
            $title = $item['title'];
            unset($_SESSION['gallery_items'][$key]);
            $_SESSION['gallery_items'] = array_values($_SESSION['gallery_items']);
            
            addActivity('delete', 'Gallery Item Deleted', $title . ' was deleted from the gallery');
            
            return true;
        }
    }
    
    return false;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $response = ['status' => 'error', 'message' => 'Unknown action'];
    
    if ($action === 'add') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Handle file uploads (simplified for demo)
        $imagePath = 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80';
        $videoPath = '';
        
        if (!empty($title) && !empty($description)) {
            addGalleryItem($title, $description, $imagePath, $videoPath);
            $response = ['status' => 'success', 'message' => 'Item added successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Title and description are required'];
        }
    }
    elseif ($action === 'edit') {
        $id = $_POST['id'] ?? '';
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        
        if (!empty($id) && !empty($title) && !empty($description)) {
            updateGalleryItem($id, $title, $description);
            $response = ['status' => 'success', 'message' => 'Item updated successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'All fields are required'];
        }
    }
    elseif ($action === 'delete') {
        $id = $_POST['id'] ?? '';
        
        if (!empty($id)) {
            if (deleteGalleryItem($id)) {
                $response = ['status' => 'success', 'message' => 'Item deleted successfully'];
            } else {
                $response = ['status' => 'error', 'message' => 'Item not found'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Item ID is required'];
        }
    }
    
    // If it's an AJAX request, return JSON response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    // For regular form submissions, redirect to avoid form resubmission
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Gallery Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #6c5ce7;
      --secondary-color: #a29bfe;
      --dark-color: #2d3436;
      --light-color: #f5f6fa;
      --success-color: #00b894;
      --warning-color: #fdcb6e;
      --danger-color: #d63031;
      --card-bg: rgba(255, 255, 255, 0.15);
      --transition: all 0.3s ease;
      --nav-height: 70px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
      color: var(--light-color);
      min-height: 100vh;
      overflow-x: hidden;
      padding-top: var(--nav-height);
    }

    .particles-container {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(108, 92, 231, 0.3);
      box-shadow: 0 0 20px rgba(108, 92, 231, 0.5);
      animation: float 15s infinite ease-in-out;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) translateX(0);
      }
      25% {
        transform: translateY(-20px) translateX(10px);
      }
      50% {
        transform: translateY(-40px) translateX(-10px);
      }
      75% {
        transform: translateY(-20px) translateX(20px);
      }
    }

    /* Sticky Navigation */
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(45, 52, 54, 0.95);
      backdrop-filter: blur(10px);
      padding: 0;
      z-index: 1000;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
      height: var(--nav-height);
      display: flex;
      align-items: center;
    }

    .admin-nav {
      max-width: 1400px;
      width: 100%;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1rem;
      font-weight: 700;
      color: var(--light-color);
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .logo i {
      color: var(--primary-color);
      font-size: 2rem;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.1);
      }
    }

    .nav-container {
      display: flex;
      align-items: center;
    }

    .nav-links {
      display: flex;
      gap: 5px;
      margin-right: 20px;
    }

    .nav-links a {
      color: var(--light-color);
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 8px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      font-weight: 500;
      font-size: 0.8rem;
    }

    .nav-links a:before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .nav-links a:hover:before {
      left: 100%;
    }

    .nav-links a:hover, .nav-links a.active {
      background: rgba(108, 92, 231, 0.2);
      box-shadow: 0 0 15px rgba(108, 92, 231, 0.4);
    }

    .nav-links a.active {
      background: var(--primary-color);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      position: relative;
      cursor: pointer;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      box-shadow: 0 0 10px rgba(108, 92, 231, 0.5);
      transition: var(--transition);
    }

    .user-info:hover .user-avatar {
      transform: scale(1.1);
    }

    .user-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      background: rgba(45, 52, 54, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 8px;
      padding: 10px 0;
      margin-top: 10px;
      min-width: 150px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: var(--transition);
    }

    .user-info:hover .user-dropdown {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .user-dropdown a {
      display: block;
      padding: 8px 15px;
      color: var(--light-color);
      text-decoration: none;
      transition: var(--transition);
    }

    .user-dropdown a:hover {
      background: rgba(108, 92, 231, 0.2);
    }

    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      color: var(--light-color);
      font-size: 1.5rem;
      cursor: pointer;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Dashboard Cards */
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      transition: var(--transition);
      transform-style: preserve-3d;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card:hover {
      transform: translateY(-10px) rotateX(5deg);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .card-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: rgba(108, 92, 231, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: var(--primary-color);
    }

    .card-title {
      font-size: 1rem;
      font-weight: 500;
      color: var(--light-color);
    }

    .card-value {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 5px;
    }

    .card-growth {
      font-size: 0.9rem;
      color: var(--success-color);
    }

    /* Main Content */
    .main-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
    }

    .content-card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      margin-bottom: 30px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .content-card h2 {
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .content-card h2 i {
      color: var(--primary-color);
    }

    /* Gallery Management */
    .gallery-form {
      display: grid;
      gap: 15px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .form-group label {
      font-weight: 500;
      font-size: 0.9rem;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      padding: 12px 15px;
      color: var(--light-color);
      font-family: 'Poppins', sans-serif;
      transition: var(--transition);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 10px rgba(108, 92, 231, 0.5);
    }

    .btn {
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px 20px;
      font-family: 'Poppins', sans-serif;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn:hover {
      background: #5649d3;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
    }

    .btn i {
      font-size: 1rem;
    }

    /* Gallery Items */
    .gallery-items {
      display: grid;
      gap: 15px;
      max-height: 400px;
      overflow-y: auto;
      padding-right: 5px;
    }

    .gallery-items::-webkit-scrollbar {
      width: 6px;
    }

    .gallery-items::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
    }

    .gallery-items::-webkit-scrollbar-thumb {
      background: var(--primary-color);
      border-radius: 10px;
    }

    .gallery-item {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 15px;
      display: grid;
      grid-template-columns: 100px 1fr auto;
      gap: 15px;
      align-items: center;
      transition: var(--transition);
    }

    .gallery-item:hover {
      background: rgba(255, 255, 255, 0.15);
      transform: translateX(5px);
    }

    .gallery-item-img {
      width: 100px;
      height: 70px;
      border-radius: 8px;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .gallery-item-info h3 {
      font-size: 1rem;
      margin-bottom: 5px;
    }

    .gallery-item-info p {
      font-size: 0.8rem;
      opacity: 0.8;
    }

    .gallery-item-actions {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
    }

    .edit-btn {
      background: rgba(253, 203, 110, 0.2);
      color: var(--warning-color);
    }

    .edit-btn:hover {
      background: var(--warning-color);
      color: white;
    }

    .delete-btn {
      background: rgba(214, 48, 49, 0.2);
      color: var(--danger-color);
    }

    .delete-btn:hover {
      background: var(--danger-color);
      color: white;
    }

    /* Recent Activity */
    .activity-list {
      display: grid;
      gap: 15px;
      max-height: 300px;
      overflow-y: auto;
      padding-right: 5px;
    }

    .activity-list::-webkit-scrollbar {
      width: 6px;
    }

    .activity-list::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
    }

    .activity-list::-webkit-scrollbar-thumb {
      background: var(--primary-color);
      border-radius: 10px;
    }

    .activity-item {
      display: flex;
      gap: 15px;
      padding: 10px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.05);
      transition: var(--transition);
    }

    .activity-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .activity-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(108, 92, 231, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-color);
    }

    .activity-content {
      flex: 1;
    }

    .activity-content h4 {
      font-size: 0.9rem;
      margin-bottom: 5px;
    }

    .activity-content p {
      font-size: 0.8rem;
      opacity: 0.8;
    }

    .activity-time {
      font-size: 0.7rem;
      opacity: 0.6;
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 20px;
      margin-top: 50px;
      font-size: 0.9rem;
      opacity: 0.7;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      z-index: 1001;
      align-items: center;
      justify-content: center;
    }

    .modal-content {
      background: var(--dark-color);
      border-radius: 15px;
      padding: 25px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
      transform: translateY(-50px);
      opacity: 0;
      transition: all 0.3s ease;
    }

    .modal.show .modal-content {
      transform: translateY(0);
      opacity: 1;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-close {
      background: none;
      border: none;
      color: var(--light-color);
      font-size: 1.5rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .modal-close:hover {
      color: var(--danger-color);
      transform: rotate(90deg);
    }

    /* Toast notifications */
    .toast-container {
      position: fixed;
      top: 90px;
      right: 20px;
      z-index: 1002;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .toast {
      background: var(--dark-color);
      color: var(--light-color);
      padding: 15px 20px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      display: flex;
      align-items: center;
      gap: 10px;
      transform: translateX(100%);
      opacity: 0;
      transition: all 0.3s ease;
    }

    .toast.show {
      transform: translateX(0);
      opacity: 1;
    }

    .toast.success {
      border-left: 4px solid var(--success-color);
    }

    .toast.error {
      border-left: 4px solid var(--danger-color);
    }

    .toast.warning {
      border-left: 4px solid var(--warning-color);
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .main-content {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 992px) {
      .nav-links {
        position: fixed;
        top: var(--nav-height);
        left: -100%;
        width: 280px;
        height: calc(100vh - var(--nav-height));
        background: rgba(45, 52, 54, 0.95);
        backdrop-filter: blur(10px);
        flex-direction: column;
        padding: 20px;
        transition: var(--transition);
        z-index: 999;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.2);
      }

      .nav-links.active {
        left: 0;
      }

      .nav-links a {
        width: 100%;
        justify-content: center;
      }

      .mobile-menu-btn {
        display: block;
      }
    }

    @media (max-width: 768px) {
      .dashboard-cards {
        grid-template-columns: 1fr;
      }

      .gallery-item {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .gallery-item-actions {
        justify-content: center;
      }

      .user-info span {
        display: none;
      }
    }

    @media (max-width: 576px) {
      .logo span {
        display: none;
      }

      .card {
        padding: 15px;
      }

      .content-card {
        padding: 20px 15px;
      }
    }
    
    .video-indicator {
      color: var(--secondary-color);
      font-size: 0.8rem;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <!-- Background particles -->
  <div class="particles-container" id="particles-container"></div>

  <!-- Sticky Navigation -->
  <header>
    <div class="admin-nav">
      <div class="logo">
        <i class="fas fa-camera"></i>
        <span>GalleryAdmin Pro</span>
      </div>
      
      <div class="nav-container">
        <div class="nav-links" id="nav-links">
          <a href="admin-dashboard.php">Home</a>
          <a href="admin-manage-gallery.php" class="active">Manage Gallery</a>
        </div>
        
        <button class="mobile-menu-btn" id="mobile-menu-btn">
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="dashboard-cards">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Total Gallery Items</div>
          <div class="card-icon">
            <i class="fas fa-image"></i>
          </div>
        </div>
        <div class="card-value"><?php echo count(getGalleryItems()); ?></div>
        <div class="card-growth">+<?php echo count(getRecentItems()); ?> this week</div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <div class="card-title">Active Bookings</div>
          <div class="card-icon">
            <i class="fas fa-calendar-check"></i>
          </div>
        </div>
        <div class="card-value">28</div>
        <div class="card-growth">+3 today</div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <div class="card-title">Pending Enquiries</div>
          <div class="card-icon">
            <i class="fas fa-question-circle"></i>
          </div>
        </div>
        <div class="card-value">17</div>
        <div class="card-growth">-2 this week</div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <div class="card-title">User Comments</div>
          <div class="card-icon">
            <i class="fas fa-comments"></i>
          </div>
        </div>
        <div class="card-value">56</div>
        <div class="card-growth">+8 today</div>
      </div>
    </div>

    <div class="main-content">
      <div class="content-column">
        <div class="content-card">
          <h2><i class="fas fa-plus-circle"></i> Add New Gallery Item</h2>
          <form class="gallery-form" id="gallery-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" required>
            </div>
            
            <div class="form-group">
              <label for="description">Description</label>
              <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter description" required></textarea>
            </div>
            
            <div class="form-group">
              <label for="image">Image</label>
              <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
              <div id="image-preview" style="margin-top: 10px; display: none;">
                <img id="preview-img" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
              </div>
            </div>
            
            <div class="form-group">
              <label for="video">Video (Optional)</label>
              <input type="file" id="video" name="video" class="form-control" accept="video/*">
            </div>
            
            <button type="submit" class="btn">
              <i class="fas fa-plus"></i> Add Item
            </button>
          </form>
        </div>
      </div>
      
      <div class="content-column">
        <div class="content-card">
          <h2><i class="fas fa-images"></i> Gallery Items</h2>
          <div class="gallery-items" id="gallery-items-container">
            <?php
            $items = getGalleryItems();
            foreach ($items as $item): 
            ?>
            <div class="gallery-item" data-id="<?php echo $item['id']; ?>">
              <img src="<?php echo $item['image_path']; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="gallery-item-img">
              <div class="gallery-item-info">
                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><?php echo htmlspecialchars($item['description']); ?></p>
                <?php if (!empty($item['video_path'])): ?>
                <p class="video-indicator"><i class="fas fa-video"></i> Has video</p>
                <?php endif; ?>
              </div>
              <div class="gallery-item-actions">
                <div class="action-btn edit-btn" onclick="openEditModal(<?php echo $item['id']; ?>)">
                  <i class="fas fa-edit"></i>
                </div>
                <div class="action-btn delete-btn" onclick="deleteItem(<?php echo $item['id']; ?>)">
                  <i class="fas fa-trash"></i>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        
        <div class="content-card">
          <h2><i class="fas fa-history"></i> Recent Activity</h2>
          <div class="activity-list" id="activity-list">
            <?php
            $activities = getRecentActivities();
            foreach ($activities as $activity): 
              $iconClass = '';
              switch($activity['type']) {
                case 'add': $iconClass = 'fa-plus'; break;
                case 'edit': $iconClass = 'fa-edit'; break;
                case 'delete': $iconClass = 'fa-trash'; break;
                case 'user': $iconClass = 'fa-user'; break;
                case 'comment': $iconClass = 'fa-comment'; break;
                default: $iconClass = 'fa-bell';
              }
            ?>
            <div class="activity-item">
              <div class="activity-icon">
                <i class="fas <?php echo $iconClass; ?>"></i>
              </div>
              <div class="activity-content">
                <h4><?php echo htmlspecialchars($activity['title']); ?></h4>
                <p><?php echo htmlspecialchars($activity['description']); ?></p>
                <div class="activity-time"><?php echo htmlspecialchars($activity['time']); ?></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <p>&copy; 2023 GalleryAdmin Pro. All rights reserved.</p>
    </footer>
  </div>

  <!-- Edit Modal -->
  <div class="modal" id="edit-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fas fa-edit"></i> Edit Gallery Item</h2>
        <button class="modal-close" id="modal-close">&times;</button>
      </div>
      <form class="gallery-form" id="edit-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" id="edit-id" name="id">
        <div class="form-group">
          <label for="edit-title">Title</label>
          <input type="text" id="edit-title" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label for="edit-description">Description</label>
          <textarea id="edit-description" name="description" class="form-control" rows="3" required></textarea>
        </div>
        
        <div class="form-group">
          <label for="edit-image">Image (Leave empty to keep current)</label>
          <input type="file" id="edit-image" name="image" class="form-control" accept="image/*">
          <div id="edit-image-preview" style="margin-top: 10px;">
            <img id="edit-preview-img" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
          </div>
        </div>
        
        <button type="submit" class="btn">
          <i class="fas fa-save"></i> Save Changes
        </button>
      </form>
    </div>
  </div>

  <!-- Toast Container -->
  <div class="toast-container" id="toast-container"></div>

  <script>
    // DOM Elements
    const navLinks = document.getElementById('nav-links');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const galleryForm = document.getElementById('gallery-form');
    const editForm = document.getElementById('edit-form');
    const galleryContainer = document.getElementById('gallery-items-container');
    const activityList = document.getElementById('activity-list');
    const editModal = document.getElementById('edit-modal');
    const modalClose = document.getElementById('modal-close');
    const toastContainer = document.getElementById('toast-container');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const editImageInput = document.getElementById('edit-image');
    const editPreviewImg = document.getElementById('edit-preview-img');
    const editImagePreview = document.getElementById('edit-image-preview');

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      createParticles();
      initEventListeners();
    });

    // Create background particles
    function createParticles() {
      const particlesContainer = document.getElementById('particles-container');
      const particleCount = 20;
      
      for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        
        // Random size between 5 and 15px
        const size = Math.random() * 10 + 5;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        // Random position
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        
        // Random animation delay
        particle.style.animationDelay = `${Math.random() * 5}s`;
        particle.style.animationDuration = `${Math.random() * 10 + 15}s`;
        
        particlesContainer.appendChild(particle);
      }
      
      // Add 3D tilt effect to cards
      const cards = document.querySelectorAll('.card');
      cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
          const x = e.clientX;
          const y = e.clientY;
          const rect = this.getBoundingClientRect();
          const hWidth = rect.width / 2;
          const hHeight = rect.height / 2;
          
          const angleY = (x - rect.left - hWidth) / 25;
          const angleX = (y - rect.top - hHeight) / -25;
          
          this.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) translateZ(10px)`;
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
        });
      });
    }

    // Initialize event listeners
    function initEventListeners() {
      // Mobile menu toggle
      mobileMenuBtn.addEventListener('click', function() {
        navLinks.classList.toggle('active');
      });

      // Close modal when clicking outside
      window.addEventListener('click', function(e) {
        if (e.target === editModal) {
          closeModal();
        }
      });

      // Close modal with button
      modalClose.addEventListener('click', closeModal);

      // Image preview
      imageInput.addEventListener('change', function() {
        previewImage(this, previewImg, imagePreview);
      });

      editImageInput.addEventListener('change', function() {
        previewImage(this, editPreviewImg, editImagePreview);
      });

      // Form submissions
      galleryForm.addEventListener('submit', handleFormSubmit);
      editForm.addEventListener('submit', handleEditSubmit);
    }

    // Handle form submission
    function handleFormSubmit(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      
      fetch(window.location.href, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          showToast(data.message, 'success');
          // Reset form
          this.reset();
          imagePreview.style.display = 'none';
          
          // Reload page to update gallery and activities
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showToast(data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showToast('Error submitting form', 'error');
      });
    }

    // Handle edit form submission
    function handleEditSubmit(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      
      fetch(window.location.href, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          showToast(data.message, 'success');
          closeModal();
          
          // Reload page to update gallery and activities
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showToast(data.message, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showToast('Error updating item', 'error');
      });
    }

    // Open edit modal
    function openEditModal(id) {
      // Find the item in the DOM
      const itemElement = document.querySelector(`.gallery-item[data-id="${id}"]`);
      if (!itemElement) return;
      
      // Get item data
      const title = itemElement.querySelector('.gallery-item-info h3').textContent;
      const description = itemElement.querySelector('.gallery-item-info p').textContent;
      const imageSrc = itemElement.querySelector('.gallery-item-img').src;
      
      // Populate the form
      document.getElementById('edit-id').value = id;
      document.getElementById('edit-title').value = title;
      document.getElementById('edit-description').value = description;
      
      // Set the image preview
      editPreviewImg.src = imageSrc;
      editImagePreview.style.display = 'block';
      
      // Show the modal
      editModal.style.display = 'flex';
      setTimeout(() => {
        editModal.classList.add('show');
      }, 10);
    }

    // Close modal
    function closeModal() {
      editModal.classList.remove('show');
      setTimeout(() => {
        editModal.style.display = 'none';
      }, 300);
    }

    // Delete item
    function deleteItem(id) {
      if (confirm('Are you sure you want to delete this item?')) {
        // Create form data
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);
        
        // Send request
        fetch(window.location.href, {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            // Remove item from DOM
            const itemElement = document.querySelector(`.gallery-item[data-id="${id}"]`);
            if (itemElement) {
              itemElement.remove();
            }
            
            // Update total count
            updateTotalCount();
            
            // Show success message
            showToast('Gallery item deleted successfully!', 'success');
            
            // Reload page to update activities
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          } else {
            showToast('Error: ' + data.message, 'error');
          }
        })
        .catch(error => {
          console.error('Error deleting item:', error);
          showToast('Error deleting gallery item', 'error');
        });
      }
    }

    // Preview image before upload
    function previewImage(input, imgElement, previewContainer) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          imgElement.src = e.target.result;
          previewContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Show toast notification
    function showToast(message, type = 'success') {
      const toast = document.createElement('div');
      toast.classList.add('toast', type);
      
      let icon = 'fa-check-circle';
      if (type === 'error') icon = 'fa-exclamation-circle';
      if (type === 'warning') icon = 'fa-exclamation-triangle';
      
      toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
      `;
      
      toastContainer.appendChild(toast);
      
      // Show toast
      setTimeout(() => {
        toast.classList.add('show');
      }, 10);
      
      // Hide after 3 seconds
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
          toastContainer.removeChild(toast);
        }, 300);
      }, 3000);
    }

    // Update total count in dashboard
    function updateTotalCount() {
      const totalCountElement = document.querySelector('.dashboard-cards .card:first-child .card-value');
      if (totalCountElement) {
        const itemCount = document.querySelectorAll('.gallery-item').length;
        totalCountElement.textContent = itemCount;
      }
    }
  </script>
</body>
</html>