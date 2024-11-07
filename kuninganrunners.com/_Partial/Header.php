<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        <a href="" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo_head.png" alt=""> -->
            <h2 class="sitename text-warning"><?php echo $title_web; ?></h2>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <?php
                    if(empty($_GET['Page'])){
                        echo '<li><a href="#hero" class="active">Beranda</a></li>';
                        echo '<li><a href="#about">Tentang</a></li>';
                        echo '<li><a href="#call-to-action">Kontak</a></li>';
                        echo '<li><a href="#portfolio">Galeri</a></li>';
                        echo '<li><a href="#testimonials">Testimoni</a></li>';
                        echo '<li><a href="#faq">FAQ</a></li>';
                        echo '<li><a href="#product">Merchandise</a></li>';
                    }else{
                        if($_GET['Page']=="Galeri"){
                            echo '<li><a href="index.php">Beranda</a></li>';
                            echo '<li><a href="index.php?Page=Galeri" class="active">Galeri</a></li>';
                        }
                    }
                    //Kondisi Apabila Belum Login
                    echo '<li><a href="index.php?Page=Login">Login</a></li>';
                ?>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>