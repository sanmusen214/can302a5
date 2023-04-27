<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";

        // 表单里的默认值
        $myrow=array(
            'Product_ID'=>'',
            'Product_Name'=>'',
            'Product_Category_ID'=>'',
            'Product_In_stock'=>'',
            'Product_Price'=>'',
            'Product_Description'=>'',
            'Product_Image_link'=>''
        );
        // 查询数据库，获得数据库里这行的内容
        // myget获取url里的参数,根据不同的参数渲染默认值
        
        if(myget("p_id")){
            // 设为更新模式，对应按钮值update
            $mode="update";
            $urlid=myget("p_id");
            // 查询原先数据
            $sql = "SELECT * FROM product WHERE `Product_ID`='$urlid'";
            $query = $con->query($sql);
            // 得到查询结果,待会放入表单内显示
            $myrow=$query->fetch();
        }else if(myget("create")){
            // 设为新建模式，对应按钮值create
            $mode="create";
        }

        // 当用户点按钮提交表单时,接受表单内用户填写的参数
        $productID = mypost('Product_ID');
        $productName = mypost('Product_Name');
        $productcategoryID = mypost('Product_Category_ID');
        $productInStock = mypost('Product_In_stock');
        $productPrice = mypost('Product_Price');
        $productDescription = mypost('Product_Description');
        $productImage = mypost('Product_Image_link');

        if(isset($_POST['update'])){
            // 如果点击按钮值是update,更行那行数据
            $sql = "
            UPDATE `product` SET 
            `Product_Name` = '$productName', 
            `Product_Category_ID` = '$productcategoryID',
            `Product_In_stock` = '$productInStock',
            `Product_Price` = '$productPrice',
            `Product_Description` = '$productDescription',
            `Product_Image_link` = '$productImage' WHERE `Product_ID` = '$productID'
            ";
            $con->exec($sql);
            // 网页跳转到
            header("Location:./a5product.php");
            exit();
        }else if(isset($_POST['create'])){
            //如果点击按钮值是create,插入新数据
            $sql = "
            INSERT INTO `product` (`Product_ID`, `Product_Name`, `Product_Category_ID`, 
            `Product_In_stock`,`Product_Price`,`Product_Description`,`Product_Image_link`) 
            VALUES (NULL, '$productName','$productcategoryID','$productInStock',
            '$productPrice','$productDescription','$productImage')
            ";
            $con->exec($sql);
            // 网页跳转到
            header("Location:./a5product.php");
            exit();
        }else if(isset($_POST['delete'])){
            //如果点击按钮值是delete
            // 将deleted字段设置为true
            $sql = "UPDATE `product` SET `deleted` = TRUE WHERE `Product_ID` = '$productID'";
            $con->exec($sql);
            // 网页跳转到
            header("Location:./a5product.php");
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
    <title>CAN302 A5 store | Product</title>
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

                <!--Product ID-->
                <div class="mdui-col-xs-3">Product ID:</div>
                <!-- 此处id限制为readonly -->
                <div class="mdui-col-xs-9">
                    <?php
                        inputbox(array(
                            "name"=>"Product_ID",
                            "defaultvalue"=>$myrow['Product_ID'],
                            "extra"=>"readonly"
                        ));
                    ?>
                </div>
                
                <!--Product Name-->
                <div class="mdui-col-xs-3">Product Name:</div>
                <div class="mdui-col-xs-9">
                    <!-- required必填字段 -->
                    <?php
                        inputbox(array(
                            "name"=>"Product_Name",
                            "defaultvalue"=>$myrow['Product_Name'],
                            "required"=>true
                        ));
                    ?>
                </div>
                
                <!--Product_Category_ID| Category_ID-->
                <div class="mdui-col-xs-3">Product CategoryID:</div>
                <div class="mdui-col-xs-9">
                <!-- 单选框 -->
                    <?php
                        selectitemsbox(array(
                        "name"=>"Product_Category_ID",
                        "tablename"=>"category", // 数据库表名
                        "indexname"=>"Category_ID", //选取后的实际值，表的下标
                        "displayindexname"=>"Category_Name",//选取框显示的名字，表的下标
                        "defaultvalue"=>$myrow['Product_Category_ID'],//实际值的默认值
                        "all"=>false//true时显示所有存在的数据，false时隐藏被删除的那些
                        ));
                    ?>
                </div>

                <!--Product_In_stock-->
                <div class="mdui-col-xs-3">In stock:</div>
                <div class="mdui-col-xs-9">
                    <?php
                        inputbox(array(
                            "name"=>"Product_In_stock",
                            "defaultvalue"=>$myrow['Product_In_stock'],
                            "required"=>true
                        ));
                    ?>
                </div>

                <!--Product_Price-->
                <div class="mdui-col-xs-3">Product Price:</div>
                <div class="mdui-col-xs-9">
                    <?php
                        inputbox(array(
                            "name"=>"Product_Price",
                            "defaultvalue"=>$myrow['Product_Price'],
                            "required"=>true
                        ));
                    ?>
                </div>

                <!--Product_Description-->
                <div class="mdui-col-xs-3">Description:</div>
                <div class="mdui-col-xs-9">
                    <?php
                        inputbox(array(
                            "name"=>"Product_Description",
                            "defaultvalue"=>$myrow['Product_Description'],
                            "required"=>true
                        ));
                    ?>
                    
                </div>

                <!--Product_Image_link-->
                <div class="mdui-col-xs-3">Product Image:</div>
                <div class="mdui-col-xs-9">
                    <img src=<?php echo $myrow["Product_Image_link"]?> alt="Product image" style='max-width: 200px'/>
                    <?php
                        inputbox(array(
                            "name"=>"Product_Image_link",
                            "defaultvalue"=>$myrow['Product_Image_link'],
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
    // 让Product_Name的input框只能填写不重复的产品名
    window.addEventListener("load",function(){
        itMustNotExist('Product_Name','product','Product_Name','<?php echo $myrow['Product_Name'] ?>')
    })
    
</script>
</html>
