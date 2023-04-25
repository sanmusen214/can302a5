<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";
        // 表单里的默认值
        $myrow=array(
            'Category_ID'=>'',
            'Category_Name'=>'',
            'Category_Status'=>'',
            'Description'=>''
        );
        // 查询数据库，获得数据库里这行的内容
        // myget获取url里的参数,根据不同的参数渲染默认值
        if(myget("c_id")){
            // 设为更新模式，对应按钮值update
            $mode="update";
            $urlid=myget("c_id");
            // 查询原先数据
            $sql = "SELECT * FROM category WHERE `Category_ID`='$urlid'";
            $query = $con->query($sql);
            // 得到查询结果,待会放入表单内显示
            $myrow=$query->fetch();
        }else if(myget("create")){
            // 设为新建模式，对应按钮值create
            $mode="create";
        }
    
        // 当用户点按钮提交表单时,接受表单内用户填写的参数
        $categoryID = mypost('Category_ID');
        $categoryName = mypost('Category_Name');
        $categoryStatus = mypost('Category_Status');
        $categoryDescription = mypost('Description');

        if(isset($_POST['update'])){
            // 如果点击按钮值是update,更行那行数据
            $sql = "
            UPDATE `category` SET 
            `Category_Name` = '$categoryName', 
            `Category_Status` = '$categoryStatus', 
            `Description` = '$categoryDescription' WHERE `Category_ID` = '$categoryID'
            ";
            $con->exec($sql);
            // 网页跳转到
            header("Location:./a5category.php");
            exit();
        }else if(isset($_POST['create'])){
            //如果点击按钮值是create,插入新数据
            $sql = "
            INSERT INTO `category` (`Category_ID`, `Category_Name`, `Category_Status`,`Description`) VALUES (NULL, '$categoryName','$categoryStatus','$categoryDescription')
            ";
            $con->exec($sql);
            // 网页跳转到
            header("Location:./a5category.php");
            exit();
        }else if(isset($_POST['delete'])){
            //如果点击按钮值是delete
            // 将deleted字段设置为true
            $sql = "UPDATE `category` SET `deleted` = TRUE WHERE `Category_ID` = '$categoryID'";
            $con->exec($sql);
            // 网页跳转到
            header("Location:./a5category.php");
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
            <form class="" role="form" action="" method="post" >
                <div class="mdui-col-xs-3">Category ID:</div>
                <!-- 此处id限制为readonly -->
                <div class="mdui-col-xs-9">
                    <?php
                        inputbox(array(
                            "name"=>"Category_ID",
                            "defaultvalue"=>$myrow['Category_ID'],
                            "extra"=>"readonly"
                        ));
                    ?>
                </div>
                
                <div class="mdui-col-xs-3">Category Name:</div>
                <div class="mdui-col-xs-9">
                    <!-- required必填字段 -->
                    <?php
                        inputbox(array(
                            "name"=>"Category_Name",
                            "defaultvalue"=>$myrow['Category_Name'],
                            "required"=>true
                        ));
                    ?>
                </div>

                <div class="mdui-col-xs-3">Status Select:</div>
                <div class="mdui-col-xs-9">
                <!-- 单选框 -->
                    <?php
                        selectbox(array(
                            "name"=>"Category_Status",
                            "valuelist"=>array("Avaliable","Not Available"),
                            "defaultvalue"=>$myrow['Category_Status']
                        ));
                    ?>
                </div>

                <div class="mdui-col-xs-3">Description:</div>
                <div class="mdui-col-xs-9">
                    <?php
                        inputbox(array(
                            "name"=>"Description",
                            "defaultvalue"=>$myrow['Description'],
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
    
</script>
</html>