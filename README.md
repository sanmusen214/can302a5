# HOW TO RUN

1. 在电脑的xampp安装目录下的/htdocs文件夹内，执行git clone，此时文件夹结构为 /htdocs/can302a5
2. 启动xampp的apache和mysql
3. 在mysql的[admin页面](http://localhost/phpmyadmin/index.php?route=/server/sql)内，使用`asm2.sql`文件内的sql语句创建数据库和数据表
4. 访问[http://localhost/can302a5/](http://localhost/can302a5/)即可

# REMINDER

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