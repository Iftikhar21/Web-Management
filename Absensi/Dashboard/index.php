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
  
    $today = date('Y-m-d');  // Get today's date
    
    $sqlBadMoodToday = "SELECT COUNT(*) AS total_buruk 
                        FROM Absensi 
                        WHERE Mood = 'Buruk' 
                        AND DATE(Waktu) = '$today'";  // Adjusting Mood to 'buruk' for bad mood
    
    $resultBadMoodToday = $conn->query($sqlBadMoodToday);
    
    $totalBadMood = 0;  // Initialize count variable
    
    if ($resultBadMoodToday && $resultBadMoodToday->num_rows > 0) {
        $rowBadMoodToday = $resultBadMoodToday->fetch_assoc();
        $totalBadMood = $rowBadMoodToday['total_buruk'];  // Retrieve the count of students with a bad mood
    } else {
        echo $conn->error;  // Display error if query fails
    }



    $persentaseKehadiran = ($totalAbsen > 0) ? ($totalHadir / $totalAbsen) * 100 : 0;
    $persentaseTerlambat = ($totalAbsen > 0) ? ($totalLate / $totalAbsen) * 100 : 0;
    $persentaseAbsen = ($totalAbsen > 0) ? ($totalAbsen / 1214) * 100 : 0;
    
    $persentaseBadMood = ($totalAbsen > 0) ? ($totalBadMood / $totalAbsen) * 100: 0;
    
    $tidakHadir = 1214 - $totalAbsen;
    
    $persentaseTidakHadir = ($totalAbsen > 0) ? ($tidakHadir / 1214) * 100 : 0;

    
    $sqlLateStudents = "SELECT Nama, Kelas, Jurusan, Waktu FROM Absensi WHERE Kehadiran = 'Terlambat' AND DATE(Waktu) = '$lateToday'";
    $resultLateStudents = $conn->query($sqlLateStudents);
    
    $lateStudents = [];
    if ($resultLateStudents && $resultLateStudents->num_rows > 0) {
        while ($row = $resultLateStudents->fetch_assoc()) {
            $lateStudents[] = $row;
        }
    } else {
        echo $conn->error;
    }

    // Query to fetch students with a bad mood
    $sqlBadMoodStudents = "SELECT Nama, Kelas, Jurusan, Catatan FROM Absensi WHERE Mood = 'Buruk' AND DATE(Waktu) = '$today'";  // Make sure 'Mood' is checked for 'Buruk'
    
    // Execute the query
    $resultBadMoodStudents = $conn->query($sqlBadMoodStudents);
    
    // Initialize an array to hold the students with bad mood
    $badMoodStudents = [];
    
    if ($resultBadMoodStudents && $resultBadMoodStudents->num_rows > 0) {
        // Fetch each student data into the array
        while ($row = $resultBadMoodStudents->fetch_assoc()) {
            $badMoodStudents[] = $row;  // Add the student details to the array
        }
    } else {
        // If query failed, show error
        echo $conn->error;
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
          <div class="theme-bar d-flex align-items-center">
          <div class="theme-toggler me-3" id="themeToggler">
            <span class="material-icons-sharp active"> light_mode </span>
            <span class="material-icons-sharp"> dark_mode </span>
          </div>
          <div class="real-time-clock">
            <h3 id="clock" class="m-0"></h3>
          </div>
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
                  <h1>1.214</h1>
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
                  <h4>Jumlah Yang Belum Absen</h4>
                  <h1><?=$tidakHadir?></h1>
                </div>
                <div class="progress">
                  <svg>
                    <circle cx="42" cy="42" r="39" style="stroke-dasharray: 245; stroke-dashoffset: <?= 245 - (245 * $persentaseTidakHadir / 100); ?>"></circle>
                  </svg>
                  <div class="number">
                    <p><?= round($persentaseTidakHadir); ?>%</p>
                  </div>
                </div>
              </div>
              <small class="text-muted"> Last 24 Hours </small>
            </div>

            <div class="jumlah-hadir">
              <span class="material-icons-sharp"> checklist </span>
              <div class="middle">
                <div class="left">
                  <h4>Jumlah Murid BadMood</h4>
                  <h1><?=$totalBadMood;?></h1>
                </div>
                <div class="progress">
                  <svg>
                    <circle cx="42" cy="42" r="39" style="stroke-dasharray: 245; stroke-dashoffset: <?= 245 - (245 * $persentaseBadMood / 100); ?>"></circle>
                  </svg>
                  <div class="number">
                    <p><?= round($persentaseBadMood); ?>%</p>
                  </div>
                </div>
              </div>
              <small class="text-muted"> Last 24 Hours </small>
                <a href="#" class="view-late-students" data-bs-toggle="modal" data-bs-target="#badMoodStudentsModal">
                    View Late Students
                  </a>
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
                  <a href="#" class="view-late-students" data-bs-toggle="modal" data-bs-target="#lateStudentsModal">
                    View Late Students
                  </a>
            </div>
          </div>
        <div class="real-time-clock">
          <h3 id="clock" style="font-weight: bold; color: #333;"></h3>
        </div>
        </main>
      </div>
      
      <div class="modal fade" id="lateStudentsModal" tabindex="-1" aria-labelledby="lateStudentsModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="lateStudentsModalLabel">Students Who Are Late</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <ul id="lateStudentsList">
                  <!-- List of late students will be populated here -->
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="prevPage">Previous</button>
                <button type="button" class="btn btn-primary" id="nextPage">Next</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal for Bad Mood Students -->
        <div class="modal fade" id="badMoodStudentsModal" tabindex="-1" aria-labelledby="badMoodStudentsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="badMoodStudentsModalLabel">Students with Bad Mood</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="badMoodStudentsList">
                            <!-- List of students with bad mood will be populated here -->
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="prevPage">Previous</button>
                        <button type="button" class="btn btn-primary" id="nextPage">Next</button>
                    </div>
                </div>
            </div>
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
            $(document).ready(function () {
                // When the modal is shown, populate the list of late students
                $('#lateStudentsModal').on('show.bs.modal', function () {
                    var lateStudents = <?php echo json_encode($lateStudents); ?>;
                    var listHtml = '';
        
                    if (lateStudents.length > 0) {
                        lateStudents.forEach(function(student, index) {
                            listHtml += '<li>' + (index + 1) + '. ' + student.Nama + ' (' + student.Kelas + ' - ' + student.Jurusan + ') - ' + new Date(student.Waktu).toLocaleString() + '</li>';
                        });
                    } else {
                        listHtml = '<li>No late students today.</li>';
                    }
        
                    $('#lateStudentsList').html(listHtml);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                // When the modal is shown, populate the list of students with bad mood
                $('#badMoodStudentsModal').on('show.bs.modal', function () {
                    // Get the list of students with bad mood from PHP
                    var badMoodStudents = <?php echo json_encode($badMoodStudents); ?>;
                    var listHtml = '';
        
                    if (badMoodStudents.length > 0) {
                        badMoodStudents.forEach(function(student, index) {
                            listHtml += '<li>' + (index + 1) + '. ' + student.Nama + ' (' + student.Kelas + ' - ' + student.Jurusan + ') - ' + student.Catatan + '</li>';
                        });
                    } else {
                        listHtml = '<li>No students with bad mood today.</li>';
                    }
        
                    // Update the modal content
                    $('#badMoodStudentsList').html(listHtml);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                function paginateList(listId, data) {
                    let currentPage = 0;
                    const pageSize = 10;
            
                    function renderPage() {
                        let start = currentPage * pageSize;
                        let end = start + pageSize;
                        let listHtml = '';
            
                        let pageData = data.slice(start, end);
                        pageData.forEach((student, index) => {
                            listHtml += `<li>${start + index + 1}. ${student.Nama} (${student.Kelas} - ${student.Jurusan}) - ${new Date(student.Waktu).toLocaleString()}</li>`;
                        });
            
                        if (pageData.length === 0) {
                            listHtml = '<li>No data available.</li>';
                        }
            
                        $(listId).html(listHtml);
                        updateButtons();
                    }
            
                    function updateButtons() {
                        $("#prevPage").prop("disabled", currentPage === 0);
                        $("#nextPage").prop("disabled", (currentPage + 1) * pageSize >= data.length);
                    }
            
                    $("#prevPage").click(function () {
                        if (currentPage > 0) {
                            currentPage--;
                            renderPage();
                        }
                    });
            
                    $("#nextPage").click(function () {
                        if ((currentPage + 1) * pageSize < data.length) {
                            currentPage++;
                            renderPage();
                        }
                    });
            
                    renderPage();
                }
            
                // Modal untuk siswa terlambat
                $('#lateStudentsModal').on('show.bs.modal', function () {
                    var lateStudents = <?php echo json_encode($lateStudents); ?>;
                    paginateList('#lateStudentsList', lateStudents);
                });
            
                // Modal untuk bad mood students
                $('#badMoodStudentsModal').on('show.bs.modal', function () {
                    var badMoodStudents = <?php echo json_encode($badMoodStudents); ?>;
                    paginateList('#badMoodStudentsList', badMoodStudents);
                });
            });
        </script>
        <script>
          function showRealTimeClock() {
            const now = new Date();
            const options = {
              weekday: 'long', 
              year: 'numeric', 
              month: 'long', 
              day: 'numeric', 
              hour: '2-digit', 
              minute: '2-digit', 
              second: '2-digit',
              timeZone: 'Asia/Jakarta'
            };
            
            const formattedTime = now.toLocaleString('id-ID', options);
            document.getElementById("clock").textContent = formattedTime;
          }
        
          setInterval(showRealTimeClock, 1000);
          showRealTimeClock(); // Panggilan awal agar langsung muncul tanpa tunggu interval
        </script>

    </body>
  </html>