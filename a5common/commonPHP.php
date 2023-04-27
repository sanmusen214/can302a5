<?php
// 一些可以重复使用的php函数
// 运行路径是调用者所在的路径
// php框外面的上面如果有注释竟然也会被接口返回（被解析为html），所以上面不放注释了

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


// 查询某个数据表的有效id列表，返回json数据
// 调用时 GET 方法，
// url参数为tablename和indexname
// 需要url里同时有这两个参数才会作为接口使用
// 接口返回参数模板{"code":200,"message":"","data":['1',''2,'3','4']}
// 如查询可用（已经存在且未删除的）的user,ajax请求参数为?tablename=user&indexname=User_ID
/**
 * @param mycon 数据库连结实例
 */
function myColList($mycon){
    // 只有同时有这两个参数才会作为接口使用
    if(isset($_GET['tablename'])&&isset($_GET['indexname'])) {
        $tablename=myget('tablename');
        $indexname=myget('indexname');
        // 查询
        try{
            $sql = "SELECT $indexname FROM $tablename";
            $query = $mycon->query($sql);
            $data=array();
            foreach($query as $row){
                // 拼接查询结果
                $data[]=$row[$indexname];
            }
            // 构造返回结果
            $result["code"] = 200;
            $result["message"] = "OK";
            $result["data"] = $data;
        }catch(Exception $e){
            // 构造error返回结果
            $result["code"] = 500;
            $result["message"] = $e->getMessage();
            $result["data"] = array();
        }
        // 接口返回json
        echo json_encode($result);
        // 退出脚本
        exit();
    }
}


// 给定表名和主键名，以及一个主键以及要查询的字段名。
// 查询某个表中某一行的某个字段
/**
 * @param tablename 表名
 * @param primaryindex 主键名
 * @param primaryname 某个主键
 * @param searchindex 该主键所在行的另一字段
 */
function searchnameof($tablename,$primaryindex,$primaryname,$searchindex){
    global $con;
    $sql = "SELECT `$searchindex` FROM `$tablename` WHERE `$primaryindex`='$primaryname'";
    $query = $con->query($sql);
    return $query->fetch()[$searchindex];
}

?>

