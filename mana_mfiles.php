<?php
/**
 * 1.建立資料庫及資料表來儲存檔案資訊
 * 2.建立上傳表單頁面
 * 3.取得檔案資訊並寫入資料表
 * 4.製作檔案管理功能頁面
 */
$dsn="mysql:host=localhost;charset=utf8;dbname=prox";
$pdo=new PDO($dsn,"root","");

if(!empty($_FILES) && $_FILES['xfloor']['error']==0){
    $theNotes=$_POST['notes'];
    
    $theType=$_FILES['xfloor']['type'];
    $file=$_FILES['xfloor']['name'];
    $thePath="./house/" . $file;   
    // oriName= original file name 
    
    move_uploaded_file($_FILES['xfloor']['tmp_name'] , $thePath);
    $sql="INSERT INTO mfiles (`name`,`type`,`path`,`notes`) values('$file','$theType','$thePath','$theNotes')";
    $result=$pdo->exec($sql);
    if($result==1){
        echo "上傳成功";
    }else{
        echo "DB有誤";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ProjectX 檔案管理</title>
    <link rel="stylesheet" href="style.css">
    <style>
    a{
        display: inline-block;
        border: 1px solid #ccc;
        padding: 5px 15px;
        border-radius: 20px;
        box-shadow: 1px 1px 3px #ccc;
    }
    
    </style>
</head>
<body>
<h1 class="header">ProjectX 檔案管理</h1>
<!----建立上傳檔案表單及相關的檔案資訊存入資料表機制----->
<form action="mana_mfiles.php" method="post" enctype="multipart/form-data">
  檔案：<input type="file" name="xfloor" ><br><br>
  說明：<input type="text" name="notes" ><br>
  <!-- 注意這個form欄位是text，是用post抓取和暫存 -->
  <input type="submit" value="上傳">
</form>

<!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->

<table>
    <tr>
        <td>編號</td>
        <td>檔名</td>
        <td>類型</td>
        <td>縮圖</td>
        <td>路徑</td>
        <td>說明</td>
        <td>首次上傳</td>
        <td>操作</td>
    </tr>

    <?php
        $sql="SELECT * FROM mfiles";
        $rows=$pdo->query($sql)->fetchAll();
        foreach ($rows as $key=>$value) {  
     
            
    ?>
    <tr>
        <td><?=$value['id'];?></td>
        <td><?=$value['name'];?></td>
        <td><?=$value['type'];?></td>
        <td><img src="<?=$value['path'];?>" style="width:50px;height:50px;"></td>
        <td><?=$value['path'];?></td>
        <td><?=$value['notes'];?></td>
        <td><?=$value['create-time'];?></td>
        <td>
            <a href="edit_mfiles.php?id=<?=$value['id'];?>">更新檔案</a>
            <a href="del_mfiles.php?id=<?=$value['id'];?>">刪除檔案</a>
        
        </td>
    </tr>
   
    <?php
     }
    ?>

</table>


</body>
</html>