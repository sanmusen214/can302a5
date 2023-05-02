<?php
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";
    checklogin();


    // 表单里的默认值，这一步很重要
    $myrow=array(
        'Shop_Name'=>'',
        'Shop_Logo'=>'',
        'Shop_Address'=>'',
        'Shop_Telephone'=>'',
        'Shop_Email'=>''
    );
    // 查询数据库，获得数据库里id所在行的内容
    // myget获取url里的参数,根据不同的参数渲染默认值
    $mode="update";//默认模式为update
    // 查询原先数据
    $sql = "SELECT * FROM profile";
    $query = $con->query($sql);
    // 查询的结果的行数
    $num = $query -> rowCount();
    if($num!=0){
        // 得到查询结果,表单默认值
        $myrow=$query->fetch();
    }else{
        $mode="create";
    }


    // 当用户点按钮提交表单时,接受表单内用户填写的参数
    $Shop_Name = mypost('Shop_Name');
    $Shop_Logo = mypost('Shop_Logo');
    $Shop_Address = mypost('Shop_Address');
    $Shop_Telephone = mypost('Shop_Telephone');
    $Shop_Email = mypost('Shop_Email');

    if(isset($_POST['update'])){
        // 如果点击按钮值是update,更行那行数据
        $sql = "
        UPDATE `profile` SET 
        `Shop_Name` = '$Shop_Name', 
        `Shop_Logo` = '$Shop_Logo', 
        `Shop_Address` = '$Shop_Address', 
        `Shop_Telephone` = '$Shop_Telephone',
        `Shop_Email`='$Shop_Email'
        ";
        $con->exec($sql);
        header("Location: a5profile.php");

    }else if(isset($_POST['create'])){
        $sql = "
        INSERT INTO `profile` (`Shop_ID`, `Shop_Name`, `Shop_Logo`, `Shop_Address`, `Shop_Telephone`, `Shop_Email`, `deleted`) VALUES
(NULL, '$Shop_Name', '$Shop_Logo', '$Shop_Address', '$Shop_Telephone', '$Shop_Email', 0);
        ";
        $con->exec($sql);
        header("Location: a5profile.php");

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
    <title>CAN302 A5 store | Profile</title>
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
        <h1 style="text-transform:capitalize;">Profile</h1>
        <div class="mdui-container">
            <form class="" role="form" action="" method="post" >
                <div class="mdui-col-xs-3">Shop_Name:</div>
                <!-- 此处id字段限制为readonly -->
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                        "name"=>"Shop_Name",
                        "defaultvalue"=>$myrow['Shop_Name'],
                        "required"=>true
                    ));
                    ?>
                </div>
                
                <div class="mdui-col-xs-3">Shop_Logo:</div>
                <div class="mdui-col-xs-9">
                    <img 
                    id="img1"
                    style="max-witdth:300px;max-height:300px"
                    src="<?php echo $myrow['Shop_Logo'] ?>"
                    />
                </div>
                <div class="mdui-col-xs-3">Shop_Logo url:</div>
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                            "name"=>"Shop_Logo",
                            "defaultvalue"=>$myrow['Shop_Logo'],
                            "required"=>true
                        ));
                    ?>
                </div>

                <div class="mdui-col-xs-3">Shop_Address:</div>
                <div class="mdui-col-xs-9">
                    <?php 
                        inputbox(array(
                            "name"=>"Shop_Address",
                            "defaultvalue"=>$myrow['Shop_Address'],
                            "required"=>true
                        ));
                    ?>
                </div>
                
                <div class="mdui-col-xs-3">Shop_Telephone:</div>
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                            "name"=>"Shop_Telephone",
                            "defaultvalue"=>$myrow['Shop_Telephone'],
                            "required"=>true,
                            "pattern"=>"^\d{11}$",
                            "patternword"=>"must be 11 numbers"
                        ));
                    ?>
                </div>

                <div class="mdui-col-xs-3">Shop_Email:</div>
                <div class="mdui-col-xs-9">
                    <?php inputbox(array(
                            "name"=>"Shop_Email",
                            "defaultvalue"=>$myrow['Shop_Email'],
                            "required"=>true,
                            "pattern"=>"^\w{3,}(\.\w+)*@[A-z0-9]+(\.[A-z]{2,5}){1,2}$",
                            "patternword"=>"must be valid email address"
                        ));
                    ?>
                </div>

                <!-- 这个按钮name值根据$mode可以为create或update -->
                <?php 
                    buttonbox(array(
                        "name"=>$mode,
                        "cssclass"=>"mdui-color-green-700"
                    ));
                ?>
            </form>
        </div>
    </div>
</body>
<!-- 这个页面的JS，放在文档尾部 -->
<script src="a5common/commonJS.js?<?php echo rand(1,999999) ?>"></script>
<script>
    window.addEventListener("load",function(){
        // 图片url改变后立即变img里src
        document.querySelector("#Shop_Logo").addEventListener("change",function(e){
            document.querySelector("#img1").src=(e.target.value)
        })
    })
</script>
</html>