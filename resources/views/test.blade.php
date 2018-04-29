<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script type="text/javascript">

        var xhr = new XMLHttpRequest();

        var clock = null;

        var postfix = null;

        var myDate = new Date();

        var time = null;

        var filename = null;




        // 随便写的一个值，具体的userid和cid你从Storage取出来

        // 随便写的一个值，具体的userid和courseId你从Storage取出来


        var userid = 1;

        var cid = 2;

        // 视频名称和所属知识点，由用户填写，加两个input框
        var videoName = "测试视频";

        var kp = "知识点是xxxx";

        function fire(file){

            var name = file.value;

            var pos = name.lastIndexOf('.');


            postfix = name.substring(pos+1);

            time = myDate.getFullYear()+'-'+myDate.getMonth()+'-'+myDate.getDate()+'-'+Math.ceil(Math.random()*100000);

            filename = time + '.' + postfix;

            clock =  window.setInterval(sendfile,1000);

        }


        var sendfile = (function (){
            const  LENGTH = 5*1024*1024; //每一次上传10M
            // 开始截取位置
            var sta = 0;
            // 截取结束的位置。
            var end = sta+LENGTH;
            //标识上一块是否上传完毕。
            var flag = false;
            // 设置一个blob变量
            var blob = null;
            // 设置一个HTML5的文件对象。
            var fd = null;
            // 设置百分比
            var percent = 0;


            return (function (){

            var res = (function (){
                if(flag == true){
                    return;
                }

                // 获取文件信息
                var mov = document.getElementsByName('pic')[0].files[0];
                // 如果sta>mov.size
                if(sta>mov.size){
                    clearInterval(clock);
                    info(userid,cid);
                    alert("上传成功");
                    return ;
                }

                blob = mov.slice(sta,end);

                fd = new FormData();

                fd.append('part',blob);


                up(fd);

                sta = end;

                end = sta + LENGTH;

                flag = false;

                percent =100*end/mov.size;

                if (percent>100) {
                    percent=100;
                }
                document.getElementById('bar').style.width = percent + '%';
                document.getElementById('bar').innerHTML = parseInt(percent) + '%';
            });
            return res;
        })(userid,cid);


        function up(fd){

            xhr.open('POST','api/v1/upload/lecture/video?filename='+filename,false);
            xhr.send(fd);
            // alert(xhr.responseText);
            console.log(FormData);
        }

        function info(userid,cid){
            xhr.open('POST','api/v1/upload/lecture/insert/video?userid='+userid + "&cid=" + cid + "&filename="+filename
                +"&kp=" + kp + "&videoName=" + videoName,false);
            xhr.send();
        }


    </script>
    <style type="text/css">
        #progress{
            width: 500px;
            height: 30px;
            border: 1px solid green;
        }
        #bar{
            width: 0%;
            height: 100%;
            background: green;
        }
    </style>
</head>
<body>
<h1>上传视频材料</h1>
<div id="progress">
    <div id="bar"></div>
</div>
<input type="file" name="pic" onchange="fire(this);" >


</body>
</html>
