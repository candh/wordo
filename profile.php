<?php require_once('./includes/header.php'); ?>
<?php
    $screen_name = $_GET['screen_name'];
    $sql = "select Id, screen_name, email, profile_image from users where screen_name = substr(:screen_name,2)";
    $query = $db->prepare( $sql );
    $query->execute( array( ':screen_name'=>$screen_name));
	
	if(!$query->rowCount()) {
		header('Location: /');
	}
	
	$user_object = $query->fetch();
  if (($_SESSION['Id']) && ($user_object['Id'] != $_SESSION['Id'])) {
    $sql = "select 1 as follows_you from users_followed uf where uf.followed_user_Id = :logged_In_User and uf.user_Id = :user_Id";
    $is_following = $db->prepare( $sql );
  	$is_following -> execute(array(':logged_In_User'=>$_SESSION['Id'], ':user_Id'=>$user_object['Id']));
   $follows_you = $is_following->fetch();
  }
?>


<div class="wrapper">
<div class="container">
	<a href="http://twitter.com/<?php echo $user_object['screen_name']; ?>" target="_blank" rel="nofollow" style="display: inline-flex;">
    <div class="profileimg" style="<?php echo "background: url(".str_replace('_normal','',$user_object['profile_image']).") no-repeat center; background-size: contain;"; ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
    </div></a>
    <h3><?php echo '@'.$user_object['screen_name']; ?></h3> 
    <?php if (!$_SESSION['Id']) { ?>
            <a href='./login.php'><button id="login-to-follow" class="button-green">Follow</button></a>
    <?php } elseif ($user_object['Id'] != $_SESSION['Id']) {
 
              if($follows_you['follows_you']){
    ?>
                <div class="followsyou">Follows you</div>
    <?php
              }
    ?>
      
			<button id="<?php echo $user_object['Id'].'@'.$user_object['screen_name']; ?>" class="button-green follow-user-button">Follow</button>
	<?php } ?>
</div>
</div>

<div class="notes-profile">
    <center style="height: 25px;">
        <?php
            $sql = "select user_word from user_words where user_Id = :user_Id";
            $likes_query = $db->prepare( $sql );
            $likes_query->execute( array( ':user_Id'=>$user_object['Id']));
            
            $sql = "select u.screen_name from users_followed uf inner join users u on u.Id = uf.followed_user_Id where uf.user_Id = :user_Id";
		    $followings_query = $db->prepare( $sql );
	        $followings_query->execute( array( ':user_Id'=>$user_object['Id']));
	        
	        $sql = "select u.screen_name from users_followed uf inner join users u on u.Id = uf.user_Id where uf.followed_user_Id = :user_Id";
		    $followers_query = $db->prepare( $sql );
		    $followers_query->execute( array( ':user_Id'=>$user_object['Id']));
		?>
        <div id="user-likes-tab-header" class="profiletabs" onclick="(function(){$('.content-tab').hide();$('#user-likes-tab').show();})()"><?php echo $likes_query->rowCount(); ?> Like<?php echo $likes_query->rowCount()==1?'':'s'; ?></div>
        <div id="user-followings-tab-header" class="profiletabs" onclick="(function(){$('.content-tab').hide();$('#user-followings-tab').show();})()"><?php echo $followings_query->rowCount(); ?> Following<?php echo $followings_query->rowCount()==1?'':'s'; ?></div>
        <div id="user-followers-tab-header" class="profiletabs" onclick="(function(){$('.content-tab').hide();$('#user-followers-tab').show();})()" style="border-right:0;"><?php echo $followers_query->rowCount(); ?> Follower<?php echo $followers_query->rowCount()==1?'':'s'; ?></div>
    </center>

    <ul id="user-likes-tab" class="content-tab">
        <?php if ($likes_query->rowCount()){ ?>
                    <b><?php echo $likes_query->rowCount() ?> like<?php echo $likes_query->rowCount()==1?'':'s'; ?></b>
        <?php   foreach ($likes_query as $user_likes){ ?>
                    <li> <a href="./<?php echo $user_likes['user_word']; ?>"><?php echo $user_likes['user_word']; ?></a></li>
        <?php   } 
              } else { ?>
                    <?php if ($user_object['Id'] == $_SESSION['Id']) { ?>
                        <li>Like some words, and check back here in a minute <img src="http://emojipedia-us.s3.amazonaws.com/cache/e2/fc/e2fc91084bd4870dd2dc8947adc1f363.png" width="25" style="vertical-align:bottom;"></li>
                    <?php } else { ?>
                        <li><?php echo '@'.$user_object['screen_name']; ?> hasn't liked any words yet...</li>
                    <?php } ?>
        <?php } ?>
    </ul>
    
    <ul id="user-followings-tab" class="content-tab" style="display:none;">
        <?php if ($followings_query->rowCount()){ ?>
                    <b><?php echo $followings_query->rowCount() ?> following<?php echo $followings_query->rowCount()==1?'':'s'; ?></b>
        <?php   foreach ($followings_query as $user_followings){ ?>
                    <li> <a href="./<?php echo '@'.$user_followings['screen_name']; ?>"><?php echo $user_followings['screen_name']; ?></a></li>
        <?php   } 
              } else { ?>
                    <?php if ($user_object['Id'] == $_SESSION['Id']) { ?>
                        <li>Start following others, its more fun with friends around...</li>
                    <?php } else { ?>
                        <li><?php echo '@'.$user_object['screen_name']; ?> is enjoying solitude...</li>
                    <?php } ?>
        <?php } ?>
    </ul>
    
    <ul id="user-followers-tab" class="content-tab" style="display:none;">
        <?php if ($followers_query->rowCount()){ ?>
                    <b><?php echo $followers_query->rowCount() ?> follower<?php echo $followers_query->rowCount()==1?'':'s'; ?></b>
        <?php   foreach ($followers_query as $user_followers){ ?>
                    <li> <a href="./<?php echo '@'.$user_followers['screen_name']; ?>"><?php echo $user_followers['screen_name']; ?></a></li>
        <?php   } 
              } else { ?>
                    <?php if ($user_object['Id'] == $_SESSION['Id']) { ?>
                        <li>You have no followers. Time to invite some friends...</li>
                    <?php } else { ?>
                        <li>You can be <?php echo '@'.$user_object['screen_name']; ?>'s first follower...</li>
                    <?php } ?>
                    
        <?php } ?>
    </ul>

<?php 
    if ($user_object['Id'] == $_SESSION['Id']) { ?>
    <a href="./logout.php"><button class="button-red logout-button">Logout</button></a>
<?php } ?>
</div>

<?php require_once('includes/footer.php'); ?>