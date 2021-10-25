<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?= site_url()?>"><img src="<?= site_url()?>assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">القائمة الرئيسية</li>

                <li class="sidebar-item active ">
                    <a href="<?= site_url()?>" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span> الرئيسية </span>
                    </a>
                </li>
                <li class="sidebar-item  " id="profile">
                    <a href="<?= site_url()?>profile" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>الملف الشخصي</span>
                    </a>
                </li>
                <li class="sidebar-item  " id="config">
                    <a href="<?= site_url()?>config" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>اعدادات الموقع</span>
                    </a>
                </li>
                <li class="sidebar-item " id="card">
                    <a href="<?= site_url()?>card" class='sidebar-link'>
                        <i class="bi bi-credit-card-2-front"></i>
                        <span> البطاقات الالكترونية </span>
                    </a>
                </li>
                <li class="sidebar-item " id="agent">
                    <a href="<?= site_url()?>agent" class='sidebar-link'>
                        <i class="bi bi-briefcase"></i>
                        <span> الوكلاء </span>
                    </a>
                </li>
                <li class="sidebar-item " id="cart">
                    <a href="<?= site_url()?>cart" class='sidebar-link'>
                        <i class="bi bi-cart2"></i>
                        <span> طلبات الشراء </span>
                    </a>
                </li>
                <li class="sidebar-item " id="wallet">
                    <a href="<?= site_url()?>wallet" class='sidebar-link'>
                        <i class="bi bi-wallet"></i>
                        <span>المحفظة</span>
                    </a>
                </li>
                <li class="sidebar-item " id="chat">
                    <a href="<?= site_url()?>chat" class='sidebar-link'>
                        <i class="bi bi-chat-square-text"></i>
                        <span>المراسلات</span>
                    </a>
                </li>
                <li class="sidebar-item " id="report">
                    <a href="<?= site_url()?>report" class='sidebar-link'>
                        <i class="bi bi-clipboard-data"></i>
                        <span>تقارير واحصائيات</span>
                    </a>
                </li>
                <li class="sidebar-item " id="notifications">
                    <a href="<?= site_url()?>notifications" class='sidebar-link'>
                        <i class="bi bi-bell"></i>
                        <span>الاشعارات</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#!" onclick="logout()" class='sidebar-link'>
                        <i class="bi bi-door-open"></i>
                        <span>تسجيل خروج</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

<script> 
    var sidebarItem = "<?=$this->uri->segment(1); ?>";
    if(sidebarItem != ""){
        $(".sidebar-item").removeClass("active");
        $("#"+sidebarItem).addClass("active"); 
    }
</script>