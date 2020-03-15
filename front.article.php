<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recommend Articles</title>
    <meta name="description" content="Core HTML Project">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="/static/js/article.js"></script>
    <link href="/static/css/main.css" rel="stylesheet">
    <link href="/static/css/bootstrap2.min.css" rel="stylesheet">
    <style>
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

</head>
<body  class="static-layout">
<div class="boxed-page">
    <div class="dg" onclick="window.history.back()">
        &lt;&lt;
    </div>
    <section id="gtco-section-featurettes" class="abcAAA">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="title-wrap">
                            <h2 class="section-title">
                                <b>Personalized Recommendation: Three Articles Value For You...</b>
                            </h2>
                        </div>
                        <?php for ($i = 0; $i < 3; $i++) { ?>
                        <div class="text-left" style="padding-left: 10%;padding-right: 10%">
                                <div class="my-5">
                                    <span class="lnr lnr-camera fs-40 col or-primary"></span>
                                </div>
                                <h4 class="mb-4" style="align-content: center">
                                    <span id="ti_<?=$i?>">Title</span>
                                    <button class="btn btn-default" onclick="$('#co_<?=$i?>').toggle(400)">>></button>
                                </h4>
                                <p id="co_<?=$i?>">
                                    Content
                                </p>
                        </div>
                        <?php } ?>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section id="gtco-blog" class="abcAAA">
        <div class="container">
            <div class="section-content">
                <div class="title-wrap mb-5">
                    <h2 class="section-title">Recommended Words In The Articles Above ,Try to Learn them!</h2>
                    <p onclick="a1ert()">What does the red number mean? </p>
                </div>
                <div class="row">
                    <div class="col-md-12 blog-holder">
                        <div id="needwords" class="row">



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



</body>
</html>
