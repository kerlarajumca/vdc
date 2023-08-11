<?PHP
require_once("../../database/dbconnect.php");
$deptid=$_POST['deptid'];

$sql=mysqli_query($conn,"select * from users where user_role=2 and deptid=$deptid order by fname asc");
$res=array();
while($r=mysqli_fetch_array($sql))
{
    $temp=array(
        "fid"=>$r['id'],
        "faculty"=>$r['fname']
    );
    array_push($res,$temp);
}

echo json_encode($res);
?>