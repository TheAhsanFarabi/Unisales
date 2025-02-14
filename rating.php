 <!--                   FORMULA :
                         5*total 5 star ratings+ 
                        4* total 4 star ratings+
                         3* total 3 star ratings+
                         2* total 2 star ratings+
                          1 * total 1 star 
                          rating divided by total number of users rated for the app -->
<?php

if (isset($_POST['ranking'])) {
    $rate = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    if ($rate >= 1 && $rate <= 5) {
        $userId = $_SESSION['id']; // Assuming you have a user session
        $profileID = $_GET['id'];

        // Check if the user has already rated this profile
        $existingRating = $conn->query("SELECT stars FROM ratings WHERE userID = $userId AND profileID = $profileID")->fetch_assoc();

        if ($existingRating) {
            // User has already rated, update the existing rating
            $conn->query("UPDATE ratings SET stars = $rate WHERE userID = $userId AND profileID = $profileID");
        } else {
            // User is rating for the first time, insert a new rating
            $conn->query("INSERT INTO ratings (userID, profileID, stars) VALUES ($userId, $profileID, $rate)");
        }

        // Calculate the weighted average rating
        $result = $conn->query("SELECT
            (5 * COUNT(CASE WHEN stars = 5 THEN 1 END) +
             4 * COUNT(CASE WHEN stars = 4 THEN 1 END) +
             3 * COUNT(CASE WHEN stars = 3 THEN 1 END) +
             2 * COUNT(CASE WHEN stars = 2 THEN 1 END) +
             1 * COUNT(CASE WHEN stars = 1 THEN 1 END)) /
            COUNT(*) AS weighted_average
            FROM ratings WHERE profileID = $profileID");

        $row = $result->fetch_assoc();
        $weightedAverage = $row['weighted_average'];

        // Update the average rating in the apps table
        $conn->query("UPDATE users SET rating = $weightedAverage WHERE id = $profileID");

        // Success message or redirection
        echo "Rating submitted successfully!";
        // Reload the page using JavaScript with a different approach
    echo '<script>';
    echo 'setTimeout(function() { window.location.href = window.location.href; }, 500);'; // reload after 0.5 seconds
    echo '</script>';
    } else {
        // Invalid rating
        echo "Invalid rating value!";
    }
}

?>



<style>
    /* Optional: Custom styles for the rating form */
    .rating {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 2em;
        color: #aaa;
        cursor: pointer;
    }

    .rating input:checked~label {
        color: #ffc107; /* or your desired color for selected stars */
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }
</style>

<form method="POST">
    <div class="mb-2 d-flex flex-column justify-content-center text-center">
        <label for="rating" class="form-label fs-4">Rate This Profile</label><br>
        <div class="rating d-flex flex-row-reverse justify-content-center">
            <input type="radio" id="star5" name="rating" value="5">
            <label for="star5"><i class="fas fa-star"></i></label>

            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4"><i class="fas fa-star"></i></label>

            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3"><i class="fas fa-star"></i></label>

            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2"><i class="fas fa-star"></i></label>

            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1"><i class="fas fa-star"></i></label>
        </div>
        <button type="submit" name="ranking" class="btn btn-primary mx-auto my-2 rounded-pill">Submit Rating</button>
    </div>
   
</form>