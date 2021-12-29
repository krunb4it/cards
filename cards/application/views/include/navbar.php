<nav class="navbar navbar-expand navbar-light ">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler d-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link dropdown-toggle dropdown-inbox" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                        <span class="alert-dot"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">البريد</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">No new mail</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-3">
                    <?php 
                        $dropdown_order = "";
                        $order = get_new_order();
                        if(!empty($order)){
                            $dropdown_order = "dropdown-order new-alert";
                        }
                    ?>
                    <a class="nav-link dropdown-toggle <?= $dropdown_order?>" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                        <span class="alert-dot"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">الطلبات (<?= count($order)?>) </h6>
                        </li>
                        <?php 
                        if(!empty($order)){
                        foreach($order as $o){
                        ?>
                        <li>
                            <a href="<?= site_url()?>order/view_order/<?= $o->order_id?>" class="dropdown-item">
                                <div class="avatar bg-primary me-2">
                                    <span class="avatar-content"><i class="iconly-boldProfile"></i></span>
                                </div>
                                هناك طلب جديد رقم (<?= $o->order_id?>)
                            </a>
                            </li>
                        <?php }
                        } else {?>
                        <li><a class="dropdown-item">لا يوجد طلبات جديدة</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600"><?= $this->session->userdata("user_name")?></h6>
                            <p class="mb-0 text-sm text-gray-600">Administrator</p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="<?= site_url().$this->session->userdata("user_pic")?>">
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <h6 class="dropdown-header">مرحبا بك</h6>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= site_url()?>profile">
                            <i class="icon-mid bi bi-person me-2"></i> حسابي
                        </a>
                    </li>
                    <hr class="dropdown-divider"> 
                    <li>
                        <a class="dropdown-item" onclick="logout()" href="#">
                            <i class="icon-mid bi bi-box-arrow-left me-2"></i> تسجيل خروج
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>