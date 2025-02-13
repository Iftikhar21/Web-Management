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
  $dateToday = date('Y-m-d');
  // Mendapatkan data dari database
  $sql = "SELECT * FROM Absensi WHERE DATE(Waktu) = '$dateToday'";
  $result = $conn->query($sql);

  // Menyimpan data dalam array untuk digunakan di JavaScript
  $dataAbsensi = [];
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $dataAbsensi[] = $row;
      }
  }
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

      <style>
        body {
            overflow-y: visible;
        }
      </style>

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
            <a href="index.php">
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

          <h1 class="title">Absensi</h1>

          <div class="table-container">
              <table id="absensiTable" class="table table-bordered rounded-3">
                <thead>
                    <tr class="title">
                        <th>No</th>
                        <th>Nama</th>
                        <th>NISN</th>
                        <th>Android ID</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Mood</th>
                    </tr>
                    <tr class="filter-row">
                        <td></td>
                        <td><input type="text" id="filterNama" class="form-control" placeholder="Cari Nama"></td>
                        <td><input type="text" id="filterNISN" class="form-control" placeholder="Cari NISN"></td>
                        <td><input type="text" id="filterAndroidID" class="form-control" placeholder="Cari Android Id"></td>
                        <td>
                            <select id="filterKelas" class="form-select">
                                <option value="">All</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </td>
                        <td>
                            <select id="filterJurusan" class="form-select">
                                <option value="">All</option>
                                <option value="RPL 1">RPL 1</option>
                                <option value="RPL 2">RPL 2</option>
                                <option value="TBG 2">TBG 2</option>
                                <option value="^TBG 3$">TBG 3</option>
                                <option value="^PH 1$">PH 1</option>
                                <option value="^PH 2$">PH 2</option>
                                <option value="^PH 3$">PH 3</option>
                                <option value="^TBS 1$">TBS 1</option>
                                <option value="^TBS 2$">TBS 2</option>
                                <option value="^TBS 3$">TBS 3</option>
                                <option value="^ULW$">ULW</option>
                            </select>
                        </td>
                        <td><input type="date" id="filterTanggal" class="form-control"></td>
                        <td>
                            <select id="filterKehadiran" class="form-select">
                                <option value="">All</option>
                                <option value="Hadir">Hadir</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Izin">Izin</option>
                                <option value="Terlambat">Terlambat</option>
                            </select>
                        </td>
                        <td><input type="text" id="filterCatatan" class="form-control" placeholder="Cari Catatan"></td>
                        <td>
                            <select id="filterMood" class="form-select">
                                <option value="">All</option>
                                <option value="Baik">Baik</option>
                                <option value="Biasa Aja">Biasa Aja</option>
                                <option value="Buruk">Buruk</option>
                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; 
                        foreach ($dataAbsensi as $row): ?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?= htmlspecialchars($row['Nama']); ?></td>
                        <td><?= htmlspecialchars($row['NISN']); ?></td>
                        <td><?= htmlspecialchars($row['AndroidID']); ?></td>
                        <td><?= htmlspecialchars($row['Kelas']); ?></td>
                        <td><?= htmlspecialchars($row['Jurusan']); ?></td>
                        <td><?= htmlspecialchars($row['Waktu']); ?></td>
                        <!-- <td><?= htmlspecialchars($row['Kehadiran']); ?></td> -->
                        <td>
                            <span class="status-badge status-<?= strtolower(htmlspecialchars($row['Kehadiran'])); ?>">
                                <?= htmlspecialchars($row['Kehadiran']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['Catatan']); ?></td>
                        <td><?= htmlspecialchars($row['Mood']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
      <script>
      
      function loadAbsensiData() {
        $.ajax({
          url: "absensi.php", // Pastikan file ini hanya mengembalikan tabel tanpa reload halaman
          type: "GET",
          success: function (data) {
            let newTableBody = $(data).find("tbody").html();
            $("#absensiTable tbody").html(newTableBody);
          },
          error: function () {
            console.error("Gagal memuat data");
          },
        });
      }
    
      // Muat ulang data setiap 10 detik (10000 milidetik)
      setInterval(loadAbsensiData, 5000);
    </script>


    </body>
  </html>