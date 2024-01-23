<?php
include('./MainInclude/header.php');
?>
<!-- Get Method for Delete Users  -->
<?php
if(isset($_GET['deleteSubCategory_cate_id'])){
    include('../dbConnection.php');
    $cate_id = $_GET['deleteSubCategory_cate_id'];
    $query = "DELETE FROM sub_category WHERE sub_cate_id = '$cate_id'";
    $result = mysqli_query($conn,$query);
    if($result){
        $_SESSION['status_success'] = " Delete Sub Category #$cate_id Successfully";
    }
    else
    {
        $_SESSION['status_danger'] = " Category does not delete due to some technical issues";
    }
}
?>
<div class="div-2 w-100">
    <?php
        include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow mb-4 mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white text-center w-100">Sub Category</strong>
        </h5>
        <div class="row mb-4">
            <div class="addButton col-md-3">
                <a href="add_sub_category.php" class="btn btn-sm btn-primary">Add Sub Category</a>
            </div>
            <form action="" method="post" class="cate_search col-md-6">
                <div class="cate_search me-2 w-100 d-flex justify-content-center">
                    <input type="text" name="sub_cate_search" id="sub_cate_search" class="form-control searchBar" placeholder="Search Category">
                    <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        <div class="continer-fluid ">
            <table class="table table-hover table-responsive" id="sub_cate_table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Sub Category</th>
                        <th scope="col">Parent Category</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include('../dbConnection.php');
                        $query = "SELECT * FROM sub_category JOIN category ON (sub_category.cate_id = category.cate_id)";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result)>0){
                            while($rows = mysqli_fetch_assoc($result)){
                                // convert date format 
                                $date = $rows['created_at'];
                                $formatedDate = date('d/m/Y',strtotime($date));
                    ?>
                    <tr>
                        <th scope="row"><?php if(isset($rows['sub_cate_id'])){ echo $rows['sub_cate_id'];} ?></th>
                        <td><?php if(isset($formatedDate)){ echo $formatedDate;} ?></td>
                        <td><?php if(isset($rows['sub_cate_name'])){ echo $rows['sub_cate_name'];} ?></td>
                        <td><?php if(isset($rows['cate_name'])){ echo $rows['cate_name'];} ?></td>
                        <td>
                            <a href="edit_sub_category.php?sub_cate_id=<?php echo $rows['sub_cate_id']?>" class="btn btn-sm btn-secondary">
                                <i class="fa-sharp fa-solid fa-pen-to-square fs-6"></i>
                            </a>
                            <a href="sub_category.php?deleteSubCategory_cate_id=<?php echo $rows['sub_cate_id']?>" class="btn btn-sm btn-danger">
                                <i class="fa-sharp fa-solid fa-trash fs-6"></i>
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