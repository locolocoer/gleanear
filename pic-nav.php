<?php

/**
 * 图片展示页
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$this->need('header.php'); ?>

<?php
$options = Typecho_Widget::widget('Widget_Options');
$pri_thumbs = explode("|", $options->bcool_cover); /*获取文章封面*/
$pub_thumbs = explode("|", $options->public_bcool_cover);
if ($this->user->hasLogin()) {
    $thumbs = array_merge($pri_thumbs, $pub_thumbs);
} else {
    $thumbs = $pub_thumbs;
}
$num = count($thumbs);
// shuffle($thumbs);
if (!isset($_POST["pageNum"])) {
    $pageNum = 1;
} else {
    $pageNum = intval($_POST["pageNum"]);
}
$begin = 100 * ($pageNum - 1);
$end = 100 * ($pageNum - 1) + 99;
if ($end >= $num) {
    $end = $num - 1;
}
?>
<script>


</script>
<div class="pageNav">
    <div class="centerbox">
        <div class="discription">共计
            <?php echo $num; ?>张图片,当前
        </div>
        <form method="post">
            <input type="number" name="pageNum" id="page" min="1" max="<?php echo ceil($num / 100); ?>"
                placeholder="<?php echo $pageNum; ?>" required="required" onmousewheel="return false;" />

            <button type="submit" id="submit">/
                <?php echo ceil($num / 100); ?>页
            </button>
        </form>
    </div>
</div>

<script>
    const input = document.getElementById("page");
    input.addEventListener("wheel", function (event) {
        event.preventDefault();
    });
    $(document).ready(function () {
        $("#submit").hover(function () {
            $("#submit").html("转到");
        }, function () {
            $("#submit").html("/<?php echo ceil($num / 100); ?>页");
        });

    });

</script>
<br>
<div
    class="page-wrap archive-page <?php if ($this->options->bcool_animate !== "close" || !empty($this->options->bcool_animate)): ?>animate__animated animate__<?php $this->options->bcool_animate() ?><?php endif; ?>">


    <div class="archive-body">
        <div class="wrap">
            <div class="wrap_float grid">
                <div class="portfolio">

                    <?php for ($i = $begin; $i <= $end; $i++): ?>
                        <div class="portfolio-item p-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="content">
                                <div class="thumb clearbg">
                                    <img class="lazy" src="<?php $this->options->themeUrl('./assets/img/loading.gif'); ?>"
                                        data-src="<?php echo $thumbs[$i]; ?>"
                                        error-src="<?php $this->options->themeUrl('./assets/img/404.jpg'); ?>" alt="" />
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>

                </div>

            </div>
        </div>
    </div>

    <style>
        .over {
            background-color: rgba(255, 255, 255, 0.88);
            opacity: 1;
            filter: alpha(opacity=100);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            overflow: auto;
            display: flex;
            justify-content: center;
        }

        .overimg {
            position: absolute;
            z-index: 11;
            width: auto;
            height: 100%;
        }

        .leftarrow,
        .rightarrow {
            position: fixed;
            width: 40px;
            height: 30px;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            text-align: center;
            line-height: 30px;
            font-size: 20px;
            color: #fff;
            z-index: 12;
            top: 50%;
            user-select: none;
        }

        .leftarrow {
            left: 5%;
        }

        .rightarrow {
            right: 5%;
        }

        .close {
            position: fixed;
            width: 40px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            user-select: none;
            border-radius: 15px;
            top: 10%;
            right: 5%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 12;
            color: #fff;
        }
    </style>
    <script>
        function addExpand() {
            var imgs = document.getElementsByClassName("content");
            imgs[0].focus();
            for (var i = 0; i < imgs.length; i++) {
                imgs[i].addEventListener('click', expandPhoto);
                imgs[i].addEventListener('keydown', expandPhoto);
                imgs[i].getElementsByTagName('img')[0].setAttribute("index", i);
            }
        }
        function expandPhoto() {
            // console.log('点击了');
            var imgs = document.getElementsByClassName("content");
            var maxlen = imgs.length;
            var overlay = document.createElement("div");
            overlay.setAttribute("id", "over");
            overlay.setAttribute("class", "over");
            document.body.appendChild(overlay);

            var img = document.createElement("img");
            img.setAttribute("id", "expand");
            img.setAttribute("class", "overimg");
            // img.setAttribute("src","https://www.fengdaxian.x…r/assets/img/loading.gif")
            var tureimg = this.getElementsByTagName('img')[0];

            img.src = tureimg.getAttribute("src");
            overlay.appendChild(img);

            // function loadImage(url, callback) {
            //     var img = new Image();
            //     img.src = url;
            //     img.onload = function () { //图片下载完毕时异步调用callback函数。 
            //         callback.call(img); // 将callback函数this指针切换为img。 
            //     };
            // }

            var flag = 1;
            img.ondblclick=function(e){
                console.log(e);
                var x = window.innerWidth/2-e.clientX;
                var y = window.innerHeight/2-e.clientY;
                if (flag==1){
                    img.style.transform="scale(2) translateX("+x+"px)"
                    img.style.top = 2*y+"px";
                    // img.style.height=window.innerHeight*2+"px";
                    flag=0;
                }else{
                    img.style.transform="";
                    img.style.top="0px";
                    img.style.height="100%";
                    flag=1;
                }
            }

            var left = document.createElement("div");
            left.setAttribute("id", "leftarrow");
            left.setAttribute("class", "leftarrow");
            left.innerHTML = "<<"
            document.body.appendChild(left);
            var index = tureimg.getAttribute('index');
            left.onclick = function () {
                // console.log(index);
                var imgs = document.getElementsByClassName("content");
                // console.log(tureimg.getAttribute('index'));
                if (index > 0) {
                    --index;
                    img.src = "https://www.fengdaxian.xyz/usr/themes/gleaner/assets/img/picload.gif";
                    var tempimg = new Image();
                    tempimg.src = imgs[index].getElementsByTagName('img')[0].getAttribute('data-src');
                    console.log(tempimg);
                    tempimg.onload = function () { //图片下载完毕时异步调用callback函数。 
                        img.setAttribute("src", imgs[index].getElementsByTagName('img')[0].getAttribute('data-src'));
                    };
                    // img.src = imgs[index].getElementsByTagName('img')[0].getAttribute('data-src');
                } else {
                    alert("到顶了，别点了");
                }
            };
            var right = document.createElement("div");
            right.setAttribute("id", "rightarrow");
            right.setAttribute("class", "rightarrow");
            right.innerHTML = ">>"
            document.body.appendChild(right);
            right.onclick = function () {
                var imgs = document.getElementsByClassName("content");
                // console.log(tureimg.getAttribute('index'));
                if (index < maxlen - 1) {
                    ++index;
                    img.src = "https://www.fengdaxian.xyz/usr/themes/gleaner/assets/img/picload.gif";
                    var tempimg = new Image();
                    tempimg.src = imgs[index].getElementsByTagName('img')[0].getAttribute('data-src');
                    console.log(tempimg);
                    tempimg.onload = function () { //图片下载完毕时异步调用callback函数。 
                        img.setAttribute("src", imgs[index].getElementsByTagName('img')[0].getAttribute('data-src'));
                    };
                    
                    // img.src = imgs[index].getElementsByTagName('img')[0].getAttribute('data-src');
                } else {
                    alert("到底了，别点了");
                }
            };

            var close = document.createElement("div");
            close.setAttribute("class", "close");
            close.setAttribute("id", "close");
            close.innerHTML = "X";
            document.body.appendChild(close);
            close.onclick = restore;
            // overlay.onclick = restore;

        }
        function restore() {
            document.body.removeChild(document.getElementById("over"));
            document.body.removeChild(document.getElementById("leftarrow"));
            document.body.removeChild(document.getElementById("rightarrow"));
            document.body.removeChild(document.getElementById("close"));
        }
        // window.onload = addExpand;
        // window.addEventListener('load', addExpand);
        addExpand();
    </script>

    <script>
        function post(URL, PARAMS) {
            var temp = document.createElement("form");
            temp.action = URL;
            temp.method = "post";
            temp.style.display = "none";
            for (var x in PARAMS) {
                var opt = document.createElement("textarea");
                opt.name = x;
                opt.value = PARAMS[x];
                // alert(opt.name)
                temp.appendChild(opt);
            }
            document.body.appendChild(temp);
            temp.submit();
            return temp;
        }
    </script>
    <script>
        $(document).ready(function () {
            $("#prevPage").click(function () {
                if (<?php echo $pageNum ?> > 1) {
                    post("", { "pageNum":<?php echo $pageNum - 1; ?>})
                }
            });
        });
        $(document).ready(function () {

            $("#nextPage").click(function () {
                if (<?php echo $pageNum ?> < <?php echo ceil($num / 100) ?>) {
                    post("", { "pageNum":<?php echo $pageNum + 1; ?>})
                }
            });
        });
    </script>
    <div class="pages-controls">


        <div id="prevPage" class="pages-controls-item prev-article">
            <div class="pages-controls-item-wrapper">
                <div class="control-direction"><i class="fa-solid fa-arrow-left fa-lg"></i> 上一页</div>
                <h3 class="post-title">
                    <?php if ($pageNum == 1): ?>没有了~
                    <?php else: ?>第
                        <?php echo $pageNum - 1; ?>页
                    <?php endif; ?>
                </h3>
            </div>
        </div>

        <div class="pages-controls-item next-article" id="nextPage">
            <div class="pages-controls-item-wrapper">
                <div class="control-direction">下一页 <i class="fa-solid fa-arrow-right fa-lg"></i></div>
                <h3 class="post-title">
                    <?php if ($pageNum == ceil($num / 100)): ?>没有了~
                    <?php else: ?>第
                        <?php echo $pageNum + 1; ?>页
                    <?php endif; ?>
                </h3>
            </div>
        </div>

    </div>
    <!-- <div id="test" style="height:70px;padding:30px 10px;font-size: 300%;"></div> -->
    <!-- <div id="div1"></div> -->
    <!-- <div class="pageNav" id="pageNav"></div> -->
    <?php $this->need('footer.php'); ?>