<!-- 一些可以重复使用的php函数 -->
<!-- 运行路径是调用者所在的路径 -->
<?php

// 数据库实例
$dbms='mysql';     //DBMS type
$host='localhost'; //Host name
$dbName='a5asm2';  //database name
$user='root';      //database user
$pass='';          //database password
$dsn="$dbms:host=$host;dbname=$dbName";

$projectname="Group A5";

try {
    $con = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}

// 测试引入函数能否使用
function echoonce($str){
    echo "复用了a5php里的echoonce函数输出：".$str;
}

// 接受get参数
function myget($str) { 
    $val = !empty($_GET[$str]) ? $_GET[$str] : '';
    return $val;
}       

//接受post参数
function mypost($str) { 
    $val = !empty($_POST[$str]) ? $_POST[$str] : '';
    return $val;
}

// 设置cookie
function setnewcookie($name,$value){
    $expire = time() + 60*60*24;
    setcookie($name, $value, $expire, "/");
}

/**
 * 从数据库中查询并展示一个列表，
 * 第一个参数为数据库实例
 * 第二个参数为查询字符串
 * 第三个参数为表头数据的html字符串
 * 第四个参数为一个回调函数，输入值是一行查询结果，然后自定义如何渲染这一行tr
 * 第五个参数是右上角加号的跳转目的地
 *  */ 
function displayList($mycon,$mysqlstr,$myheadstr,$myrenderrow,$myaddurl){
    // mycon为入参，使用这个函数的时候把全局的$con传入就行了
    $query = $mycon->query($mysqlstr);

    echo '<div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-selectable">
            <thead><tr>'.$myheadstr.'<th>
            <span style="display:inline-block;padding-right:30px;">Operations</span>
            <a style="color:green;" href="javascript:;" onclick="location.href=`'.$myaddurl.'`" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">add</i></a>
            <a style="color:green;" href="javascript:;" onclick="findWhichAreSelected()" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">delete</i></a>
            <a style="color:green;" href="javascript:;" onclick="location.reload()" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">autorenew</i></a>
            </th></tr></thead><tbody>';
    foreach($query as $row){
        $rowdata=array($row);
        echo "<tr>";
        call_user_func_array($myrenderrow,$rowdata);
        echo "</tr>";
    }
    
    echo '</tbody>
        </table>
        </div>';
}
?>