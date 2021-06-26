<!DOCTYPE html>
<html lang="en">
<head>
	<title>Benvolio Bookstore</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<style>
	table, th, td {
	  border: 1px solid black;
	}
	</style>

</head>

<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Benvolio Bookstore</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="?page=books">Books</a></li>      
      <li><a href="?page=authors">Authors</a></li>
      <li><a href="?page=genres">Genres</a></li>
      <li><a href="?page=sales">Sales</a></li>
    </ul>
  </div>
</nav>


<?php

	function list_books($conn) {	
		
		echo "<h1>Books</h1><div class='container'> <table class='table table-bordered'>";

		$result = $conn->query("SELECT * FROM book WHERE no_in_stock > 0");

		if ($result->num_rows > 0) {
		    // output id of each row
		   	echo "<tr><th>ID</th> <th>Title</th> <th>Price (THB)</th> <th>No. in stock</th></tr>";
		    while($row = $result->fetch_assoc()) {
		    	//echo $row["book_id"] . ". " . $row["title"]."<br>\n<br>\n";
		    	echo "<tr>";
       			echo "<td>".$row["book_id"]."</td>";
			    echo "<td>".$row["title"]."</td>";
			    echo "<td>".$row["price"]."</td>";
			    echo "<td>".$row["no_in_stock"]."</td>";

			    echo "</tr>";
		    }


			print("<br/>");
			print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
			print("Enter book ID for more info: <input type=\"text\" name=\"book_number\">");
			print("<input type=\"submit\" value=\"Submit\">");
			print("</form><br/>");

			if ($_POST['book_number']) {
		  		$id = $_POST['book_number'];
		  	
		  	//output info about chosen book
		  	$stmt = $conn->prepare("SELECT * FROM book WHERE book_id = ?");
		  	$ok = $stmt->bind_param("i", $id);
		  	if (!$ok) { die("Bind param error"); }
		  	$ok = $stmt->execute();
		  	if (!$ok) { die("Exec error"); }
	        $result = $stmt->get_result();

		  	print("<br/>");
		  	
		  	while($row = $result->fetch_assoc()) {
		      echo "Title: " . $row["title"]. "<br>\n";
		      echo "ISBN: " . $row["ISBN"]. "<br>\n";
		      echo "Page count: " . $row["page_count"]. "<br>\n";
		      echo "Release date: " . $row["release_date"]. "<br>\n";
		      //echo "Price: " . $row["price"]. "<br>\n";
		      //echo "No. in stock: " . $row["no_in_stock"]. "<br>\n";
		    }
		  }
		  echo '<br></table></div>';

		} else {
		    echo "0 results";
		}
	}
	
	function add_author($conn) {
		echo "<h2>Authors</h2><br/>";
		
		echo
		"<div class=\"container\">
		  	<form method=\"POST\">
		    <div class=\"form-group\">
		      <label for=\"author_id\">Author ID</label>
		      <input type=\"number\" required min=\"1\" max=\"99999\" class=\"form-control\" id=\"author_id\" placeholder=\"Enter author ID\" name=\"author_id\">
		    </div>
		    <div class=\"form-group\">
		      <label for=\"author_name\">Author name</label>
		      <input type=\"text\" required maxlength=\"30\" class=\"form-control\" id=\"author_name\" placeholder=\"Enter author name\" name=\"author_name\">
		    </div>
		    <div class=\"form-group\">
		      <label for=\"author_birth_date\">Date of birth</label>
		      <input type=\"date\" required class=\"form-control\" id=\"author_birth_date\" placeholder=\"Enter date of birth\" name=\"author_birth_date\">
		    </div>
		    <div class=\"form-group\">
		      <label for=\"author_country\">Country</label>
		      <input type=\"text\" required maxlength=\"30\" class=\"form-control\" id=\"author_country\" placeholder=\"Enter country\" name=\"author_country\">
		    </div>
		    <button type=\"submit\" class=\"btn btn-default\">Submit</button>
		  </form>
		</div>";
		
		//print_r($_POST);
		if (isset($_POST['author_id'])) {
			$author_id = $_POST['author_id'];
			$author_name = $_POST['author_name'];
			$author_birth_date = $_POST['author_birth_date'];
			$author_country = $_POST['author_country'];
			$sql = "insert into author (author_id, author_name, author_birth_date, author_country) values (?,?,?,?)";
			// prepare statement
			$stmt = $conn->prepare($sql);
		  	$ok = $stmt->bind_param('isss', $author_id, $author_name, $author_birth_date, $author_country);
		  	if (!$ok) { die("Bind param error"); }
		  	$ok = $stmt->execute();
		  	if (!$ok) { die("Exec error"); }
	        $result = $stmt->get_result();
		}
	}

	$servername = "localhost";
	$username = "tybalt";
	$password = "queenmab";
	$dbname = "benvolio_bookstore";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$page = $_GET['page'];
	if ($page == "" || $page == "books") {
		//lists books on main page
		list_books($conn);
	} elseif ($page == "authors") {
		//functionality to add author
		add_author($conn);
	} elseif ($page == "genres") {
		
	} else {
		
	}

	$conn->close();

?>

</body>
</html>
