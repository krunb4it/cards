	<nav class="navbar navbar-light">
		<div class="container d-block">
			<div class="d-flex justify-content-between align-items-center">
				<a class="navbar-brand ms-4" href="<?= site_url()?>">
					<img src="<?= site_url()?>assets/images/logo/logo.png">
				</a> 
				 
				<ul class="nav mb-2 mb-md-0">
					<li class="nav-item dropdown me-1">
						<a class=" dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							<i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
							<li>
								<h6 class="dropdown-header">البريد</h6>
							</li>
							<li><a class="dropdown-item" href="#">No new mail</a></li>
						</ul>
					</li>
					<li class="nav-item dropdown me-1">
						<a class=" dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							<i class='bi bi-bell fs-4 text-gray-600'></i>
							<span class="badge rounded-pill bg-danger">4</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
							<li>
								<h6 class="dropdown-header">الاشعارات</h6>
							</li>
							<li><a class="dropdown-item">No notification available</a></li>
						</ul>
					</li>
					<li class="nav-item me-3">
						<a href="<?= site_url()?>/viewCart">
							<i class='bi bi-cart2 fs-4 text-gray-600'></i>
							<?php if(count($this->cart->contents()) > 0) $class = ""; else $class = "d-none"; ?>
							<span class="badge rounded-pill bg-success badge-cart <?= $class?>"><?= count($this->cart->contents())?></span> 
						</a>
					</li>
				</ul>
				
				<?php /*
				<div class="dropdown ">
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
							<a class="dropdown-item" href="#">
								<i class="icon-mid bi bi-person me-2"></i> حسابي
							</a>
						</li>
						<li>
							<a class="dropdown-item" href="#">
								<i class="icon-mid bi bi-gear me-2"></i> الاعدادات
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
				*/ ?> 
			</div>
		</div>
	</nav>