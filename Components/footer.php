<footer class="container-fluid text-white " style="background:linear-gradient(#04BF00,#015D00);margin-top:380px;">
    <div class="row pt-2 pb-2">
        <!-- <div class="col-4"></div> -->
        <div class="col-8 text-end">
            <?php 
                $query = "SELECT * FROM setting";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    if(isset($row['web_name']) && $row['web_name'] != null){
                        echo "Copyright © 2023 <strong>".$row['web_name']."</strong> All Rights Reserved ";
                    }
                    else{
                        echo "Copyright © 2023 Website All Rights Reserved ";
                    }
                }else{
                    echo "Copyright © 2023 Website All Rights Reserved ";
                }
            ?>
        </div>

        <div class="col-4 text-end ">
        <?php 
            $query = "SELECT * FROM setting";
            $result = mysqli_query($conn,$query);
            if($result){
                $links = mysqli_fetch_assoc($result);
            }
        ?>
            <a href="<?php if(isset($links['fb_link'])){ echo $links['fb_link'];}?>" class="text-white ms-1" target="_blank"><i class="bi bi-facebook fs-5"></i></a>
            <a href="<?php if(isset($links['insta_link'])){ echo $links['insta_link'];}?>" class="text-white ms-1" target="_blank"><i class="bi bi-youtube fs-5"></i></a>
            <a href="<?php if(isset($links['you_link'])){ echo $links['you_link'];}?>" class="text-white ms-1" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
            <a href="<?php if(isset($links['whatsapp'])){ echo $links['whatsapp'];}?>" class="text-white ms-1" target="_blank"><i class="bi bi-whatsapp fs-5"></i></a>
        </div>
    </div>
</footer>
<?php
    include('./Admin/MainInclude/alert_messages.php');
    ob_end_flush();
    $conn->close();
?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./Assets/js/myjavaScript.js"></script>
</body>

</html>