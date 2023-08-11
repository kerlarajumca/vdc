<?PHP
require_once("../../database/dbconnect.php");

$tdate=$_POST['tdate'];
$cid=$_POST['cid'];



$q1=mysqli_query($conn,"select * from students where classid=$cid");
$subjcount=1;
while($r=mysqli_fetch_array($q1))
{
    
    $mobileno=$r['mobileno'];
    $sid=$r['id'];
    $q2="select A.recid,A.hour,S.subj_code from attendance A left join subjects S on A.subject=S.id where A.classid=$cid and A.tdate='$tdate'";
    $execq2=mysqli_query($conn,$q2);
    $abmsg="";
    
    while($r2=mysqli_fetch_array($execq2))
    {
        $recid=$r2['recid'];
        $subjcode=$r2['subj_code'];
        $hour=$r2['hour'];
        $q3="select * from attendance_detail where recid='$recid' and studentid=$sid";
        
        $execq3=mysqli_query($conn,$q3);
        
        $c=mysqli_num_rows($execq3);
         if($c==0) continue;
        $r3=mysqli_fetch_array($execq3);
        
        if($r3['status']==0)
        {
            if($abmsg=="")
            {
                $abmsg=$subjcode."($hour hour)";
                
            }
            else
            {
                $abmsg.=", ". $subjcode."($hour hour)";
                $subjcount++;
            }
            
        }
        
    }
    if($abmsg=="")
    {
        continue;
    }
    else
    {
        $abmsg="Dear Parent your ward is absent for ".$abmsg."-Principal, Vaagdevi College";
    }

    if($abmsg!="")
    {
        $q5="update attendance set sms_status=1 where tdate='$tdate' and classid=$cid";
        mysqli_query($conn,$q5);

        $q6="insert into sms_details(classid,tdate,mobileno,sms) values($cid,'$tdate','$mobileno','$abmsg')";
        mysqli_query($conn,$q6);

    }
}

$res=array();

$temp=array(
    "msg"=>"SMS Sent Successfully"       
);
array_push($res,$temp);

echo json_encode($res);
?>