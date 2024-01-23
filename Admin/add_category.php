<?php
include('./MainInclude/header.php');
?>

<?php
    if(isset($_POST['addCateBtn'])){
        include('../dbConnection.php');
        $categoryName = $conn->real_escape_string($_POST['addCate']);
        if(!$categoryName==''){
            $query = " INSERT INTO category(cate_name)VALUES('$categoryName'); ";
            $result = mysqli_query($conn,$query);
            if($result){
                $_SESSION['status_success'] = " Add Category Successfully!";
            }
            else{
                $_SESSION['status_danger'] = " Database Error";
            }
        }
        else
        {
            $_SESSION['status_danger'] = " Please enter category name!";
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
                    <strong class="p-1 text-white text-center w-100">Add Category</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="categories.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <div>
                    <label for="addCate" class="form-label">Category Name</label>
                    <input type="text" name="addCate" id="addCate" class="form-control">
                </div>
                <div class="mt-2 d-flex justify-content-between">
                    <input type="submit" class="btn btn-sm btn-primary" name="addCateBtn" id="addCateBtn" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>