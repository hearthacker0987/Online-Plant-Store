<?php
include('./MainInclude/header.php');
?>
<?php
    if(isset($_GET['delete_prod_id'])){
        $product = $_GET['delete_prod_id'];
        include('../dbConnection.php');
        $query = "DELETE FROM products WHERE prod_id = '$product'";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = "Product deleted successfully!";
        }
        else
        {
            $_SESSION['status_danger'] = "Product does not delete";
        }
    }
?>
<div class="div-2 w-100">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow mb-4 mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white text-center w-100">Products</strong>
        </h5>
        <div class="product-sub-header row mb-4">
            <div class="addButton col-md-3">
                <a href="add_products.php" class="btn btn-sm btn-primary">Add Product</a>
            </div>
            <form action="" method="post" class="pro_search d-flex col-md-6 ">
                <div class="prod_search me-2 w-100 d-flex justify-content-center">
                    <input type="text" name="prod_search_input" id="prod_search_input" class="form-control searchBar" placeholder="Search Product">
                    <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        <div class="continer-fluid " style="overflow-x:auto ;">
            <table class="table table-hover table-responsive" id="product_table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">IMG</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include('../dbConnection.php');
                    $query = "SELECT * FROM products JOIN sub_category ON (products.sub_cate_id = sub_category.sub_cate_id)";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result) > 0){
                        while( $rows = mysqli_fetch_assoc($result)){
                ?>
                    <tr>
                        <td><?php if(isset($rows['prod_id'])){ echo $rows['prod_id']; } ?></td>

                        <th scope="row" class="text-center h-100" style="vertical-align: middle;">
                            <div class="img" style="width:60px">
                                <img src="<?php echo $rows['prod_img']; ?>" alt="Not Found" srcset="" class=" rounded w-100">
                            </div>
                        </th>
                        <td><?php if(isset($rows['prod_name'])){ echo $rows['prod_name']; } ?></td>
                        <td><?php if(isset($rows['prod_desc'])){ echo $rows['prod_desc']; } ?></td>
                        <td><?php if(isset($rows['sub_cate_name'])){ echo $rows['sub_cate_name']; } ?></td>
                        <td><?php if(isset($rows['price'])){ echo number_format($rows['price']); } ?></td>
                        <td><?php if(isset($rows['stock'])){ echo number_format($rows['stock']); } ?></td>
                        <td style="width: 90px;">
                            <a href="edit_product.php?prod_id=<?php echo $rows['prod_id']; ?>" class="btn btn-sm btn-secondary mb-1">
                                <i class="fa-sharp fa-solid fa-pen-to-square fs-6"></i>
                            </a>
                            <a href="products.php?delete_prod_id=<?php echo $rows['prod_id']; ?>" class="btn btn-sm btn-danger mb-1">
                                <i class="fa-sharp fa-solid fa-trash fs-6 "></i>
                            </a>
                        </td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('./MainInclude/footer.php');
?>