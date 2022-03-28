<?php
/* Alert */

$success = ($_GET['success']);
$info = ($_GET['info']);
$warning = ($_GET['warning']);
$danger = ($_GET['danger']);
if(isset($success)) {
    ?>
    <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $success; ?>
    </div>
<?php	}
if(isset($info)) {
    ?>
    <div class="alert alert-info alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $info; ?>
    </div>
<?php	}
if(isset($warning)) {
    ?>
    <div class="alert alert-warning alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $warning; ?>
    </div>
<?php	}
if(isset($danger)) {
    ?>
    <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $danger; ?>
    </div>
    <?php
}
?>