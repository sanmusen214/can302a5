<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";

        // 定义查询语句，只找deleted字段为TRUE的那些数据
        $productsql='SELECT * FROM product WHERE `deleted`= FALSE';
        // 定义表头数据，这个名字最好不要重复，比如user页面的表头的变量名为userhead，那么product页面的这个变量名就可以是producthead
        //Product_ID	Product_Name	Product_Category_ID	Product_In_stock	
        //Product_Price	Product_Description	Product_Image_link
        $producthead=' 
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category ID</th>
                    <th>In Stock</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    ';

        function productrender($row){
            $rowid=$row["Product_ID"];

            echo "<td>".$row["Product_ID"]."</td>";
            echo "<td>".$row["Product_Name"]."</td>";
            echo "<td>".searchnameof("category","Category_ID",$row["Product_Category_ID"],"Category_Name")."</td>";//改成显示name
            echo "<td>".$row["Product_In_stock"]."</td>";
            echo "<td>".$row["Product_Price"]."</td>";
            echo "<td>".$row["Product_Description"]."</td>";
            echo "<td><img src='".$row["Product_Image_link"]."' alt='".$row["Product_Name"]."' style='max-width: 100px;'></td>";
            echo "<td>
                <button onclick='location.href=`a5productedit.php?p_id=$rowid`' class='mdui-btn mdui-btn-icon mdui-color-teal-500'>
                    <i class='mdui-icon material-icons'>brush</i>
                </button>
                <button onclick='location.href=`a5productedit.php?p_id=$rowid`' class='mdui-btn mdui-btn-icon mdui-color-red-500'>
                    <i class='mdui-icon material-icons'>delete</i>
                </button>
                </td>";
        }
         // 定义表格右上角加号跳转目的地
         $prodaddtarget="a5productedit.php?create=1";
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
        <?php
            // 将开头定义的几个东西按顺序传进去，注意第四个参数是函数的名字
            displayList($con,$productsql,$producthead,"productrender",$prodaddtarget);
        ?>    
    </div>
</body>
<!-- 这个页面的JS，放在文档尾部 -->
<script src="a5common/commonJS.js?<?php echo rand(1,999999) ?>"></script>
<script>
    
</script>
</html>
