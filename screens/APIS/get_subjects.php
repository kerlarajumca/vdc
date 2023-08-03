<?PHP
require_once("../../database/dbconnect.php");
$classid=$_POST['classid'];

$sql=mysqli_query($conn,"select * from subjects where classid=$classid");
$studsql=mysqli_query($conn,"select * from students where classid=$classid");
$res=array();
$subjects=array();
while($r=mysqli_fetch_array($sql))
{
    $temp=array(
        "id"=>$r['id'],
        "subj_code"=>$r['subj_code'],
        "subj"=>$r['subj_title']
    );
    array_push($subjects,$temp);
}

$studs=array();
while($r1=mysqli_fetch_array($studsql))
{
   $temp=array(
    "id"=>$r1['id'],
    "sname"=>$r1['sname'],
    "htno"=>$r1['htno'],
    "admnno"=>$r1['admn_no']
   );

   array_push($studs,$temp);
}
array_push($res,$subjects);
array_push($res,$studs);
echo json_encode($res);
?>