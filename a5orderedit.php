<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";
    checklogin();
    // 表单里的默认值
$myrow=array(
    'Order_ID'=>'',
    'Order_Product_ID'=>'',
    'Order_Customer_ID'=>'',
    'Order_Coupon_ID'=>'',
    'Order_Status'=>'',
    'Order_Time'=>'',
    'Order_Details'=>'',
);
// 查询数据库，获得数据库里这行的内容
// myget获取url里的参数,根据不同的参数渲染默认值
if(myget("o_id")){
    // 设为更新模式，对应按钮值update
    $mode="update";
    $urlid=myget("o_id");
    // 查询原先数据
    $sql = "SELECT * FROM orders WHERE `Order_ID`='$urlid'";
    $query = $con->query($sql);
    // 得到查询结果,待会放入表单内显示
    $myrow=$query->fetch();
}else if(myget("create")){
    // 设为新建模式，对应按钮值create
    $mode="create";
}

// 当用户点按钮提交表单时,接受表单内用户填写的参数
$Order_ID = mypost('Order_ID');
$Order_Product_ID = mypost('Order_Product_ID');
$Order_Customer_ID = mypost('Order_Customer_ID');
$Order_Coupon_ID = mypost('Order_Coupon_ID');
$Order_Status = mypost('Order_Status');
$Order_Time = mypost('Order_Time');
$Order_Details = mypost('Order_Details');

$Order_Status = 1;
if ($Order_Status == 'Not Available') {
    $Order_Status = 2;
}

if(isset($_POST['update'])){
    $mode="update";
    // 如果点击按钮值是update,更行那行数据
    $sql = "
            UPDATE `orders` SET 
            `Order_ID` = '$Order_ID', 
            `Order_Product_ID` = '$Order_Product_ID', 
            `Order_Customer_ID` = '$Order_Customer_ID' ,
            `Order_Coupon_ID` = '$Order_Coupon_ID' ,
            `Order_Status` = '$Order_Status' ,
            `Order_Time` = '$Order_Time' ,
            `Order_Details` = \"$Order_Details\" 
                   WHERE `Order_ID` = '$Order_ID'
            ";
    $con->exec($sql);
    // 网页跳转到
    header("Location:./a5order.php");
    exit();
}else if(isset($_POST['create'])){
    $mode="create";
    //如果点击按钮值是create,插入新数据
    $sql = "
            INSERT INTO `orders` (`Order_ID`, `Order_Product_ID`, `Order_Customer_ID`,`Order_Coupon_ID`,`Order_Status`, `Order_Time`, `Order_Details`) 
            VALUES (NULL, '$Order_Product_ID','$Order_Customer_ID','$Order_Coupon_ID', '$Order_Status', '$Order_Time', \"$Order_Details\")
            ";
    $con->exec($sql);

    // 网页跳转到
    header("Location:./a5order.php");
    exit();
}else if(isset($_POST['delete'])){
    //如果点击按钮值是delete
    // 将deleted字段设置为true
    $sql = "UPDATE `orders` SET `deleted` = TRUE WHERE `Order_ID` = '$Order_ID'";
    $con->exec($sql);
    // 网页跳转到
    header("Location:./a5order.php");
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

    <title>CAN302 A5 store | Order</title>
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
            <div class="mdui-col-xs-3">Order ID:</div>
            <!-- 此处id限制为readonly -->
            <div class="mdui-col-xs-9">
                <?php
                inputbox(array(
                    "name"=>"Order_ID",
                    "defaultvalue"=>$myrow['Order_ID'],
                    "extra"=>"readonly"
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Order Product ID:</div>
            <div class="mdui-col-xs-9">
                <!-- required必填字段 -->
                <?php
                selectitemsbox(array(
                    "name"=>"Order_Product_ID",
                    "tablename"=>"product", // 数据库表名
                    "indexname"=>"Product_ID", //选取后的实际值，表的下标
                    "displayindexname"=>"Product_Name",//选取框显示的名字，表的下标
                    "defaultvalue"=>$myrow['Order_Product_ID'],//实际值的默认值
                    "all"=>false//true时显示所有存在的数据，false时隐藏被删除的那些
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Order Customer ID:</div>
            <div class="mdui-col-xs-9">
                <!-- required必填字段 -->
                <?php
                selectitemsbox(array(
                    "name"=>"Order_Customer_ID",
                    "tablename"=>"user", // 数据库表名
                    "indexname"=>"User_ID", //选取后的实际值，表的下标
                    "displayindexname"=>"User_Name",//选取框显示的名字，表的下标
                    "defaultvalue"=>$myrow['Order_Customer_ID'],//实际值的默认值
                    "all"=>false//true时显示所有存在的数据，false时隐藏被删除的那些
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Order Coupon ID:</div>
            <div class="mdui-col-xs-9">
                <!-- required必填字段 -->
                <?php
                selectitemsbox(array(
                    "name"=>"Order_Coupon_ID",
                    "tablename"=>"coupon", // 数据库表名
                    "indexname"=>"Coupon_ID", //选取后的实际值，表的下标
                    "displayindexname"=>"Coupon_Name",//选取框显示的名字，表的下标
                    "defaultvalue"=>$myrow['Order_Coupon_ID'],//实际值的默认值
                    "all"=>false//true时显示所有存在的数据，false时隐藏被删除的那些
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Status Select:</div>
            <div class="mdui-col-xs-9">
                <!-- 单选框 -->
                <?php
                selectbox(array(
                    "name"=>"Order_Status",
                    "valuelist"=>array("Avaliable","Not Available"),
                    "defaultvalue"=>$myrow['Order_Status']
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Order Time:</div>
            <div class="mdui-col-xs-9">
                <!-- required必填字段 -->
                <?php
                timeselectbox(array(
                    "name"=>"Order_Time",
                    "defaultvalue"=>$myrow['Order_Time'],
                    "required"=>true,
                    "placeholder"=>"yyyy-mm-dd hh:mm:ss",
                    "pattern"=>"^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$",
                    "patternword"=>"should be yyyy-mm-dd hh:mm:ss"
                ));
                ?>
            </div>

            <div class="mdui-col-xs-3">Order Details:</div>
            <div class="mdui-col-xs-9">
                <?php
                inputbox(array(
                    "name"=>"Order_Details",
                    "defaultvalue"=>$myrow['Order_Details'],
                    "required"=>true
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
        $('#Order_Time').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss',			//显示年月日
        });
    });
</script>
</html>