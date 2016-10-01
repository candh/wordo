<title>Notifications on Wordo</title>
<?php 
	require_once('includes/header.php');
	require_once('includes/db.php'); 
    
?>
<div class="wrapper" style="padding-top: 50px;">
<div class="container" style="max-width: none !important; width: 800px !important;">

<?php 
	$user_Id = $_SESSION['Id'];
	
	if(!$user_Id) {
		header('Location: ./');
	}
?>
	<center style="height: 25px; margin-top: 100px;">
        <div id="user-followers-tab-header" class="notificationtabs"  style="border-right:0; margin-top: 45px;"><h3>Notifications</h3></div>
    </center><br><br>
<?php
	
	$sql = "select u.screen_name screen_name, uw.user_word user_word, null as followed_user_screen_name
		,DATE_FORMAT(uw.row_created_date,'%Y-%m-%dT%TZ-0400') as word_liked_time_ISO8601
		,DATE_FORMAT(uw.row_created_date,'%M %d, %Y') as word_liked_time
		,uw.row_created_date-(select last_seen_date from users where Id = :user_Id) newNotifications
		from user_words 
		uw inner join users_followed uf on uw.user_Id = uf.followed_user_Id 
		inner join users u on uf.followed_user_Id = u.Id
		where uf.user_Id = :user_Id
    
    union all
    
    select u.screen_name screen_name, null as user_word, u0.screen_name followed_user_screen_name
    		,DATE_FORMAT(uf0.row_created_date,'%Y-%m-%dT%TZ-0400') as word_liked_time_ISO8601
    		,DATE_FORMAT(uf0.row_created_date,'%M %d, %Y') as word_liked_time
    		,uf0.row_created_date-(select last_seen_date from users where Id = :user_Id) newNotifications
		from users_followed uf0 inner join users_followed uf on uf0.user_Id = uf.followed_user_Id 
		inner join users u0 on uf0.followed_user_Id = u0.Id inner join users u on uf.followed_user_Id = u.Id
		where uf.user_Id = :user_Id and uf0.followed_user_Id <> :user_Id
    		
		union all		
				
		select u.screen_name screen_name, null as user_word,  null as followed_user_screen_name
				,DATE_FORMAT(uf.row_created_date,'%Y-%m-%dT%TZ-0400') as word_liked_time_ISO8601
				,DATE_FORMAT(uf.row_created_date,'%M %d, %Y') as word_liked_time
				,uf.row_created_date-(select last_seen_date from users where Id = :user_Id) newNotifications
		from users_followed uf  inner join users u on uf.user_Id = u.Id where uf.followed_user_Id = :user_Id
			order by 4 desc";
    $query = $db->prepare( $sql );
    $query->execute( array( ':user_Id'=>$user_Id));
    
    if ($query->rowCount()){
    	echo '<div class="notification"><ul>';
      $count = 0;
   		foreach ($query as $row){
        $count++;  
        echo "<li class='".(($row['newNotifications']>=0)?'new-notifications':'')."' style ='".(($count>25)?'display:none;':'')."'><div>";
        if($row['user_word'] != null){		
        		echo "<b><a href='./@" . $row['screen_name'] . "'>@".$row['screen_name']."</a></b>
        			liked the word <b><a href='./" . $row['user_word'] . "'>".$row['user_word']."</a></b>, 
        			<time class='timeago' datetime='".$row['word_liked_time_ISO8601']."'>".$row['word_liked_time']."</time>";
        } elseif ($row['followed_user_screen_name'] != null) {
        		echo "Your friend <b><a href='./@" . $row['screen_name'] . "'>@".$row['screen_name']."</a></b>
        			started following <b><a href='./@" . $row['followed_user_screen_name'] . "'>@".$row['followed_user_screen_name']."</a></b>, 
        			<time class='timeago' datetime='".$row['word_liked_time_ISO8601']."'>".$row['word_liked_time']."</time>";
        } else {
        		echo "<b><a href='./@" . $row['screen_name'] . "'>@".$row['screen_name']."</a></b>
        			started following you, 
        			<time class='timeago' datetime='".$row['word_liked_time_ISO8601']."'>".$row['word_liked_time']."</time>";
       	}
        echo "</div></li>";
   		}
      echo "<li style ='".(($count>25)?'display:none;':'')."'><div style='font-size:1rem; margin-bottom:100px;'>
        				--- <b>All good things must come to an end</b> ---
        		 </div></li>";
   		echo '</ul>
   				<div class="showmore">Show more notifications</div>
       </div>';
	} else {
	    echo "You have no new notification...";
	}
	
	$sql = "update users set last_seen_date = now() where Id = :user_Id";
    $query = $db->prepare( $sql );
    $query->execute( array( ':user_Id'=>$user_Id));
	    
?>
</div>
</div>
<script type="text/javascript">
	$('.showmore').click(function(){
		if ($('.notification ul li:hidden').length <= 25)
			$('.showmore').hide(600);
		$('.notification ul li:hidden').slice(0,25).slideDown(600);
		
	});
</script>
<?php require_once('includes/footer.php'); ?>
