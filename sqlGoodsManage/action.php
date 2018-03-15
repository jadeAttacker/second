<?php
header("Content-type:text/html;charset=utf-8");
include("config.php");
$link=mysqli_connect(HOST,USER,PASS) or die("数据库连接失败");//调用函数不成功！,这里的host不需要加分号。
mysqli_select_db($link,DBNAME);
$path='./uploads';
switch ($_GET["action"]) {//需要加括号
	case 'add'://添加
	//1 获取数据
		$name=$_POST["name"];
		$typeid=$_POST["typeid"];
		$price=$_POST["price"];
		$total=$_POST["total"];
		$note=$_POST["note"];
		$time=time();
	//2. 验证（省略）
	if (empty($name)) {
		die("商品名称不能为空！");
	}
    //3. 把图片上传(有一节单独讲)，不需要管原来文件的路径，只获取文件名和后缀。{可以封装为一个函数}（"pic",$path)传入参数即可。把错误信息为返回值
        $pic=$_FILES["pic"];
        var_dump($_FILES);
        //(1)过滤文件，查看错误号。
        echo "图片的错误代码为：".$pic["error"]."</br>";
        //(2)对文件大小进行限定
        echo "图片的大小为：".$pic["size"]."</br>";
        //(3)文件类型的过滤
        echo "文件的类型为：".$pic["type"]."</br>";//判断是否在某个数组中
        //(4)数组的形式返回文件路径的信息，并给文件命名
        $fileinfo=pathinfo($pic["name"]);//[dirname] [basename] [extension],上传的文件全是这么命名的，与原文件名无关
        do{
             $newfile=date("YmdHis").rand(1111,9999).".".$fileinfo["extension"];
        }while(file_exists($path."/".$newfile)); 
        //(5)移动到upload里面去
        if (is_uploaded_file($pic["tmp_name"])) {
        	if (move_uploaded_file($pic["tmp_name"], $path."/".$newfile)) {
        		echo "图片上传成功！";
        		echo "<a href='index.php'>查看商品</a>";
        	}else{
        		die("文件上传失败！！");//上传到服务器，对客户端而言。
        	}
        }else{
        	echo "不是上传文件！！";
        }
    //4 执行图片缩放
        imageUpdateSize($path."/".$newfile,50,50);//传入的是一个资源，带上路径的。
    //5 添加数据
        $sql="insert into goods values(null,'{$name}',{$typeid},{$price},{$total},'{$note}','{$newfile}','{$time}')";
        mysqli_query($link,$sql);
        if (mysqli_insert_id($link)>0) {//mysql_insert_id() 函数返回上一步 INSERT 操作产生的 ID。
        	echo "商品添加成功";
        }else{
            echo "商品添加失败".mysqli_error($link);
        }
    //6 输出 添加成功
        echo "<br/><a href='index.php'>往数据库添加成功！！</a>";
		break;
	case 'del'://删除\
	//删除之前可以有弹出框！！
		$id=$_GET['id'];
		echo "要删除的是第".$id."条";
		$sql="delete from goods where id={$id}";
		mysqli_query($link,$sql);
		if (mysqli_affected_rows($link)>0) {//影响的行大于1，则进行图片删除
			@unlink("./uploads/".$_GET['name']);
			@unlink("./uploads/s_".$_GET['name']);
		}
        header("Location:index.php");
		break;
	case 'update'://修改
		$id=$_POST['id'];
		/*window.locat*/
		echo "要修改的是第".$id."条"."<br/>";
		$oldpic=$_POST['oldpic'];
		echo "要删除的图片是".$oldpic."<br/>";
        $sql="update goods set note='2222',name='beautiful' where id={$id}";
        echo $sql;
        mysqli_query($link,$sql) or die("数据库连接有误".mysqli_error($link));
		/*1 检测有无图片上传=>根据错误号$_FILES['pic']["error"]!=4=>执行图片上传；
		2 图片缩放
		3 执行修改（sql语句）*/
		break;
	
	default:
		# code...
		break;
}
mysqli_close($link);


//图片等比缩放函数
//创建了两块画布。
function imageUpdateSize($picname,$maxx=100,$maxy=100,$pre="s_" ){
    $info=getimagesize($picname);//高度，宽度，类型（只针对图片）资源，带路径
    $w=$info[0];
    $h=$info[1];
    switch ($info[2]) {//判断图片后缀。
    	case 1://gif
    		$im=imagecreatefromgif($picname);//创建一块画布，并从 GIF 文件或 URL 地址载入一副图像
    		break;
    	case 2://jpg
    		$im=imagecreatefromjpeg($picname);
    		break;
    	case 3://png
    		$im=imagecreatefromjpg($picname);
    		break;
    	default:
    		die("图片上传失败！");
    		break;
    }
    //计算缩放比例
    if(($maxx/$w)>($maxy>$h)){
    	$b=$maxy/$h;
    }else{
    	$b=$maxx/$w;
    }
    $w2=floor($w*$b);
    $h2=floor($h*$b);
    $newfile=imagecreatetruecolor($w2, $h2);//第二块画布
    imagecopyresampled($newfile, $im, 0, 0, 0, 0, $w2, $h2, $w, $h);//进行等比缩放。
    $picinfo=pathinfo($picname);//路径，名字，后缀。
    $newpicname=$picinfo["dirname"]."/".$pre.$picinfo["basename"];//定义在函数内部
    //输出图像,根据源图像的类型，输出为对应的类型
    switch ($info[2]) {
    	case 1:
    		imagegif($newfile,$newpicname);//以 GIF 格式将图像输出到浏览器或文件,指定了输出到哪里去。
    		break;
    	case 2:
    		imagejpeg($newfile,$newpicname);
    		break;
    	case 2:
    		imagepng($newfile,$newpicname);
    		break;
    	default:
    		break;
    }
    //释放图片资源
    imagedestroy($im);//释放第一块画布
    imagedestroy($newfile);//释放第二块画布。
    return $newpicname;
}

?>