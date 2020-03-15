<?php
$title = 'Welcome';
include 'front.header.php';
?>
<!--<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,200,100,300,500,600,800,900' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,700italic,900,400italic,300italic' rel='stylesheet' type='text/css'>-->
<link rel="stylesheet" href="/static/css/usermain.css">
<script type="text/javascript" src="/static/js/jquery.sticky.js"></script>
<script type="text/javascript" src="/static/js/usermain.js"></script>
<script type="text/javascript" src="/static/js/zturn.js"></script>
<script>
    $(window).load(function(){
        $("#menu").sticky({ topSpacing: 0 });
    });
</script>
<html>
<head>
<script>
window.onload = loads();
</script>


</head>


<body>
<div class="mainform ur">
	<!--<div class="col-md-12">
        <div class="btn-group btn-group-justified">
            <a href="javascript:void(0)" class="btn btn-primary" onclick='_locate("/status")'>My Status</a>
            <a href="javascript:void(0)" class="btn btn-primary" onclick='_locate("/list")'>Wordlist</a>
            <a href="javascript:void(0)" class="btn btn-primary" onclick='_locate("/user/<?=$uid?>")'>My Home</a>
        </div>
    </div>-->

	<div class="container">
        <h5>导航栏中有更多功能。</h5>
		<h3>Latest News From CNN ：Click the picture for more</h3>
		<div id="mdl1" class="mdl col-md-12" style="background: rgba(120,120,120,0.5)">
			<div class="col-md-5">
				<p class="xxgy" id="toph1">Loading</p>
				<p class="say" id="topp1" style="text-indent:25px">Loading</p>
			</div>
			<div class="col-md-7">
				<img id="i1" src="/static/img/loading.gif" width="100%" style="border-radius:14px;">
			</div>
		</div>
		<div id="mdl3" class="mdl col-md-12" style="margin:0 auto;text-align: center;background: rgba(120,120,120,0.5)" >
            <p>
               <button class="btn btn-default" type="submit" onclick="nowmdl = 0; pbar = 1; swapslide();">1</button>
               <button class="btn btn-default" type="submit" onclick="nowmdl = 1; pbar = 1; swapslide();">2</button>
               <button class="btn btn-default" type="submit" onclick="nowmdl = 2; pbar = 1; swapslide();">3</button>
               <button class="btn btn-default" type="submit" onclick="nowmdl = 3; pbar = 1; swapslide();">4</button>
               <button class="btn btn-default" type="submit" onclick="nowmdl = 4; pbar = 1; swapslide();">5</button>
            </p>
            <div class="progress progress-striped active" style="height: 5px" >
                <div id="pbar" class="progress-bar progress-bar-warning" role="progressbar"
                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                     style="width: 100%; height: 5px">
                    <span class="sr-only">....</span>
                </div>
            </div>
        </div>
	</div>


    <div class="galleryAA" id="gallery">
        <div class="containerAA">
            <h2 style="font-size:40px;color: #fec04e;font-family: 微软雅黑;padding-top: 20px;padding-left: 20px">Nine Topics</h2>

            <div class="rowAB">

                <div class="gridAA col-md-4DD">
                            <figure class="effect-BeautyAA">
                                <a href="javascript:void(0)" onclick="_locate('/recommend/经济')" >
                                    <img src="/static/images/经济.jpg" alt="test">
                                    <figcaption>
                                        <h2 class="topictit">Economics</h2>
                                        <p class="topiccon" style="text-align:center">The economic basis determine superstructure.</p>
                                    </figcaption>
                                </a>
                            </figure>
                        </div>
                <div class="gridAA col-md-4DD  ">
                        <figure class="effect-BeautyAA">
                            <a href="javascript:void(0)" onclick="_locate('/recommend/考古')" >
                                <img src="/static/images/考古.jpg" alt="test">
                                <figcaption>
                                    <h2 class="topictit">Archaeology</h2>
                                    <p class="topiccon" style="text-align:center">History is soaked in blood and tears between the lines, while archaeology is a trials and hardships in walking</p>
                                </figcaption>
                            </a>
                        </figure>
                    </div>
                <div class="gridAA col-md-4DD  ">
                        <figure class="effect-BeautyAA">
                            <a href="javascript:void(0)" onclick="_locate('/recommend/科技')" >
                                <img src="/static/images/科技.png" alt="test">
                                <figcaption>
                                    <h2 class="topictit">Technology</h2>
                                    <p class="topiccon" style="text-align:center">Technology without traditional art has no soul, and art without modern technology has no future.</p>
                                </figcaption>
                            </a>
                        </figure>
                    </div>

                <div class="gridAA col-md-4DD  ">
                    <figure class="effect-BeautyAA">
                        <a href="javascript:void(0)" onclick="_locate('/recommend/社会')" >
                            <img src="/static/images/社会.jpg" alt="test">
                            <figcaption>
                                <h2 class="topictit">Society</h2>
                                <p class="topiccon" style="text-align:center">A society that does not pursue the truth is necessarily a depraved society.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
                <div class="gridAA col-md-4DD  ">
                    <figure class="effect-BeautyAA">
                        <a href="javascript:void(0)" onclick="_locate('/recommend/体育')" >
                            <img src="/static/images/体育.jpg" alt="test">
                            <figcaption>
                                <h2 class="topictit">Sports</h2>
                                <p class="topiccon" style="text-align:center">Life is like riding a bicycle. To keep your balance you must keep moving.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
                <div class="gridAA col-md-4DD  ">
                    <figure class="effect-BeautyAA">
                        <a href="javascript:void(0)" onclick="_locate('/recommend/医学健康')" >
                            <img src="/static/images/医学健康.jpg" alt="test">
                            <figcaption>
                                <h2 class="topictit">Healthy</h2>
                                <p class="topiccon" style="text-align:center">A healthy body is the living room of the soul; a sick body is the prison of the soul.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>

                <div class="gridAA col-md-4DD  ">
                    <figure class="effect-BeautyAA">
                        <a href="javascript:void(0)" onclick="_locate('/recommend/政治')" >
                            <img src="/static/images/政治.jpg" alt="test">
                            <figcaption>
                                <h2 class="topictit">Politics</h2>
                                <p class="topiccon" style="text-align:center">Politics is full of drama, comedy is full of politics.</p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
                <div class="gridAA col-md-4DD  ">
                    <figure class="effect-BeautyAA">
                        <a href="javascript:void(0)" onclick="_locate('/recommend/自然')" >
                            <img src="/static/images/自然.jpg" alt="test">
                            <figcaption>
                                <h2 class="topictit">Nature</h2>
                                <p class="topiccon" style="text-align:center">Nature came before man, but man came before science.
                                </p>
                            </figcaption>
                        </a>
                    </figure>
                </div>
                <div class="gridAA col-md-4DD  ">
                    <figure class="effect-BeautyAA">
                        <a href="javascript:void(0)" onclick="_locate('/recommend/宗教')" >
                            <img src="/static/images/社会.jpg" alt="test">
                            <figcaption>
                                <h2 class="topictit">Religion</h2>
                                <p class="topiccon" style="text-align:center">The deepest misconception in religion is that bad people don't have religion.
                                </p>
                            </figcaption>
                        </a>
                    </figure>
                </div>














            </div>
        </div>
    </div>




</div>
    <!--<script src="/static/js/typed.js" type="text/javascript"></script>-->
    

</body>
</html>

