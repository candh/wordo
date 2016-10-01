<?php 
  require_once('includes/functions.php');
	require_once('includes/header.php');
?>
<div class="wrapper">
<div class="container">
<form id="foo" action="./">
	<input class="search" name="search" type="text" placeholder="Search for definitions" autofocus autocomplete="off" autocapitalize="off" value="" />
	<?php 
		$word = substr($_SERVER['REQUEST_URI'],1);
		if ($is_user_logged_in) {
	?>
		<span class="mywl-link" style="display: block; top:-60px; left:-7px;">
		<img src="../assets/images/loading.gif" alt="Loading" title="Loading" class="mywl-hide mywl-img">
  		 <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
    	  <path class="unliked-heart" d="M12 9.229c.234-1.12 1.547-6.229 5.382-6.229 2.22 0 4.618 1.551 4.618 5.003 0 3.907-3.627 8.47-10 12.629-6.373-4.159-10-8.722-10-12.629 0-3.484 2.369-5.005 4.577-5.005 3.923 0 5.145 5.126 5.423 6.231zm-12-1.226c0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-7.962-9.648-9.028-12-3.737-2.338-5.262-12-4.27-12 3.737z" style="fill:#d4d4d4;"></path>
    	  <path class="liked-heart" d="M12 4.435c-1.989-5.399-12-4.597-12 3.568 0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-8.118-10-8.999-12-3.568z" style="fill:red; display:none;"></path>
       </svg>
    </span>
	<?php 
	} else { ?>
		<a href='./login.php'>
		<span class="mywl-link-login" style="display: block; top:-60px; left:-7px;">
		<img src="../assets/images/loading.gif" alt="Loading" title="Loading" class="mywl-hide mywl-img">
		   <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
    	  <path d="M12 9.229c.234-1.12 1.547-6.229 5.382-6.229 2.22 0 4.618 1.551 4.618 5.003 0 3.907-3.627 8.47-10 12.629-6.373-4.159-10-8.722-10-12.629 0-3.484 2.369-5.005 4.577-5.005 3.923 0 5.145 5.126 5.423 6.231zm-12-1.226c0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-7.962-9.648-9.028-12-3.737-2.338-5.262-12-4.27-12 3.737z" style="fill:#d4d4d4;"></path>
       </svg>
    </span>
		</a>
	<?php
	}
	?>
	<br/>
</form>
<div id="detail">
	<div id="result">
	<?php echo wordo_get_result();?>
	</div>
	<?php
		if ($is_user_logged_in) {
	?>
	<div id="notes"></div>
	<?php 
		}
	?>
</div>
<div id="log"></div>
</div>
</div>
<div class="notes" style="display: none;">
	
    <center style="height: 25px;">
        <div id="word-likes-tab-header" class="profiletabs" style="border-right:0;"></div>
    </center>
    <ul id="word-likes-tab" class="content-tab">
    </ul>
    
</div>

	
<?php require_once('includes/footer.php'); ?>