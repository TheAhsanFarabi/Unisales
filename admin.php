<?php 

include('connection.php');
session_start();

// Function to destroy the session and redirect to the registration page
if (isset($_POST['btn_logout'])) {
    destroySession();
}

function destroySession()
{
    session_destroy();
    header("location: registration.php");
    exit();
}

// Redirect to the registration page if the user is not logged in
if (!isset($_SESSION['id'])) {
    header("location: registration.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASHBOARD</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>


<nav class="navbar navbar-light bg-light navbar-fixed">
  <span class="navbar-brand mb-0 h1">ADMIN</span>
                                <form method="post">
                                    <input class="bg-transparent border border-2" type="submit" name="btn_logout"
                                        value="Logout">
                                </form>
</nav>


    <div class="container d-flex flex-column justify-content-center">
    <h1 class="display-1 text-center">ADMIN DASHBOARD</h1><br>
    <!-- First Button -->
    <button type="button" class="btn btn-primary btn-lg p-5 rounded-5 mx-auto my-5" data-bs-toggle="modal" data-bs-target="#modal1">
    <i class="fas fa-cogs"></i> Users Report
    </button>

    <!-- Second Button -->
    <button type="button" class="btn btn-success btn-lg p-5 rounded-5 mx-auto my-5" data-bs-toggle="modal" data-bs-target="#modal2">
    <i class="fas fa-chart-bar"></i> Sales Report
    </button>

    <!-- Modals -->
    <div class="modal" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal1Label">User Report</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php include('admin/load_users.php') ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2Label">Sales Report</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php include('admin/sales_report.php') ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

       
      
    </div>


    <footer class="container pt-4 mb-0 w-100">
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="assets/js/app.js"></script>
    </footer>
</body>

</html>