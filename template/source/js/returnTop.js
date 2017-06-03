
window.onload = function () {


    var oBtn = document.getElementById("returnTop");
    var Iheader = document.getElementsByClassName("index-header")[0];
    var Categories = document.getElementsByClassName("categories")[0];
    var oAppHeader = 50;
    var timer = null;
    var iSys = true;
    window.onscroll = function () {
        var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
        var seachH = document.body.offsetHeight / 4;

        //检测是否用户滚动
        if (!iSys && scrollTop >= seachH) {

            clearInterval(timer);
            oBtn.style.display = 'block';
        } else {

            oBtn.style.display = 'none';
        }
        iSys = false;



    }

    oBtn.onclick = function () {

        timer = setInterval(function () {

            var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
            var iSpeed = Math.floor(-scrollTop / 8);

            if (scrollTop == 0) {
                clearInterval(timer);
            }

            document.documentElement.scrollTop = document.body.scrollTop = scrollTop + iSpeed;
            iSys = true;

        }, 30)

    }


}


