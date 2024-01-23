<?php
include('./MainInclude/header.php');
include('../dbConnection.php');
?>
<?php
if(isset($_POST['addProdBtn'])){
    $pro_name = ucwords($_POST['pro_name']);
    $cate_id = $_POST['sel_cate'];
    $pro_desc = $conn->real_escape_string($_POST['pro_desc']);
    $price = $_POST['pro_price'];
    $stock = $_POST['pro_stock'];
    $img_name = $_FILES['add_pro_img']['name'];
    if($img_name == '' || $pro_name == '' || $cate_id == '' || $pro_desc == '' || $price == '' || $stock == ''){
        $_SESSION['status_danger'] = " Please fill all feilds";
    }
    else{
        $img_temp_name = $_FILES['add_pro_img']['tmp_name'];
        $img_path = 'Images/'.$img_name;
        $query = "INSERT INTO products (sub_cate_id,prod_name,prod_desc,prod_img,price,stock) VALUES ('$cate_id','$pro_name',
        '$pro_desc','$img_path','$price','$stock');";
        $result = mysqli_query($conn,$query);
        if($result){
            move_uploaded_file($img_temp_name,$img_path);
            $_SESSION['status_success'] = " Product added successfully!";
        }
        else{
            $_SESSION['status_danger'] = " Product not add";
        }
    }
}

?>
<div class="div-2 w-100">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid d-flex justify-content-center align-items-center">
            <form action="" method="post" enctype="multipart/form-data" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 mt-5 m-1 rounded border-bottom border-top border-danger">
                <h5 class="shadow mb-4 d-flex align-items-center p-1" style="background-color:#B3005E;">
                    <strong class="p-1 text-white text-center w-100">Add Product</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="./products.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <div>
                    <label for="add_pro_img" class="form-label">Product Image</label>
                    <input type="file" name="add_pro_img" id="add_pro_img" class="form-control">
                    <div class="text-center">Dimension must be 750x340</div>
                </div>
                <div class="mt-2">
                    <input type="text" class="form-control" name="pro_name" id="pro_name" placeholder="Product Name">
                </div>
                <div class="mt-2">
                    <select name="sel_cate" id="sel_cate" class="form-select">
                        <?php
                            $query = "SELECT * FROM sub_category";
                            $result = mysqli_query($conn,$query);
                            if(mysqli_num_rows($result)>0){
                                while($rows = mysqli_fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $rows['sub_cate_id']; ?>"><?php echo $rows['sub_cate_name']; ?></option>
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
                    <textarea class="form-control" name="pro_desc" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>
                <div class="mt-2">
                    <input type="number" name="pro_price" id="pro_price" class="form-control" placeholder="Price">
                </div>
                <div class="mt-2">
                    <input type="number" name="pro_stock" id="pro_stock" class="form-control" placeholder="Stock">
                </div>
                <div class="mt-2">
                    <input type="submit" class="btn btn-sm btn-primary" name="addProdBtn" id="addProdBtn" value="Add">
                </div>
            </form>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>