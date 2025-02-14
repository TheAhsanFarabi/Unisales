<?php include('header.php') ?>
<?php 

if(isset($_POST['update'])) {
    $new_email = $_POST['new_email'];
    $old_password = $_POST['old_password'];
    
    // Assuming $u is defined somewhere in your code
    // Make sure to retrieve the user's information from the database

    // Assuming $conn is your database connection
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=".$u['id']);
    $u = mysqli_fetch_assoc($result);

    if(password_verify($old_password, $u["password"])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        
        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($conn, "UPDATE users SET email=? , password=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssi", $new_email, $new_password, $u['id']);
        mysqli_stmt_execute($stmt);

        // Set a flag for JavaScript to indicate successful order processing
        echo '<script>var settings_updated = true;</script>';
    } else {
        echo "Invalid Info";
    }
}


if(isset($_POST['delete'])) {
    // Assuming $u is defined somewhere in your code
    // Make sure to retrieve the user's information from the database

    // Assuming $conn is your database connection
    if(mysqli_query($conn, "DELETE FROM users WHERE id=".$u['id'])){
        // Redirect to the homepage or login page after account deletion
    session_destroy();
    //header("location:index.php");
    echo '<script>var account_deleted = true;</script>';

    }

    
}
?>
<div class="container m-5">
    <h1>SETTINGS</h1>
    <form method="POST">
        <div class="form-group">
            <label for="name">Update your email</label>
            <input type="text" class="form-control" name="new_email" value="<?=$u['email']?>" required />
        </div>
        <div class="form-group">
            <label for="name">Type old password</label>
            <input type="password" class="form-control" name="old_password" required />
            <label for="name">Type new password</label>
            <input type="password" class="form-control" name="new_password" required />
        </div>
        <button type="submit" name="update" class="btn btn-primary mt-3">Update Settings</button>
    </form>

     <!-- Add a delete button -->
     <form method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
        <button type="submit" name="delete" class="btn btn-danger mt-3">Delete Account</button>
    </form>
</div>

<!-- ... Your PHP and HTML code ... -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Check the settings_updated flag and show the toast if true
    if (typeof settings_updated !== 'undefined' && settings_updated) {
        var toast = new bootstrap.Toast(document.getElementById('successToast'));
        toast.show();
    }
    // Check the account_deleted flag and show the toast if true
    if (typeof account_deleted !== 'undefined' && account_deleted) {
        var toast = new bootstrap.Toast(document.getElementById('sadToast'));
        toast.show();
    }
});
</script>

<!-- ... Your PHP and HTML code ... -->

<!-- Add this Bootstrap Toast element somewhere in your HTML -->
<div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 100px; right: 0;">
    <div class="toast-header bg-success">
        <strong class="me-auto">Success</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Settings Updated
    </div>
</div>
<div id="sadToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 100px; right: 0;">
    <div class="toast-header bg-danger">
        <strong class="me-auto">Account Deleted</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <p>We are sorry to see you go</p>
        <a class="btn btn-outline-info" href="registration.php">Good Bye</a>
    </div>
</div>

<?php include('footer.php') ?>
