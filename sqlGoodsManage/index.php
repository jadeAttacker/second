<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>查看商品信息</title>
</head>
<body>
   <center>
       <?php  include("nav.php");    ?>
       <h3>查看商品信息</h3>
       <table border="1" width="800">
           <tr>
               <th>商品编号</th>
               <th>商品名称</th>
               <th>商品图片</th>
               <th>商品类型</th>

               <th>商品价格</th>
                <th>商品总数</th>
               <th>商品描述</th>
               <th>添加时间</th>
               <th width="70">操作</th>
           </tr>
           <?php
           //1 连接数据库
           include("config.php");
           $link=mysqli_connect(HOST,USER,PASS);
           mysqli_select_db($link,"test");
           $sql='select * from goods';
           $result=mysqli_query($link,$sql);
           while ($row=mysqli_fetch_assoc($result)) {
               echo "<tr>";
               echo "<td>{$row['id']}</td>";
               echo "<td>{$row['name']}</td>";
                echo "<td><img src='./uploads/s_".$row["pic"]."'/></td>";
               echo "<td>{$typelist[$row['typeid']]}</td>";
               echo "<td>{$row['price']}</td>";
               echo "<td>{$row['total']}</td>";
               echo "<td>{$row['note']}</td>";
                echo "<td>".date("Y-m-d H:i:s",$row['addtime'])."</td>";
                echo "<td><a href='./action.php?action=del&id=".$row['id']."&name={$row['pic']}"."'>删除</a>|
                          <a href='./edit.php?id=".$row['id']."'>修改</a></td>";
                
               echo "</tr>";
           }
           ?>

       </table>
   </center>

</body>
</html>