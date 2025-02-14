<?php include("header.php") ?>


<?php

$applicant = $_SESSION['id'];
$prop_id = $_GET['id'];
$prop = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM props JOIN users ON props.p_creator = users.id WHERE p_id=$prop_id"));


if (isset($_POST['submit_request_prop'])) {
    $img_name = $_FILES['prop_img']['name'];
    $img_size = $_FILES['prop_img']['size'];
    $tmp_name = $_FILES['prop_img']['tmp_name'];
    $error = $_FILES['prop_img']['error'];
  
  
    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png"); 
  
        if (in_array($img_ex_lc, $allowed_exs)) {
            $prop_img = uniqid("PROPR-", true).'.'.$img_ex_lc;  
            $img_upload_path = "data/requests/".$prop_img;
            copy($tmp_name, $img_upload_path);
        }
    } 
    else {
      $prop_img = 0;
    }

    $request_message = $_POST['request_prop'];
    //$request_message = htmlspecialchars($request_message);
    $request_query = "INSERT INTO requests (prop_id, user_id, request_message, request_img) VALUES ('$prop_id', '$applicant', '$request_message', '$prop_img')";
    mysqli_query($conn, $request_query);

    $total_requests = ($conn->query("SELECT COUNT(*) AS postCount FROM requests WHERE prop_id = $prop_id"))->fetch_assoc();
    $request_count = $total_requests['postCount'];
    $request_update = "UPDATE props SET p_requests = $request_count WHERE p_id=$prop_id";
    mysqli_query($conn, $request_update);


}

// DELETE REQUEST
if (isset($_POST['delete_request'])) {
    mysqli_query($conn, "DELETE FROM requests WHERE request_id =".$_POST['request_id']);
    $total_requests = ($conn->query("SELECT COUNT(*) AS postCount FROM requests WHERE prop_id = $prop_id"))->fetch_assoc();
    $request_count = $total_requests['postCount'];
    $request_update = "UPDATE props SET p_requests = $request_count WHERE p_id=$prop_id";
    mysqli_query($conn, $request_update);
}


if(isset($_POST['update_prop'])){
    $p_title = $_POST['prop_title'];
    $p_details = $_POST['prop_details'];
    $p_price = $_POST['prop_price'];
    
    // Assuming $conn is your mysqli connection
    $stmt = $conn->prepare("UPDATE props SET p_title=?, p_details=?, p_price=? WHERE p_id=?");
    
    // Bind parameters
    $stmt->bind_param("ssdi", $p_title, $p_details, $p_price, $prop_id);
    
    // Execute the statement
    $stmt->execute();
    
    // Close the statement
    $stmt->close();
   // Reload the page using JavaScript with a different approach
   
   // Reload the page using JavaScript with a different approach
   echo '<script>';
   echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
   echo '</script>';
}



$requests = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM requests JOIN users ON requests.user_id=users.id WHERE prop_id=$prop_id"), MYSQLI_ASSOC);


if (isset($_POST['order'])) {
    $buyer = $_POST['buyer'];
    $seller = $prop['p_creator'];
    $propID = $prop['p_id'];
    mysqli_query($conn, "INSERT INTO orders (seller, buyer, prop_id) VALUES('$seller','$buyer','$propID')");
    mysqli_query($conn, "UPDATE props SET p_flag=1 WHERE p_id=$propID");

    // Set a flag for JavaScript to indicate successful order processing
    echo '<script>var orderProcessed = true;</script>';
}
?>

?>


<div class="container my-5">
    <div class="row">
        <div class="col">
            <img src="data/props/<?= $prop['p_img'] ?>" class="img-thumbnail rounded-5" width="400px" />
        </div>
        <div class="col text-start">
            <h1 class="fs-1 fw-bold"><?= $prop['p_title'] ?></h1>
            <p class="fs-4"><b>Details: </b><?= $prop['p_details'] ?></p>
            <p class="fs-5"><b>Amount: </b><?= $prop['p_amount'] ?> <small class="text-muted">KG</small></p>
            <p class="fs-5"><b>Price: </b><?= $prop['p_price'] ?> Per <small class="text-muted">KG</small></p>
            <p class="fs-5"><b>location: </b><?= $prop['p_location'] ?></p>
            <p class="fs-5"><b>Category: </b><?= $prop['p_category'] ?></p>

            <div class="d-flex flex-row bg-light border border-3 rounded-pill w-75 mt-3">
                <img src="data/profiles/<?= $prop['img']?>" alt="Profile Picture" width="90" height="90"
                    class="rounded-circle shadow">
                <div class="container">
                    <p class="fs-3 text-muted">Seller: <a
                            href="profile.php?id=<?=$prop['id']?>"><?php echo $prop['name']; ?></a></p>
                    <small><b>Posted:</b> <?php echo date("F j, Y, g:i a", strtotime($prop['p_time'])); ?></small>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container text-center my-2">
    <!-- Button trigger modal -->
    <?php if($applicant!=$prop['p_creator']){?>
    <button type="button" class="btn btn-lg btn-primary rounded-pill" data-bs-toggle="modal"
        data-bs-target="#request_prop">
        Apply Now
    </button>
    <?php } else { ?>
    <button type="button" class="btn btn-lg btn-primary rounded-pill" data-bs-toggle="modal"
        data-bs-target="#updateProp">
        Update
    </button>
    <?php } ?>
</div>




<div class="album py-5 bg-body-tertiary">
    <h2 class="text-center">All requests</h2>

    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach($requests as $r) { ?>
            <div class="col">
                <div class="card shadow-sm text-center mt-4">
                    <div class="card-header">
                        <?php echo "By " . $r['name']; ?>
                    </div>

                    <div class="card-body">
                        <?php if($r['request_img']){ ?>
                        <img src="data/requests/<?=$r['request_img'] ?>" class="rounded-5 img-thumbnail" width="200px"
                            height="200px" />
                        <?php } ?>
                        <h5 class="card-title"><?php echo $r['request_message']?></h5>

                        <?php if($applicant==$prop['p_creator']){?>
                        <form method="POST" id="orderForm">
                            <input type="hidden" name="buyer" value="<?= $r['id'] ?>">
                            <button type="submit" class="btn btn-warning" name="order"> Aprove </button>
                        </form>
                        <a href="chat.php?id=<?= $r['id'] ?>" class="btn btn-secondary">Chat Now</a>
                        <?php } else { ?>
                        <div class="d-flex flex-row justify-content-center">
                            <form method="POST">
                                <input type="hidden" name="request_id" value="<?= $r['request_id'] ?>">
                                <input type="submit" name="delete_request" class="btn btn-danger rounded-pill mx-1"
                                    value="Delete">
                            </form>
                            <a href="chat.php?id=<?= $prop['p_creator'] ?>"
                                class="btn btn-secondary rounded-pill mx-1">Chat Now</a>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo date("F j, Y, g:i a", strtotime($r['time'])); ?>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="request_prop" tabindex="-1" role="dialog" aria-labelledby="request_propTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Request for props</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">


                    <div class="form-group">
                        <label for="request_prop">Write your request</label>
                        <textarea class="form-control m-2" id="request_prop" rows="5"
                            placeholder="Write details about your request" name="request_prop" required></textarea>
                    </div>

                    <div class="shadow-lg rounded-5 p-3 mt-2">
                        <div class="d-flex justify-content-between flex-column align-items-center">
                            <img id="frame" src="assets\images\img_empty.svg" width="165" height="127px"
                                style="opacity:0.5;" class="mb-3 rounded-3 img-fluid" />
                            <input type="file" id="formFileLg" name="prop_img" class="form-control rounded-pill"
                                accept="image/png, image/jpeg, image/jpg" onchange="preview()">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-primary" name="submit_request_prop">Submit</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>














<!-- UPDATE Modal -->
<div class="modal fade" id="updateProp" tabindex="-1" role="dialog" aria-labelledby="propModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Update your Prop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prop_title">Title</label>
                        <input type="text" class="form-control" name="prop_title" value="<?= $prop['p_title'] ?>"
                            required />
                    </div>

                    <div class="form-group">
                        <label for="prop_details">Details</label>
                        <textarea class="form-control" name="prop_details" required><?= $prop['p_details'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="prop_price">Price</label>
                        <input type="number" step="0.01" min="0" max="10000" class="form-control" name="prop_price"
                            value="<?= $prop['p_price'] ?>" required />
                    </div>



                    <button type="submit" name="update_prop" class="btn btn-warning mt-3">Update</button>
                </form>
            </div>

        </div>
    </div>
</div>




<!-- ... Your PHP and HTML code ... -->

<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script> -->

<script>
function preview() {
    frame.src = URL.createObjectURL(event.target.files[0]);
}
document.addEventListener("DOMContentLoaded", function() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Check the orderProcessed flag and show the toast if true
    if (typeof orderProcessed !== 'undefined' && orderProcessed) {
        var toast = new bootstrap.Toast(document.getElementById('successToast'));
        toast.show();
    }
});
</script>

<!-- ... Your PHP and HTML code ... -->

<!-- Add this Bootstrap Toast element somewhere in your HTML -->
<div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
    style="position: absolute; top: 100px; right: 0;">
    <div class="toast-header bg-success">
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Approved Successfully <br>
        <a class="btn btn-info" href="orders.php">Check your orders</a>
    </div>
</div>







<?php include("footer.php"); ?>