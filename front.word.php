<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
    <meta name="description" content="Start your development with a Design System for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Recommend Words</title>
    <link rel="apple-touch-icon" sizes="114x114" href="/static/icon.jpg">
    <link rel="icon" sizes="114x114" href="/static/icon.jpg">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="/static/js/main.js"></script>
    <script src="/static/js/newword.js"></script>
    <link href="/static/css/main.css" rel="stylesheet"></head>
    <style>
        hli {
            text-shadow: 0px 0px 3px #FFEB3B;
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
<body>
<div class="boxed-page">
    <div class="dg" onclick="window.history.back()">
        &lt;&lt;
    </div>
    <main>
        <section class="sectionBB  section-shapedAA my-0AA overflow-hiddenAA">
            <div class="containerAA py-0AA">
                <h3 class="h4 text-successSS font-weight-boldGG mb-4GG">Personalized Recommendation: Recommended Words</h3>
                <?php for ($i = 0; $i < 10; $i++) { ?>
                <div class="rowAB row-grid align-items-center shown_PC">
                    <div class="containerAA">
                        <div class="cardAA bg-gradient-lightSS shadow-lgSS border-0SS">
                            <div class="p-5AA">
                                <div class="rowAB align-items-center">
                                    <div class="col-lg-8AA">
                                        <p id="sent_<?=$i?>" class="leadAA text-whiteAA mt-3A">Loading...</p>
                                    </div>
                                    <div class="col-lg-3AA ml-lg-autoAA">
                                        <button id="recbtn1" class="btnAA btn-lgAA btn-blockAA btn-whiteAA" onclick="$('#recshow<?=$i?>').toggle(200)">查看释义</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div hidden id="recshow<?=$i?>" class="containerAA">
                        <div class="cardAA shadowAA shadow-lg--hoverAA mt-5A">
                            <div class="card-bodySS">
                                <div class="d-flexSS px-3AA">
                                    <div>
                                        <div class="iconAA icon-shapeAA bg-gradient-successAA rounded-circleSS text-whiteAA">
                                            <i class="ni ni-satisfied"></i>
                                        </div>
                                    </div>
                                    <div class="pl-4AA">
                                        <h5 id="word_<?=$i?>" class="text-successAA">Loading...</h5>
                                        <p id="trans_<?=$i?>" class="leadAA  mt-3A">Translation...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
        <section class="sectionBB  section-shapedAA my-0AA overflow-hiddenAA">
            <div class="containerAA">
                <h3 class="h4 text-successSS font-weight-boldGG mb-4GG">5 Recommended New words For You!</h3>
                <?php
                $ar = ["①", '②', '③', '④', '⑤'];
                for ($i = 0; $i < 5; $i++) { ?>
                <div class="cuser alertGG alert-success11 alert-dismissible11 fade11 showGG" role="alert">
                    <span class="alert-inner--textGG" style="color:white;font-size: 20px;font-weight: bolder">
                        <span id="nick_<?=$i?>">word</span>
                    </span>
                    <span aria-hidden="true" class="closeGG"><?=$ar[$i]?></span>
                    <p id="personal_<?=$i?>" class="leadBB text-whiteBB mt-3AGG">info</p>
                </div>
                <?php } ?>
        </section>
    </main>
</div>
</body>

</html>