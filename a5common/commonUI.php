<?php
    // 一些可以重复使用的UI
    // 顶部栏
    function topbarUI(){
        echo '
        <div class="mdui-toolbar mdui-color-theme" style="color:green;">
            <a onclick="toggleSiderbar()" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">menu</i>
            </a>
            <span class="mdui-typo-title" style="color:black;">A5 Shopping Mall Admin System</span>
            <div class="mdui-toolbar-spacer"></div>
            <a onclick="clickSomething()" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">assignment_late</i>
            </a>
            <a onclick="clickSomething()" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">local_post_office</i>
            </a>
            <div class="mdui-chip" style="line-height:normal" onclick="clickSomething()">
                <span class="mdui-chip-icon">
                    <i class="mdui-icon material-icons">person</i>
                </span>
                <span class="mdui-chip-title">Admin</span>
            </div>
            <a onclick="clickSomething()" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">exit_to_app</i>
            </a>
        </div>
        ';//记得分号
    }
    // 侧边框
    function siderbarUI(){
        $nowurl=$_SERVER["REQUEST_URI"];
        $product=strpos($nowurl,"product")?"lefthighlight":"";
        $category=strpos($nowurl,"category")?"lefthighlight":"";
        $user=strpos($nowurl,"user")?"lefthighlight":"";
        $order=strpos($nowurl,"order")?"lefthighlight":"";
        $coupon=strpos($nowurl,"coupon")?"lefthighlight":"";


        echo '
        <div class="mdui-drawer" id="siderbar">
            <ul class="mdui-list">
            <li class="mdui-list-item mdui-ripple '.$product.'" onclick="window.location=`a5product.php`;">
                <i class="mdui-icon material-icons">class</i>
                <div class="mdui-list-item-content">&nbsp Product</div>
            </li>
            <li class="mdui-list-item mdui-ripple '.$category.'" onclick="window.location=`a5category.php`;">
                <i class="mdui-icon material-icons">apps</i>
                <div class="mdui-list-item-content">&nbsp Category</div>
            </li>
            <li class="mdui-list-item mdui-ripple '.$user.'" onclick="window.location=`a5user.php`;">
                <i class="mdui-icon material-icons">person</i>
                <div class="mdui-list-item-content">&nbsp User</div>
            </li>
            <li class="mdui-list-item mdui-ripple '.$order.'" onclick="window.location=`a5order.php`;">
                <i class="mdui-icon material-icons">assignment</i>
                <div class="mdui-list-item-content">&nbsp Order</div>
            </li>
            <li class="mdui-list-item mdui-ripple '.$coupon.'" onclick="window.location=`a5coupon.php`;">
                <i class="mdui-icon material-icons">card_giftcard</i>
                <div class="mdui-list-item-content">&nbsp Coupon</div>
            </li>
            </ul>
        </div>
        ';//记得分号
    }


    // 输入框
    // 传入时name必填
    function inputbox($config){
        $name=$config["name"];
        $defaultvalue=isset($config["defaultvalue"])?$config["defaultvalue"]:"";
        $required=isset($config["required"])?$config["required"]:false;
        $placeholder=isset($config["placeholder"])?$config["placeholder"]:"Input $name";
        $pattern=isset($config["pattern"])?$config["pattern"]:"^.*$";
        $patternword=isset($config["patternword"])?$config["patternword"]:"Invalid Input";
        $extra=isset($config["extra"])?$config["extra"]:"";

        $requirestr=$required?"required":"";

        echo "
        <input $requirestr $extra pattern='$pattern' type='text' onInput='checkit(this,`$patternword`)' class='form-control' id='$name' placeholder='$placeholder' name='$name' value='$defaultvalue'>
        ";
    }

    // 选择框
    // 传入时name和valuelist必填
    function selectbox($config){
        $name=$config["name"];
        $valuelist=$config["valuelist"];
        $defaultvalue=isset($config["defaultvalue"])?$config["defaultvalue"]:"";

        echo "<select class='mdui-select' name='Payment_Method'>'";
        foreach($valuelist as $value){
            $isselect=$defaultvalue==$value?'selected':'';
            echo "<option value='$value' $isselect>$value</option>";
        }
        echo "</select>";
    }
?>