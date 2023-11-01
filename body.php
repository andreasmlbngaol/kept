<?php
require "functions.php";
if(isset($_POST['recordSize'])) {
    $height = $_POST['height'];
    $width = $_POST['width'];
    if($width <= $height) {
        echo ("Miringkan HP anda dan Reload halaman");
        die;
    } else {
?>
    <nav class="navbar sticky-top navbar-expand-lg bg-keptblue mb-0">
        <div class="container-fluid">
            <a class="navbar-brand bg-keptskin nav-link rounded color-keptskin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="src/img/logo.png" alt="Logo Kept" id="navbar-brand">
            </a>
            <button class="navbar-toggler bg-keptskin" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav me-auto">
					<!-- <a class="nav-link color-keptskin fw-bold" href="login/">Masuk</a> -->
					<!-- <a class="nav-link color-keptskin fw-bold" href="register/">Daftar</a> -->
					<a class="nav-link color-keptskin fw-bold" href="about/">Tentang</a>
                </div>
			</div>
		</div>
    </nav>
    <div class="home-start d-flex flex-wrap justify-content-center align-items-center">
        <div id="home-container" class=" ms-auto me-auto border rounded-pill pt-5 pb-5 d-flex flex-wrap justify-content-center align-items-center">
            <div id="home-menu-container" class="container text-center justify-content-center mb-4">
                <div id="home-menu-text">
                    <h2 class="home-menu-item"><span id="home-menu-text-motto">Smartly Kept, Wisely Flowed</span></h2>
                    <h1 class="home-menu-item">LET'S TAKE YOUR <br>FLOW TO THE<br> NEXT LEVEL</h1>
                    <p class="home-menu-item">You will have the best experience with thousands of smart individuals worldwide in managing their finances</p>
                </div>
                <!-- <div id="home-menu-img">
                    <img src="src/img/home-mascot.png" alt="Ini Gambar" id="home-img" class="home-menu-item">
                </div> -->
            </div>
            <div class="container text-center pb-5">
                <a href="register/" class="home-menu"><span id="home-register-text">MULAI</span></a>
                <a href="login/" class="home-menu"><span id="home-login-text">MASUK</span></a>
            </div>
        </div>
    </div>
    <script src="src/script/bootstrap.bundle.min.js"></script>
<?php }
} ?>