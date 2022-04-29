<?php
/* Alert */
//session_start();
if(isset($_GET['alert']) && isset($_GET['message'])) {
    ?>
    <div class="alert alert-<?php echo $_GET['alert'] ?> alert-dismissable fadein" style="margin-bottom: 0rem;">
        <a href="?" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo $_GET['message'] ?>
    </div>
<?php
}
?>