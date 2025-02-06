<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">ROLL CALL ATTENDANCE</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action">Employees</a>
                <a href="#" class="list-group-item list-group-item-action">Manual Attendance</a>
                <a href="#" class="list-group-item list-group-item-action">Shifts</a>
                <a href="#" class="list-group-item list-group-item-action">Configurations</a>
                <a href="#" class="list-group-item list-group-item-action">Daily Reports</a>
                <a href="#" class="list-group-item list-group-item-action">Monthly Reports</a>
                <a href="#" class="list-group-item list-group-item-action">Leave Management</a>
            </div>
        </div>
        
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="menu-toggle">☰</button>
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    <div>
                        <i class="fa fa-envelope"></i>
                        <i class="fa fa-bell"></i>
                        <img src="user.png" alt="User" class="rounded-circle" width="40">
                    </div>
                </div>
            </nav>
            
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5>Total Registrations</h5>
                                <h2>6,54,29,708</h2>
                                <p>15% Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5>Present</h5>
                                <h2>48,690</h2>
                                <p>2.3% Today</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5>Late</h5>
                                <h2>13,750</h2>
                                <p>10% Today</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5>Absent</h5>
                                <h2>7,932</h2>
                                <p>8% Today</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Attendance chart by status</h5>
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Reports</h5>
                                <canvas id="reportsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="main.js"></script>
</body>
</html>