<?php
	// connect to the database
	$db_host = 'fdb1030.awardspace.net';
	$db_name = '4285319_cd680';
	$db_user = '4285319_cd680';
	$db_pass = 'Derp!678';
	$db_conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	// get the game title from the URL parameter
	$game_title = "Obduction";
	$URL="obduction.php";
	
	// get the recommendation from the database
	$query = "SELECT * FROM Recommendations WHERE Game_Title='$game_title'";
	$result = mysqli_query($db_conn, $query);
	$recommendation = mysqli_fetch_assoc($result);
	
	// get the comments for the recommendation
	$recommendation_id = $recommendation['Recommendation_ID'];
	$query = "SELECT * FROM Comments WHERE Recommendation_ID='$recommendation_id'";
	$result = mysqli_query($db_conn, $query);
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="content.css">
	</head>
	<body>
		<header>
			<div class="container">
				<div class="logo">
					<h1>Game Recommendations</h1>
				</div>
				<div class="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
					</ul>
				</div>
			</div>
		</header>
		
		<section id="content">
			<div class="container">
				<div class="game-details">
					<img src="<?php echo $recommendation['Thumbnail']; ?>">
					<div class="details">
						<h2><?php echo $recommendation['Game_Title']; ?></h2>
						<p><strong>Game Description: </strong><?php echo $recommendation['Game_Description']; ?></p>
						<p><strong>Game Publisher: </strong><?php echo $recommendation['Game_Publisher']; ?></p>
						<p><strong>Release Date: </strong><?php echo $recommendation['Release_Date']; ?></p>
						<p><strong>Article Date: </strong><?php echo $recommendation['Article_Date']; ?></p>
					</div>
				</div>
				<div class="article">
					<?php echo $recommendation['Article']; ?>
				</div>
			</div>
			
			<div class="comments">
				<div class="comment-form">
					
					<h3>Add a comment:</h3>
					<form method="post">
						<label for="comment_content">Comment:</label>
						<textarea id="comment_content" name="comment_content" required></textarea>
						<input type="submit" name="add_comment" id="add_comment" value="Submit"/>
						<script>
							if ( window.history.replaceState ) {
								window.history.replaceState( null, null, window.location.href );
							}
						</script>
					</form>
					<?php
						if(isset($_POST['add_comment'])) {
							$conn = $GLOBALS['db_conn'];
							$recommendation_id = $GLOBALS['recommendation_id'];
							$result = mysqli_query($conn, "SELECT MAX(Comment_ID) AS max_id FROM Comments");
							$row = mysqli_fetch_assoc($result);
							$comment_id = $row['max_id'] + 1;
							$comment_content = $_POST["comment_content"];
							$sql = "INSERT INTO Comments (Comment_ID, Comment_Content, Recommendation_ID) VALUES ('$comment_id', '$comment_content', '$recommendation_id')";
							if ($conn->query($sql) === TRUE) {
								echo "New comment added successfully";
								} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							} 
							$URL = $GLOBALS['URL'];
							echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
							echo '<meta http-equiv="refresh" content="0; url=' . $URL . '">';
						}
					?>
				</div>
				
				<?php if (empty($comments)): ?>
				<p>No comments yet.</p>
                <?php else: ?>
				<ul>
					<?php foreach ($comments as $comment): ?>
					<li><?php echo $comment['Comment_Content']; ?></li>
					<?php endforeach; ?>
				</ul>
                <?php endif; ?>
				
			</div>
			
			
		</section>
	</body>
</html>				