<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <form>
        <table>
            <tr>
                <td>发送内容：</td>
                <td><textarea cols="30" rows="10" id="sendcontent"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" value="群发" id="send"></td>
            </tr>
        </table>
    </form>
</body>
<script>
    $("#send").click(function(e){
        e.preventDefault();
        var content = $('#sendcontent').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     :   '/admin/weixin/send/all',
            type    :   'post',
            data    :   {content:content},
            dataType:   'json',
            success :   function(res){
               if(res.code==0){
                   alert(res.msg)
               }else{
                   alert(res.msg)
               }
                //window.location.reload();
            }
        });
    });
</script>
