<div class=" text-white bg-dark d-flex align-items-center" style="background-color:#00adff;height:70px">
    <header>
        <div class="item-1 toggle_btn">
            <i class="bi bi-sliders text-white open-menu-btn fs-3 ps-3" style="display:none;cursor:pointer;"></i>
        </div>
        <div class="item-2 ">
            <h4 class=" text-center topheaderHeading"><strong>
            <?php
              include('../dbConnection.php');
              $query = "SELECT web_name FROM setting";
              $runQuery = mysqli_query($conn,$query);
              if(mysqli_num_rows($runQuery) > 0){
                $web_detail = mysqli_fetch_assoc($runQuery);
                if(isset($web_detail['web_name']) && $web_detail['web_name'] != null){
                    echo $web_detail['web_name'];
                }
                else{
                    echo "Website Name";
                }
              }
              else{
                echo "Website Name";
              }
            ?>
            </strong></h4>
        </div>
        <div class="item-3 ">
            <div class=" dropdown d-flex align-items-center" style="cursor:pointer;">
                <div class="dropdown-toggle btn-sm me-3 mt-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-people-fill "></i>
                </div>
                <ul class="dropdown-menu bg-dark">
                    <li><button class="dropdown-item" type="button"><a href="admin_profile.php" class="nav-link">My Profile</a></button></li>
                    <li><button class="dropdown-item" type="button"><a href="change_password.php" class="nav-link">Change Password</a></button></li>
                    <li><button class="dropdown-item" type="button"><a href="./setting.php" class="nav-link">Setting</a></button></li>
                    <li><button class="dropdown-item" type="button"><a href="./../logout.php" class="nav-link">Logout</a></button></li>
                </ul>
            </div>
        </div>
    </header>
</div>