<!DOCTYPE html>
<html lang="en">
<head>
	<title>Benvolio Bookstore</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

<?php
	
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "benvolio_bookstore";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM book WHERE no_in_stock > 0";
	$result = $conn->query($sql);

	print("Benvolio Bookstore<br/><br/>");
	if ($result->num_rows > 0) {
	    // output id of each row
	    while($row = $result->fetch_assoc()) {
	      echo $row["book_id"] . ". " . $row["title"]."<br>\n<br>\n";
	    }

	  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
	  print("Enter book number for more info: <br/> <input type=\"text\" name=\"book_number\">");
	  print("<br/>");
	  print("<input type=\"submit\" value=\"Submit\">");
	  print("</form>");

	  if ($_POST['book_number']) {
	  	$id = $_POST['book_number'];
	  	
	  	//output info about chosen book
	  	$result = $conn->query($sql);
	  	print("<br/>");
	  	while($row = $result->fetch_assoc()) {
	      if ($row["book_id"] == $id) {
	       	echo "ISBN: " . $row["ISBN"]. "<br>\n";
	       	echo "Title: " . $row["title"]. "<br>\n";
	       	echo "Page count: " . $row["page_count"]. "<br>\n";
	       	echo "Price: " . $row["price"]. "<br>\n";
	       	echo "No. in stock: " . $row["no_in_stock"]. "<br>\n";
	      }
	    }
	  }
	} else {
	    echo "0 results";
	}
	$conn->close();
?>

</body>
</html>