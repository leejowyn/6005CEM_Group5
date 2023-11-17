<!-- Page Header-->
<header class="section page-header">
    <!-- RD Navbar-->
    <div class="rd-navbar-wrap">
        <nav class="rd-navbar rd-navbar-wide" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-static" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
                <div class="rd-navbar-main">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                        <!-- RD Navbar Brand-->
                        <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo.png" alt="" width="232" height="67" /><img class="brand-logo-light" src="images/logo-inverse-86x104.png" alt="" width="86" height="104" /></a>
                        </div>
                    </div>
                    <?php
                    // Function to check if the current page matches the given page name
                    function isPageActive($pageName)
                    {
                        $currentPage = basename($_SERVER['PHP_SELF']);
                        return ($currentPage === $pageName) ? 'active' : '';
                    }
                    ?>

                    <div class="rd-navbar-nav-wrap">
                        <!-- RD Navbar Nav-->
                        <ul class="rd-navbar-nav">
                            <li class="rd-nav-item <?php echo isPageActive('index.php'); ?>"><a class="rd-nav-link" href="index.php">Home</a></li>
                            <li class="rd-nav-item <?php echo isPageActive('about-us.php'); ?>"><a class="rd-nav-link" href="about-us.php">About</a></li>
                            <li class="rd-nav-item <?php echo isPageActive('portfolio.php'); ?>"><a class="rd-nav-link" href="portfolio.php">Portfolio</a></li>
                            <li class="rd-nav-item <?php echo isPageActive('appointmentForm.php'); ?>"><a class="rd-nav-link" href="appointmentForm.php">Consultation</a></li>
                            <li class="rd-nav-item <?php echo isPageActive('contacts.php'); ?>"><a class="rd-nav-link" href="contacts.php">Contacts</a></li>
                            <li class="rd-nav-item <?php echo isPageActive('users.php'); ?>"><a class="rd-nav-link" href="users.php">Chat</a></li>
                            <li class="rd-nav-item <?php echo isPageActive('profile.php'); ?>"><a class="rd-nav-link" href="profile.php">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>