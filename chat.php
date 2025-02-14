<?php

include("header.php"); ?>


<?php

$user1_id = $_SESSION['id'];
$user2_id = $_GET['id'];
$user2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user2_id"));


if (isset($_POST['send'])) {
    $chat_message = $_POST['chat_message'];
    $message_type = 'text'; // Default to text
    if (!empty($_FILES['chat_photo']['name'])) {
        // Handle photo upload
        $upload_dir = 'data/chats/';
        $uploaded_file = $upload_dir . basename($_FILES['chat_photo']['name']);
        move_uploaded_file($_FILES['chat_photo']['tmp_name'], $uploaded_file);
        $chat_message = $uploaded_file;
        $message_type = 'photo';
    }

    $chat_message = htmlspecialchars($chat_message);
    $chat_query = "INSERT INTO chats (user1, user2, chat_message, message_type) VALUES ('$user1_id', '$user2_id', '$chat_message', '$message_type')";
    mysqli_query($conn, $chat_query) or die(mysqli_error($conn));
}




?>

<div class="d-flex flex-row justify-content-center mb-5 text-light mt-5">

    <div
        class="d-flex flex-column px-3 align-items-center bg-light text-dark border border-2 rounded-5 py-3 mx-2">
        <i class="fa-solid fa-user display-4"></i>
        <h1 class=" fs-2"><?php echo $user2['name'];?></h1>
        <button class="btn btn-secondary rounded-pill">View Profile</button>
    </div>

</div>


<div class="container py-5 my-5" id="contentBlock">

</div>

<div class="mt-5 pt-5"></div>


<form method="POST" enctype="multipart/form-data" class="fixed-bottom m-5">
    <div class="form-group px-3 mx-5 d-flex flex-row py-3 rounded-pill">
        <input type="text" class="form-control fs-4 rounded-pill ps-4 bg-light" name="chat_message" placeholder="Type a Message">
        
        <!-- Image preview container -->
        <div class="position-relative">
            <label for="chat_photo" class="fs-2 border border-3 ms-2 rounded-circle p-3 btn bp-shadow">
                <img id="frame" src="assets/images/img_empty.svg" width="50px" height="50px" style="opacity:0.5;" class="rounded-3 img-fluid" />
            </label>
            <input type="file" id="chat_photo" name="chat_photo" style="display: none;" onchange="preview(event);">
        </div>
        
        <button type="submit" name="send" class="fs-2 border border-0 ms-2 rounded-circle p-3 btn btn-primary bp-shadow">
            <i class="fa-solid fa-paper-plane text-white fs-4"></i>
        </button>
    </div>
</form>

<!-- Modal structure for image preview -->
<div class="modal" tabindex="-1" role="dialog" id="imagePreviewModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalPreviewImage" class="img-fluid" alt="Preview Image">
            </div>
        </div>
    </div>
</div>

<script>
function preview(event) {
    const frame = document.getElementById('frame');
    const modalPreviewImage = document.getElementById('modalPreviewImage');
    
    frame.src = URL.createObjectURL(event.target.files[0]);

    // Show the modal preview
    const imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    imagePreviewModal.show();

    // Update the modal preview's image source
    modalPreviewImage.src = URL.createObjectURL(event.target.files[0]);
}

// Clear the modal preview's image source when the modal is closed
document.getElementById('imagePreviewModal').addEventListener('hidden.bs.modal', function () {
    const modalPreviewImage = document.getElementById('modalPreviewImage');
    modalPreviewImage.src = "";
});
</script>





<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

<script>
function reloadContent() {
    // Use AJAX to reload the contentBlock
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Update the contentBlock with the new content
            document.getElementById("contentBlock").innerHTML = this.responseText;
        }
    };
    // Make a request to the server-side script that fetches the updated content
    xhttp.open("GET", "fetch_chat.php?id=<?php echo $user2_id; ?>", true);
    xhttp.send();
}

// Call the function every second
setInterval(reloadContent, 500);
</script>


<?php include('footer.php') ?>

