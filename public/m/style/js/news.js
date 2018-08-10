var domain = "https://" + window.location.host;
function home() {
    var p=1
    $.post(domain + "?s=News.getNewsList", {
        p: p,
        psize: 30
    }, function (res) {
        console.log(res)
        if (res.ret == 200) {
            for (i = 0; i < res.data.length; i++) {
                var images = '';
                var image = '';
                var strs = new Array(); //定义一数组
                if (res.data[i]['images']){
                    strs = res.data[i]['images'].split(","); //字符分割
                    for (j = 0; j < strs.length && j<3; j++) {
                        image = '<img style="width: 100%;" src="' + strs[j] + '">';
                        images += '<img src="' + strs[j] + '">';
                    }
                }
                if (i<6 && p==1){
                    if (strs.length>0){
                        $(".swiper-wrapper").append(
                            '<div class="swiper-slide"> '+image+' <p>' + res.data[i].title + '</p> </div>'
                        )
                        continue
                    }
                }
                if (res.data[i].id.charAt(res.data[i].id.length - 1) == 1 && strs.length>0) {
                    $(".newslist").append(
                        '<div class="item bottomline"> <div class="newsinfo"> <h3 style="padding-right: 1rem;">' + res.data[i].title + '</h3> <span>' + res.data[i].source + '<span style="padding-left: .5rem">' + res.data[i].addtime + '</span></span> </div> <div class="image big"> ' + image + '</div> </div>'
                    )
                } else if (res.data[i].id.charAt(res.data[i].id.length - 1) % 3 == 0 && strs.length >= 3) {
                    $(".newslist").append(
                        '<div class="item bottomline"> <div class="newsinfo"> <h3>' + res.data[i].title + '</h3> <span>' + res.data[i].source + '<span style="padding-left: .5rem">' + res.data[i].addtime + '</span></span> </div> <div class="image">' + images + ' </div> </div>'
                    )
                } else if (strs.length==0){
                    $(".newslist").append(
                        '<div class="item bottomline" style="display: flex"> <div class="newsinfo" style="width:100%;"> <h3 style="padding-right: 1rem;">' + res.data[i].title + '</h3> <span>' + res.data[i].source + '<span style="padding-left: .5rem">' + res.data[i].addtime + '</span></span> </div>  </div>'
                    )
                } else {
                    $(".newslist").append(
                        '<div class="item bottomline" style="display: flex"> <div class="newsinfo" style="width: 69.1%;"> <h3 style="padding-right: 1rem;">' + res.data[i].title + '</h3> <span>' + res.data[i].source + '<span style="padding-left: .5rem">' + res.data[i].addtime + '</span></span> </div> <div class="image" style="width: 30.9%;"> ' + image + '</div> </div>'
                    )
                }

            }
            $(".home .newslist").find('.item').click(function (e) {
                pageManager.go('details')
            })

            $('#demo2').swiper({
                pagination: '#demo2 .swiper-pagination',
                paginationClickable: true
            });
        } else {
            console.log(res.msg)
        }

    }, "json")


}

function details() {

    $(".input>button").click(function () {
        $("#toast").fadeIn(100)
        setTimeout(function () {
            $("#toast").fadeOut(200)
        }, 2000)
    })

}