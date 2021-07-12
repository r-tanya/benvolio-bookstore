

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
	table, th, td, tr {
	  border: 1px solid black;
	  background-color: aquamarine;
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
      <li><a href="?page=genres">Genres</a></li>
      <li><a href="?page=sales">Sales</a></li>
      <li><a href="https://github.com/r-tanya/benvolio-bookstore/wiki">Help</a></li>
    </ul>
  </div>
</nav>


<?php

	$servername = "localhost";
	$username = "tybalt";
	$password = "queenmab";
	$dbname = "benvoliobookstore";


	function books_page($conn) {	
		
		echo "<div class='container'> <h1>Books</h1> <br> <table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";

		$result = $conn->query("SELECT * FROM book WHERE no_in_stock > 0");

		if ($result->num_rows > 0) {
		   	echo "<thead><tr><th>ID</th> <th>Title (click for more info)</th> <th>Price (THB)</th> <th>No. in stock</th></tr></thead><tbody>";
		    while($row = $result->fetch_assoc()) {
		    	echo "<tr>";
       	  		echo "<td>".$row["book_id"]."</td>";
			    echo "<td> <a href=\"?book_id=".$row["book_id"]."\">".$row["title"]."</a></td>";
			    echo "<td>".$row["price"]."</td>";
			    echo "<td>".$row["no_in_stock"]."</td>";
			    echo "</tr>";
		    }

		    echo '</tbody></table>';
			//print("<br/>");
			//print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
			//print("Enter book ID for more info: <input type=\"text\" name=\"book_number\">");
			//print("<input type=\"submit\" value=\"Submit\">");
			//print("</form><br/>");

			if ($_GET['book_id']) {
		  		$id = $_GET['book_id'];
		  	
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

				    $stmt = $conn->prepare("SELECT pub_name FROM publishing_house WHERE pub_id = ?");
				  	$ok = $stmt->bind_param("i", $row["pub_id"]);
				  	if (!$ok) { die("Bind param error"); }
				  	$ok = $stmt->execute();
				  	if (!$ok) { die("Exec error"); }
			      	$result = $stmt->get_result();
			      	$pubname = $result->fetch_row()[0];
			      	echo "Publisher: " .$pubname. "<br>\n";

			      	$stmt = $conn->prepare("SELECT author_id FROM author_book WHERE book_id = ?");
				  	$ok = $stmt->bind_param("i", $id);
				  	if (!$ok) { die("Bind param error"); }
				  	$ok = $stmt->execute();
				  	if (!$ok) { die("Exec error"); }
				  	
			      	$result2 = $stmt->get_result();

			      	echo "Author(s): ";

			      	$count = 1;
			      	while($row2 = $result2->fetch_assoc()) {
			      		$authid = $row2["author_id"];
			      		
			      		$stmt = $conn->prepare("SELECT author_name FROM author WHERE author_id = ?");
					  	$ok = $stmt->bind_param("i", $authid);
					  	if (!$ok) { die("Bind param error"); }
					  	$ok = $stmt->execute();
					  	if (!$ok) { die("Exec error"); }
				      	$result3 = $stmt->get_result();
				      	$authorname = $result3->fetch_row()[0];
				      	
				      	if ($count > 1) echo ", ";
				      	print($authorname);

				      	$count++;
			      	}

			    }
		  	}
		  	echo '</div>';
		} else {
		    echo "0 results";
		}


		echo "<form method='POST'>
	          </table></div>
	          <div class='container'> <h3>Add new</h3> <table class='table table-bordered'>	          
	          <tr>
	      		<th>Title</th> <td> <input type='text' id = 'Title' name='Title' required='true' maxlength='150'> </td>
	          </tr>
	          <tr>
	      		<th>ISBN</th> <td> <input type='text' id = 'ISBN' name='ISBN' required='true' maxlength='14'> </td>
	          </tr>
	          <tr>
	      		<th>Author(s)</th> <td> <input type='text' id = 'Authors' name='Authors' required='true' maxlength='150'> </td>
	       	  </tr>
	          <tr>
	      		<th>Publisher</th> <td> <input type='text' id = 'Publisher' name='Publisher' required='true' maxlength='30'> </td>
	          </tr>
	          <tr>
	      		<th>Publication date</th> <td> <input type='date' id = 'Publicationdate' name='Publicationdate' required='true'> </td>
	          </tr>
	          <tr>
	      		<th>Page count</th> <td> <input type='number' min = '1' max = '10000' id = 'Pagecount' name='Pagecount' required='true'> </td>
	          </tr>
	          <tr>
	      		<th>Price</th> <td> <input type='number' min = '1' max = '10000' id = 'Price' name='Price' required='true'> </td>
	          </tr>
	          <tr>
	      		<th>No. in stock</th> <td> <input type='number' min = '1' max = '10000' id = 'Noinstock' name='Noinstock' required='true'> </td>
	          </tr>
	          <tr>
	      		<td></td> <td colspan='2'><button type='submit'> Add Book </button> </td>
	          </tr>
	          </table></div>
	    </form>";



	    if (isset($_POST['Title'])) {
	    	$title = $_POST['Title'];
	    	$ISBN = $_POST['ISBN'];
	    	$pubdate = $_POST['Publicationdate'];
	    	$pagecount = $_POST['Pagecount'];
	    	$price = $_POST['Price'];
	    	$noinstock = $_POST['Noinstock'];
	    	$pubgiven = $_POST['Publisher'];
	    	$authgiven = $_POST['Authors'];

	    	$res = $conn->query("SELECT max(book_id) from book");
			if (!$res) { die("Query1 failed"); }
			$maxid = $res->fetch_row()[0];
			if (!$maxid) { $next = 1; } else { $next = $maxid + 1; }
			$bookid = $next;

			$sql = "SELECT pub_id from publishing_house where pub_name = ?";
			$stmt = $conn->prepare($sql);
			$ok = $stmt->bind_param('s', $pubgiven);
			if (!$ok) { die("Bind param error"); }
			$ok = $stmt->execute();
			if (!$ok) { die("Exec error"); }
		    $result = $stmt->get_result();
		    $pub_id = $result->fetch_row()[0];
			
			if (!$pub_id){ 
				$sql = "INSERT into publishing_house(pub_name) values (?)";
				$stmt = $conn->prepare($sql);
			  	$ok = $stmt->bind_param('s', $pubgiven);
			  	if (!$ok) { die("Bind param error"); }
			  	$ok = $stmt->execute();
			  	if (!$ok) { die("Exec error"); }
		        $result = $stmt->get_result();

		        $sql = "SELECT pub_id from publishing_house where pub_name = ?";
				$stmt = $conn->prepare($sql);
			  	$ok = $stmt->bind_param('s', $pubgiven);
			  	if (!$ok) { die("Bind param error"); }
			  	$ok = $stmt->execute();
			  	if (!$ok) { die("Exec error"); }
		        $result = $stmt->get_result();
		        $pub_id = $result->fetch_row()[0];
			}

			$sql = "INSERT into book values (?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($sql);
		  	$ok = $stmt->bind_param('isssiiii', $bookid, $ISBN, $title, $pubdate, $pagecount, $price, $noinstock, $pub_id);
		  	if (!$ok) { die("Bind param error"); }
		  	$ok = $stmt->execute();
		  	if (!$ok) { die("Exec error"); }
	        $result = $stmt->get_result();

	        $auth_arr = explode (", ", $authgiven);
	        
	        foreach($auth_arr as $value){
	        	
				$sql = "SELECT author_id from author where author_name = ?";
				$stmt = $conn->prepare($sql);
				$ok = $stmt->bind_param('s', $value);
				if (!$ok) { die("Bind param error"); }
				$ok = $stmt->execute();
				if (!$ok) { die("Exec error"); }
			    $result = $stmt->get_result();
			    $auth_id = $result->fetch_row()[0];
				
				if (!$auth_id){ 
					$sql = "INSERT into author(author_name) values (?)";
					$stmt = $conn->prepare($sql);
				  	$ok = $stmt->bind_param('s', $value);
				  	if (!$ok) { die("Bind param error"); }
				  	$ok = $stmt->execute();
				  	if (!$ok) { die("Exec error"); }
			        $result = $stmt->get_result();

			        $sql = "SELECT author_id from author where author_name = ?";
					$stmt = $conn->prepare($sql);
				  	$ok = $stmt->bind_param('s', $value);
				  	if (!$ok) { die("Bind param error"); }
				  	$ok = $stmt->execute();
				  	if (!$ok) { die("Exec error"); }
			        $result = $stmt->get_result();
			        $auth_id = $result->fetch_row()[0];
				}

				$sql = "INSERT into author_book values (?,?)";
				$stmt = $conn->prepare($sql);
			  	$ok = $stmt->bind_param('ii', $auth_id, $bookid);
			  	if (!$ok) { die("Bind param error"); }
			  	$ok = $stmt->execute();
			  	if (!$ok) { die("Execc error"); }
		        $result = $stmt->get_result();

	        }

	    }

	}
	
	function add_author($conn) {   // not used in this application
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
			$sql = "INSERT into author (author_id, author_name, author_birth_date, author_country) values (?,?,?,?)";
	
			$stmt = $conn->prepare($sql);
		  	$ok = $stmt->bind_param('isss', $author_id, $author_name, $author_birth_date, $author_country);
		  	if (!$ok) { die("Bind param error"); }
		  	$ok = $stmt->execute();
		  	if (!$ok) { die("Exec error"); }
	        $result = $stmt->get_result();
		}
	}

	function sales_page($conn) {

		$result = $conn->query("SELECT title, date, emp_id from book_sold, book where book_sold.book_id = book.book_id order by date");

		if ($result->num_rows > 0) {

			echo "<div class='container'> <h2>Sales</h2> <br> <table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";

			echo "<thead><tr><th></th> <th>Title</th> <th>Date Sold</th> <th>Employee ID</th></tr></thead><tbody>";
			$no = 1;
			while ($row = $result->fetch_assoc()) {
			    echo "<tr>";
			    echo "<td>".$no."."."</td>";
			    echo "<td>".$row["title"]."</td>";
			    echo "<td>".$row["date"]."</td>";
			    echo "<td>".$row["emp_id"]."</td>";
			    echo "</tr>";
			    $no = $no + 1;
			}
			echo "</tbody></table></div>";
		}

		else echo "0 results";

		$book_sel = "<select name='bookselect'>";
	    $result = $conn->query("SELECT * from book");
	    while ($row = $result->fetch_assoc()) {
	        $book_sel = $book_sel."<option value=".$row["book_id"].">".$row["title"]."</option>";
	    }
	    $book_sel = $book_sel."</select>";

		$emp_sel = "<select name='empselect'>";
	    $result = $conn->query("SELECT * from salesperson");
	    while ($row = $result->fetch_assoc()) {
	        $emp_sel = $emp_sel."<option value=".$row["emp_id"].">".$row["emp_id"]."</option>";
	    }
	    $emp_sel = $emp_sel."</select>";	    

		echo
	     "<form method='POST'>
	     	<input type='hidden' name='page' value='addsale'/>
	          </table></div>
	          <div class='container'> <h4>Add new</h4> <table class='table table-bordered'>
	          <tr> <th>Title</th> <th>Employee ID</th> <th> </th> </tr>

	          <tr>
	      		<td>".$book_sel."</td>
	      		<td>".$emp_sel."</td>
	      		<td colspan='4'><button type='submit'> Make Transaction </button></td>
	          </tr>
	          </table></div>
	    </form>";
	    //non-formatted data table, reference here


	    if (isset($_POST['page'])) {	
			$id_result = $_POST['bookselect'];
			$emp_id = $_POST['empselect'];
			$date = date("Y-m-d");

	        $res = $conn->query("UPDATE Book SET no_in_stock = no_in_stock - 1 WHERE book_id = ".$id_result);
	        //need to bind parameters(?)
	        if (!$res) { die("Query failed"); }

	        $res = $conn->query("SELECT max(item_sold_id) from book_sold");
			if (!$res) { die("Query failed"); }
			$maxid = $res->fetch_row()[0];
			if (!$maxid) { $next = 1; } else { $next = $maxid + 1; }
			
			$sql = "INSERT into book_sold values (?,?,?,?)";
			$stmt = $conn->prepare($sql);
		  	$ok = $stmt->bind_param('isii', $next, $date, $emp_id, $id_result);
		  	if (!$ok) { die("Bind param error"); }
		  	$ok = $stmt->execute();
		  	if (!$ok) { die("Exec error"); }
	        $result = $stmt->get_result();
		}
	}


	function genres_page($conn) {
		$result = $conn->query("SELECT genre_name from genre");

		echo "<div class='container'> <h2>Genres</h2> <br>";

		if ($result->num_rows > 0) {
			
			while ($row = $result->fetch_assoc()) {	

				$genre_res = $row["genre_name"];
				
				echo "<table class='table table-bordered'>";
				echo "<tr> <th>".$row["genre_name"]."</th> <th></th> </tr>";

				$stmt = $conn->prepare("SELECT title from book_genre, book where book_genre.book_id = book.book_id and genre_name = ?");
				$ok = $stmt->bind_param("s", $row["genre_name"]);
			  	if (!$ok) { die("Bind param error"); }	
			  	$ok = $stmt->execute();
			  	if (!$ok) { die("Exec error"); }
		        $result2 = $stmt->get_result();

				while ($row2 = $result2->fetch_assoc()) {
				    echo "<tr>";
				    echo "<td>".$row2["title"]."</td>";
				    echo "<td></td>";
				    echo "</tr>";
				}
				//possibility: using data tables

				$book_sel = "<select name='bookselect'>";
			    $result5 = $conn->query("SELECT * from book");
			    while ($row5 = $result5->fetch_assoc()) {
			        $book_sel = $book_sel."<option value=".$row5["book_id"].">".$row5["title"]."</option>";
			    }
			    $book_sel = $book_sel."</select>";

				echo "<form method='POST'>
				  <input type='hidden' name='page' value='addbook'/>
		          <input type='hidden' id='genrename' name='genrename' value='".$genre_res."'>
		          <tr>
		      		<td>".$book_sel."</td>
		      		<td colspan='4'><button type='submit'> Add Book </button></td>
		          </tr>
	    		</form>";
	    		echo "</table>";

	    		if (isset($_POST['page'])) {

	    			$id_result = $_POST['bookselect'];

	    			//$title = $_POST['Title'];
	    			$genre_ress = $_POST['genrename'];

		    		//$stmt = $conn->prepare("SELECT book_id FROM book WHERE title = ?");
				  	//$ok = $stmt->bind_param("s", $title);
				  	//if (!$ok) { die("Bind param error"); }	
				  	//$ok = $stmt->execute();
				  	//if (!$ok) { die("Exec error1"); }
			        //$result3 = $stmt->get_result();
			        //$id_result = $result3->fetch_row()[0];
			        //removed to accommodate dropdown

		    		$sql = "INSERT into book_genre values (?,?)";
					$stmt = $conn->prepare($sql);
			  		$ok = $stmt->bind_param('si', $genre_ress, $id_result);
			  		if (!$ok) { die("Bind param error"); }
			  		$ok = $stmt->execute();
			  		if (!$ok) { die("Exec error2"); }
		        	$result4 = $stmt->get_result();

		        	if (count($_POST) > 0) {
						$_POST = array();
					}
	        	}
			}
		}

		else echo "0 results";

		echo "</div>";

		echo
	     "<form method='POST'>
	          </table></div>
	          <div class='container'> <h4>Add new</h4> <table class='table table-bordered'>	          
	          <tr>
	      		<th>Genre</th> <td> <input type='text' id = 'Genre' name='Genre' required='true' maxlength='20'> </td>
	          </tr>
	          <tr>
	      		<th>Description</th> <td> <input type='text' id = 'Description' name='Description' required='true' maxlength='200'> </td>
	          </tr>
	          <tr>
	      		<td></td> <td colspan='2'><button type='submit'> Add Genre </button> </td>
	          </tr>
	          </table></div>
	    </form>";


	    if (isset($_POST['Genre'])) {

	    	$genre = $_POST['Genre'];
	    	$description = $_POST['Description'];

		    $sqll = "INSERT into genre values (?,?)";
			$stmt = $conn->prepare($sqll);
			$ok = $stmt->bind_param('ss', $genre, $description);
			if (!$ok) { die("Bind param error"); }
			$ok = $stmt->execute();
			if (!$ok) { die("Exec error"); }
		    $result4 = $stmt->get_result();    

	    }

	}


	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$page = $_GET['page'];
	if ($page == "" || $page == "books") {
		books_page($conn);
	} elseif ($page == "genres") {		
		genres_page($conn);
	} elseif ($page == "sales") {
		sales_page($conn);
	}

	$conn->close();

?>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script> type="text/javascript"
  $(document).ready(function() {
    $('#example').DataTable( {
    } );
  });
</script>


</html>



