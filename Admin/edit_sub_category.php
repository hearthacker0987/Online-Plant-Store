<?php
include('./MainInclude/header.php');
?>

<?php
    if(isset($_GET['sub_cate_id'])){
        $sub_category_id = $_GET['sub_cate_id'];
    }
    else{
        header('location: ./sub_category.php');
    }
    if(isset($_POST['UpdateSubCateBtn'])){
        include('../dbConnection.php');
        $sub_category_name = $conn->real_escape_string($_POST['sub_edit_cate']);
        if($sub_category_name == ''){
            $_SESSION['status_danger'] = " Please enter category name!";
        }
        else
        {
            $query = "UPDATE sub_category SET sub_cate_name = '$sub_category_name' WHERE sub_cate_id = '$sub_category_id'";
            $result = mysqli_query($conn,$query);
            if($result){
                $_SESSION['status_success'] = " Update Category Successfully!";
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
                    <strong class="p-1 text-white text-center w-100">Edit Sub Category</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="sub_category.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <?php
                    if(isset($_GET['sub_cate_id'])){
                        $sub_category_id = $_GET['sub_cate_id'];
                        include('../dbConnection.php');
                        $query = "SELECT sub_cate_name FROM sub_category WHERE sub_cate_id = '$sub_category_id'";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                ?>
                <div>
                    <label for="sub_edit_cate" class="form-label">Category Name</label>
                    <input type="text" name="sub_edit_cate" id="sub_edit_cate" class="form-control" value="<?php if(isset($row['sub_cate_name'])){ echo $row['sub_cate_name'];}?>">
                </div>
                <?php
                        } 

                    }
                ?>
                <div class="mt-2">
                    <input type="submit" class="btn btn-sm btn-primary" name="UpdateSubCateBtn" id="UpdateSubCateBtn" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>