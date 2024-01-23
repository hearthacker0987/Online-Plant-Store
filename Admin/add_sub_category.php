<?php
include('./MainInclude/header.php');
?>

<?php
    if(isset($_POST['addSubCateBtn'])){
        include('../dbConnection.php');
        $subCategoryName = $conn->real_escape_string($_POST['add_sub_cate']);
        $parent_cate = $_POST['p_cate'];
        if($subCategoryName == '' || $parent_cate == ''){
            $_SESSION['status_danger'] = " Please fill all fields!";
        }
        else
        {
            $query = " INSERT INTO sub_category(sub_cate_name,cate_id)VALUES('$subCategoryName','$parent_cate'); ";
            $result = mysqli_query($conn,$query);
            if($result){
                $_SESSION['status_success'] = "Sub Category Added Successfully!";
            }
            else{
                $_SESSION['status_danger'] = " Database Error";
            }
        }
    }
?>
<div class="div-2 w-100">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-center align-items-center ">
            <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 mt-5 m-1 rounded border-bottom border-top border-danger">
                <h5 class="shadow mb-4 d-flex align-items-center p-1" style="background-color:#B3005E;">
                    <strong class="p-1 text-white text-center w-100">Add Sub Category</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="sub_category.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <div>
                    <label for="addCate" class="form-label">Select Parent Category</label>
                    <select name="p_cate" id="p_cate" class="form-select">
                    <?php
                        include('../dbConnection.php');
                        $query = "SELECT * FROM category";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result)>0){
                            while( $rows = mysqli_fetch_assoc($result))
                            {
                    ?>
                        <option value="<?php echo $rows['cate_id'];?>"><?php echo $rows['cate_name'];?></option>
                    <?php
                            } 
                        }
                    ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="add_sub_cate" class="form-label">Sub Category Name</label>
                    <input type="text" name="add_sub_cate" id="add_sub_cate" class="form-control">
                </div>
                <div class="mt-2 d-flex justify-content-between">
                    <input type="submit" class="btn btn-sm btn-primary" name="addSubCateBtn" id="addSubCateBtn" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>