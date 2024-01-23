<?php
include('./Components/header.php')
?>
<!---------------------------------------- Carousel ------------------------------------>
<?php 
    include('./dbConnection.php');
    $query = "SELECT * FROM setting";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        if(isset($row['car_1_img']) && $row['car_1_img'] != null){

?>
<div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php
        if(isset($row['car_2_img']) && $row['car_2_img'] != null){
            echo '
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>           
            ';
        }
        if (isset($row['car_3_img']) && $row['car_3_img'] != null){
            echo '
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            ';
        }
        ?>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./Admin/<?php if(isset($row['car_1_img']) && $row['car_1_img'] != null){ echo $row['car_1_img'];}?>" class="d-block w-100 h-100" alt="..." style="object-fit: cover;">
            <div class="carousel-caption d-none d-md-block fw-bold">
                <h4><?php if(isset($row['car_1_heading']) && $row['car_1_heading'] != null){ echo $row['car_1_heading'];}?></h4>
                <p><?php if(isset($row['car_1_text']) && $row['car_1_text'] != null){ echo $row['car_1_text'];}?></p>
            </div>
        </div>
        <?php if(isset($row['car_2_img']) && $row['car_2_img'] != null){
        ?>
        <div class="carousel-item">
            <img src="./Admin/<?php if(isset($row['car_2_img']) && $row['car_2_img'] != null){ echo $row['car_2_img'];}?>" class="d-block w-100 h-100" alt="..." style="object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h4><?php if(isset($row['car_2_heading']) && $row['car_2_heading'] != null){ echo $row['car_2_heading'];}?></h4>
                <p><?php if(isset($row['car_2_text']) && $row['car_2_text'] != null){ echo $row['car_2_text'];}?></p>
            </div>
        </div>
        <?php    
        }?>

        <?php if(isset($row['car_3_img']) && $row['car_3_img'] != null){
        ?>
        <div class="carousel-item">
            <img src="./Admin/<?php if(isset($row['car_3_img']) && $row['car_3_img'] != null){ echo $row['car_3_img'];}?>" class="d-block w-100 h-100" alt="..." style="object-fit: cover;">
            <div class="carousel-caption d-none d-md-block">
                <h4><?php if(isset($row['car_3_heading']) && $row['car_3_heading'] != null){ echo $row['car_3_heading'];}?></h4>
                <p><?php if(isset($row['car_3_text']) && $row['car_3_text'] != null){ echo $row['car_3_text'];}?></p>
            </div>
        </div>
        <?php
        }?>
    </div>
    <?php
    if(isset($row['car_2_img']) && $row['car_2_img'] != null){ 
    ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    <?php
        }
    ?>
</div>
<?php
        }
    }
?>
<div class="container-fluid">
    <h3 class="mt-4 mb-3 p-1">Collection Of Plants</h3>
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
        <?php
        $query = "SELECT * FROM products AS p
        JOIN sub_category AS s ON p.sub_cate_id = s.sub_cate_id
        JOIN category AS cat ON s.cate_id = cat.cate_id  LIMIT 12";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
        ?>
                <div class="col">
                    <!-------------------- Products Cards ----------------->
                    <div class="card h-100 productCards position-relative shadow " style="overflow: hidden;">
                        <a href="./Product.php?product_id=<?php echo $rows['prod_id']; ?>&cate_id=<?php echo $rows['cate_id']; ?> " style=" color:inherit;text-decoration:none;">
                            <div class="img-div" style="max-height:300px;">
                                <img src="./Admin/<?php echo $rows['prod_img'] ?>" class="card-img-top" alt="Not Found">
                            </div>
                            <div class="card-body mb-5">
                                <h5 class="card-title fw-bolder"><?php echo $rows['prod_name']; ?></h5>
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
                            <input type="hidden" name="add_to_cart_prod_id" id="add_to_cart_prod_id" class="add_to_cart_prod_id" value="<?php if (isset($rows['prod_id'])) { echo $rows['prod_id'];} ?>">
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
<!-- Include Footer  -->
<?php
include('./Components/footer.php')
?>