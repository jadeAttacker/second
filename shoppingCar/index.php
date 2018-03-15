<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>购物车</title>
  <style>
       #buy{
       	  position:fixed;
       	  bottom:0;
       	  width:100%;
       	  height:60px;
       	  border: 1px #DFDFDF solid;
       }
      #buy font{
      	  display:block;
      	  position:absolute;
      	  right:20%;
          background-color:red;
          height:60px;
          width:90px;
          text-align:center;
          line-height:60px;
          font-family: courier new,courier,monospace;/* 改字体 */
          font-size:18px;
          color:white;
      }

  </style>
</head>
<body>
   <center> 
       <h3>查看我的购物车</h3>
       <table border="1" >
           <tr>
               <th>商品编号</th>
               <th width="100">商品名称</th>
               <th>商品价格</th>
               <th width="100">商品图片</th>
               <th>添加时间</th>
               <th width="70">操作</th>
           </tr>
           <?php
           //1 连接数据库
           include("config.php");
           $link=mysqli_connect(HOST,USER,PASS);
           mysqli_select_db($link,"test");
           $sql='select * from shoppingcar';
           $result=mysqli_query($link,$sql);
           while ($row=mysqli_fetch_assoc($result)) {
               echo "<tr>";
	               echo "<td>{$row['id']}</td>";
	               echo "<td>{$row['name']}</td>";
	               echo "<td>{$row['price']}</td>";
	               echo"<td>{$row['picture']}</td>";// echo "<td><img src='./uploads/s_".$row["pic"]."'/></td>";
	               echo "<td>".date("Y-m-d H:i:s",$row['time'])."</td>";
                   echo"<td><a href=''>删除</>";
	             /*  echo "<td><a href='./action.php?action=del&id=".$row['id']."&name={$row['pic']}"."'>删除</a>|
	                          <a href='./edit.php?id=".$row['id']."'>修改</a></td>";*/
               echo "</tr>";
           }
           ?>
       </table>
       <div id="buy">
            <font>去结算</font>
       </div>
   </center>

</body>
</html>
