<?php
include('./MainInclude/header.php');
?>

<div class="div-2 w-100">
    <?php
    include('./MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow mb-4 mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white text-center w-100">User Carts</strong>
        </h5>
        <div class="d-flex justify-content-center">
            <form action="" method="post" class=" d-flex  col-md-6 ">
                <input type="text" name="search_order_input" id="search_order_input" class="form-control searchBar " placeholder="Search Order">
                <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="container-fluid mt-4" style="overflow-x: auto;">
            <table class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Products</th>
                        <th scope="col">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include('../dbConnection.php');
                $query = "SELECT * FROM add_to_cart AS a 
                    JOIN products AS p ON a.prod_id = p.prod_id
                    JOIN users AS u ON a.user_id = u.user_id";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    while($rows = mysqli_fetch_assoc($result)){
                ?>
                    <tr>
                        <th scope="row"><?php echo $rows['id'] ?></th>
                        <td><?php echo $rows['user_name'] ?></td>
                        <td><?php echo $rows['prod_name'] ?></td>
                        <td><?php echo $rows['prod_quantity'] ?></td>
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