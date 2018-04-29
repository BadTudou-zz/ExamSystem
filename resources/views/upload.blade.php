<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Insert title here</title>
</head>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>

<body>
<form id="upfile">
    选择一个文件:
    <input type="file" name="document" id="upload" />
    <br/><br/>
    <input id="uploadFile" value="上传" type="button"/>
</form>

<div id="upFile"></div>
</body>
<script type="text/javascript">

    $("#uploadFile").click(function(){
        var formData = new FormData($("#upfile")[0]);
        //formData.set('file', document.getElementById("upload").files[0]);
        $.ajax({
            url: 'api/v1/questions/import',
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success:function (json) {

            }
        });
    });
</script>
</html>