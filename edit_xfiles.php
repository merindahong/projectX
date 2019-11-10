<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=prox";
$pdo=new PDO($dsn,"root","");

if(!empty($_FILES) && $_FILES['xfloor']['error']==0){
    $theNotes=$_POST['notes'];
    $theType=$_FILES['xfloor']['type'];
    $filename=$_FILES['xfloor']['name'];
    $thePath="./wh_xfiles/". $filename;
    // $thePath="./upload/" . $filename;
    $updateTime=date("Y-m-d H:i:s");
    $theId=$_POST['id'];
    move_uploaded_file($_FILES['xfloor']['tmp_name'] , $thePath );
    //刪除原本的檔案
    $sql="SELECT * FROM xfiles WHERE id='$theId'";
    $origin=$pdo->query($sql)->fetch();
    $origin_file=$origin['path'];
    unlink($origin_file);
    //更新資料
    $sql="UPDATE xfiles SET NAME='$filename',type='$theType',update-time='$updateTime',path='$thePath', notes='$theNotes' WHERE id='$theId'";
    $result=$pdo->exec($sql);
    if($result==1){
        echo "更新成功";
        header("location:mana_xfiles.php");
    }else{
        echo "DB有誤";
    }
}
$id=$_GET['id'];
$sql="SELECT * FROM xfiles WHERE id='$id'";
// as: http://localhost/MyWorkatSchool/Merindas/projectX/edit_xfiles.php?id=0
// URL尾端可發現有序號為0
$data=$pdo->query($sql)->fetch();
?>
<style>
table{
  border-collapse:collapse;
}
td{
  padding:5px;
  border:1px solid #ccc;
}
</style>
<form action="edit_xfiles.php" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <td colspan="2">
            <img src="<?=$data['path'];?>" style="width:200px;height:200px">
        </td>

    </tr>
    <tr>
        <td>name</td>
        <td><?=$data['name'];?></td>
    </tr>
    <tr>
        <td>path</td>
        <td><?=$data['path'];?></td>
    </tr>
    <tr>
        <td>type</td>
        <td><?=$data['type'];?></td>
    </tr>
    <tr>
        <td>create-time</td>
        <td><?=$data['create-time'];?></td>
    </tr>
</table><br>
更新檔案:<input type="file" name="xfloor"><br><br>
說明:
<input type="text" name="notes" value="<?=$data['notes'];?>"><br><br>
<input type="hidden" name="id" value="<?=$data['id'];?>">
<input type="submit" value="更新">
</form>