<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";
    checklogin();

        // 定义查询语句，只找deleted字段为TRUE的那些数据
        $categorysql='SELECT * FROM category WHERE `deleted`= FALSE';
        // 定义表头数据，这个名字最好不要重复，比如user页面的表头的变量名为userhead，那么order页面的这个变量名就可以是orderhead
        $categoryhead=' 
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Status</th>
                    <th>Description</th>
                    ';
        // 定义查询到的每行数据怎么渲染，这里的row指一行数据
        function categoryrender($row){
            $rowid=$row["Category_ID"];
    
            echo "<td>".$row["Category_ID"]."</td>";
            echo "<td>".$row["Category_Name"]."</td>";
            echo "<td>".$row["Category_Status"]."</td>";
            echo "<td>".$row["Description"]."</td>";
            echo "<td>
                <button onclick='location.href=`a5categoryedit.php?c_id=$rowid`' class='mdui-btn mdui-btn-icon mdui-color-teal-500'>
                    <i class='mdui-icon material-icons'>brush</i>
                </button>
                <button onclick='location.href=`a5categoryedit.php?c_id=$rowid`' class='mdui-btn mdui-btn-icon mdui-color-red-500'>
                    <i class='mdui-icon material-icons'>delete</i>
                </button>
                </td>";
        }
        // 定义表格右上角加号跳转目的地
        $cataddtarget="a5categoryedit.php?create=1";
        // 可搜索的列
        $catsearchind=array("Category_ID","Category_Name","Category_Status","Description");
    
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
    <title>CAN302 A5 store | Category</title>
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
        displayList($con,$categorysql,$categoryhead,"categoryrender",$cataddtarget,$catsearchind);
    ?>
    </div>
</body>
<!-- 这个页面的JS，放在文档尾部 -->
<script src="a5common/commonJS.js?<?php echo rand(1,999999) ?>"></script>
<script>
    
</script>
</html>