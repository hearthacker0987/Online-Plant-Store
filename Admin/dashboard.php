<!--------------------------------------- Inlude Header File --------------------------------------->
<?php
include('MainInclude/header.php');
include('../dbConnection.php');
?>
<div class="div-2  w-100"> <!--- div-2 Start !-->
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h4 class="shadow mb-4 mt-3 text-center" style="width:100%;height:35px;background-color:#B3005E;">
            <strong class="p-2 text-white">Dashboard</strong>
        </h4>
        <div class="group d-flex gap-2 flex-wrap mb-5">
            <div class="cards rounded d-flex align-items-center text-white col-md-3" style="width:260px; background: linear-gradient(#DA4453, #89216B)">
                <div class="icon p-3" style="border-right: 1px solid white;">
                    <i class="bi bi-boxes " style="font-size:2.5rem;"></i>
                </div>
                <div class="body p-3 w-100">
                    <h5 class="">Products</h5>
                    <div class="card-text text-white text-end w-100 fs-5">
                        <?php 
                        $countProductsQ = "SELECT * FROM products";
                        $countProductsQrun = mysqli_query($conn,$countProductsQ);
                        if($countProductsQrun){
                            echo number_format(mysqli_num_rows($countProductsQrun));
                        }
                        else{
                            echo "Error";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="cards rounded d-flex align-items-center text-white col-md-3 " style="width:260px; background: linear-gradient(#DA4453, #89216B)">
                <div class="icon p-3" style="border-right: 1px solid white;">
                    <i class="bi bi-bookmarks-fill " style="font-size:2.5rem;"></i>
                </div>
                <div class="body p-3 w-100">
                    <h5 class="">Category</h5>
                    <div class="card-text text-white text-end w-100 fs-5">
                    <?php 
                        $countCategoryQ = "SELECT * FROM category";
                        $countCategoryQrun = mysqli_query($conn,$countCategoryQ);
                        if($countCategoryQrun){
                            echo number_format(mysqli_num_rows($countCategoryQrun));
                        }
                        else{
                            echo "Error";
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class="cards rounded d-flex align-items-center text-white col-md-3" style="width:260px; background: linear-gradient(#DA4453, #89216B)">
                <div class="icon p-3" style="border-right: 1px solid white;">
                    <i class="bi bi-bookmarks" style="font-size:2.5rem;"></i>
                </div>
                <div class="body p-3 w-100">
                    <h5 class="">Sub Category</h5>
                    <div class="card-text text-white text-end w-100 fs-5">
                    <?php 
                        $countSubCategoryQ = "SELECT * FROM sub_category";
                        $countSubCategoryQrun = mysqli_query($conn,$countSubCategoryQ);
                        if($countSubCategoryQrun){
                            echo number_format(mysqli_num_rows($countSubCategoryQrun));
                        }
                        else{
                            echo "Error";
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class="cards rounded d-flex align-items-center text-white col-md-3" style="width:260px; background: linear-gradient(#DA4453, #89216B)">
                <div class="icon p-3" style="border-right: 1px solid white;">
                    <i class="bi bi-people-fill " style="font-size:2.5rem;"></i>
                </div>
                <div class="body p-3 w-100">
                    <h5 class="">Users</h5>
                    <div class="card-text text-white text-end w-100 fs-5">
                    <?php 
                        $countUsersQ = "SELECT * FROM users WHERE role_as != 'admin'";
                        $countUsersQrun = mysqli_query($conn,$countUsersQ);
                        if($countUsersQrun){
                            echo number_format(mysqli_num_rows($countUsersQrun));
                        }
                        else{
                            echo "Error";
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div> <!---- card-div-end  !-->
        <!-- ***************** Out Of Stock Products ****************** -->
        <div class="lowStock mt-5">
            <div class="container-fluid" style="overflow-x: auto;">
                <?php
                $outStockQuery = "SELECT * FROM products AS p JOIN sub_category AS s ON (p.sub_cate_id = s.sub_cate_id) WHERE p.stock = 0";
                $run = mysqli_query($conn,$outStockQuery);
                    echo '
                    <strong class="fs-5 text-center w-100 mb-3" style="color: #DA4453">Out of Stock Products <span class="badge bg-secondary">'.mysqli_num_rows($run).'</span></strong>
                    ';
                
                if(mysqli_num_rows($run) > 0){
                ?>
                <table class="table table-hover table-responsive mt-4">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">IMG</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        while( $rows = mysqli_fetch_assoc($run)){
                    ?>
                        <tr>
                            <th scope="row" class="text-center h-100" style="vertical-align: middle;">
                                <div class="img" style="width:60px">
                                    <img src="<?php echo $rows['prod_img']; ?>" alt="Not Found" srcset="" class=" rounded w-100">
                                </div>
                            </th>
                            <td><?php if(isset($rows['prod_name'])){ echo $rows['prod_name']; } ?></td>
                            <td><?php if(isset($rows['prod_desc'])){ echo $rows['prod_desc']; } ?></td>
                            <td><?php if(isset($rows['sub_cate_name'])){ echo $rows['sub_cate_name']; } ?></td>
                            <td><?php if(isset($rows['price'])){ echo number_format($rows['price']); } ?></td>
                            <td><?php if(isset($rows['stock'])){ echo number_format($rows['stock']); } ?></td>
                        </tr>
                <?php
                        }
                    echo "</tbody>";
                echo "</table>";
            }
            else{
                echo ' <div class="alert alert-warning mt-3">0 Prodcuts</div>';
            }
        
        ?>
            </div>
        </div>
        <!-- ***************** Low Stock Products ****************** -->
        <div class="lowStock " style="margin-top: 70px;">
            <div class="container-fluid" style="overflow-x: auto;">
            <?php
                $lowStockQuery = "SELECT * FROM products AS p JOIN sub_category AS s ON (p.sub_cate_id = s.sub_cate_id) WHERE p.stock <= 12 AND p.stock != 0";
                $run2 = mysqli_query($conn,$lowStockQuery);
                echo '
                <strong class="fs-5 text-center w-100" style="color: #DA4453">Low Stock Products <span class="badge bg-secondary">'.mysqli_num_rows($run2).'</span></strong>
                ';
                if(mysqli_num_rows($run2) > 0 ){
            ?>
                <table class="table table-hover table-responsive mt-4">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">IMG</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while( $rows = mysqli_fetch_assoc($run2)){
                    ?>
                        <tr>
                            <th scope="row" class="text-center h-100" style="vertical-align: middle;">
                                <div class="img" style="width:60px">
                                    <img src="<?php echo $rows['prod_img']; ?>" alt="Not Found" srcset="" class=" rounded w-100">
                                </div>
                            </th>
                            <td><?php if(isset($rows['prod_name'])){ echo $rows['prod_name']; } ?></td>
                            <td><?php if(isset($rows['prod_desc'])){ echo $rows['prod_desc']; } ?></td>
                            <td><?php if(isset($rows['sub_cate_name'])){ echo $rows['sub_cate_name']; } ?></td>
                            <td><?php if(isset($rows['price'])){ echo number_format($rows['price']); } ?></td>
                            <td><?php if(isset($rows['stock'])){ echo number_format($rows['stock']); } ?></td>
                        </tr>
                <?php
                        }
                    echo "</tbody>";
                echo "</table>";
            }
            else{
                echo ' <div class="alert alert-warning mt-3">0 Prodcuts</div>';
            }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> <!--- div-2 close !-->


<!--------------------------------------- Inlude Footer File --------------------------------------->
<?php
include('MainInclude/footer.php');
?>