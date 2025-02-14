<?php include('connection.php'); ?>

<?php

   
if (isset($_POST['login'])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_type= $_POST["user_type"];

      // Retrieve user data from the database
    $result = $conn->query("SELECT * FROM users WHERE username='$username' ");

  if($user_type==1 OR $user_type==2){
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["id"] = $row["id"];
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    }

    else {

      if($user_type==3){

        if ($result->num_rows === 1) {
          $row = $result->fetch_assoc();
          if ($password == $row["password"]) {
              session_start();
              $_SESSION["id"] = $row["id"];
              header("Location: admin.php");
              exit();
          } else {
              echo "Invalid password!";
          }
      } else {
          echo "User not found!";
      }


      }
      else {

        if ($result->num_rows === 1) {
          $row = $result->fetch_assoc();
          if ($password == $row["password"]) {
              session_start();
              $_SESSION["id"] = $row["id"];
              header("Location: transportations.php");
              exit();
          } else {
              echo "Invalid password!";
          }
      } else {
          echo "User not found!";
      }

      }

    }
    
}
?>

<?php


if (isset($_POST['registration'])) {
    if($_POST['user_type']==1){
    // FARMER
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $user_type = $_POST['user_type'];
    }
    elseif($_POST['user_type']== 2){
    // COMPANY
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $user_type = $_POST['user_type'];
    }
    else {
    // ADMIN
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $user_type = $_POST['user_type'];
    }
    

    // Check if username or email already exists
    $check_query = "SELECT id FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Insert new user into the database
        $insert_query = "INSERT INTO users (name, username, email, password, address, user_type) VALUES ('$name', '$username', '$email', '$password', '$address', '$user_type')";

        if ($conn->query($insert_query) === TRUE) {
            echo "<h1>Signup successful!</h1>";
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniSales</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
    body {
        font-family: 'Open Sans', sans-serif;
        /* Use the chosen font */
    }

    .carousel-item {
        height: 80vh;
    }

    .red {
        background-color: #FF5733;
    }

    .green {
        background-color: #33FF77;
    }

    .blue {
        background-color: #3377FF;
    }

    .carousel-inner {
        position: relative;
    }

    .carousel-caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
    }

    .company-logo {
        opacity: 0.3;
        /* Set the opacity as needed */
        filter: grayscale(100%);
        /* Convert the image to black and white */
    }
    </style>

</head>

<body>


    <header>
        <header>
            <nav class="navbar navbar-expand-lg bg-transparent fixed-top">
                <div class="container">
                    <a class="navbar-brand fw-bolder text-light" href="#" style="font-size: 50px;">Uni<b
                            class="text-warning">Sales
                            <i class="fa-solid fa-truck-fast"></i></b></a>

                    <div class="d-flex">

                        <button class="btn btn-outline-light fs-5 me-2" data-bs-toggle="modal"
                            data-bs-target="#login">Login</button>
                        <button type="button" class="btn btn-outline-success fs-4" data-bs-toggle="modal"
                            data-bs-target="#join">Join</button>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Your modals go here -->

        <script>
        // Custom JavaScript for changing the background color on scroll
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                var navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('bg-dark');
                } else {
                    navbar.classList.remove('bg-dark');
                }
            });
        });
        </script>




        <main>

            <div id="imageCarousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active red">
                        <img src="assets/images/human-1.png" style="margin-top:200px; margin-left: 900px;"
                            class="d-block" width="900px" alt="Human 1">
                        <div class="carousel-caption">
                            <h5 class="display-3 text-start fw-bolder">A Place Where Companies Meet Farmers!</h5>
                        </div>
                    </div>
                    <div class="carousel-item green">
                        <img src="assets/images/human-2.png" style="margin-top:80px; margin-left: 800px;"
                            class="d-block" width="1200px" alt="Human 2">
                        <div class="carousel-caption">
                            <h5 class="display-3 text-start fw-bolder">UniSale Connects Companies and Farmers</h5>
                        </div>
                    </div>
                    <div class="carousel-item blue">
                        <img src="assets/images/human-3.png" style="margin-top:100px; margin-left: 900px;"
                            class="d-block" width="1100px" alt="Human 3">
                        <div class="carousel-caption">
                            <h5 class="display-3 text-start fw-bolder">Unlock the Power of Agribusiness Collaboration
                                with UniSale</h5>
                        </div>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <!-- Trusted by Companies Section -->
            <section class="bg-light py-5">
                <div class="container text-center">
                    <div class="row justify-content-center">
                        <!-- Add company logos here -->
                        <div class="col-md-2 mb-4 mt-4 company-logo">
                            <h3 class>Trusted By:</h3>
                        </div>
                        <div class="col-md-2 mb-4">
                            <img src="https://agorasuperstores.com/assets/images/thumbnail.png" alt="Company 1"
                                class="img-fluid company-logo">
                        </div>
                        <div class="col-md-2 mb-4">
                            <img src="https://tds-images.thedailystar.net/sites/default/files/styles/very_big_201/public/feature/images/meena_bazar_0.jpg?itok=Ig8T9KMF"
                                alt="Company 2" class="img-fluid company-logo">
                        </div>
                        <div class="col-md-2 mb-4">
                            <img src="https://www.tbsnews.net/sites/default/files/styles/big_3/public/images/2020/07/04/shwapno.jpg"
                                alt="Company 3" class="img-fluid company-logo">
                        </div>
                        <div class="col-md-2 mb-4">
                            <img src="data:image/jpeg;base64,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"
                                alt="Company 4" class="img-fluid company-logo">
                        </div>
                        <div class="col-md-2 mb-4">
                            <img src="https://dailyshoppingbd.com/images/logos/24/ds-logo.png" alt="Company 5"
                                class="img-fluid company-logo">
                        </div>
                        <!-- Add more companies as needed -->
                    </div>
                </div>
            </section>

            <section class="container mt-5">
                <h3 class="fw-bolder display-3">Popular Services</h3>
                <div class="d-flex flex-row justify-content-between">
                    <div class="card m-2" style="width: 16rem;">
                        <img class="card-img-top"
                            src="https://img.freepik.com/free-photo/healthy-vegetables-wooden-table_1150-38014.jpg?size=626&ext=jpg&ga=GA1.1.1222169770.1702339200&semt=sph"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class=" fs-3 fw-bolder">Vegetables</p>
                        </div>
                    </div>

                    <div class="card m-2" style="width: 16rem;">
                        <img class="card-img-top"
                            src="https://images.unsplash.com/photo-1619566636858-adf3ef46400b?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8OHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class="fs-3 fw-bolder">Fruits</p>
                        </div>
                    </div>

                    <div class="card m-2" style="width: 16rem;">
                        <img class="card-img-top"
                            src="https://s3-us-west-2.amazonaws.com/photoawardscom/uploads/4103285629/8-198705-20/full/2f230641d90708e7131920986415ca0c.jpg"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class="fs-3 fw-bolder">Fish</p>
                        </div>
                    </div>
                    <div class="card m-2" style="width: 16rem;">
                        <img class="card-img-top"
                            src="https://media.istockphoto.com/id/857308908/photo/raw-meat-assortment-beef-lamb-chicken-on-a-wooden-board.jpg?s=612x612&w=0&k=20&c=prpHvLW_SLuf9nZ0ah17agO9LDYErJ1vqiTCT2dD0lw="
                            alt="Card image cap">
                        <div class="card-body">
                            <p class=" fs-3 fw-bolder">Meat</p>
                        </div>
                    </div>
                    <div class="card m-2" style="width: 16rem;">
                        <img class="card-img-top"
                            src="https://hospitalityinsights.ehl.edu/hubfs/1440/1440x960-spices.jpg"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class=" fs-3 fw-bolder">Spice</p>
                        </div>
                    </div>
                    <div class="card m-2" style="width: 16rem;">
                        <img class="card-img-top"
                            src="https://www.datocms-assets.com/20941/1665663448-what-are-dairy-foods.png?auto=compress&fm=jpg&w=850"
                            alt="Card image cap">
                        <div class="card-body">
                            <p class="fs-3 fw-bolder">Dairy</p>
                        </div>
                    </div>


                </div>
            </section>

            



            <style>
            .image-radio-list {
                list-style-type: none;
                padding: 0;
            }

            .image-radio-list label {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                cursor: pointer;
                border: 2px solid #B2BEB5;
                border-radius: 1rem;
                padding: 10px;
            }

            .image-radio-list input[type="radio"] {
                display: none;
            }

            .image-radio-list img {
                width: 50px;
                height: 50px;
                margin-right: 10px;
                border-radius: 50%;
            }

            .image-radio-list input[type="radio"]:checked+label {
                background-color: #f0f0f0;
                /* Highlight the selected option */
            }
            </style>






            <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="userName">User Name:</label>
                                    <input type="text" class="form-control m-2 rounded-pill" id="userName"
                                        placeholder="Enter User Name" name="username" required>
                                </div>

                                <div class="form-group">
                                    <label for="passWord">Password:</label>
                                    <input type="text" class="form-control m-2 rounded-pill" id="passWord"
                                        placeholder="Enter Password" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="transport">Choose User Type</label>
                                    <ul class="image-radio-list">
                                        <li class="rounded-pill">
                                            <input type="radio" id="1" name="user_type" value="1">
                                            <label for="1"><i
                                                    class="fa-solid fa-circle-user fs-2 text-success me-2"></i>Farmer</label>
                                        </li>
                                        <li class="rounded-pill">
                                            <input type="radio" id="2" name="user_type" value="2">
                                            <label for="2"><i
                                                    class="fa-solid fa-circle-user fs-2 text-primary me-2"></i>Company</label>
                                        </li>
                                        <li class="rounded-pill">
                                            <input type="radio" id="3" name="user_type" value="3">
                                            <label for="3"><i
                                                    class="fa-solid fa-circle-user fs-2 text-dark me-2"></i>Admin</label>
                                        </li>
                                        <li class="rounded-pill">
                                            <input type="radio" id="4" name="user_type" value="4">
                                            <label for="4"><i
                                                    class="fa-solid fa-circle-user fs-2 text-secondary me-2"></i>Transport</label>
                                        </li>
                                    </ul>
                                </div>

                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-secondary rounded-pill">Reset</button>
                                    <button type="submit" class="btn btn-primary rounded-pill"
                                        name="login">Login</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>






























            <!-- JOIN OPTION -->
            <div class="modal fade" id="join">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal header -->
                        <div class="modal-header">
                            <h5 class="modal-title">Select Registration Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">


                            <button class="btn btn-outline-success p-5 w-100 fs-2" data-bs-toggle="modal"
                                data-bs-target="#join_farmer"><i class="fa-solid fa-hat-cowboy mx-2"></i>For
                                Farmers</button>
                            <button class="btn btn-outline-warning p-5 mt-2 w-100 fs-2" data-bs-toggle="modal"
                                data-bs-target="#join_company"><i class="fa-solid fa-building mx-2"></i>For
                                Companies</button>

                        </div>

                    </div>
                </div>
            </div>


        </main>







        <div class="modal fade" id="join_farmer">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-success">
                        <h5 class="modal-title">Farmer Registration with Verification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form method="POST">
                            <div class="form-group">
                                <label for="fullName">Full Name:</label>
                                <input type="text" class="form-control m-2" id="fullName" placeholder="Enter Full Name"
                                    name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="userName">User Name:</label>
                                <input type="text" class="form-control m-2" id="userName" placeholder="Enter User Name"
                                    name="username" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control m-2" id="email" placeholder="Enter Email"
                                    name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="passWord">Password:</label>
                                <input type="text" class="form-control m-2" id="passWord" placeholder="Enter Password"
                                    name="password" required>
                            </div>




                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea class="form-control m-2" id="address" rows="3"
                                    placeholder="Provide info about address" name="address" required></textarea>
                            </div>

                            <!-- USER TYPE FARMER -->

                            <input type="hidden" name="user_type" value="1">

                            <!-- Modal footer -->
                            <div class="modal-footer mt-3">
                                <button type="reset" class="btn btn-secondary">Close</button>
                                <button type="submit" class="btn btn-primary" name="registration">Submit</button>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>





























        <div class="modal fade" id="join_company">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Company Registration with Verification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <form method="POST">
                            <div class="form-group">
                                <label for="fullName">Full Name:</label>
                                <input type="text" class="form-control m-2" id="fullName" placeholder="Enter Full Name"
                                    name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="userName">User Name:</label>
                                <input type="text" class="form-control m-2" id="userName" placeholder="Enter User Name"
                                    name="username" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control m-2" id="email" placeholder="Enter Email"
                                    name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="passWord">Password:</label>
                                <input type="text" class="form-control m-2" id="passWord" placeholder="Enter Password"
                                    name="password" required>
                            </div>




                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea class="form-control m-2" id="address" rows="3"
                                    placeholder="Provide info about address" name="address" required></textarea>
                            </div>

                            <!-- USER TYPE FARMER -->

                            <input type="hidden" name="user_type" value="2">

                            <!-- Modal footer -->
                            <div class="modal-footer mt-3">
                                <button type="reset" class="btn btn-secondary">Close</button>
                                <button type="submit" class="btn btn-primary" name="registration">Submit</button>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>

























        <footer class="container pt-4 mb-0 w-100">
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/app.js"></script>
            <p>&copy; 2023 UniSales, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>

        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>

</body>

</html>