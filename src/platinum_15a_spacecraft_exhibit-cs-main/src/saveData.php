<?php
// header("Content-Type: application/json; charset=utf-8");
$name=$_POST['name'];
$date=$_POST['date'];
echo $name;
$link=mysqli_connect("localhost","root","root","statistical_output");
if ($link){
    echo "connect MySQL successfully!";
}
else if (mysqli_connect_errno($link)) 
{ 
    echo "connect MySQL fail! " . mysqli_connect_error(); 
} 
  $sql = "INSERT INTO `data_save` (`button`, `date`) VALUES ('$name', '$date');";
$link->query($sql);
$link->close();

?>