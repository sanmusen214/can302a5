# HOW TO RUN

##

1. 在电脑的xampp安装目录下的/htdocs文件夹内，执行git clone，此时文件夹结构为 /htdocs/can302a5
2. 启动xampp的apache和mysql
3. 在mysql的[admin页面](http://localhost/phpmyadmin/index.php?route=/server/sql)内，使用`database.sql`文件内的sql语句创建一个名为a5asm2的数据库以及其内的数据表。
4. 访问[http://localhost/can302a5/](http://localhost/can302a5/)即可

##

1. Run `git clone https://github.com/sanmusen214/can302a5.git` in the folder `/htdocs` of XAMPP, which will make a folder structure like /htdocs/can302a5
2. Run apache and mysql in XAMPP
3. In [admin page,](http://localhost/phpmyadmin/index.php?route=/server/sql) use sql commands in `database.sql` to create database and tables.
4. Visit [http://localhost/can302a5/](http://localhost/can302a5/)

# Dev Readme

## 假删除

数据库使用假删除：每个数据表拥有一个deleted字段，其类型为boolean。
当deleted字段为TRUE时，在用户视角下，此行数据内容不可见，但其仍在数据库内。

- 显示默认列表时**筛选**deleted为FALSE的行
  
  ```
  浏览可显示的用户列表
  SELECT * FROM `user` WHERE `deleted`=FALSE;
  ```

- 显示关键词搜索结果列表时**筛选**deleted为FALSE的行
  
  ```
  查找名字里有wu的用户
  SELECT * FROM `user` WHERE `name` like "%wu%" AND `deleted`=FALSE;
  ```

- 通过id查看时**不需要**筛选deleted字段，比如从订单页面跳转到某个商品界面，即使该商品已经被'删除'，也应当能看到该商品（只不过加个商品已下架这种字样）

    ```
    强制查看id为1的商品
    SELECT * FROM `product` WHERE `id`=1;
    ```

删除操作则变为把这个deleted字段更新为为TRUE即可，而不用DELETE语句

```
    假删除id为1的用户
    UPDATE `user` SET `deleted` = TRUE WHERE `id`=1;
```

deleted默认值为FALSE，添加一行新数据或修改数据时可以忽略deleted字段。

## 面向组件构建

基本实现了页面主要元素的组件化，如commonUI.php里封装的inputbox()，selectbox()。同时通过插件的方式为组件注入额外功能，如commonJS.js里的itMustExist()和itMustNotExist()

### 组件inputbox

输入性组件，使用pattern或结合插件可以实现对输入值的限制

### 组件selectbox

下拉选择组件，通过给定的valuelist表现下拉元素。

### 组件selectitemsbox

下拉选择组件，与selectbox不同的是下拉元素是通过查询mysql获得的。

### 插件itMustExist()

通过ajax请求查询和表单的错误弹窗事件，控制表单元素必须在某个表的表项中出现过，通过在文档末尾调用此函数，传入指定的表单input控件以及表名，表项即可

### 插件itMustNotExist()

同上，控制表单元素不在某个表的表项中出现过。