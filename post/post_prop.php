<?php

if (isset($_POST['prop_submit'])) {

    $img_name = $_FILES['prop_img']['name'];
    $img_size = $_FILES['prop_img']['size'];
    $tmp_name = $_FILES['prop_img']['tmp_name'];
    $error = $_FILES['prop_img']['error'];

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $allowed_exs = array("jpg", "jpeg", "png");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $prop_img = uniqid("PROP-", true) . '.' . $img_ex_lc;
            $img_upload_path = "data/props/" . $prop_img;
            move_uploaded_file($tmp_name, $img_upload_path);
        }
    }

    $prop_title = $_POST['prop_title'];
    $prop_details = $_POST['prop_details'];
    $prop_amount = $_POST['prop_amount'];
    $prop_price = $_POST['prop_price'];
    $prop_category = $_POST['prop_category'];
    $prop_location = $_POST['prop_location'];
    $prop_creator = $u['id'];

    $conn->query("INSERT INTO props(p_title,p_details,p_img,p_amount,p_price,p_category,p_location,p_creator) VALUES('$prop_title','$prop_details','$prop_img','$prop_amount','$prop_price','$prop_category','$prop_location','$prop_creator')");
}

?>



<!-- Modal -->
<div class="modal fade" id="propModal" tabindex="-1" role="dialog" aria-labelledby="propModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Create a Prop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prop_title">Title</label>
                        <input type="text" class="form-control" name="prop_title" placeholder="Type your title"
                            required />
                    </div>

                    <div class="form-group">
                        <label for="prop_details">Details</label>
                        <textarea class="form-control" name="prop_details" placeholder="Type details about your prop"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="prop_price">Amount (KG)</label>
                        <input type="number" step="1" min="1" max="100" class="form-control" name="prop_amount"
                            placeholder="Type your amount" required />
                    </div>
                    <div class="form-group">
                        <label for="prop_price">Price (Per KG)</label>
                        <input type="number" step="0.01" min="0" max="10000" class="form-control" name="prop_price"
                            placeholder="Type your price" required />
                    </div>

                    <div class="form-group">
                        <label for="prop_location">Location</label>
                        <select class="form-control" name="prop_location" required>
                            <option value="" disabled selected>Select location</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Sylhet">Sylhet</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prop_category">Category (6 Types)</label>
                        <select class="form-control" name="prop_category" required>
                            <option value="" disabled selected>Select category</option>
                            <option value="Fruits">Fruits</option>
                            <option value="Vegitables">Vegitables</option>
                            <option value="Fish">Fish</option>
                            <option value="Meat">Meat</option>
                            <option value="Dairy">Dairy</option>
                            <option value="Spice">Spice</option>
                        </select>
                    </div>

                    <div class="shadow-lg rounded-5 p-3 mt-2">
                        <div class="d-flex justify-content-between flex-column align-items-center">
                            <img id="frame" src="assets\images\img_empty.svg" width="165" height="127px"
                                style="opacity:0.5;" class="mb-3 rounded-3 img-fluid" />
                            <input type="file" id="formFileLg" name="prop_img" class="form-control rounded-pill"
                                accept="image/png, image/jpeg, image/jpg" onchange="preview()" required />
                        </div>
                    </div>

                    <button type="submit" name="prop_submit" class="btn btn-warning mt-3">Submit</button>
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