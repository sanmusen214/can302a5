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

session_start();

/**
 * 从数据库中查询并展示一个列表，
 * 第一个参数为数据库实例
 * 第二个参数为查询字符串
 * 第三个参数为表头数据的html字符串
 * 第四个参数为一个回调函数，输入值是一行查询结果，然后自定义如何渲染这一行tr
 * 第五个参数是右上角加号的跳转目的地
 * 第六个参数（可选）是用于搜索的数据库下标名字，使用这个参数的话则第二个参数应当最后有WHERE
 *  */ 
function displayList($mycon,$mysqlstr,$myheadstr,$myrenderrow,$myaddurl,$searchindexes=array()){
    // mycon为入参，使用这个函数的时候把全局的$con传入就行了
    
    // 如果有传入可搜索的下标searchindexed
    // 按钮
    if($searchindexes){
        // 尝试获取searchword
        if(isset($_GET["searchword"])){
            $keyword=$_GET["searchword"];
            // 将关键字里的'去掉，否则数据库报错
            $keyword=str_replace("'","",$keyword);
            // 拼接搜索 https://blog.csdn.net/qq_61726905/article/details/126891406
            $mysqlstr=$mysqlstr." AND CONCAT(";

            foreach($searchindexes as $ind){
                $mysqlstr=$mysqlstr."IFNULL(`$ind`, ''),";
            }
            // 去除最后一位的逗号
            $mysqlstr=substr($mysqlstr, 0, strlen($mysqlstr)-1);
            $mysqlstr=$mysqlstr.") LIKE '%$keyword%';";

            echo '<div class="mdui-textfield mdui-textfield-expandable mdui-float-right 
            mdui-textfield-expanded" style="max-width:400px;margin-bottom:10px">
            <button class="mdui-textfield-icon mdui-btn mdui-btn-icon" onclick="clicktosearch()">
              <i class="mdui-icon material-icons">search</i>
            </button>
            <input class="mdui-textfield-input" type="text" placeholder="Search" id="listsearchbox" value='.$keyword.' />
            <button class="mdui-textfield-close mdui-btn mdui-btn-icon">
              <i class="mdui-icon material-icons" onclick="clicktoclear()">close</i>
            </button>
          </div>';
        }else{
            echo '<div class="mdui-textfield mdui-textfield-expandable mdui-float-right mdui-textfield-expanded" style="max-width:400px;margin-bottom:10px">
            <button class="mdui-textfield-icon mdui-btn mdui-btn-icon" onclick="clicktosearch()">
              <i class="mdui-icon material-icons">search</i>
            </button>
            <input class="mdui-textfield-input" type="text" placeholder="Search" id="listsearchbox"/>
            <button class="mdui-textfield-close mdui-btn mdui-btn-icon">
              <i class="mdui-icon material-icons" onclick="clicktoclear()">close</i>
            </button>
          </div>';
        }
    }
    // 列表
    echo '<div class="mdui-table-fluid">
            <table class="mdui-table">
            <thead><tr>'.$myheadstr.'<th>
            <span style="display:inline-block;padding-right:30px;">Operations</span>
            <a style="color:green;" href="javascript:;" onclick="location.href=`'.$myaddurl.'`;saveMessage(\'Add New\')" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">add</i></a>

            <a style="color:green;" href="javascript:;" onclick="location.reload();saveMessage(\'Refresh Page\')" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">autorenew</i></a>
            </th></tr></thead><tbody>';
            // .mdui-table-selectable 批量删除            <a style="color:green;" href="javascript:;" onclick="findWhichAreSelected()" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons">delete</i></a>
    $query = $mycon->query($mysqlstr);
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

/**
 * 如果登录，则不动，如果没登陆则跳到登录页
 */
function checklogin(){
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
    }
}

?>

