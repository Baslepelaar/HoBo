<?php
/**
 * Copyright (c) 2017 Netixy Development
 */
	function getFollowedParks($id) {
		
		require_once('ini.php');
		
		$email = getEmail($id);
		
        $sql="SELECT * FROM `parks` WHERE `followers` LIKE '%{$email}%'";
        $result = connection()->query($sql);
        $count=mysqli_num_rows($result);
        $parks = "";
        if($count > 0){
            $counter = 1;
            while($row = mysqli_fetch_assoc($result)) {
                if($count <= $counter) {
                    $parks = $parks." ".$row['id'];
                } else {
                    $parks = $parks." ".$row['id'].",";
                }
                $counter++;
            }
        }
        return $parks;
    }
    function loadArticles($pageid, $id) {
		
		require_once('ini.php');
		
        $pagefeed = $pageid*10;
		if(isPlayerFollowingAnyPark($_SESSION['id'])) {
        $parksfollowed = getFollowedParks($id);
        $sql = "SELECT * FROM `posts` WHERE `deleted`='0' AND `reviewed`='1' AND `park_id` IN (".$parksfollowed.") order by id desc LIMIT $pagefeed, 10";
        $result = connection()->query($sql);
        $count = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) {
                if (isFollowing($_SESSION['id'], $row['park_id'])) {
                    $parkname = getParkname($row['park_id']);
                    $logo = getParklogo($row['park_id']);
                    echo '<div class="box">
						<div class="media">
							<div class="media-left">
								<a href="park.php?id='.$row['park_id'].'"><img src="'.$logo.'" class="media-object img-circle" style="width:60px"></a>
							</div>
							<div class="media-body">
								<h5 class="media-heading"><a href="park.php?id='.$row['park_id'].'" class="park-link"><strong>'.$parkname.'</strong></a><span> -  '.$row['posted_on'].'</span></h5>
								<a href="article.php?id='.$row['id'].'" class="article-link">
								<h4>'.$row['post_title'].'</h4>
								<img src="'.$row['post_poster'].'" class="img-rounded" width="100%">
								</a>
								<h4>';
								if(isLikingPost($_SESSION['id'], $row['id']))
								{
									echo '<a href="article.php?id='.$row['id'].'&unlike" class="like"><i class="fa fa-heart" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>';
								}
								else {
									echo '<a href="article.php?id='.$row['id'].'&like" class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>';
								}
								if(hasCommentPost($_SESSION['id'], $row['id']))
								{
									echo '<a href="article.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a>';
								}
								else {
									echo '<a href="article.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a>';
								}
					echo 		'</h4>
							</div>
						</div>
					</div>';		
				}
            }
        } else {
            $sql = "SELECT * FROM `posts` WHERE deleted='0' AND reviewed='1' order by ID desc LIMIT $pagefeed, 10";
			$result = connection()->query($sql);
            $count = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) {
                if (!isParkDelted($row['park_id'])) {
                    $parkname = getParkname($row['park_id']);
                    $logo = getParklogo($row['park_id']);
                    echo '<div class="box">
						<div class="media">
							<div class="media-left">
								<a href="park.php?id='.$row['park_id'].'"><img src="'.$logo.'" class="media-object img-circle" style="width:60px"></a>
							</div>
							<div class="media-body">
								<h5 class="media-heading"><a href="park.php?id='.$row['park_id'].'" class="park-link"><strong>'.$parkname.'</strong></a><span> -  '.$row['posted_on'].'</span></h5>
								<a href="article.php?id='.$row['id'].'" class="article-link">
								<h4>'.$row['post_title'].'</h4>
								<img src="'.$row['post_poster'].'" class="img-rounded" width="100%">
								</a>
								<h4>';
								if(isLikingPost($_SESSION['id'], $row['id']))
								{
									echo '<a href="article.php?id='.$row['id'].'&unlike" class="like"><i class="fa fa-heart" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>';
								}
								else {
									echo '<a href="article.php?id='.$row['id'].'&like" class="like"><i class="fa fa-heart-o" aria-hidden="true"></i> <strong>'.countLikesPost($row['id']).'</strong></a>';
								}
								if(hasCommentPost($_SESSION['id'], $row['id']))
								{
									echo '<a href="article.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a>';
								}
								else {
									echo '<a href="article.php?id='.$row['id'].'" class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> <strong>'.countCommentsPost($row['id']).'</strong></a>';
								}
					echo 		'</h4>
							</div>
						</div>
					</div>';
                }
            }
        }
    }
?>