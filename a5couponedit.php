<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";
    checklogin();

    // 表单里的默认值
$myrow=array(
    'Coupon_ID'=>'',
    'Coupon_Name'=>'',
    'Discount_Amount'=>'',
    'Create_Time'=>'',
    'Expire_Time'=>'',
    'Coupon_Status'=>'',
);
// 查询数据库，获得数据库里这行的内容
// myget获取url里的参数,根据不同的参数渲染默认值
if(myget("c_id")){
    // 设为更新模式，对应按钮值update
    $mode="update";
    $urlid=myget("c_id");
    // 查询原先数据
    $sql = "SELECT * FROM coupon WHERE `Coupon_ID`='$urlid'";
    $query = $con->query($sql);
    // 得到查询结果,待会放入表单内显示
    $myrow=$query->fetch();
}else if(myget("create")){
    // 设为新建模式，对应按钮值create
    $mode="create";
}

// 当用户点按钮提交表单时,接受表单内用户填写的参数
$Coupon_ID = mypost('Coupon_ID');
$Coupon_Name = mypost('Coupon_Name');
$Discount_Amount = mypost('Discount_Amount');
$Create_Time = mypost('Create_Time');
$Expire_Time = mypost('Expire_Time');
$t_Coupon_Status = mypost('Coupon_Status');

$Coupon_Status = 1;
if ($t_Coupon_Status == 'Not Available') {
    $Coupon_Status = 2;
}

if(isset($_POST['update'])){
    // 如果点击按钮值是update,更行那行数据
    $sql = "
            UPDATE `coupon` SET 
            `Coupon_ID` = '$Coupon_ID', 
            `Coupon_Name` = '$Coupon_Name', 
            `Discount_Amount` = '$Discount_Amount' ,
            `Create_Time` = '$Create_Time' ,
            `Expire_Time` = '$Expire_Time' ,
            `Coupon_Status` = '$Coupon_Status' 
                   WHERE `Coupon_ID` = '$Coupon_ID'
            ";
    $con->exec($sql);

    // 网页跳转到
    header("Location:./a5coupon.php");
    exit();
}else if(isset($_POST['create'])){
    //如果点击按钮值是create,插入新数据
    $sql = "
            INSERT INTO `coupon` (`Coupon_ID`, `Coupon_Name`, `Discount_Amount`,`Create_Time`,`Expire_Time`, `Coupon_Status`) 
            VALUES (NULL, '$Coupon_Name','$Discount_Amount','$Create_Time', '$Expire_Time', '$Coupon_Status')
            ";
    $con->exec($sql);

    // 网页跳转到
    header("Location:./a5coupon.php");
    exit();
}else if(isset($_POST['delete'])){
    //如果点击按钮值是delete
    // 将deleted字段设置为true
    $sql = "UPDATE `coupon` SET `deleted` = TRUE WHERE `Coupon_ID` = '$Coupon_ID'";
    $con->exec($sql);
    // 网页跳转到
    header("Location:./a5coupon.php");
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
    <!-- 引入时间选择框 -->
    <link rel="stylesheet" href="styles/bootstrap-datetimepicker.min.css">
    <script src="js/moment-with-locales.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>

    <title>CAN302 A5 store | Coupon</title>
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
        <form class="" role="form" action="" method="post">
            <div class="mdui-col-xs-3">Coupon ID:</div>
            <!-- 此处id限制为readonly -->
            <div class="mdui-col-xs-9">
                <?php
                inputbox(array(
                    "name"=>"Coupon_ID",
                    "defaultvalue"=>$myrow['Coupon_ID'],
                    "extra"=>"readonly"
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Coupon Name:</div>
            <div class="mdui-col-xs-9">
                <!-- required必填字段 -->
                <?php
                inputbox(array(
                    "name"=>"Coupon_Name",
                    "defaultvalue"=>$myrow['Coupon_Name'],
                    "required"=>true
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Discount Amount:</div>
            <div class="mdui-col-xs-9">
                <!-- required必填字段 -->
                <?php
                inputbox(array(
                    "name"=>"Discount_Amount",
                    "defaultvalue"=>$myrow['Discount_Amount'],
                    "required"=>true,
                    "pattern"=>"^\d+(?:\.\d{1,2})?$"
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Create Time:</div>
            <div class="mdui-col-xs-9">
            <?php
                timeselectbox(array(
                    "name"=>"Create_Time",
                    "defaultvalue"=>$myrow['Create_Time'],
                    "required"=>true,
                    "placeholder"=>"yyyy-mm-dd hh:mm:ss",
                    "pattern"=>"^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$",
                    "patternword"=>"should be yyyy-mm-dd hh:mm:ss"
                ));
                ?>
                
            </div>

            <div class="mdui-col-xs-3">Expire Time:</div>
            <div class="mdui-col-xs-9">
                <?php
                timeselectbox(array(
                    "name"=>"Expire_Time",
                    "defaultvalue"=>$myrow['Expire_Time'],
                    "required"=>true,
                    "placeholder"=>"yyyy-mm-dd hh:mm:ss",
                    "pattern"=>"^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$",
                    "patternword"=>"should be yyyy-mm-dd hh:mm:ss"
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Status Select:</div>
            <div class="mdui-col-xs-9">
                <!-- 单选框 -->
                <?php
                selectbox(array(
                    "name"=>"Coupon_Status",
                    "valuelist"=>array("Avaliable","Not Available"),
                    "defaultvalue"=>$myrow['Coupon_Status']
                ));
                ?>
            </div>

            <!-- 按钮内容和name随着$mode的值变化,从而实现不同的添加修改删除效果 -->
            <?php
            buttonbox(array(
                "name"=>$mode,
                "cssclass"=>"mdui-color-green-700"
            ));
            ?>
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
    $(function () {
        $('#Create_Time').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss',			//显示年月日
        });
        $('#Expire_Time').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss',			//显示年月日
        });
    });
</script>
</html>