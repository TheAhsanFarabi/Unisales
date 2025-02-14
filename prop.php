<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="album py-5 bg-body-tertiary">
    <h2 class="text-center">Latest Props</h2>

    <form class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group text-center">
                    <label for="location" class="fs-5 text-muted">Filter by Location:</label>
                    <select class="form-control rounded-pill" name="location" id="location">
                        <option value="all">All Locations</option>
                        <option value="Dhaka">Dhaka</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Sylhet">Sylhet</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group text-center">
                    <label for="price" class="fs-5 text-muted">Filter by Price:</label>
                    <select class="form-control rounded-pill" name="price" id="price">
                        <option value="10000">0-10000</option>
                        <option value="1000">0-1000</option>
                        <option value="100">0-100</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group text-center">
                    <label for="rank" class="fs-5 text-muted">Filter by Company Rank:</label>
                    <select class="form-control rounded-pill" name="rank" id="rank">
                        <option value="all">All</option>
                        <option value="5">5</option>
                        <option value="4">4</option>
                        <option value="3">3</option>
                        <option value="2">2</option>
                        <option value="1">1</option>
                    </select>
                </div>
            </div>
        </div>
    </form>



    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="propsContainer">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col">
                    <div class="card text-center mt-4 rounded-5">
                        <div class="card-header">
                            <img src="data/profiles/<?= $row['img'] ?>" alt="Profile Picture" width="30" height="30"
                                class="rounded-circle">
                            <a href="profile.php?id=<?= $row['id'] ?>"><?php echo $row['name']; ?></a>
                        </div>
                        <img src="data/props/<?= $row['p_img'] ?>" class="bd-placeholder-img card-img-top"
                            alt="Image description" style="height:200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['p_title'] ?></h5>
                            <p class="card-text"><?php echo $row['p_details'] ?></p>
                            <p class="text-muted">Amount: <?php echo $row['p_amount'] ?> KG</p>
                            <p class="text-muted">Price: <?php echo $row['p_price'] ?> BDT/KG</p>
                            <p class="text-danger">Total Request: <?php echo $row['p_requests'] ?></p>
                            <a href="single-prop.php?id=<?= $row['p_id'] ?>"
                                class="btn btn-outline-dark rounded-pill">Apply</a> 
                        </div>
                        <div class="card-footer text-muted">
                            <?php echo date("F j, Y, g:i a", strtotime($row['p_time'])); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            function updateProps() {
                var location = $("#location").val();
                var price = $("#price").val();
                var rank = $("#rank").val();

                $.ajax({
                    type: "POST",
                    url: "filter_props.php", // Update with your actual PHP file
                    data: {
                        location: location,
                        price: price,
                        rank: rank
                    },
                    success: function (response) {
                        $("#propsContainer").html(response);
                    }
                });
            }

            $("#location, #price, #rank").on("change", function () {
                updateProps();
            });

            // Initial load of all props
            updateProps();
        });
    </script>
</div>