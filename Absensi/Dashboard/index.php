  <?php
  // Konfigurasi database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "bacs5153_recode";

  date_default_timezone_set('Asia/Jakarta');

  // Membuat koneksi
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Mengecek koneksi
  if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
  }

  // Mendapatkan data dari database
  $sql = "SELECT * FROM Absensi";
  $result = $conn->query($sql);

  // Menyimpan data dalam array untuk digunakan di JavaScript
  $dataAbsensi = [];
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $dataAbsensi[] = $row;
      }
  }

  $dateAbsenToday = date('Y-m-d');

  $sqlAbsen = "SELECT COUNT(*) AS total_absen 
             FROM Absensi 
             WHERE DATE(Waktu) = '$dateAbsenToday'";

  $resultAbsen = $conn->query($sqlAbsen);

  $totalAbsen = 0;

  if ($resultAbsen && $resultAbsen->num_rows > 0) {
      $rowAbsen = $resultAbsen->fetch_assoc();
      $totalAbsen = $rowAbsen['total_absen'];
  } else {
      echo $conn->error;
  }


  $dateToday = date('Y-m-d');
  $sqlToday = "SELECT COUNT(*) AS total_hadir 
             FROM Absensi 
             WHERE Kehadiran = 'Hadir' 
             AND DATE(Waktu) = '$dateToday'";

  $resultToday = $conn->query($sqlToday);

  $totalHadir = 0;

  if ($resultToday && $resultToday->num_rows > 0) {
      $rowToday = $resultToday->fetch_assoc();
      $totalHadir = $rowToday['total_hadir'];
  } else {
      echo $conn->error;
  }

  $lateToday = date('Y-m-d');
  $sqlLateToday = "SELECT COUNT(*) AS total_terlambat 
             FROM Absensi 
             WHERE Kehadiran = 'Terlambat' 
             AND DATE(Waktu) = '$lateToday'";

  $resultLateToday = $conn->query($sqlLateToday);

  $totalLate = 0;

  if ($resultLateToday && $resultLateToday->num_rows > 0) {
      $rowLateToday = $resultLateToday->fetch_assoc();
      $totalLate = $rowLateToday['total_terlambat'];
  } else {
      echo $conn->error;
  }

  $persentaseKehadiran = ($totalHadir / $totalAbsen) * 100;
  $persentaseTerlambat = ($totalLate / $totalAbsen) * 100;
  $persentaseAbsen = ($totalAbsen / 1200) * 100;

  // Menutup koneksi
  $conn->close();
  ?>

  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Admin Dashboard</title>

      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

      <!-- Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>

      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

      <link rel="stylesheet" href="./style.css" />

    </head>
    <body>
      <div class="containerr">
        <aside>
          <div class="top">
            <div class="logo">
              <h2>Re<span class="danger">Code</span></h2>
            </div>
          </div>

          <div class="sidebar">
            <a href="#">
              <span>
                  <i class='bx bxs-dashboard'></i>
              </span>
              <h3>Dashboard</h3>
            </a>
            <a href="absensi.php">
              <span>
                  <i class='bx bxs-bar-chart-alt-2'></i>
              </span>
              <h3>Absensi</h3>
            </a>
            <a href="about.php">
              <span>
                  <i class='bx bx-info-circle' ></i>
              </span>
              <h3>About</h3>
            </a>
          </div>
        </aside>

        <main>
          <div class="theme-toggler" id="themeToggler">
              <span class="material-icons-sharp active"> light_mode </span>
              <span class="material-icons-sharp"> dark_mode </span>
          </div>
          
          <div class="refresh-data" id="refresh_data">
              <span class="material-icons-sharp" onclick="refreshPage()"> refresh </span>
          </div>

          <div class="insights">
            <!-- SALES -->
            <div class="jumlah-siswa">
              <span class="material-icons-sharp"> analytics </span>
              <div class="middle">
                <div class="left">
                  <h4 style="margin-top: 15px;">Jumlah Siswa</h4>
                  <h1>1.200</h1>
                </div>
                <!-- <div class="progress">
                  <svg>
                    <circle cx="42" cy="42" r="39" style="stroke-dasharray: 245; stroke-dashoffset: <?= 245 - (245 * $persentaseKehadiran / 100); ?>"></circle>
                  </svg>
                  <div class="number">
                    <p><?= round($persentaseKehadiran); ?>%</p>
                  </div>
                </div> -->
              </div>
              <small class="text-muted"> Last 24 Hours </small>
            </div>
            
            <div class="jumlah-absen">
              <span class="material-icons-sharp"> data_usage </span>
              <div class="middle">
                <div class="left">
                  <h4>Jumlah Absen Hari ini</h4>
                  <h1><?=$totalAbsen?></h1>
                </div>
                <div class="progress">
                  <svg>
                    <circle cx="42" cy="42" r="39" style="stroke-dasharray: 245; stroke-dashoffset: <?= 245 - (245 * $persentaseAbsen / 100); ?>"></circle>
                  </svg>
                  <div class="number">
                    <p><?= round($persentaseAbsen); ?>%</p>
                  </div>
                </div>
              </div>
              <small class="text-muted"> Last 24 Hours </small>
            </div>

            <div class="jumlah-hadir">
              <span class="material-icons-sharp"> checklist </span>
              <div class="middle">
                <div class="left">
                  <h4>Jumlah Murid Hadir</h4>
                  <h1><?=$totalHadir;?></h1>
                </div>
                <div class="progress">
                  <svg>
                    <circle cx="42" cy="42" r="39" style="stroke-dasharray: 245; stroke-dashoffset: <?= 245 - (245 * $persentaseKehadiran / 100); ?>"></circle>
                  </svg>
                  <div class="number">
                    <p><?= round($persentaseKehadiran); ?>%</p>
                  </div>
                </div>
              </div>
              <small class="text-muted"> Last 24 Hours </small>
            </div>

            <!-- EXPENSES -->
            <div class="jumlah-terlambat">
              <span class="material-icons-sharp"> bar_chart </span>
              <div class="middle">
                <div class="left">
                  <h3>Jumlah Murid Terlambat</h3>
                  <h1><?=$totalLate;?></h1>
                </div>
                <div class="progress">
                <svg>
                    <circle cx="42" cy="42" r="39" style="stroke-dasharray: 245; stroke-dashoffset: <?= 245 - (245 * $persentaseTerlambat / 100); ?>"></circle>
                  </svg>
                  <div class="number">
                    <p><?= round($persentaseTerlambat); ?>%</p>
                  </div>
                </div>
              </div>
              <small class="text-muted"> Last 24 hours </small>
            </div>
          </div>
        </main>
      </div>
      <footer id="footer">
          <div class="footer-container">
              <div class="footer-content">
                  <p>© 2023 Re-Code Corporation. All rights reserved.</p>
              </div>
          </div>
      </footer>

      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

      <script src="./main.js"></script>

    </body>
  </html>