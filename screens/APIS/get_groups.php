<?PHP
require_once("../../database/dbconnect.php");
$course=$_POST['course'];
$sql=mysqli_query($conn,"select * from groups where course_id=$course");
$res=array();
while($r=mysqli_fetch_array($sql))
{
    $temp=array(
        "groupid"=>$r['id'],
        "group"=>$r['group_name']
    );
    array_push($res,$temp);
}

echo json_encode($res);
?>