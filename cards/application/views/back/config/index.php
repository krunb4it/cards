<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>الاعدادات</h3>
					<p class="text-subtitle text-muted">مجموعة الاعدادات الخاصة بالموقع الخاص بك</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item active" aria-current="page">الاعدادات</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<div class="row">
				<div class="col-12 col-lg-3 col-md-6">
					<a href="<?= site_url()?>profile" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">
								<div class="avatar avatar-xl">
									<img src="<?= site_url().$this->session->userdata("user_pic")?>" alt="<?= $this->session->userdata("user_name")?>">
								</div>
								<div class="ms-3 name">
									<h5 class="font-bold"><?= $this->session->userdata("user_name")?></h5> 
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/setting" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon purple">
									<i class="bi bi-gear"></i>
								</div>
								<h6 class="text-muted font-semibold">إعدادت الموقع</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/contact" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon blue">
									<i class="bi bi-telephone"></i>
								</div>
								<h6 class="text-muted font-semibold">بيانات التواصل</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/social_media" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon green">
									<i class="bi bi-twitter"></i>
								</div>
								<h6 class="text-muted font-semibold">التواصل الاجتماعي</h6> 
							</div>
						</div>
					</a>
				</div> 
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/page" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon red">
									<i class="bi bi-files"></i>
								</div>
								<h6 class="text-muted font-semibold">صفحات الموقع</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6 d-none">
					<a href="<?= site_url()?>config/language" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon yellow">
									<i class="bi bi-megaphone"></i>
								</div>
								<h6 class="text-muted font-semibold">لغات الموقع</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/payment_way" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon dark">
									<i class="bi bi-credit-card-2-front"></i>
								</div>
								<h6 class="text-muted font-semibold">قنوات الدفع</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/users" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon purple">
									<i class="bi bi-people"></i>
								</div>
								<h6 class="text-muted font-semibold">المستخدمين</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6 d-none">
					<a href="<?= site_url()?>config/activites" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon  blue">
									<i class="bi bi-exclamation-circle"></i>
								</div>
								<h6 class="text-muted font-semibold">نشاطات المستخدمين</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/slider" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon green">
									<i class="bi bi-image-fill"></i>
								</div>
								<h6 class="text-muted font-semibold">سلايدر الاعلانات</h6> 
							</div>
						</div>
					</a>
				</div>
				<div class="col-6 col-lg-3 col-md-6">
					<a href="<?= site_url()?>config/currency" class="card mb-3">
						<div class="card-body p-4">
							<div class="d-flex align-items-center">  
								<div class="stats-icon red">
									<i class="bi bi-image-fill"></i>
								</div>
								<h6 class="text-muted font-semibold">العملات</h6> 
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>