<?php
include('./MainInclude/header.php');

?>
<div class="div-2 w-100">


    <?php
    include('./MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow  mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white w-100"><i class="bi bi-gear me-1"></i> GENERAL SETTING</strong>
        </h5>
        <?php
            include('../dbConnection.php');
            $query = "SELECT * FROM setting";
            $result = mysqli_query($conn,$query);
            if($result){
                $row = mysqli_fetch_assoc($result);
        ?>
        <!---------------- Add Website Logo / Name ------------------->
        <div class="border border-success m-4 mt-4 mb-3 p-3 rounded">
            <strong class="text-center w-100"><i class="bi bi-globe me-1"></i>Add Site Logo / Name</strong>
            <div class="row mt-2 mb-3">
                <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                    <div class="" style="width: 90px;">
                        <img src="<?php if(isset($row['web_logo']) && $row['web_logo'] != null){ echo $row['web_logo'];} ?>" alt="Logo not found" class="img-thumbnail w-100" >
                    </div>
                    <span class="text-secondary">Site Logo</span>
                    <form action="./code.php" method="post" class="mt-1" enctype="multipart/form-data">
                        <div>
                            <input type="file" name="web_logo" id="web_logo" class="form-control" >
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm mt-2" name="webLogoBtn">Save</button>
                        <button type="submit" class="btn btn-danger btn-sm mt-2" name="webDelLogoBtn">Remove</button>
                    </form>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                    <form action="./code.php" method="post">
                        <div class="" style="width: 90px;visibility:hidden;">
                            <img src="<?php if(isset($row['web_logo'])&& $row['web_logo'] != null){ echo $row['web_logo'];} ?>" alt="Logo not found" class="img-thumbnail w-100" >
                        </div>
                        <div>
                            <label for="web_name" class="form-label">Site Name</label>
                            <input type="text" name="web_name" id="web_name" class="form-control" value="<?php if(isset($row['web_name']) && $row['web_name'] != null){ echo $row['web_name'];  } ?>">
                        </div>
                        <div class="mt-2">
                            <button type="submit" name="webNameBtn" class="btn btn-sm btn-primary">Save</button>
                            <!-- <button type="submit" class="btn btn-danger btn-sm " name="webRemNameBtn">Remove</button> -->
                        </div>  
                    </form>              
                </div>
            </div>
            <strong><i class="bi bi-share-fill me-1 "></i>Add site Links</strong>
            <form action="./code.php" method="post" class="row mt-2">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="mt-2">
                        <label for="fb-link" class="form-label"><i class="bi bi-facebook me-1 text-primary"></i>Facebook</label>
                        <input type="text" name="fb-link" id="fb-link" class="form-control" value="<?php if(isset($row['fb_link']) && $row['fb_link'] != null){ echo $row['fb_link'];  } ?>">
                    </div>
                    <div class="mt-2">
                        <label for="instagram-link" class="form-label"><i class="bi bi-instagram me-1 text-danger"></i>Instagram</label>
                        <input type="text" name="instagram-link" id="instagram-link" class="form-control" value="<?php if(isset($row['insta_link']) && $row['insta_link'] != null){ echo $row['insta_link'];  } ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-2" name="siteLinkBtn">Save</button>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="mt-2">
                        <label for="you-link" class="form-label"><i class="bi bi-youtube me-1 text-danger"></i>Youtube</label>
                        <input type="text" name="you-link" id="you-link" class="form-control" value="<?php if(isset($row['you_link']) && $row['you_link'] != null){ echo $row['you_link'];  } ?>">
                    </div>
                    <div class="mt-2">
                        <label for="whats-link" class="form-label"><i class="bi bi-whatsapp me-1 text-success"></i>Whatsapp</label>
                        <input type="text" name="whats-link" id="whats-link" class="form-control" value="<?php if(isset($row['whatsapp']) && $row['whatsapp'] != null){ echo $row['whatsapp'];  } ?>">
                    </div>
                </div>
            </form>
        </div>
        <!---------------- Add Website Carousel Details ------------------->
        <div class="border border-success m-4 mt-4 mb-3 p-3 rounded">
            <strong><i class="bi bi-wallet2 me-1"></i>Add Website Carousel Details</strong>
            <div class="row mt-2">
                <!-- Carousel 1 -->
                <div class="col-sm-4 col-md-4 col-lg-4 mt-2">
                    <span class="text-danger">1st Carousel</span>
                    <form action="./code.php" method="post" class="mt-1" enctype="multipart/form-data">
                        <div>
                            <input type="file" name="carousel-1-img" id="carousel-1-img" class="form-control">
                        </div>
                        <div>
                            <label for="carousel-1-heading" class="form-label mt-1">Heading</label>
                            <input type="text" name="carousel-1-heading" id="carousel-1-heading" class="form-control" value="<?php if(isset($row['car_1_heading']) && $row['car_1_heading'] != null){ echo $row['car_1_heading'];  } ?>">
                        </div>
                        <div>
                            <label for="carousel-1-text" class="form-label mt-1">Text</label>
                            <input type="text" name="carousel-1-text" id="carousel-1-text" class="form-control" value="<?php if(isset($row['car_1_text']) && $row['car_1_text'] != null){ echo $row['car_1_text'];  } ?>">
                        </div>                        
                        <button type="submit" class="btn btn-primary btn-sm mt-2" name="firstCarouselBtn">Save</button>
                    </form>
                </div>
                <!-- Carousel 2 -->
                <div class="col-sm-4 col-md-4 col-lg-4 mt-2">
                    <span class="text-danger">2nd Carousel</span>
                    <form action="./code.php" method="post" class="mt-1" enctype="multipart/form-data">
                        <div>
                            <input type="file" name="carousel-2-img" id="carousel-2-img" class="form-control">
                        </div>
                        <div>
                            <label for="carousel-2-heading" class="form-label mt-1">Heading</label>
                            <input type="text" name="carousel-2-heading" id="carousel-2-heading" class="form-control" value="<?php if(isset($row['car_2_heading']) && $row['car_2_heading'] != null){ echo $row['car_2_heading'];  } ?>">
                        </div>
                        <div>
                            <label for="carousel-2-text" class="form-label mt-1">Text</label>
                            <input type="text" name="carousel-2-text" id="carousel-2-text" class="form-control" value="<?php if(isset($row['car_2_text']) && $row['car_2_text'] != null){ echo $row['car_2_text'];  } ?>">
                        </div>                        
                        <button type="submit" class="btn btn-primary btn-sm mt-2" name="secondCarouselBtn">Save</button>
                    </form>
                </div>
                <!-- Carousel 3 -->
                <div class="col-sm-4 col-md-4 col-lg-4 mt-2">
                    <span class="text-danger">3rd Carousel</span>
                    <form action="./code.php" method="post" class="mt-1" enctype="multipart/form-data">
                        <div>
                            <input type="file" name="carousel-3-img" id="carousel-3-img" class="form-control">
                        </div>
                        <div>
                            <label for="carousel-3-heading" class="form-label mt-1">Heading</label>
                            <input type="text" name="carousel-3-heading" id="carousel-3-heading" class="form-control" value="<?php if(isset($row['car_3_heading']) && $row['car_3_heading'] != null){ echo $row['car_3_heading'];  } ?>">
                        </div>
                        <div>
                            <label for="carousel-3-text" class="form-label mt-1">Text</label>
                            <input type="text" name="carousel-3-text" id="carousel-3-text" class="form-control" value="<?php if(isset($row['car_3_text']) && $row['car_3_text'] != null){ echo $row['car_3_text'];  } ?>">
                        </div>                        
                        <button type="submit" class="btn btn-primary btn-sm mt-2" name="thirdCarouselBtn">Save</button>
                    </form>
                </div>                
            </div>
        </div>
        <!-- For Add Recovery Email -->
        <div class="border border-success m-4 mt-4 mb-3 p-3 rounded">
            <strong><i class="bi bi-envelope-fill me-1"></i>SMTP Details</strong>
            <form action="./code.php" method="post" class="mt-3">
                <div>
                    <label for="smtpMail" class="form-label">Email</label>
                    <input type="email" name="smtpMail" id="smtpMail" class="form-control" value="<?php if(isset($row['sEmail']) && $row['sEmail'] != null){ echo $row['sEmail'];  } ?>">
                </div>
                <div>
                    <label for="appPass" class="form-label">App Password</label>
                    <input type="text" name="appPass" id="appPass" class="form-control" value="<?php if(isset($row['app_pass']) && $row['app_pass'] != null){ echo $row['app_pass'];  } ?>">
                </div>
                <button type="submit" class="btn btn-sm btn-primary mt-2" name="SmtpDetailsBtn">Add</button>
            </form>
        </div>

        <!-- Reset Button  -->
        <form action="./code.php" method="post" class="m-4 text-center">
            <input type="submit" name="resetSetting" id="resetSetting" class="btn btn-danger btn-sm mb-4 mt-3" value="Reset Setting">
        </form>
        <?php
            }
        ?>
    </div>
</div>



<?php
include('./MainInclude/footer.php');
?>