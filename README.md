# HOW TO RUN

1. 在电脑的xampp安装目录下的/htdocs文件夹内，执行git clone
2. 启动xampp的apache和mysql
3. 在mysql的[admin页面](http://localhost/phpmyadmin/index.php?route=/server/sql)内，使用`asm2.sql`文件内的sql语句创建数据库和数据表
4. 访问`http://localhost/can302a5/`即可

# REMINDER

## 假删除

数据库使用假删除：每个数据表拥有一个deleted属性，其类型为boolean。
当deleted为true时，可以认为此行不可见。

如果某行的deleted字段为true：

- 展示默认列表时应当**忽略**这行
  
  ```
  SELECT * FROM `table` WHERE `deleted`=FALSE;
  ```

- 展示关键词搜索结果列表时应当**忽略**这行
  
  ```
  SELECT * FROM `table` WHERE `name` like "water" AND `deleted`=FALSE;
  ```

- 通过id查看时应当**显示**这行

    ```
    SELECT * FROM `table` WHERE `id`=1;
    ```

删除操作则变为把这个deleted字段更新为为TRUE，而不用DELETE操作

```
    UPDATE `table` SET `deleted` = TRUE WHERE `id`=1;
```

deleted默认值为FALSE，添加一行新数据或修改数据，可以忽略这个参数。