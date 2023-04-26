<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";

    // 表单里的默认值，这一步很重要
    $myrow=array(
        'User_ID'=>'',
        'User_Name'=>'',
        'Telephone'=>'',
        'Payment_Method'=>'',
        'Shipping_Address'=>''
    );
    // 查询数据库，获得数据库里id所在行的内容
    // myget获取url里的参数,根据不同的参数渲染默认值
    $mode="create";//默认模式为create
    if(myget("id")){
        // 如果url参数里有id
        // 设为更新模式，对应第一个按钮值update
        $mode="update";
        $urlid=myget("id");
        // 查询原先数据
        $sql = "SELECT * FROM user WHERE `User_ID`='$urlid'";
        $query = $con->query($sql);
        // 得到查询结果,表单默认值
        $myrow=$query->fetch();
    }else if(myget("create")){
        // 设为新建模式，对应第一个按钮值create
        $mode="create";
        // 表单默认值不做修改
    }

    // 当用户点按钮提交表单时,接受表单内用户填写的参数
    $User_ID = mypost('User_ID');
    $User_Name = mypost('User_Name');
    $Telephone = mypost('Telephone');
    $Payment_Method = mypost('Payment_Method');
    $Shipping_Address = mypost('Shipping_Address');

    if(isset($_POST['update'])){
        // 如果点击按钮值是update,更行那行数据
        $sql = "
        UPDATE `user` SET 
        `User_Name` = '$User_Name', 
        `Telephone` = '$Telephone', 
        `Payment_Method` = '$Payment_Method', 
        `Shipping_Address` = '$Shipping_Address' WHERE `User_ID` = '$User_ID'
        ";
        $con->exec($sql);
        // 网页跳转到
        header("Location:./a5user.php");
        exit();
    }else if(isset($_POST['create'])){
        //如果点击按钮值是create,插入新数据
        $sql = "
        INSERT INTO `user` (`User_ID`, `User_Name`, `Telephone`, `Payment_Method`, `Shipping_Address`) VALUES (NULL, '$User_Name', '$Telephone', '$Payment_Method','$Shipping_Address')";
        $con->exec($sql);
        // 网页跳转到
        header("Location:./a5user.php");
        exit();
    }else if(isset($_POST['delete'])){
        //如果点击按钮值是delete
        // 将deleted字段设置为true
        $sql = "UPDATE `user` SET `deleted` = TRUE WHERE `User_ID` = '$User_ID'";
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
        /* 限制input长度 */
        .content form input{
            width:60%;
        }
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
            <form class="" role="form" action="" method="post" >
                <div class="mdui-col-xs-3">User_ID:</div>
                <!-- 此处id字段限制为readonly -->
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                        "name"=>"User_ID",
                        "defaultvalue"=>$myrow['User_ID'],
                        "extra"=>"readonly"
                    ));
                    ?>
                </div>
                
                <div class="mdui-col-xs-3">User_Name:</div>
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                            "name"=>"User_Name",
                            "defaultvalue"=>$myrow['User_Name'],
                            "required"=>true
                        ));
                    ?>
                </div>
                
                <div class="mdui-col-xs-3">Telephone:</div>
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                            "name"=>"Telephone",
                            "defaultvalue"=>$myrow['Telephone'],
                            "required"=>true,
                            "pattern"=>"^\d{11}$",
                            "patternword"=>"must be 11 numbers"
                        ));
                    ?>
                </div>

                <div class="mdui-col-xs-3">Payment_Method:</div>
                <div class="mdui-col-xs-9">
                <!-- 单选框 -->
                    <?php
                        selectbox(array(
                            "name"=>"Payment_Method",
                            "valuelist"=>array("Wechat","Alipay","VISA","MASTERCARD"),
                            "defaultvalue"=>$myrow['Payment_Method']
                        )) 
                    ?>
                </div>

                <div class="mdui-col-xs-3">Shipping_Address:</div>
                <div class="mdui-col-xs-9">
                    <?php 
                        inputbox(array(
                            "name"=>"Shipping_Address",
                            "defaultvalue"=>$myrow['Shipping_Address'],
                            "required"=>true
                        ));
                    ?>
                </div>
                <?php
                    // selectitemsbox(array(
                    //     "name"=>"User_Past_Name",//这个选择框字段的name
                    //     "tablename"=>"user",//数据来源 数据表名
                    //     "indexname"=>"User_Name",//数据来源 数据表某一列
                    //     "defaultvalue"=>$myrow['User_Name'],//选择框默认值
                    //     "all"=>false//true时显示所有存在的数据，false时隐藏被删除的那些
                    // ));
                ?>
                <!-- 这个按钮name值根据$mode可以为create或update -->
                <?php 
                    buttonbox(array(
                        "name"=>$mode,
                        "cssclass"=>"mdui-color-green-700"
                    ));
                ?>
                <!-- 如果是$mode是update，出现删除按钮，这个按钮name恒为delete -->
                <?php 
                    if($mode=="update"){
                        buttonbox(array(
                            "name"=>"delete",
                            "cssclass"=>"mdui-color-red-500"
                        ));
                }
                ?>
            </form>
        </div>
    </div>
</body>
<!-- 这个页面的JS，放在文档尾部 -->
<script src="a5common/commonJS.js?<?php echo rand(1,999999) ?>"></script>
<script>
    // 让User_Name的input框只能填写不重复的用户名
    // 第一个参数为inputbox的name
    // 第二个参数为user数据库名
    // 第三个参数为该数据库的User_Name列
    // 第四个参数可选，排除原先值
    window.addEventListener("load",function(){
        itMustNotExist('User_Name','user','User_Name','<?php echo $myrow['User_Name'] ?>')
    })
</script>
</html>