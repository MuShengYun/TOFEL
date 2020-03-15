<?php
//$title = 'Welcome';
//include 'front.header.php';
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Newsitems</title>

    <!-- Icons  -->
   <link href="/static/vendor/nucleo/css/nucleo.css" rel="stylesheet">

    <!-- Argon CSS -->
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link type="text/css" href="/static/css/argon.min.css?v=1.0.0" rel="stylesheet">
    <link href="/static/css/main.css" rel="stylesheet">
	<script src="/static/js/main.js"></script>
    <script>var my_uid = <?=intval($uid)?>;
    var newscate = "<?=addslashes($_REQUEST['class'])?>";
    </script>
    <script src="/static/js/recommend.js"></script>
</head>

<style>
    .btn-show {
        padding: 5px;
        font-size: 200%;
        background: black;
        color: white;
        border: 0;
    }
    .dg {
        z-index: 9999;
        position: fixed ! important;
        right: 10px;
        top: 10px;
        border-radius: 2px;
        background-color: black;
        width: 32px;
        height: 32px;
        color: white
    }
</style>


<div class="dg" onclick="window.history.back()">
    &lt;&lt;
</div>


    <div class="position-relative  mainform1 ur"  >



        <section class="section section-components">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Tabs with icons -->
                        <div class="mb-3">
                            <h5 class="text-info text-uppercase font-weight-bold">One latest news of this topic</h5>
                        </div>
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a id="newsTitle" style="font-size:1.45em" class="tit nav-link mb-sm-3 mb-md-0" data-toggle="tab" href="#" role="tab"
                                       aria-controls="tabs-icons-text-3" aria-selected="false"><i class="ni ni-calendar-grid-58 mr-2"></i>Sorry! </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div id="newsCon" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                        <p class="description" align="center"><img src="/static/img/loading.gif" width="300" height="240"  /></p>
                                        <p class="description">No Article in this Page. </p>
                                        <p class="description">You can <a href="javascript:void(0)" onclick="window.history.back()">Go Back</a> and try other categories. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="h4 text-success font-weight-bold mb-4">You can refer to</h3>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-inner--text"><a href="https://www.washingtonpost.com/" style="color:white;font-size: 20px">华盛顿邮报 </a></span>

                </div>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
                    <span class="alert-inner--text"><a href="https://www.thetimes.co.uk/" style="color:white;font-size: 20px">泰晤士报 </a></span>

                </div>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-bell-55"></i></span>
                    <span class="alert-inner--text"><a href="https://edition.cnn.com/" style="color:white;font-size: 20px">CNN </a></span>

                </div>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-inner--icon"><i class="ni ni-support-16"></i></span>
                    <span class="alert-inner--text"><a href="https://www.newsweek.com/" style="color:white;font-size: 20px">华尔街日报 </a></span>

                </div>
                <h3 class="h4 text-success font-weight-bold mb-4"></h3>

        </section>
    </div>








