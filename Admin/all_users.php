<?php
include('./MainInclude/header.php');
include('../dbConnection.php');
?>


<!-- Get Method for Delete Users  -->
<?php
if(isset($_GET['deleteUser_user_id'])){
    $user_id = $_GET['deleteUser_user_id'];
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn,$query);
    if($result){
        $_SESSION['status_success'] = " Delete User #$user_id Successfully";
    }
    else
    {
        $_SESSION['status_danger'] = " User does not delete due to some technical issues";
    }
}
?>
<div class="div-2 w-100 " style="overflow-y:auto;">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow mb-4 mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white text-center w-100">All Users</strong>
        </h5>
        <div class="row mb-4">
            <div class="addButton col-md-3">
                <a href="./add_users.php" class="btn btn-sm btn-primary">Add Users</a>
            </div>
            <form action="" method="post" class="pro_search d-flex col-md-6">
                <div class="user_search me-2 w-100 d-flex justify-content-center">
                    <input type="text" name="user_search_input" id="user_search_input" class="form-control searchBar" placeholder="Search User">
                    <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
                </div>
            </form>            
        </div>
        <div class="continer-fluid mt-3" style="overflow-x:auto;">
            <table class="table table-hover table-responsive" id="user_table">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM users WHERE role_as != 'admin'";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result)>0){
                            while($rows = mysqli_fetch_assoc($result)){
                    ?>
                    <tr class="">
                        <th scope="row"><?php if(isset($rows['user_id'])){ echo $rows['user_id'];} ?></th>
                        <td><?php if(isset($rows['user_name'])){ echo $rows['user_name'];} ?></td>
                        <td><?php if(isset($rows['user_email'])){ echo $rows['user_email'];} ?></td>
                        <td><?php if(isset($rows['user_number'])){ echo $rows['user_number'];} ?></td>
                        <td>
                            <a href="edit_user.php?user_id=<?php echo $rows['user_id']; ?>" class="btn btn-sm btn-secondary mb-1">
                                <i class="fa-sharp fa-solid fa-pen-to-square fs-6"></i>
                            </a>
                            <a href="all_users.php?deleteUser_user_id=<?php echo $rows['user_id']; ?>" class="btn btn-sm btn-danger mb-1">
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