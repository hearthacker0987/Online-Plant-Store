<?php
include('./Components/header.php')
?>
<?php
if (!isset($_GET['product_id']) || !isset($_GET['cate_id'])) {
    header('location: index.php');
}
?>


<div class="container-fluid">
    <?php
    if (isset($_GET['product_id']) && isset($_GET['cate_id'])) {
        $prod_id = $_GET['product_id'];
        $cate_id = $_GET['cate_id'];
        include('./dbConnection.php');
        $query = "SELECT * FROM products WHERE prod_id = '$prod_id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    ?>
            <div class="card mb-3 mt-5" style="max-width: 100%;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="./Admin/<?php echo $row['prod_img'] ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['prod_name'] ?></h5>
                            <p class="card-text"><?php echo $row['prod_desc'] ?></p>
                            <h5>Rs <span><?php echo number_format($row['price'], 2); ?></span></h5>
                            <p class="card-text">Update <small class="text-body-secondary"><?php echo $row['updated_at'] ?></small></p>
                            <div class="stockMessage text-center mt-2">
                                <span class="text-danger ">
                                    <?php if (isset($row['stock'])) {
                                        if ($row['stock'] == 0) {
                                            echo "<i>Out of Stock</i>";
                                        }
                                    } ?>
                                </span>
                                <div>
                                    <button type="submit" class="btn btn-dark addToCardProdBtn mt-1">
                                        Add To Cart
                                        <input type="hidden" name="add_to_cart_prod_id" id="add_to_cart_prod_id" class="add_to_cart_prod_id" value="<?php if (isset($row['prod_id'])) {
                                                                                                                                                        echo $row['prod_id'];
                                                                                                                                                    } ?>">
                                        <div class="spinner-border spinner-border-sm text-light ms-2 addToCardProdLoading" role="status" style="display: none;"></div>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        } else {
            echo '<div class="alert alert-warning">Product not found!</div>';
        }
    }
    ?>
    <!------------------- Review Section -------------------->
    <div class="review mt-4 mb-5">
            <?php 
                $selCmntQ = "SELECT * FROM user_feedback AS f 
                    JOIN users AS u ON f.user_id = u.user_id WHERE prod_id = '{$_GET['product_id']}'";
                $runQ = mysqli_query($conn,$selCmntQ);
                if($result){
                    echo '<h4 class=" text-center p-3" style="background-color: #f4f4f4;">'.mysqli_num_rows($runQ).' Reviews For This Products</h4>';
                    while($rows = mysqli_fetch_assoc($runQ)){
            ?>
                <div class="row mt-5">
                    <div class="col-sm-2 col-md-2 col-lg-3 d-flex align-items-center" style="width: 100px;">
                        <img src="./user-img.jpg" alt="" class="w-100 rounded">
                    </div>
                    <div class="col-sm-10 col-md-10 col-lg-9  d-flex flex-column">
                        <p>by<span class="text-danger"><strong> <?php echo $rows['user_name'] ?></span></strong> | <span><?php echo $rows['date'] ?></span></p> 
                        <p>
                            <?php echo $rows['comment'] ?>
                        </p>
                    </div>
                </div> 
                <!-- Admin Reply Review  -->
                <?php if(isset($rows['admin_reply']) && $rows['admin_reply'] != null){ ?>
                
                <div class="mt-1 mb-3 " style="margin-left: 100px;">
                    <div class="d-flex">
                        <div class="d-flex align-items-center" style="width: 20px;">
                            <img src="./user-img.jpg" alt="" class="w-100 rounded">
                        </div>
                        <div class="col-sm-10 col-md-10 col-lg-8">Reply by <span class="text-danger"><strong>Admin</strong></span> | <span><?php echo $rows['reply_date'] ?></span></div>
                    </div>
                    <div class="ms-4 col-md-8 col-lg-8 ">
                        <p class="text-justify"><?php echo $rows['admin_reply'];?> </p>
                    </div>
                </div> 
                <?php
                } 
                ?>
                <hr>
                <?php        
                    }
                }
            ?>
                <div class="p-2 mt-4">
                    <form action="./code.php" method="post">
                        <h5>Add A REVIEW</h5>
                        <div class="form-floating col-md-6">
                            <textarea class="form-control" placeholder="Leave a comment here" name="comment" id="floatingTextarea2" style="height: 110px"></textarea>
                            <label for="floatingTextarea2">Write Review </label>
                        </div>
                        <div class="mt-2">
                            <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>">
                            <input type="hidden" name="cate_id" value="<?php echo $_GET['cate_id']; ?>">
                            <input type="submit" class="btn btn-primary btn-sm" name="submitFeedback" value="Submit">
                        </div>
                    </form>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <div class="container-fluid related-contents mt-5">
        <h4 class=" text-center p-3" style="background-color: #f4f4f4;">Related Products</h4>
        <div class="row row-cols-1 row-cols-md-4 g-4 mb-5 mt-2">
            <?php
                $query = "SELECT * FROM products AS p 
                    JOIN sub_category AS s ON p.sub_cate_id = s.sub_cate_id 
                    JOIN category AS cat ON s.cate_id = cat.cate_id
                    WHERE cat.cate_id = '$cate_id' AND p.prod_id != '$prod_id'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    while($rows = mysqli_fetch_assoc($result)){
            ?>
            <div class="col">
                <!-------------------- Products Cards ----------------->
                <div class="card h-100 productCards position-relative shadow " style="overflow: hidden;">
                    <a href="./Product.php?product_id=<?php echo $rows['prod_id']; ?>&cate_id=<?php echo $rows['cate_id']; ?> " style=" color:inherit;text-decoration:none;">
                        <div class="img-div">
                            <img src="./Admin/<?php echo $rows['prod_img'] ?>" class="card-img-top" alt="Not Found">
                        </div>
                        <div class="card-body mb-5">
                            <h5 class="card-title"><?php echo $rows['prod_name'] ?></h5>
                            <div class="category d-flex justify-content-between ">
                                <h6 class="category_heading fw-bold">Category Name</h6>
                                <h6 class="category_name fw-bold"><?php echo $rows['cate_name']; ?></h6>
                            </div>
                            <p class="card-text"><?php echo $rows['prod_desc'] ?></p>
                            <div class="d-flex justify-content-between fs-5">
                                <strong>Price</strong>
                                <strong><?php echo $rows['price'] ?> Rs</strong>
                            </div>
                            <div class="stockMessage text-center mt-2">
                                <span class="text-danger">
                                    <?php if (isset($rows['stock'])) {
                                        if ($rows['stock'] == 0) {
                                            echo "<i>Out of Stock</i>";
                                        }
                                    } ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <button type="submit" id="addToCardProdBtn" name="addToCardProdBtn" class="text-white pt-2 pb-2 btn btn-dark d-flex justify-content-center align-items-center addToCartOnCards addToCardProdBtn" style="border-top-left-radius:0px;border-top-right-radius:0px;">
                        Add To Cart
                        <input type="hidden" name="add_to_cart_prod_id" id="add_to_cart_prod_id" class="add_to_cart_prod_id" value="<?php if (isset($rows['prod_id'])) {
                                                                                                                                        echo $rows['prod_id'];
                                                                                                                                    } ?>">
                        <div class="spinner-border spinner-border-sm text-light ms-2 addToCardProdLoading" role="status" style="display: none;"></div>
                    </button>
                </div>
            </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>


<?php
include('./Components/footer.php')
?>