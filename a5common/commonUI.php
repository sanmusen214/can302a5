<!-- 一些可以重复使用的UI -->
<?php
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
        echo '
        <div class="mdui-drawer" id="siderbar">
            <ul class="mdui-list">
            <li class="mdui-list-item mdui-ripple" onclick="window.location=`a5product.php`;">
                <i class="mdui-icon material-icons">class</i>
                <div class="mdui-list-item-content">&nbsp Product</div>
            </li>
            <li class="mdui-list-item mdui-ripple" onclick="window.location=`a5category.php`;">
                <i class="mdui-icon material-icons">apps</i>
                <div class="mdui-list-item-content">&nbsp Category</div>
            </li>
            <li class="mdui-list-item mdui-ripple" onclick="window.location=`a5user.php`;">
                <i class="mdui-icon material-icons">person</i>
                <div class="mdui-list-item-content">&nbsp User</div>
            </li>
            <li class="mdui-list-item mdui-ripple" onclick="window.location=`a5order.php`;">
                <i class="mdui-icon material-icons">assignment</i>
                <div class="mdui-list-item-content">&nbsp Order</div>
            </li>
            <li class="mdui-list-item mdui-ripple" onclick="window.location=`a5coupon.php`;">
                <i class="mdui-icon material-icons">card_giftcard</i>
                <div class="mdui-list-item-content">&nbsp Coupon</div>
            </li>
            </ul>
        </div>
        ';//记得分号
    }
?>