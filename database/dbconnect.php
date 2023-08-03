<?PHP
$server="localhost";
$user="root";
$password="";
$database="vdc";

$conn=mysqli_connect($server,$user,$password,$database);

if(!isset($conn))
{
    echo '<script>alert("Database Not Connected Please try again...");</script>';
    exit;
}


?>