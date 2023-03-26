<!DOCTYPE html>
<html>
	<head>
		<title>Game Recommendations</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Game Recommendations</h1>
		<div class="container"> 
			<div id="recommendations">
				<?php
					// Connect to the database
					$servername = "fdb1030.awardspace.net";
					$username = "4285319_cd680";
					$password = "Derp!678";
					$dbname = "4285319_cd680";
					
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					
					// Fetch the recommendations from the database
					$sql = "SELECT * FROM Recommendations ORDER BY Article_Date DESC";
					$result = mysqli_query($conn, $sql);
					
					// Generate the dynamic content
					echo '<div class="dynamic-div">';
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<div class="recommendation">';
						echo '<img src="' . $row['Thumbnail'] . '" class="thumbnail">';
						echo '<div class="recommendation-content">';
						echo '<h2 class="game-title">' . $row['Game_Title'] . '</h2>';
						echo '<p class="game-description">' . $row['Game_Description'] . '</p>';
						echo '<a href="' . $row['Link'] . '" class="read-more-button">Read More</a>';
						echo '</div>';
						echo '</div>';
					}
					echo '</div>';
					
					// Close the database connection
					mysqli_close($conn);
				?>
			</div>
			
			<aside id="history">
				<h3>Page History</h3>
				<?php
					//connect to the database
					$servername = "fdb1030.awardspace.net";
					$username = "4285319_cd680";
					$password = "Derp!678";
					$dbname = "4285319_cd680";
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					
					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					
					//get the page history from the database
					$sql = "SELECT Game_Title, Link FROM Recommendations ORDER BY Article_Date DESC";
					$result = mysqli_query($conn, $sql);
					
					//loop through the results and display them as hyperlinks
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							echo "<li><a href='" . $row["Link"] . "'>" . $row["Game_Title"] . "</a></li>";
						}
						} else {
						echo "<li>No articles found.</li>";
					}
					
					//close the database connection
					mysqli_close($conn);
				?>
			</aside>
		</div>
	</body>
</html>			