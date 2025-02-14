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

// Fetch user information from the database
$sql = "SELECT * FROM users WHERE id = " . $_SESSION['id'];
$result = $conn->query($sql);

// Check for a successful query and fetch user data
if ($result && $u = $result->fetch_assoc()) {
    // User data is available
} else {
    // Redirect to the registration page if user data cannot be fetched
    header("location: registration.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniSales</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>


    <header class="container">
        <nav
            class="navbar fixed-top fixed-top <?php if($u['user_type']==1) echo "bg-success"; else echo "bg-primary"; ?>">
            <div class="container">
                <div class="row">
                    <a class="navbar-brand fs-2 col text-light" href="index.php">Uni<b class="text-warning">Sales <i
                                class="fa-solid fa-truck-fast"></i></b></a>

                    <!-- Search Bar -->
                    <form class="d-flex mx-auto position-relative col my-1" method="get" action="search.php">
                        
                        <input class="form-control rounded-pill" type="text" id="searchInput" name="q" placeholder="Search any post"
                            aria-label="Search" autocomplete="off" style="width:450px;">
                        <div id="searchSuggestions"
                            class="card suggestions-card position-absolute start-0 top-100 mt-2">

                            <!-- Suggestions will be displayed here -->

                        </div>
                        <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
                    </form>
                </div>

                <div class="d-flex flex-row justify-content-end px-3 align-items-center">


                    
                    <?php if($u['user_type']==1) { ?>
                        
    <button class="btn btn-outline-light fs-5 rounded-circle" data-bs-toggle="modal" data-bs-target="#propModal"><i class="fa-solid fa-pen-to-square"></i></button>
    <?php } else { ?>
    <button class="btn btn-outline-light fs-5 rounded-circle" data-bs-toggle="modal" data-bs-target="#gigModal"><i class="fa-solid fa-pen-to-square"></i></button>
    <?php } ?>
                    <?php include('chat_box.php') ?>
                    <div>


                        <?php include('notifications.php') ?>
                        <a href="orders.php"
                            class="btn btn-outline-light me-2 rounded-pill">Orders<?php if($order_count!=0) { ?><i
                                class="ps-1 fa-solid fa-circle text-danger"></i><?php } ?></a>

                        <div class="dropdown">
                            <button class="btn btn-light rounded-pill dropdown-toggle px-2 me-2" type="button"
                                id="dropdownBalance" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $u['balance']?> BDT
                            </button>
                            <ul class="dropdown-menu text-center" aria-labelledby="dropdownBalance">
                                <h4 class="fs-5  text-muted">Your UBalance:</h4>
                                <h3><?= $u['balance']?> BDT</h3>
                                <?php 

                                if(isset($_POST['cash_in'])){
                                    mysqli_query($conn, "UPDATE users SET balance = balance + 100 WHERE id=".$u['id']);
                                    echo '<script>';
                                    echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
                                    echo '</script>';


                                }

                                if(isset($_POST['cash_out'])){
                                    mysqli_query($conn, "UPDATE users SET balance = balance - 100 WHERE id=".$u['id']);
                                    echo '<script>';
                                    echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
                                    echo '</script>';


                                }
                                
                                ?>
                                <?php if($u['user_type']==2){ ?>
                                    <form method="POST"><button type="submit" name="cash_in" class="btn btn-outline-success rounded-pill">Cash In 100 BDT</button></form>
                                <?php } else { ?>
                                    <form method="POST"><button type="submit" name="cash_out" class="btn btn-outline-success rounded-pill">Cash Out 100 BDT</button></form>
                                <?php } ?>
                              
                                

                                <div class="alert alert-info p-2 m-2 rounded-5" role="alert">
                                    Powerd By

                                    <img src="assets/images/bkash.png" width="100px" />
                                </div>

                            </ul>
                        </div>



                        <!--PROFILE-->
                        <div class="dropdown">

                            <div class="d-block link-dark text-decoration-none" id="dropdownUser1"
                                data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                <img src="data/profiles/<?= $u['img']?>" width="35" height="35" class="rounded-circle">

                            </div>


                            <ul class="dropdown-menu dropdown-menu-end text-small shadow-lg rounded-5 px-3"
                                aria-labelledby="dropdownUser1">
                                <li>
                                    <a class="dropdown-item rounded-pill border border-3 text-decoration-none d-flex flex-row justify-content-start p-2"
                                        href="profile.php?id=<?= $u['id'] ?>">
                                        <img src="data/profiles/<?= $u['img']?>" alt="Profile Picture" width="50"
                                            height="50" class="rounded-circle">
                                        <div class="d-flex flex-column justify-content-start ps-2">
                                            <small class="fw-bold"><?= $u['name'] ?></small>
                                            <small><?= $u['email'] ?></small>
                                        </div>
                                    </a>
                                </li>
                                <li><a class="p-3 my-2 border border-1 dropdown-item rounded-5 fs-5"
                                        href="settings.php"><i class="fa-solid rounded-5 fa-gear"></i> Settings</a></li>
                                <li><a class="p-3 my-2 border border-1 dropdown-item rounded-5 fs-5"
                                        href="orders.php"><i class="fa-solid fa-sack-dollar"></i> Orders</a></li>
                                <li><a class="p-3 my-2 border border-1 dropdown-item rounded-5 fs-5" href="#"><i
                                            class="fa-solid fa-robot"></i>FarmAI</a></li>
                                <li><a class="p-3 my-2 border border-1 dropdown-item rounded-5 fs-5" href="#"><i
                                            class="fa-solid rounded-5 fa-triangle-exclamation"></i>Terms of Service</a>
                                </li>



                                <form method="post"
                                    class="p-3 my-2 border border-1 dropdown-item rounded-5 fw-bold fs-5">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    <input class="bg-transparent border border-0" type="submit" name="btn_logout"
                                        value="Logout">
                                </form>


                            </ul>





                        </div>
                    </div>



                </div>
            </div>
        </nav>



    </header>




    <script>
    // JavaScript for handling search suggestions
    document.getElementById('searchInput').addEventListener('input', function() {
        var input = this.value;
        if (input.trim() !== '') {
            // Make an AJAX request to fetch post titles based on the input
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the suggestions card with the fetched data
                    document.getElementById('searchSuggestions').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'get_search_suggestions.php?q=' + input, true);
            xhr.send();
        } else {
            // Clear suggestions when the input is empty
            document.getElementById('searchSuggestions').innerHTML = '';
        }
    });
    </script>