<?php include('header.php') ?>


<?php 
$sql = "SELECT * FROM users WHERE id=" . $_GET['id'];
$result = $conn->query($sql);
$user = $result->fetch_assoc(); 





if (isset($_POST['save_profile'])) {
    // Get the submitted data
    $newName = $_POST['name'];
    $newLocation = $_POST['location'];
    $newThemeColor = $_POST['theme_color'];

    // Assuming $current_user is the logged-in user's ID
    $current_user = $u['id'];

    // Update the user's profile details in the database
    $sqlUpdateProfile = "UPDATE users 
                        SET name='$newName', address='$newLocation', theme_color='$newThemeColor'
                        WHERE id='$current_user'";

    mysqli_query($conn, $sqlUpdateProfile);

    echo '<script>';
    echo 'setTimeout(function() { window.location.href = window.location.href; }, 100);'; 
    echo '</script>';
}





// Profile Picture Update
// If the 'profile_change' POST parameter is set, update the user's profile picture in the database
if (isset($_POST['profile_change'])) {
    // Get information about the uploaded image
    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $error = $_FILES['my_image']['error'];
  
    // If there is no error with the upload, move the uploaded image to the 'signinup/profile_pic' directory
    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
  
        $allowed_exs = array("jpg", "jpeg", "png"); 
  
        if (in_array($img_ex_lc, $allowed_exs)) {
            $profile_pic = uniqid("IMG-", true).'.'.$img_ex_lc;  
            $img_upload_path = 'data/profiles/'.$profile_pic;
            copy($tmp_name, $img_upload_path);
        }
    } 
    // Update the user's profile picture in the database
    $current_user = $u['id'];
    $sql_profile = "UPDATE users SET img='$profile_pic' WHERE id='$current_user'";
    mysqli_query($conn, $sql_profile);

    
}

$current_user = $user['id'];
if($user['user_type']==2){
    $total_posts = ($conn->query("SELECT COUNT(*) AS postCount FROM gigs WHERE g_creator = $current_user"))->fetch_assoc();
    $total_sales = ($conn->query("SELECT COUNT(*) AS postCount FROM orders WHERE buyer = $current_user AND is_paid_full=1"))->fetch_assoc();

}
else {

    $total_posts = ($conn->query("SELECT COUNT(*) AS postCount FROM props WHERE p_creator = $current_user"))->fetch_assoc();
    $total_sales = ($conn->query("SELECT COUNT(*) AS postCount FROM orders WHERE seller = $current_user AND is_paid_full=1"))->fetch_assoc();

}





?>













<!-- PROFILE TEMPLATE BY MUEID-->

<style>
    .image-container {
        position: relative;
        overflow: hidden;
    }

    .image-container img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        /* Maintain aspect ratio and cover the container */
    }
    </style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile details -->
            <div class="card">

                <div class="card-header text-center text-dark image-container" style="background:<?= $user['theme_color'] ?>;">

                    <img class="mb-2 bd-placeholder-img profile-pic img-thumbnail rounded-circle" 
                        alt="profile_pic" data-bs-toggle="modal" data-bs-target="#profileModal"
                        <?php if($user['img']) { ?> src="data/profiles/<?= $user['img'] ?>" <?php } else { ?>
                        src="assets/images/empty.jpg" <?php } ?> />


                    <h2> <?php echo $user['name']; ?><?php if($user['is_verified']==1) {?><i class="ms-2 fa-solid fa-circle-check"><?php } ?></i></h2>
                    <p>@<?php echo $user['username']; ?></p>
                </div>

                <!-- Bio -->
                <div class="card m-4 rounded-pill" style="border:10px solid <?= $user['theme_color'] ?>;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Bio</h5>
                        <p class="card-text text-center">"<?= $user['bio'] ?>"</p>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Location:</strong><?php echo $user['address']; ?></li>

                        <?php if($u['user_type']==1) { ?>
                        <li class="list-group-item"><strong>Provides:</strong> Vegetables, Fruits, Fish </li>
                        <li class="list-group-item"><strong>Experience:</strong> 2 Years</li>
                        <?php } else { ?>
                        <li class="list-group-item"><strong>Needs:</strong> Vegetables, Milk, Oil </li>
                        <li class="list-group-item"><strong>Founded:</strong> 5 Years ago</li>
                        <?php } ?>
                    </ul>
                </div>



                <!-- Featured Photos -->
                <div class="card-body text-center">
                    <h5>Featured Photos</h5>
                    <img src="https://cdn.pixabay.com/photo/2015/05/04/10/16/vegetables-752153_1280.jpg" alt="Photo 2"
                        class="img-fluid mx-1 w-25">
                    <img src="https://cdn.pixabay.com/photo/2015/05/04/10/16/vegetables-752153_1280.jpg" alt="Photo 2"
                        class="img-fluid mx-1 w-25">
                    <img src="https://cdn.pixabay.com/photo/2015/05/04/10/16/vegetables-752153_1280.jpg" alt="Photo 2"
                        class="img-fluid mx-1 w-25">
                </div>

                <!-- YouTube video iframe -->
                <div class="embed-responsive embed-responsive-16by9 my-4 mx-auto">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VIDEO_ID"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <!-- Profile card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Profile Stats</h5>
                    <div class="d-flex flex-row justify-content-between container">
                        <div class="d-flex flex-column pe-3">
                            <p class="fs-3 text-primary fw-bolder m-0"><?= $total_posts['postCount'] ?></p>
                            <p class="fs-5 mt-1 fw-bolder">Total Posts</p>
                        </div>
                        <div class="d-flex flex-column ">
                            <p class="fs-3 text-warning fw-bolder m-0"><?= $total_sales['postCount'] ?></p>
                            <p class="fs-5 mt-1 fw-bolder">Total Sales</p>
                        </div>
                        <div class="d-flex flex-column ">
                            <p class="fs-3 text-success fw-bolder m-0"><?= number_format($user['rating'], 1) ?></p>
                            <p class="fs-5 mt-1 fw-bolder">Total Rating</p>
                        </div>



                    </div>
                </div>
            </div>

            <!-- Favorite quote -->
            <div class="card mt-4">
                <div class="card-body row">

                    <?php if($u['id']!=$_GET['id']) { ?>

                    <?php include('rating.php') ?>
                    <?php } else { ?>
                    <!-- Edit Profile Button -->
                    <a class="btn btn-primary col mx-4 rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">Edit Profile</a>
                    <a href="statistics.php" class="btn btn-info col mx-4 rounded-pill">View Statistics</a>
                    <?php } ?>



                </div>
            </div>

            <!-- Posts -->
            <?php include('profile_post.php'); ?>
        </div>
    </div>
</div>






















<!-- Modal for Editing Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Profile Form -->
                <form method="post">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="editName" name="name"
                            value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLocation" class="form-label">Location:</label>
                        <input type="text" class="form-control" id="editLocation" name="location"
                            value="<?php echo $user['address']; ?>" required>
                    </div>

                    <div class="mb-3">

                        <label for="themeColor" class="form-label col">Choose Theme Color:</label><br>
                        <span id="selectedColorIcon" class="ms-2 display-3 col">&#x25cf;</span>

                        <div class="d-flex align-items-center">
                            <select class="form-select" id="themeColor" name="theme_color">
                                <option value="#3498db" data-icon="&#x25cf;"> Blue</option>
                                <option value="#2ecc71" data-icon="&#x25cf;"> Green</option>
                                <option value="#e74c3c" data-icon="&#x25cf;"> Red</option>
                                <option value="#f39c12" data-icon="&#x25cf;"> Orange</option>
                                <option value="#9b59b6" data-icon="&#x25cf;"> Purple</option>
                            </select>

                        </div>
                    </div>
                    <button type="submit" name="save_profile" class="btn btn-primary">Save Changes</button>
                </form>

            </div>
        </div>
    </div>
</div>








<script>
// Update the selected color icon when the themeColor select changes
document.getElementById('themeColor').addEventListener('change', function() {
    const selectedColor = this.value;
    document.getElementById('selectedColorIcon').style.color = selectedColor;
});
</script>














<!-- Modal window for user profile picture display -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal title -->
                <h5 class="modal-title" id="profileModalLabel">Profile Picture</h5>
                <!-- Close button -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <!-- Display user profile picture -->
                <img src="data/profiles/<?php if($user['img']) { ?><?= $user['img'] ?><?php }else {?>empty.jpg <?php } ?>"
                    width="270px" height="270px" class="mb-2" />
            </div>
            <!-- If user is the owner of the profile, show "Change profile picture" button -->
            <?php if($user['id']==$u['id']) {?>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#profileUpdate">Change profile picture</button>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Modal window for updating user profile picture -->
<div class="modal" id="profileUpdate" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal title -->
                <h5 class="modal-title" id="profileModalLabel">Change profile picture</h5>
                <!-- Close button -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <!-- BY MUEID -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="d-flex justify-content-between flex-column align-items-center">
                        <!-- Alert user to use a square size photo of low size (1MB-5MB) -->
                        <div class="alert alert-danger rounded-5" role="alert">
                            <p class="fs-4">You must use a square size photo of low size (1MB-5MB)</p>
                        </div>
                        <!-- Display image preview and allow user to upload new image -->
                        <img id="frame" src="assets\images\empty.jpg" width="220px" class="mb-5 rounded-pill" />
                        <input type="file" id="formFileLg" name="my_image"
                            class="form-control form-control-lg rounded-pill" accept="image/png, image/jpeg, image/jpg"
                            onchange="preview()" required>
                        <!-- Submit button to update profile picture -->
                        <input type="submit" name="profile_change" class="btn btn-primary mt-5 mb-3 shadow rounded-pill"
                            value="Update profile pic" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

function preview() {
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>


















<?php include('footer.php') ?>