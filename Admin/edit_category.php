<?php
include('./MainInclude/header.php');
?>

<?php
    if(isset($_GET['cate_id'])){
        $category_id = $_GET['cate_id'];
    }
    else{
        header('location: ./categories.php');
    }
    if(isset($_POST['UpdateCateBtn'])){
        include('../dbConnection.php');
        $categoryName = $conn->real_escape_string($_POST['edit_cate']);
        if($categoryName == ''){
            $_SESSION['status_danger'] = " Please enter category name!";
        }
        else
        {
            $query = "UPDATE category SET cate_name = '$categoryName' WHERE cate_id = '$category_id'";
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
                    <strong class="p-1 text-white text-center w-100">Edit Category</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="categories.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <?php
                    if(isset($_GET['cate_id'])){
                        $category_id = $_GET['cate_id'];
                        include('../dbConnection.php');
                        $query = "SELECT cate_name FROM category WHERE cate_id = '$category_id'";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                ?>
                <div>
                    <label for="edit_cate" class="form-label">Category Name</label>
                    <input type="text" name="edit_cate" id="edit_cate" class="form-control" value="<?php if(isset($row['cate_name'])){ echo $row['cate_name'];}?>">
                </div>
                <?php
                        } 

                    }
                ?>
                <div class="mt-2">
                    <input type="submit" class="btn btn-sm btn-primary" name="UpdateCateBtn" id="UpdateCateBtn" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>