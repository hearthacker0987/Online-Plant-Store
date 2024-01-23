<?php
include('./MainInclude/header.php');
?>
<!-- Get Method for Delete Category  -->
<?php
if(isset($_GET['deleteCategory_cate_id'])){
    include('../dbConnection.php');
    $cate_id = $_GET['deleteCategory_cate_id'];
    $query = "DELETE FROM category WHERE cate_id = '$cate_id'";
    $result = mysqli_query($conn,$query);
    if($result){
        $_SESSION['status_success'] = " Delete Category #$cate_id Successfully";
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
            <strong class="p-2 text-white text-center w-100">Category</strong>
        </h5>
        <div class="row mb-4">
            <div class="addButton col-md-3">
                <a href="add_category.php" class="btn btn-sm btn-primary">Add Category</a>
            </div>
            <form action="" method="post" class="cate_search d-flex  col-md-6 ">
                <div class="cate_search me-2 w-100 d-flex justify-content-center">
                    <input type="text" name="cate_search_input" id="cate_search_input" class="form-control searchBar" placeholder="Search Category">
                    <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
        <div class="container-fluid" style="overflow-x: auto;">
            <table class="table table-hover table-responsive" id="parent_cate_table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="search_data">
                    <?php
                        include('../dbConnection.php');
                        $query = "SELECT * FROM category";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) > 0){
                            while($rows = mysqli_fetch_assoc($result)){
                                // convert date format 
                                $date = $rows['date'];
                                $formatedDate = date('d/m/Y',strtotime($date));
                    ?>
                    <tr>
                        <th scope="row"><?php if(isset($rows['cate_id'])){ echo $rows['cate_id'];} ?></th>
                        <td><?php if(isset($formatedDate)){ echo $formatedDate;} ?></td>
                        <td><?php if(isset($rows['cate_name'])){ echo $rows['cate_name'];} ?></td>
                        <td>
                            <a href="edit_category.php?cate_id=<?php echo $rows['cate_id']?>" class="btn btn-sm btn-secondary">
                                <i class="fa-sharp fa-solid fa-pen-to-square fs-6"></i>
                            </a>
                            <a href="categories.php?deleteCategory_cate_id=<?php echo $rows['cate_id']?>" class="btn btn-sm btn-danger">
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