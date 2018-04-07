<?php
session_start();
if (!$_SESSION['logado']):
    session_destroy();
    header('Location: view.login');
endif;
?>
<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<!-- Wrapper for slides -->
<div class="col-md-10 modals">
    <br>
    <h2 style="color: red;">Academia Performance Fit</h2>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="http://localhost/academia/Views/img/01.jpg" style="width:100%;">
            </div>
            
            <div class="item">
                <img src="http://localhost/academia/Views/img/03.jpg" style="width:100%;">
            </div>

            <div class="item">
                <img src="http://localhost/academia/Views/img/09.jpg" style="width:100%;">
            </div>

            <div class="item">
                <img src="http://localhost/academia/Views/img/10.jpg" style="width:100%;">
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>