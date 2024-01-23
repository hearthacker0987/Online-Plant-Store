<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width: 600px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Add To Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
            include('./dbConnection.php');
            $user_id = $_SESSION['user_id'];
            $query = "SELECT p. * ,a.prod_quantity  FROM products AS p JOIN add_to_cart AS a ON p.prod_id = a.prod_id WHERE user_id = '$user_id'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) > 0){
                while($rows = mysqli_fetch_assoc($result)){
        ?>
        <div class="card mb-3 addToCardList d-flex flex-row p-2" style="max-width: 540px;">
            <div class="row g-0">
                <input type="hidden" class="prod_id" value="<?php echo $rows['prod_id'];?>">
                <div class="col-md-4 d-flex align-items-center">
                    <img src="./Admin/<?php echo $rows['prod_img']; ?>" class="img-fluid img-thumbnail rounded-start w-100" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body addToCartBody">
                        <h5 class="card-title"><?php echo $rows['prod_name']; ?></h5>
                        <p class="card-text text-trun"><?php echo $rows['prod_desc']; ?></p>
                        <div class="d-flex justify-content-between align-items-center d">
                            <input type="hidden" id="prod_price" class="prod_price" value="<?php echo $rows['price']; ?>">
                            <strong class="price">Rs <span class="db_price"><?php echo $rows['price']; ?></span>/-</strong>
                            <div class="d-flex justify-content-center align-items-center quantytyBtn">
                                <div class="decrement rounded me-2 fs-4" ><i class="bi bi-dash"></i></div>
                                <input type="number" name="quantityCount" id="quantityCount" min="1" max="1000" value="<?php echo $rows['prod_quantity'];?>" class="form-control quantityCount" style="width: 60px;">
                                <div class="increment rounded fs-4 ms-2"><i class="bi bi-plus"></i></div>
                            </div>
                        </div>
                        <?php if($rows['stock'] < 10){
                            echo '<div class="text-danger">'.$rows['stock'].' Products Stock available only</div>';
                         } ?>
                    </div>
                </div>
            </div>
            <div class="button">
                <button type="button" class="btn-close text-danger" onclick="removeItem(<?php echo $rows['prod_id']; ?>)"></button>
            </div>
        </div>
        <?php
                }
            }
            else
            {
                echo'<div class="d-flex justify-content-center align-items-center w-100 h-100">
                        <div class="alert alert-warning">Your cart is currently empty.</div>
                    </div>';
            }
        ?>
        <div>
            <hr>
            <div class="d-flex justify-content-between">
                <h4 class="text-center">Grand Total</h4>
                <h4>Rs <span class="gt" id="gt">1200</span>/-</h4>
            </div>
            <div class="text-center">
                <a href="./checkout.php" name="checkoutBtn" id="checkoutBtn" class="btn btn-success">
                    Checkout
                </a>
            </div>
        </div>
    </div>
</div>