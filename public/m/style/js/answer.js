var domain = "http://"+window.location.host;
function home() {
    $(".nav").find("div").click(function (e) {
        if ($(this).is(".on")) {
            $(this).removeClass('on')
        } else {
            $('.nav').find('div').removeClass('on');
            $(this).addClass('on')
        }
    })

    $(".home .lists").find('.item').click(function (e) {
        pageManager.go('questions')
    })

}

function details() {

    $(".input>button").click(function () {
        $("#toast").fadeIn(100)
        setTimeout(function () {
            $("#toast").fadeOut(200)
        },2000)
    })

}

function questions() {
    //选择图片
    $("#uploaderInput").click(function (res) {
        var input;
        input = document.createElement('input');
        input.setAttribute('id', 'inImgId');
        input.setAttribute('type', 'file');
        input.setAttribute('name', 'file[]');
        input.setAttribute('multiple', 'multiple');
        input.setAttribute('accept', 'image/gif, image/jpeg, image/jpg, image/png');
        document.body.appendChild(input);
        input.style.display = 'none';

        $(input).localResizeIMG({
            width: 800,
            quality: 1,
            before: function (inp,files) {
                if ((inp.files.length+$("#uploaderFiles").find('li').length)>8){
                    alert("只能选择8张图片")
                    return false;
                }
                return true;
            },
            success: function (result) {
                console.log(result);
                for (i=0;i<result.length;i++){
                    $("#uploaderFiles").append(
                        '<li class="weui-uploader__file" style="background-image:url('+result[i].base64+')">' +
                        '<input name="images[]" type="hidden" value="'+result[i].base64+'">' +
                        '</li>'
                    )
                }
                if ($("#uploaderFiles").find('li').length>=8){
                    $("#uploaderInput").hide()
                }
            }

        });
        input.click();
    })

    $("#showTooltips").click(function (e) {
        var data = $("#questions").serializeArray()
        var d = {};
        $.each(data, function() {
            if (this.name.indexOf("[]") > 0){
                if (jQuery.isArray(d[this.name])){
                    d[this.name].push(this.value)
                }else{
                    d[this.name] = new Array();
                    d[this.name].push(this.value)
                }
            }else{
                d[this.name] = this.value;
            }
        });
        $("#loadingToast").fadeIn(10);
        console.log(data)
        $.post(domain+'?s=Answer.addAnswer',d,function (res) {
            console.log(res)
            if (res.ret==200){
                $("#loadingToast").fadeOut(0);
                $("#toast").fadeIn(0);
                var i = parseInt(res.data);
                if (i>0){
                    $("#toast").fadeIn(10);
                    setTimeout(function () {
                        $("#toast").fadeOut(10);
                        pageManager.back('home');
                    },1000)
                }else{
                    alert(res.msg);
                }
            }else{
                alert("网络请求错误");
            }
        },"json");
    })
    $("#backss").click(function (res) {
        pageManager.back('home');
    })

}