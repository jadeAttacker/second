<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>修改商品信息</title>
</head>
<body>
   <center>
      <?php
        include("nav.php");
        include("config.php");
        $link=mysqli_connect(HOST,USER,PASS) or die("数据库连接失败");//调用函数不成功！,这里的host不需要加分号。
        mysqli_select_db($link,DBNAME);
        $sql="select * from goods where id={$_GET['id']}";
        $result=mysqli_query($link,$sql);
        if ($result&&mysqli_num_rows($result)>0) {
           $row=mysqli_fetch_assoc($result);
        }
        $path='./uploads';
      ?>
      <h3> 修改商品信息</h3>
      <form  action="action.php?action=update" method="post" enctype="multipart/form-data"> 
          <input type="hidden"  name="id" value="<?php echo $_GET['id'];?>">
          <input type="hidden" name="oldpic"  value="<?php echo $row["pic"]?>"><!-- 删除图片！ -->
          <table border="0" width='300'>
              <tr>
                  <td width="40">名称:</td>
                  <td><input type="text" name="name" value="<?php echo $row['name'];?>"></td>
              </tr>
              <tr>
                  <td width="40">类型:</td>
                  <td> 
                   
                     <select name="typeid">
                         <?php
                           /* include("config.php");*/
                            foreach($typelist as $k=>$v){
                                   $td=($row['typeid']==$k)?"selected":"";
                                 echo "<option value='{$k}' $td>{$v}</option>";
                            }
                         ?>
                     </select>
                  </td>
              </tr>
              <tr>
                  <td width="40">单价:</td>
                  <td><input type="text" name="price" value="<?php echo $row['price'];?>"></td>
              </tr>
              <tr>
                  <td width="40">库存:</td>
                  <td><input type="text" name="total" value="<?php echo $row['total'];?>"></td>
              </tr>
              <tr>
                  <td width="40">图片:</td>
                  <td><input type="file" name="pic" value="<?php echo $row['pic'];?>"></td>
              </tr>
               <tr>
                  <td width="40" valign="top">描述:</td>
                  <td><textarea rows="5" cols="20" name="note"><?php echo $row["note"];?></textarea></td>
              </tr>
              <tr>
                 <td colspan="2" align="center" width="220">
                      <input type="submit" value="提交">&nbsp;&nbsp;&nbsp;
                      <input type="reset"  value="重置">
                 </td>
              </tr>
             
          </table>
          <img src="./uploads/s_<?php echo$row['pic'];?>"/>
     </form>
      

      
   </center>

</body>
</html>