<?php
include('./MainInclude/header.php');
include('../dbConnection.php');
?>
<?php
if(isset($_GET['prod_id'])){
    $product_id = $_GET['prod_id'];
}
else{
    header('./products.php');
    die;
}
if(isset($_POST['updateProdBtn'])){
    $pro_name = $_POST['edit_pro_name'];
    $cate_id = $_POST['edit_sel_cate'];
    $pro_desc = $conn->real_escape_string($_POST['edit_pro_desc']);
    $price = $_POST['edit_pro_price'];
    $stock = $_POST['edit_pro_stock'];
    $new_pro_img = $_FILES['pro_img']['name'];
    $old_img = $_POST['pro_old_img'];
    if($new_pro_img != ''){
        $upload_prod_img =  'Images/'. $new_pro_img;
    }
    else{
        $upload_prod_img = $old_img;
    }
    $query = "UPDATE products SET prod_name = '$pro_name',sub_cate_id = '$cate_id',prod_desc = '$pro_desc',
    prod_img = '$upload_prod_img',price = '$price',stock = '$stock' WHERE prod_id = '$product_id'";
    $result = mysqli_query($conn,$query);
    if($result){
        if($new_pro_img != ''){
            move_uploaded_file($_FILES['pro_img']['tmp_name'],'Images/'.$new_pro_img);
            unlink($old_img);
        }
        $_SESSION['status_success'] = " Product update successfully!";
    }
    else{
        $_SESSION['status_danger'] = " Product does not update";
    }
}

?>
<div class="div-2 w-100">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-center align-items-center mt-2 mb-3">
            <?php
                if(isset($_GET['prod_id'])){
                    $product_id = $_GET['prod_id'];
                    $query = "SELECT * FROM products WHERE prod_id = '$product_id'";
                    $result = mysqli_query($conn,$query);
                    if($result){
                        $row = mysqli_fetch_assoc($result);
            ?>
            <form action="" method="post" enctype="multipart/form-data" class="w-75 rounded border shadow p-3 pt-1">
                <h5 class="shadow mb-4 d-flex align-items-center p-1" style="width:100%;background-color:#B3005E;">
                    <strong class="p-2 text-white text-center w-100">Edit Product</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="./products.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <!-- Image input  -->
                <label for="pro_img" class="form-label">Product Image</label>
                <div class="row">
                    <div class="col-sm-2" style="width: 90px;">
                        <img src="<?php echo $row['prod_img'];?>" alt="Not Found" class="rounded w-100">
                    </div>
                    <div class="col-sm-10">
                        <input type="file" name="pro_img" id="edit_pro_img" class="form-control">
                        <input type="hidden" name="pro_old_img" value="<?php echo $row['prod_img'];?>">
                    </div>
                </div>
                <div class="mt-2">
                    <input type="text" class="form-control" name="edit_pro_name" id="edit_pro_name" placeholder="Product Name" value="<?php echo $row['prod_name'] ?>">
                </div>
                <div class="mt-2">
                    <select name="edit_sel_cate" id="edit_sel_cate" class="form-select">
                        <?php
                            $query = "SELECT * FROM sub_category";
                            $result = mysqli_query($conn,$query);
                            if(mysqli_num_rows($result)>0){
                                while($rows = mysqli_fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $rows['sub_cate_id']; ?>" <?php echo $row['sub_cate_id'] == $rows['sub_cate_id'] ? "selected":"" ?>><?php echo $rows['sub_cate_name']; ?></option>
                        <?php
                                }
                            }
                            else{
                                echo " <option> No Category Found<option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-floating mt-2">
                    <textarea class="form-control" name="edit_pro_desc" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?php echo $row['prod_desc'] ?></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>
                <div class="mt-2">
                    <input type="number" name="edit_pro_price" id="edit_pro_price" class="form-control" placeholder="Price" value="<?php echo $row['price'] ?>">
                </div>
                <div class="mt-2">
                    <input type="number" name="edit_pro_stock" id="edit_pro_stock" class="form-control" placeholder="Stock" value="<?php echo $row['stock'] ?>">
                </div>
                <div class="mt-2">
                    <input type="submit" class="btn btn-sm btn-primary" name="updateProdBtn" id="updateProdBtn" value="Update">
                </div>
            <?php
                    }
                }
            ?>
            </form>
        </div>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>