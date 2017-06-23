var wechatSDKObj =
{
    shareData:{},
    apiList:['onMenuShareTimeline', 'onMenuShareAppMessage', 'getLocation']
}

wechatSDKObj.initWXShare = function(title, desc, link, imgurl, callback)
{
    if (wx)
    {
        $.ajax({
            url: "http://shwj.allyes.com/public_share/weixin/weixinAPI.php",
            type: 'GET',
            cache: false,
            async : false,
            dataType: 'jsonp',
            success: function(data)
            {
                wx.config({
                    debug: false,
                    appId: data.appId,
                    timestamp: data.timestamp,
                    nonceStr: data.nonceStr,
                    signature: data.signature,
                    jsApiList: wechatSDKObj.apiList
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            		console.log("XMLHttpRequest:" + XMLHttpRequest);
            		console.log("textStatus:" + textStatus);
            		console.log("errorThrown:" + errorThrown);
            },
        });

        wechatSDKObj.shareData =
        {
            title: title,
            desc: desc,
            link: link,
            imgUrl: imgurl,
            shareCallBack: callback
        }
        wx.ready(function()
        {
            wechatSDKObj.setShareData(wechatSDKObj.shareData.title, wechatSDKObj.shareData.desc, wechatSDKObj.shareData.link, wechatSDKObj.shareData.imgUrl, wechatSDKObj.shareData.shareCallBack);
            // document.getElementById('music').play();
        });
    }
    else {alert("jweixin.js未加载");}
}

wechatSDKObj.setShareData = function(title, desc, link, imgurl, callback)
{
    wechatSDKObj.shareData =
    {
        title: title,
        desc: desc,
        link: link,
        imgUrl: imgurl,
        shareCallBack: callback
    }

    //朋友圈
    wx.onMenuShareTimeline({
        title: wechatSDKObj.shareData.title,    	// 分享标题
        link: wechatSDKObj.shareData.link,      	// 分享链接
        imgUrl: wechatSDKObj.shareData.imgUrl,  	// 分享图标
        success: function() {
            // 用户确认分享后执行的回调函数
            if (wechatSDKObj.shareData.shareCallBack)
            {
                wechatSDKObj.shareData.shareCallBack('pyq');
            }
        },
        cancel: function() {
            //用户取消分享后执行的回调函数
        }
    });

    //朋友
    wx.onMenuShareAppMessage({
        title: wechatSDKObj.shareData.desc,    	    // 分享标题
        desc: wechatSDKObj.shareData.title,         // 分享描述
        link: wechatSDKObj.shareData.link,      	// 分享链接
        imgUrl: wechatSDKObj.shareData.imgUrl,  	// 分享图标
        type: 'link',               				// 分享类型,music、video或link，不填默认为link
        dataUrl: wechatSDKObj.shareData.dataUrl, 	// 如果type是music或video，则要提供数据链接，默认为空
        success: function() {
            // 用户确认分享后执行的回调函数
            if (wechatSDKObj.shareData.shareCallBack)
            {
                wechatSDKObj.shareData.shareCallBack('py');
            }
        },
        cancel: function() {
            //用户取消分享后执行的回调函数
        }
    });

    // wx.getLocation({
    //     type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
    //     success: function (res) {
    //         var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
    //         var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
    //         var speed = res.speed; // 速度，以米/每秒计
    //         var accuracy = res.accuracy; // 位置精度


    //         if(!res.latitude && !res.longitude){
    //             alert("尚未获取到微信给于的经纬度，自动刷新页面");
    //             window.location.reload();
    //         }

    //         wx_lat = latitude;
    //         wx_lon = longitude;
    //     }
    // });
}