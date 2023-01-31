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
    var imgs = document.getElementsByClassName("lazy");
    var maxlen = imgs.length;
    var overlay = document.createElement("div");
    overlay.setAttribute("id", "over");
    overlay.setAttribute("class", "over");
    document.body.appendChild(overlay);
    var img = document.createElement("img");
    img.setAttribute("id", "expand");
    img.setAttribute("class", "overimg");
    var tureimg = this.getElementsByTagName('img')[0];  
    overlay.appendChild(img);
    var flag = 1;
    img.ondblclick=dbexpand;
    var left = document.createElement("div");
    left.setAttribute("id", "leftarrow");
    left.setAttribute("class", "leftarrow");
    left.innerHTML = "<<"
    document.body.appendChild(left);
    var index = tureimg.getAttribute('index');
    load(index);
    left.onclick = function () {
        img.style.transform="";
        img.style.top="0px";
        img.style.height="100%";
        flag=1;
        if (index > 0) {
            --index;
            load(index);
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
        img.style.transform="";
        img.style.top="0px";
        img.style.height="100%";
        flag=1;
        if (index < maxlen - 1) {
            ++index;
            load(index);
        } else {
            alert("到底了，别点了");
        }
    };

    function dbexpand(e){
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

    function load(index){
        imgs = document.body.getElementsByClassName("lazy");
        var tempimg = new Image();
        tempimg.src = imgs[index].getAttribute("data-src");
        img = document.getElementById("expand");
        img.src = "https://www.fengdaxian.xyz/usr/themes/gleaner/assets/img/picload.gif";
        tempimg.onload = function(){
            console.log(tempimg.src);
            img.src=tempimg.src;
        }
    }

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