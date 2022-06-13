<header class="header bg-body">
    <nav class="navbar flex-nowrap p-0">
        <div class="navbar-brand-wrapper d-flex align-items-center col-auto">
            <!-- Logo For Mobile View -->
            <a class="navbar-brand navbar-brand-mobile" href="admin.php">
                <img class="img-fluid w-100" src="public/img/logo-mini.png" alt="Graindashboard">
            </a>
            <!-- End Logo For Mobile View -->

            <!-- Logo For Desktop View -->
            <a class="navbar-brand navbar-brand-desktop" href="admin.php">
                <span class="mr-md-2 side-nav-show-on-closed"  style="width: auto; height: 33px;">LNB</span>
                <span class="mr-md-2 side-nav-hide-on-closed"  style="width: auto; height: 33px;">LuNiBo</span>
                <!-- <p class="side-nav-hide-on-closed">TaxiStern</p> -->
            </a>
            <!-- End Logo For Desktop View -->
        </div>

        <div class="header-content col px-md-3">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Side Nav Toggle -->
                <a  class="js-side-nav header-invoker d-flex mr-md-2" href="#"
                    data-close-invoker="#sidebarClose"
                    data-target="#sidebar"
                    data-target-wrapper="body">
                    <i class="gd-align-left"></i>
                </a>
                <div class="dropdown mx-3 dropdown ml-2">
                    <a id="profileMenuInvoker" class="header-complex-invoker" href="#" aria-controls="profileMenu" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#profileMenu" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                        <!-- img class="avatar rounded-circle mr-md-2" src="#" alt="John Doe" -->
                        <span class="mr-md-2 avatar-placeholder border"><?php echo substr($user['name'], 0, 1); ?></span>
                        <span class="d-none d-md-block"><?php echo $user['name']." ".$user['lastname']; ?></span>
                        <i class="gd-angle-down d-none d-md-block ml-2"></i>
                    </a>

                    <ul id="profileMenu" class="unfold unfold-user unfold-light unfold-top unfold-centered position-absolute pt-2 pb-1 mt-4 unfold-css-animation unfold-hidden fadeOut" aria-labelledby="profileMenuInvoker" style="animation-duration: 300ms;">
                    <li class="unfold-item">
                            <a class="unfold-link d-flex align-items-center text-nowrap" href="login.php?logout=1">
                                <span class="unfold-item-icon mr-3">
                                    <i class="gd-power-off"></i>
                                </span>
                                Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End User Avatar -->
            </div>
        </div>
    </nav>
</header>
<main class="main">
    <!-- Sidebar Nav -->
    <aside id="sidebar" class="js-custom-scroll side-nav">
        <ul id="sideNav" class="side-nav-menu side-nav-menu-top-level mb-0">
            <!-- Title -->
            <li class="sidebar-heading h6">Hauptmenü</li>
            <!-- End Title -->

            <!-- Dashboard -->
            <li class="side-nav-menu-item <?php echo isActive("reservationen"); ?>">
                <a class="side-nav-menu-link media align-items-center" href="admin.php?page=reservationen">
              <span class="side-nav-menu-icon d-flex mr-3">
                <i class="gd-bookmark-alt"></i>
              </span>
                    <span class="side-nav-fadeout-on-closed media-body">Reservationen</span>
                </a>
            </li>
            <li class="side-nav-menu-item <?php echo isActive("menu"); ?>">
                <a class="side-nav-menu-link media align-items-center" href="admin.php?page=menu">
              <span class="side-nav-menu-icon d-flex mr-3">
                <i class="gd-agenda"></i>
              </span>
                    <span class="side-nav-fadeout-on-closed media-body">Menu</span>
                </a>
            </li>
            

        </ul>
    </aside>
    <!-- End Sidebar Nav -->
