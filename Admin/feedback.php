<?php
include('./MainInclude/header.php');
include('../dbConnection.php');
?>


<!-- For Submit Admin Reply  -->
<?php
if(isset($_POST['feedbackReplyBtn'])){
    $feedback_id = $_POST['feedback_id_input'];
    $reply = $conn->real_escape_string($_POST['reply']);
    if($reply == ''){
        $_SESSION['status_success'] = "Invalid Input!";
    }
    else{
        $query = "UPDATE user_feedback SET admin_reply = '$reply' , reply_date = CURRENT_TIMESTAMP() WHERE feedback_id = '$feedback_id'";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = "Reply Submitted Successfully";
        }
        else
        {
            $_SESSION['status_danger'] = "Reply not submit due to some technical issues";
        }
    }
}
?>
<div class="div-2 w-100 " style="overflow-y:auto;">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow mb-4 mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white text-center w-100">User Feedback</strong>
        </h5>
        <div class="d-flex justify-content-center">
            <form action="" method="post" class=" d-flex  col-md-6 ">
                <input type="text" name="search_feedback_input" id="search_feedback_input" class="form-control searchBar " placeholder="Search Order">
                <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
            </form>            
        </div>
        <div class="continer-fluid mt-3" style="overflow-x:auto;">
            <table class="table table-hover table-responsive" id="feedback_table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Username</th>
                        <th scope="col">Product</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Reply</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM user_feedback AS f 
                        JOIN users AS u ON f.user_id = u.user_id
                        JOIN products AS p ON f.prod_id = p.prod_id";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) > 0){
                            while($rows = mysqli_fetch_assoc($result)){
                                
                    ?>
                    <tr class="">
                        <th scope="row" class="fb_id"><?php if(isset($rows['feedback_id'])){ echo $rows['feedback_id'];} ?></th>
                        <td>
                            <!-- Convert DateTime to Date  -->
                            <?php 
                                $timestamp =  $rows['date'];
                                $dateTime = new DateTime($timestamp);
                                $date = $dateTime->format('M-d-Y');
                                echo $date;
                            ?>
                        </td>
                        <td><?php if(isset($rows['user_name'])){ echo $rows['user_name'];} ?></td>
                        <td><?php if(isset($rows['prod_name'])){ echo $rows['prod_name'];} ?></td>
                        <td><?php if(isset($rows['comment'])){ echo $rows['comment'];} ?></td>
                        <td><?php if(isset($rows['admin_reply']) && $rows['admin_reply'] != null){ echo $rows['admin_reply'];}
                        else{ echo "No reply";} ?></td>
                        <td><button class="btn btn-primary btn-sm replyBtn"> Reply</button></td>
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

<!-- Reply Modal  -->
<div class="modal fade" id="replyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Reply</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
            <input type="hidden" name="feedback_id_input" id="feedback_id_input" class="form-control mt-2 mb-2 feedback_id_input">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="reply" id="floatingTextarea" style="height: 200px;"></textarea>
                <label for="floatingTextarea">Write Message</label>
            </div>
            <br>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-sm" name="feedbackReplyBtn">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include('./MainInclude/footer.php');
?>