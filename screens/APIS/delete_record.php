<?PHP
require_once("../../database/dbconnect.php");
$table=$_POST['table'];
$recid=$_POST['recid'];
$col=$_POST['colname'];

$res=array();
if(mysqli_query($conn,"delete from $table where $col=$recid"))
{
    $temp=array(
        "msg"=>"Record Deleted Successfully"       
    );
    array_push($res,$temp);
}
else{
    $temp=array(
        "msg"=>"Something Went Wrong"       
    );
    array_push($res,$temp); 
}

echo json_encode($res);
?>