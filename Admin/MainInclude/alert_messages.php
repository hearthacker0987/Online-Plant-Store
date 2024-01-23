<div class="mt-1 myalert">
    <!----------- Alert Message Code ----------->
    <?php
    if (isset($_SESSION['status_danger'])) {
        echo '
                <div class="mb-3">
                  <div class="alert alert-danger alert-dismissible message" role="alert">
                    <i class="fa-sharp fa-solid fa-circle-exclamation"></i><strong></strong>' . $_SESSION['status_danger'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                </div>
                ';
        unset($_SESSION['status_danger']);
    } else if (isset($_SESSION['status_success'])) {
        echo '
                <div class="mb-3 ">
                  <div class="alert alert-success alert-dismissible message" role="alert">
                  <i class="fa-sharp fa-solid fa-circle-check"></i>
                  <strong>' . $_SESSION['status_success'] . '  </strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                </div>
                ';
        unset($_SESSION['status_success']);
    }
    ?>
</div>