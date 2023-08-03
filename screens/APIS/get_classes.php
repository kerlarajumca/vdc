<?PHP
require_once("../../database/dbconnect.php");
$groupid=$_POST['groupid'];

$sql=mysqli_query($conn,"select * from classes where group_id=$groupid");
$res=array();
while($r=mysqli_fetch_array($sql))
{
    $temp=array(
        "classid"=>$r['id'],
        "class"=>$r['class_name']
    );
    array_push($res,$temp);
}

echo json_encode($res);
?>