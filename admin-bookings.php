<?php include 'get_background.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>View Bookings - OK Tours and Travel</title>
<style>
  /* Reset and base */
  *, *::before, *::after {
    box-sizing: border-box;
  }
  body {
    background-image: url('<?php echo $background; ?>');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
  /* Overlay for contrast */
  body::before {
    content: "";
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.45);
    z-index: -1;
  }

  header {
    background-color: #3498db;
    padding: 15px 25px;
    color: white;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
    user-select: none;
  }
  nav {
    background: #fff;
    padding: 12px 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
    box-shadow: 0 3px 7px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    flex-wrap: wrap;
  }
  nav a {
    color: #3498db;
    font-weight: 600;
    text-decoration: none;
    padding: 7px 15px;
    border-radius: 6px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    user-select: none;
  }
  nav a:hover,
  nav a:focus {
    background-color: #3498db;
    color: white;
    border-color: white;
    outline: none;
  }
  main {
    max-width: 1000px;
    margin: auto;
    background: rgba(255, 255, 255, 0.95);
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
  }
  h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #2c3e50;
    user-select: none;
  }

  /* Responsive wrapper for horizontal scroll */
  .table-wrapper {
    overflow-x: auto;
    margin-bottom: 1.5rem;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
    font-size: 0.95rem;
    transition: background-color 0.3s ease;
  }
  th, td {
    border: 1px solid #ddd;
    padding: 12px 15px;
    text-align: left;
    vertical-align: middle;
  }
  th {
    background-color: #3498db;
    color: white;
    font-weight: 600;
  }
  tbody tr:hover {
    background-color: #f1f8ff;
  }
  tbody tr:nth-child(even) {
    background-color: #f9fcff;
  }
  tbody tr.no-data td {
    text-align: center;
    font-style: italic;
    color: #777;
    padding: 30px 15px;
  }

  /* Export CSV button */
  .export-btn {
    display: inline-block;
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-bottom: 25px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
    user-select: none;
  }
  .export-btn:hover,
  .export-btn:focus {
    background-color: #2c80d9;
    outline: none;
  }

  /* Responsive font scaling on smaller devices */
  @media (max-width: 600px) {
    body {
      font-size: 14px;
    }
    nav {
      gap: 10px;
      padding: 10px 15px;
    }
    nav a {
      padding: 6px 12px;
      font-size: 0.9rem;
    }
    main {
      padding: 20px 25px;
    }
    h1 {
      font-size: 1.4rem;
    }
  }

  /* Screen reader only class for caption */
  .sr-only {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0,0,0,0) !important;
    white-space: nowrap !important;
    border: 0 !important;
  }
</style>
</head>
<body>

<header>View Bookings</header>

<nav>
  <a href="admin-dashboard.php">Home</a>
  <a href="admin-dashboard.php">Dashboard</a>
  <a href="admin-background.php" class="active">Change Background</a>
  <a href="admin-manage-admins.php">Manage Admins</a>
  <a href="admin-bookings.php" aria-current="page">View Bookings</a>
  <a href="admin-enquiries.html">View Enquiries</a>
  <a href="admin-comments.html">Manage Comments</a>
</nav>

<main>
  <h1>Bookings List</h1>
  
  <button class="export-btn" type="button" onclick="exportTableToCSV()">Export to CSV</button>

  <section class="table-wrapper" aria-label="Bookings table">
    <table role="table" aria-describedby="bookings-desc">
      <caption id="bookings-desc" class="sr-only">List of travel bookings including user and booking details</caption>
      <thead>
        <tr>
          <th scope="col">Booking ID</th>
          <th scope="col">User Name</th>
          <th scope="col">Place</th>
          <th scope="col">Number of People</th>
          <th scope="col">Number of Days</th>
          <th scope="col">Contact</th>
          <th scope="col">Email</th>
          <th scope="col">ID Number</th>
          <th scope="col">Booking Date</th>
          <th scope="col">Expected Travel Date</th>
        </tr>
      </thead>
      <tbody>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "oktours";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  echo "<tr class='no-data'><td colspan='9'>Connection failed</td></tr>";
} else {
  $sql = "SELECT * FROM bookings ORDER BY created_at DESC";


  
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>BK" . str_pad($row['id'], 3, '0', STR_PAD_LEFT) . "</td>";
      echo "<td>" . htmlspecialchars($row['name'] ?? 'N/A') . "</td>";
      echo "<td>" . htmlspecialchars($row['place']) . "</td>";
      echo "<td>" . htmlspecialchars($row['num_people']) . "</td>";
      echo "<td>" . htmlspecialchars($row['num_days']) . "</td>";
      echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
      echo "<td>" . htmlspecialchars($row['email'] ?? 'N/A') . "</td>";
      echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
      echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
      echo "<td>" . htmlspecialchars($row['travel_date']) . "</td>";
      echo "</tr>";
    }
  } else {
    echo "<tr class='no-data'><td colspan='9'>No bookings found.</td></tr>";
  }

  $conn->close();
}
?>
</tbody>


      
    </table>
  </section>
</main>

<script>
  // Export table data to CSV file
  function exportTableToCSV() {
    const rows = Array.from(document.querySelectorAll("table tr"));
    if(rows.length <= 1){
      alert("No data available to export.");
      return;
    }
    const csvContent = rows.map(row => {
      const cells = Array.from(row.querySelectorAll("th, td"));
      return cells.map(cell => `"${cell.innerText.replace(/"/g, '""')}"`).join(",");
    }).join("\n");

    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = "ok_tours_bookings.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  }



// Call it when page loads
window.addEventListener("DOMContentLoaded", loadBookings);

</script>

</body>
</html>
