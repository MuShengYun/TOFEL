<!DOCTYPE html>
<html style="width: 100%;overflow-x: hidden;overflow-y: hidden" ng-app="myApp">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
    <link rel="apple-touch-icon" sizes="114x114" href="/static/icon.jpg">
    <link rel="icon" sizes="114x114" href="/static/icon.jpg">
    <meta name="mobile-web-app-capable" content="yes">
    <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link type="text/css" href="/static/css/argon.min.css?v=1.0.0" rel="stylesheet">
	<script type="text/javascript" src="/static/js/argon.min.js"></script>
	<script type="text/javascript" src="/static/js/main.js"></script>
    <!--<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,200,100,300,500,600,800,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,700italic,900,400italic,300italic' rel='stylesheet' type='text/css'>-->
    <link href="/static/css/main_page.css" rel="stylesheet">
    <script type="text/javascript" src="/static/js/jquery.sticky.js"></script>
    <script>
        $(window).load(function(){
            $("#menu").sticky({ topSpacing: 0 });
        });
    </script>


    <script type="text/javascript" src="/static/js/jquery.sticky.js"></script>
    <script type="text/javascript" src="/static/js/usermain.js"></script>
</head>
<body>
    <div  class="btn11">
        <a href="javascript:void(0)"  class="btn-show" onclick='_locate("/status")'>My Status</a>
        <a href="javascript:void(0)"  class="btn-show" onclick='_locate("/list")'>Wordlist</a>
        <a href="javascript:void(0)"  class="btn-show" onclick='_locate("/user/<?=$uid?>")'>My Home</a>
    </div>

    <div class="position-relative ">

        <div class="position-relative ">
            <section class="section section-lg section-shaped overflow-hidden my-0">
                <div class="shape shape-style-1 shape-default shape-skew">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="container py-0 pb-lg">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-5 mb-5 mb-lg-0">
                            <h1 class="text-white font-weight-light" id="toph1">Red Cross to begin aid to Venezuela by mid-April</h1>
                            <p class="lead text-white mt-4" id="topp1">&quotThe world knows it: this victory is thanks to the mobilization of the people of Venezuela,&quotGuaidó, who has been recognized as interim president by more than 50 nations, including the United States, tweeted shortly after the announcement.</p>
                        </div>
                        <div class="col-lg-6 mb-lg-auto">
                            <div class="rounded shadow-lg overflow-hidden transform-perspective-right">
                                <div id="carousel_example" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel_example" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel_example" data-slide-to="1"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="img-fluid" src="./assets/img/theme/121001.jpg" alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="img-fluid" src="./assets/img/theme/121002.jpg" alt="Second slide">
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev"  id="btn1"  href="#carousel_example" role="button" data-slide="prev" onclick="changeTXT_Title('btn1')">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next"  id="btn2"  href="#carousel_example" role="button" data-slide="next" onclick="changeTXT_Title('btn2')">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <div class="gallery" id="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="alldesc">
                            <div class="col-md-6 col-sm-6 col-xs-12 centertext">
                                <p class="all-td">Our preciously done works</p>
                                <h2>Gallery</h2>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="galleryimg" id="galleryimg">
                            <div class="grid mix category-2 col-md-4 col-sm-6 col-xs-6" data-myorder="1">
                                <figure class="effect-Beauty" href="_apache2.html">
                                    <img src="/static/images/政治.jpg" />
                                    <figcaption  href="_apache2.html">
                                        <h2>Politics</h2>
                                        <p   id="政治"  href="_apache2.html">Politics is full of drama, comedy is full of politics.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-1 col-md-4 col-sm-6 col-xs-6" data-myorder="2">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/经济.jpg" />
                                    <figcaption>
                                        <h2>Economics</h2>
                                        <p>The economic basis determine superstructure.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-1 col-md-4 col-sm-6 col-xs-6" data-myorder="3">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/宗教.jpg" />
                                    <figcaption>
                                        <h2>Religion </h2>
                                        <p>The deepest misconception in religion is that bad people don't have religion.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-2 col-md-4 col-sm-6 col-xs-6" data-myorder="4">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/考古.jpg" />
                                    <figcaption>
                                        <h2>Archaeology</h2>
                                        <p>History is soaked in blood and tears between the lines, while archaeology is a trials and hardships in walking.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-2 col-md-4 col-sm-6 col-xs-6" data-myorder="5">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/体育.jpg" />
                                    <figcaption>
                                        <h2>Sports</h2>
                                        <p>Life is like riding a bicycle. To keep your balance you must keep moving.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-1 col-md-4 col-sm-6 col-xs-6" data-myorder="6">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/医学健康.jpg"/>
                                    <figcaption>
                                        <h2>Healthy</h2>
                                        <p>A healthy body is the living room of the soul; a sick body is the prison of the soul.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-2 col-md-4 col-sm-6 col-xs-6" data-myorder="7">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/自然.jpg" />
                                    <figcaption>
                                        <h2>Nature</h2>
                                        <p>Nature came before man, but man came before science.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-1 col-md-4 col-sm-6 col-xs-6" data-myorder="8">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/科技.png" />
                                    <figcaption>
                                        <h2>Technology</h2>
                                        <p>Technology without traditional art has no soul, and art without modern technology has no future.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="grid mix category-1 col-md-4 col-sm-6 col-xs-6" data-myorder="9">
                                <figure class="effect-Beauty">
                                    <img src="/static/images/社会.jpg" />
                                    <figcaption>
                                        <h2>Society</h2>
                                        <p>A society that does not pursue the truth is necessarily a depraved society.</p>
                                        <a href="#">View more</a>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="notes">
            <div class="container ">
                <div class="row ">
                    <div class="col-md-9 col-sm-10 col-12">
                        <p> 如果你有什么问题，请联系我们*^____^*</p>
                    </div>
                    <div class="col-md-3 col-sm-2 col-xs-12 text-center">
                        <button>Click Me</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
    <script src="/static/js/jquery.mixitup.js" type="text/javascript"></script>
    <script type="text/javascript" src="/static/js/jquery.countTo.js"></script>
    <script type="text/javascript" src="/static/js/jquery.waypoints.min.js"></script>
    <script type="text/javascript" src="/static/js/jquery.quovolver.js"></script>
    <script>
        $(function(){
            var windowH = $(window).height();
            var bannerH = $('#banner').height();
            if(windowH > bannerH) {
                $('#banner').css({'height':($(window).height() - 68)+'px'});
                $('#bannertext').css({'height':($(window).height() - 68)+'px'});
            }
            $(window).resize(function(){
                var windowH = $(window).height();
                var bannerH = $('#banner').height();
                var differenceH = windowH - bannerH;
                var newH = bannerH + differenceH;
                var truecontentH = $('#bannertext').height();
                if(windowH < truecontentH) {
                    $('#banner').css({'height': (newH - 68)+'px'});
                    $('#bannertext').css({'height': (newH - 68)+'px'});
                }
                if(windowH > truecontentH) {
                    $('#banner').css({'height': (newH - 68)+'px'});
                    $('#bannertext').css({'height': (newH - 68)+'px'});
                }

            })
        });





        $(function(){
            $('#galleryimg').mixItUp();
        });
        /*$('.timer').each(count);*/
        jQuery(function ($) {
            // custom formatting example
            $('.timer').data('countToOptions', {
                formatter: function (value, options) {
                    return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
            });

            // start all the timers
            $('#gallery').waypoint(function() {
                $('.timer').each(count);
            });

            function count(options) {
                var $this = $(this);
                options = $.extend({}, options || {}, $this.data('countToOptions') || {});
                $this.countTo(options);
            }
        });


        $('.quotes').quovolver({
            equalHeight   : true
        });


    </script>
    <script>

        $(document).ready(function () {

            $(document).on("scroll", onScroll);



            $('a[href^="#"]').on('click', function (e) {

                e.preventDefault();

                $(document).off("scroll");



                $('a').each(function () {

                    $(this).removeClass('active');

                })

                $(this).addClass('active');



                var target = this.hash;

                $target = $(target);

                $('html, body').stop().animate({

                    'scrollTop': $target.offset().top

                }, 500, 'swing', function () {

                    window.location.hash = target;

                    $(document).on("scroll", onScroll);

                });

            });

        });



        function onScroll(event){

            var scrollPosition = $(document).scrollTop();

            $('.nav li a').each(function () {

                var currentLink = $(this);

                var refElement = $(currentLink.attr("href"));

                if (refElement.position().top <= scrollPosition && refElement.position().top + refElement.height() > scrollPosition) {

                    $('.nav li a').removeClass("active");

                    currentLink.addClass("active");

                }

                else{

                    currentLink.removeClass("active");

                }

            });

        }

    </script>




