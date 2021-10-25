<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>اعدادات الموقع</h3>
					<p class="text-subtitle text-muted">اعدادات الموقع الخاصة </p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active" aria-current="page">اعدادات الموقع</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>config/update_setting" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">اعدادات الموقع</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<?php foreach($language as $l){ 
											$short = $l->lang_short?>
										<div class="<?php if($l->lang_active == 0) echo "d-none";?>">
											<h5 class="pb-3"><?= $l->lang_name?></h5>
											<div class="row"> 
												<div class="col-md-3">
													<label>اسم الموقع</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg" name="website_name[<?= $short?>]" required value="<?= json_decode($view->website_name)->$short?>" > 
												</div>
												
												<div class="col-md-3">
													<label>وصف الموقع</label>
												</div>
												<div class="col-md-9 form-group">
													<textarea rows="5" type="text" class="form-control form-control-lg" name="website_description[<?= $short?>]" required> <?= json_decode($view->website_description)->$short?> </textarea>
												</div>
												
												<div class="col-md-3">
													<label>كلمات دليلة</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg tagsinput d-none" name="website_keyword[<?= $short?>]" required value="<?= json_decode($view->website_keyword)->$short?>">
												</div>
												<hr class="my-3">
											</div>
										</div> 
                                        <?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">اعدادات الموقع</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row text-center mb-4">
											<div class="col-md-4">
												<label class="mb-3">ايقونة الموقع</label>
												<input type="file" class="upload-img" name="website_icon" id="website_icon">
												<input type="hidden" name="last_website_icon" value="<?= $view->website_icon?>"> 
											</div> 
											<div class="col-md-4">
												<label class="mb-3">شعار الموقع</label>
												<input type="file" class="upload-img" name="website_logo" id="website_logo">
												<input type="hidden" name="last_website_logo" value="<?= $view->website_logo?>">
											</div> 
											<div class="col-md-4">
												<label class="mb-3">صورة غلاف الموقع</label>
												<input type="file" class="upload-img" name="website_cover" id="website_cover">
												<input type="hidden" name="last_website_cover" value="<?= $view->website_cover?>">
											</div> 
										</div>
										<div class="row">
											<div class="col-md-3">
												<label>Google Analytics</label>
											</div>
											<div class="col-md-9 form-group">
												<textarea rows="5" type="text" class="form-control form-control-lg" name="website_google_code"> <?= $view->website_google_code?> </textarea>
											</div> 
										</div>
										<div class="row">
											<div class="col-md-3">
												<label>IOS Appliction</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="url" class="form-control form-control-lg" name="app_ios_link" value="<?= $view->app_ios_link?>"> 
											</div> 
										</div>
										<div class="row">
											<div class="col-md-3">
												<label>Andorid Appliction</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="url" class="form-control form-control-lg" name="app_andorid_link" value="<?= $view->app_andorid_link?>"> 
											</div> 
										</div>
										<hr class="my-3">
										<div class="row">  
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>config" class="btn btn-light-secondary mb-1"> الغاء</a>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('#form').submit(function(e) {
		var form = $(this);
		e.preventDefault();
		$(".btn-submit .spinner-border").toggleClass("d-none");
		form.addClass("disabled");
		
		$.ajax({
			type: "post", 
			dataType: "html",
			url: form.attr("action"),
			//data: form.serialize(), 
			data:new FormData(this),
			processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(res){
				var res = JSON.parse(res);
				setTimeout( function(){
					runToastify(res.res);
					$(".btn-submit .spinner-border").toggleClass("d-none");
					form.removeClass("disabled");
				}, 3000);
			},
			error: function() {  
				Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
			}
		});
    });
</script> 