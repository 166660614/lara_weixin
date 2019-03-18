<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="/js/jquery-1.12.4.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="all">
    <div id="first">
        <input type="button" value="一级按钮">
        名字：<input type="text" class="fname">
        <input type="button" value="克隆" class="first">
    </div>
    <div id="second" num="1">
        <input type="button" value="二级按钮">
        按钮类型：<select name="type" id="type">
            <option  value="view">跳转</option>
        </select>
        按钮名称：<input type="text" id="sname">
        按钮url： <input type="text" id="url">
        <input type="button" value="克隆" class="second">
    </div>
</div>
    <input type="button" value="发布" id="submit">
</body>
</html>
<script>
    $(function () {
        //克隆一级按钮
        $(document).on('click','.first',function () {
           var _this=$(this);
           var _fdiv=_this.parents('.all');
           if($('.all').length<3){
               _fdiv.after(_fdiv.clone());
           }
        })
        //克隆二级按钮
        $(document).on('click','.second',function () {
            _this=$(this);
            var _sdiv=_this.parents('#second');
            var num=parseInt(_sdiv.attr('num'));
            num+=1;
            _this.parent().attr('num',num)
           if(num<=3){
                _this.parents('.all').children('#first').after(_sdiv.clone());
            }
        })
        $(document).on('click','#submit',function () {
            _this=$(this);
            var first_info={};
            $('.fname').each(function (i) {
                f_info={};
                f_info['fname']=$(this).val();
                $(this).parent('div').siblings().each(function (e) {
                    second_info={}
                    s_info['type']=$('.type').val();
                    s_info['url']=$('url').val();
                    second_info[e]=s_info;
                }).

                info['sub_button']=second_info;
                first_info[i]=info;
            })
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url     :   '/weixin/passmenu',
                type    :   'post',
                data    :   first_info,
                dataType:   'json',
                success :   function(res){
                    console.log(res);
                }
            });
        })
    })

</script>