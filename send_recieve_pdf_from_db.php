<?php
	$link = mysqli_connect("localhost", "root","", "mydata") or die ("Error".mysqli_error($link));
	//$d_date= $_POST["date"];
	
	if(isset($_POST['upload']))
{

// extract file name, type, size and path
$file_path=$_FILES['pdf']['tmp_name']; //pdf is the name of the input type where we are uploading files
$file_type=$_FILES['pdf']['type'];
$file_size=$_FILES['pdf']['size'];
$file_name=$_FILES['pdf']['name'];

// checks whether selected file is a pdf file or not
if ($file_name != "" && $file_type == 'application/pdf')
{

//extracts data of file in $data variable
$data=mysqli_real_escape_string($link, file_get_contents($file_path));
// query to insert file in database
$query="INSERT INTO ktpsdata (d_date, pdf) VALUES ('".$_POST['date']."', '".$data."');"; //”field_name” is the name of the field where we are uploading pdf files
$result = mysqli_query($link, $query); //query execution   
// Check if it was successful
if($result)
echo 'Success! Your file was successfully added!';
else
echo 'Error!';
} else {
echo 'Not a pdf file'; 
}
} 
// for reading uploaded file
if(isset($_POST['read']))
{

//Query to fetch field where we are saving pdf file
$sql = "SELECT pdf FROM ktpsdata WHERE d_date = '".$_POST['date']."'"; 
$result2 = mysqli_query($link, $sql);    // query execution       
$row = mysqli_fetch_assoc($result2);			
$bytes = $row[pdf];
header("Content-type: application/pdf");
header('Content-disposition: attachment; filename="thing.pdf"');
print $bytes;

}

	?>                               	
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>blob file</title>
</head>                                                
<body> 
	
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="date" id="name">
	File: <input type="file" name="pdf" id="pdf" accept="application/pdf" title="Choose File" ></input><br />
	<input type="submit" name="upload" id="upload" value="Upload" /><br />
	<input type="submit" name="read" id="read" value="Read" />
	
	</form>
	<p></p>

</body>
</html>
	<?php
		$stat= $link->prepare("select * from ktpsdata");
		$stat->execute();
		while ($row = $stat->fetch()) {
			echo "<li><a target='_blank' href='view2.php?id=".$row['id']."'>".$row['d_date']."</li><br><br>";
		}


		?>