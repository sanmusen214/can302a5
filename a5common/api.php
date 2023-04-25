<?php
require_once "commonPHP.php";

// GET接口
// (部分有外键的数据表需要确保那个外键存在才能新建
// (如添加新order的时候需要确保其内的商品id是存在的。
// 参数有tablename和indexname时走此接口并结束响应
// 查询某个列表某一列的所有值
// 如：http://localhost/can302a5/a5common/api.php?tablename=user&indexname=User_ID
// 如：http://localhost/can302a5/a5common/api.php?tablename=user&indexname=User_Name
myColList($con);



?>