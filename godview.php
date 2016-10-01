<?php 
  require_once('./includes/db.php');
  require_once('./includes/session.php');
  
  if ( $_SESSION['Id'] >= 3 || !$_SESSION['Id']) {
    if($_SESSION['Id'] != 14){
	header('Location: /');}
  }  
?>
<html>
	<head>
		<title>Wordo God View</title>
		<style>
			body {
				font-family: San Francisco Display, 'Roboto', Helvetica;
				width: 100%;
				margin: 100px auto;
				color: gray;
			}
			
			table {
				border-collapse: collapse;
				width: 200px;
			}
			
			 td {
				border: 1px dashed #d4d4d4;
				padding: 15px 25px 15px 25px;
				text-align: center;
			}
			
			a {
				text-decoration: none;
				color: inherit;
			}
			
			a:hover {
				color: #333;
			}
			
			h1 {
				color: black;
			}
			
			td img {
				opacity: 0.1;
			}
			
			td img:hover {
				opacity: 0.4;
			}
			
.back {
	background: #fbfbfb;
    width: 100%;
    height: 50px;
    text-align: center;
    line-height: 50px;
    color: gray;
    text-shadow: 1px 1px white;
    margin: 0 auto;
    position: fixed;
    top: 0;
    z-index: 1;
    zoom: 1.3;
}

.back:hover {
	background: #f2f2f2;
}

tr:hover {
	background: #fbfbfb;
	text-shadow: 1px 1px white;
}
			
		</style>
	</head>
	<body>
		
		<a href="/"><div class="back">&#8592; Back to wordo</div></a>
		<center>
		
		<h1>Total Statistics</h1>
<table>
    <tr>
        <td colspan="2">total statistics</td>
    </tr>
    <?php 
      $sql = "select count(*) as users_count from users;";
      $query = $db->prepare( $sql );
      $query->execute();
      $result = $query->fetch();
    ?>
    
    <tr>
        <td>users</td>
        <td><?php echo $result['users_count']; ?></td>
    </tr>
    <?php 
      $sql = "select count(*) as likes_count from user_words;";
      $query = $db->prepare( $sql );
      $query->execute();
      $result = $query->fetch();
    ?>
    <tr>
        <td>likes</td>
        <td><?php echo $result['likes_count']; ?></td>
    </tr>
</table>


<br><br>

<h1>Userbase</h1>

<table>

  <tr>
    <th>#</th>
    <th>Username</th>
    <th>Followers</th>
    <th>Email</th>
    <th>Twitter</th>
  </tr>
  <?php 
      $sql = "select u.Id, u.screen_name, (select count(*) from users_followed uf where uf.followed_user_id = u.Id) as followers, u.email from users u order by u.Id;";
      $query = $db->prepare( $sql );
      $query->execute();
      $result = $query->fetchAll();
      
      foreach($result as $row) {
  ?>
  <tr>
    <td><?php echo $row['Id']; ?></td>
    <td><a href="./@<?php echo $row['screen_name']; ?>" target="_blank"><?php echo $row['screen_name']; ?></a></td>
    <td><?php echo $row['followers']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><a href="http://twitter.com/<?php echo $row['screen_name']; ?>" target="_blank"><img src="assets/images/twitter-icon.png" width="16"></a></td>
  </tr>
  <?php } ?>
</table>
		
		
		</center>
	</body>
</html>
