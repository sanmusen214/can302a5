<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";

    // 表单里的默认值
    $myrow=array(
        'User_ID'=>'',
        'User_Name'=>'',
        'Telephone'=>'',
        'Payment_Method'=>'',
        'Shipping_Address'=>''
    );
    // 查询数据库，获得数据库里这行的内容
    if(myget("id")){
        // 更新模式，对应按钮值update
        $mode="update";
        $urlid=myget("id");
        // 查询原先数据
        $sql = "SELECT * FROM user WHERE `User_ID`='$urlid'";
        $query = $con->query($sql);
        // 得到第一条结果
        $myrow=$query->fetch();
    }else if(myget("add")){
        // 新建模式，对应按钮值add
        $mode="create";
    }else if(myget("deleteid")){
        // 删除模式，对应按钮值delete
        $mode="delete";
        $urlid=myget("deleteid");
        // 查询原先数据
        $sql = "SELECT * FROM user WHERE `User_ID`='$urlid'";
        $query = $con->query($sql);
        // 得到结果
        $myrow=$query->fetch();
    }

    // 接受表单内用户填写的参数
    $userid = mypost('User_ID');
    $username = mypost('User_Name');
    $userphone = mypost('Telephone');
    $userpayment = mypost('Payment_Method');
    $useraddress = mypost('Shipping_Address');

    if(isset($_POST['update'])){
        // 如果点击upload按钮值是update
        $sql = "
        UPDATE `user` SET 
        `User_Name` = '$username', 
        `Telephone` = '$userphone', 
        `Payment_Method` = '$userpayment', 
        `Shipping_Address` = '$useraddress' WHERE `User_ID` = '$userid'
        ";
        $con->exec($sql);
        // 网页跳转到
        header("Location:./a5user.php");
        exit();
    }else if(isset($_POST['create'])){
        //如果点击upload按钮值是create
        $sql = "
        INSERT INTO `user` (`User_ID`, `User_Name`, `Telephone`, `Payment_Method`, `Shipping_Address`) VALUES (NULL, '$username', '$userphone', '$userpayment','$useraddress')";
        $con->exec($sql);
        // 网页跳转到
        header("Location:./a5user.php");
        exit();
    }else if(isset($_POST['delete'])){
        //如果点击upload按钮值是delete
        $sql = "DELETE FROM `user` WHERE `User_ID` = '$userid'";
        $con->exec($sql);
        // 网页跳转到
        header("Location:./a5user.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 引入样式，mdui -->
    <link rel="stylesheet" href="styles/bootstrap-337.min.css">
    <link rel="stylesheet" href="https://unpkg.com/mdui@1.0.2/dist/css/mdui.min.css"/>
    <link rel="stylesheet" href="a5common/commonCSS.css">
    <!-- 这个页面css，这会覆盖外链引入的样式 -->
    <style>

    </style>
    <!-- 引入jquery和boostrap，mdui -->
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>
    <script src="https://unpkg.com/mdui@1.0.2/dist/js/mdui.min.js"></script>
    <title>CAN302 A5 store | User</title>
</head>
<body class="mdui-drawer-body-left mdui-theme-primary-white mdui-theme-accent-green">
    <!-- 顶部框 -->
    <?php
        topbarUI();
    ?>
    <!-- 侧边框 -->
    <?php
        siderbarUI();
    ?>
    <!-- 主内容 -->
    <div class="content">
        <h1 style="text-transform:capitalize;"><?php echo $mode ?></h1>
        <div class="mdui-container">
            <form class="form-inline" role="form" action="" method="post" >
                <div class="mdui-col-xs-3">User_ID:</div>
                <!-- 此处id限制为readonly -->
                <div class="mdui-col-xs-9"><input readonly type="text" class="form-control" id="User_ID" placeholder="User ID" name="User_ID" value="<?php echo $myrow['User_ID']; ?>"></div>
                <!-- value字段对应默认值 -->
                
                <div class="mdui-col-xs-3">User_Name:</div>
                <div class="mdui-col-xs-9"><input type="text" class="form-control" id="User_Name" placeholder="Input User name" name="User_Name" value="<?php echo $myrow['User_Name']; ?>"></div>
                
                <div class="mdui-col-xs-3">Telephone:</div>
                <div class="mdui-col-xs-9"><input type="text" class="form-control" id="Telephone" placeholder="Input Telephone" name="Telephone" value="<?php echo $myrow['Telephone']; ?>"></div>

                <div class="mdui-col-xs-3">Payment_Method:</div>
                <div class="mdui-col-xs-9"><input type="text" class="form-control" id="Payment_Method" placeholder="Input Payment_Method" name="Payment_Method" value="<?php echo $myrow['Payment_Method']; ?>"></div>

                <div class="mdui-col-xs-3">Shipping_Address:</div>
                <div class="mdui-col-xs-9"><input type="text" class="form-control" id="Shipping_Address" placeholder="Input Shipping_Address" name="Shipping_Address" value="<?php echo $myrow['Shipping_Address']; ?>"></div>

                <button  style="text-transform:capitalize;" type="submit" class="btn btn-primary" id="<?php echo $mode ?>" name="<?php echo $mode ?>" value="<?php echo $mode ?>"> <?php echo $mode ?> </button>
            </form>
        </div>
    </div>
</body>
<!-- 这个页面的JS，放在文档尾部 -->
<script src="a5common/commonJS.js"></script>
<script>
    
</script>
</html>