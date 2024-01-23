<?php
include('./Components/header.php')
?>
<?php
if (!isset($_GET['subCate'])) {
    header('location: index.php');
}
?>

<div class="container-fluid">
    <h4 class="mt-3"><strong><?php if(isset($_GET['subCate'])){ echo $_GET['subCate'];} ?></strong></h4>
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-5 mt-2">
        <?php 
            if(isset($_GET['subCate'])){
                $subCate_name = $_GET['subCate'];
                $query = "SELECT * FROM products AS p
                JOIN sub_category AS s ON p.sub_cate_id = s.sub_cate_id
                JOIN category AS cat ON s.cate_id = cat.cate_id  WHERE s.sub_cate_name = '$subCate_name'";
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
            }  
        ?>
    </div>
</div>
<?php
include('./Components/footer.php')
?>