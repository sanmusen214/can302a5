<?php
    // header("Location:./a5product.php");
    require_once "a5common/commonPHP.php";
    require_once "a5common/commonUI.php";
?>


<?php

//if (isset($_SESSION['user_id'])) {
//    header("Location: a5product.php");
//    exit;
//}


$error = "";
if (isset($_POST['login'])) {
    $username = mypost('username');
    $password = mypost('password');

    $stmt = $con->prepare("SELECT Admin_Password FROM admin WHERE Admin_ID = ?");
    $stmt->bindParam(1, $username, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['Admin_Password'] != null) {
            if ($password == $result['Admin_Password']) {
                $_SESSION['user_id'] = $username;
                header("Location: a5product.php");
                exit;
            } else {
                $error = "Incorrect username or password.";
            }
    } else {
        $error = "User does not exist.";
    }
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
    <title>CAN302 A5 store | Category</title>
</head>
<body>
    <!-- 顶部框 -->
    <?php
    topbarUI();
    ?>

    <?php
        echo '
        <div class="mdui-card">
            <div class="mdui-card-media">
                <img src="WechatIMG9.jpeg"/>
            </div>
            
            <div class="mdui-card-primary-title">Admin System</div>
            
            <div class="mdui-card-content" id="table"> 
                <form class="form-online" role="form" action="index.php" method="post">
                    <div class="mdui-textfield mdui-textfield-floating-label">
                        <label class="mdui-textfield-label">Username</label>
                        <input id="username" name="username" class="mdui-textfield-input"/>
                    </div>
                    <div class="mdui-textfield mdui-textfield-floating-label">
                        <label class="mdui-textfield-label">password</label>
                        <input id="password" name="password" class="mdui-textfield-input"/>
                    </div>
                    <button type="submit" class="btn btn-primary" id="login" name="login" value="login"> Login </button>
                </form>
                
                
                
            </div>     
        </div>
        ';
    ?>
    <?php if (!empty($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>



</body>
<!-- 这个页面的JS，放在文档尾部 -->
<script src="a5common/commonJS.js"></script>
<script>
    
</script>
</html>