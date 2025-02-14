<?php


if(isset($_POST['gig_submit'])){

  $img_name = $_FILES['gig_img']['name'];
  $img_size = $_FILES['gig_img']['size'];
  $tmp_name = $_FILES['gig_img']['tmp_name'];
  $error = $_FILES['gig_img']['error'];


  if ($error === 0) {
      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);
      $allowed_exs = array("jpg", "jpeg", "png"); 

      if (in_array($img_ex_lc, $allowed_exs)) {
          $gig_img = uniqid("GIG-", true).'.'.$img_ex_lc;  
          $img_upload_path = "data/gigs/".$gig_img;
          copy($tmp_name, $img_upload_path);
      }
    }
    $gig_title = $_POST['gig_title'];
    $gig_details = $_POST['gig_details'];
    $gig_amount = $_POST['gig_amount'];
    $gig_price = $_POST['gig_price'];
    $gig_category = $_POST['gig_category'];
    $gig_location = $_POST['gig_location'];
    $gig_creator = $u['id'];

    $conn->query("INSERT INTO gigs(g_title,g_details,g_img,g_amount,g_price,g_category,g_location,g_creator)
    VALUES('$gig_title','$gig_details','$gig_img', '$gig_amount', '$gig_price','$gig_category','$gig_location','$gig_creator')");
 
}
?>



<!-- Modal -->
<div class="modal fade" id="gigModal" tabindex="-1" role="dialog" aria-labelledby="gigModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Create a gig</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="gig_title">Title</label>
                        <input type="text" class="form-control" name="gig_title" placeholder="Type your title"
                            required />
                    </div>

                    <div class="form-group">
                        <label for="gig_details">Details</label>
                        <textarea class="form-control" name="gig_details" placeholder="Type details about your gig"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="gig_price">Amount (KG)</label>
                        <input type="number" step="1" min="1" max="100" class="form-control" name="gig_amount"
                            placeholder="Type your amount" required />
                    </div>
                    <div class="form-group">
                        <label for="gig_price">Price (Per KG)</label>
                        <input type="number" step="0.01" min="0" max="10000" class="form-control" name="gig_price"
                            placeholder="Type your price" required />
                    </div>

                    <div class="form-group">
                        <label for="gig_location">Location</label>
                        <select class="form-control" name="gig_location" required>
                            <option value="" disabled selected>Select location</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Sylhet">Sylhet</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gig_category">Category (6 Type)</label>
                        <select class="form-control" name="gig_category" required>
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
                            <input type="file" id="formFileLg" name="gig_img" class="form-control rounded-pill"
                                accept="image/png, image/jpeg, image/jpg" onchange="preview()">
                        </div>
                    </div>

                    <button type="submit" name="gig_submit" class="btn btn-warning mt-3">Submit</button>
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