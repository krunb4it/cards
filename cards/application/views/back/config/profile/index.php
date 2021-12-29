<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>مرحبا <?= $this->session->userdata("user_name")?></h3>
					<p class="text-subtitle text-muted">اهلا وسهلا بك في صفحتك الشخصية</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active">الصفحة الشخصية</li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading">  
			<div class="row"> 
				<div class="col-lg-6"> 
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">بياناتي</h4>
							<p ><strong> عند تغيير البريد الالكتروني سيتم الخروج من النظام وارسال بريد الكتروني للتحقق من صحة البريد المستبدل</strong></p>
						
						</div>
						<form id="form" method="post" action="<?= site_url()?>config/update_profile" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="user_id" value="<?= $this->session->userdata("user_id")?>"> 
						
						<div class="card-content">
							<div class="card-body">
								<div class="form-body">
									<div class="row mb-4">
										<div class="col-md-3">
											<label>الصورة الشخصية</label>
										</div> 
										<div class="col-md-4">
											<div class="upload-pic-box">
												<label for="profile_pic" class="view-pic">
													<img src="<?= site_url().$this->session->userdata("user_pic")?>" class="img-fluid rounded preview-pic" width="150">
												</label>
												<input type="file" class="form-control d-none upload-pic" id="profile_pic" name="user_pic" id="formFile">
												<div class="invalid-feedback">مطلوب</div> 
												<input type="hidden" class="form-control" name="last_user_pic" value="<?= $this->session->userdata("user_pic")?>">
											</div>
										</div>
									</div> 
									
									<div class="row"> 
										<div class="col-md-3">
											<label>اسم المستخدم</label>
										</div>
										<div class="col-md-9 form-group">
											<input type="text" class="form-control form-control-lg" name="user_name" readonly value="<?= $this->session->userdata("user_name")?>">
										</div>  
									</div>
									<div class="row"> 
										<div class="col-md-3">
											<label>المجموعة</label>
										</div>
										<div class="col-md-9 form-group">
											<select name="group_id" class="form-control form-control-lg" required disabled>
												<option value="" disabled> اختر المجموعة</option>
												<?php foreach($admin_group as $ag){?>
												<option value="<?= $ag->admin_group_id?>" <?php if($this->session->userdata("group_id") == $ag->admin_group_id) echo "selected";?>><?= $ag->admin_group_name?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="row"> 
										<div class="col-md-3">
											<label>البريد الالكتروني</label>
										</div>
										<div class="col-md-9 form-group">
											<input type="email" class="form-control form-control-lg" name="email" required value="<?= $this->session->userdata("user_email")?>"> 
										</div>  
									</div>
									<div class="row"> 
										<div class="col-md-3">
											<label>رقم الجوال</label>
										</div>
										<div class="col-md-9 form-group">
											<input type="email" class="form-control form-control-lg" name="jawwal" value="<?= $this->session->userdata("user_jawwal")?>"> 
										</div>  
									</div> 
									
									<hr class="my-3">
									
									<div class="row">
										<div class="col-sm-12 d-flex justify-content-end">
											<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
												<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
											</button> 
										</div> 
									</div>
								</div>
							</div>
						</div> 
						</form>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">كلمة المرور</h4>
							<p class="text-danger"><span class="h6 text-danger">ملاحظة</span><strong> سيتم حظر الحساب بعد ادخال كلمة المرور القديمة 3 مرات خاطئة.</strong></p>
						</div>
						<form id="form" method="post" action="<?= site_url()?>config/update_password" class="form form-horizontal">
						<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
						<input type="hidden" name="user_id" value="<?= $this->session->userdata("user_id")?>"> 
						
						<div class="card-content">
							<div class="card-body">
								<div class="form-body">
									 
									<div class="row">
										<div class="col-md-3">
											<label>كلمة المرور القديمة</label>
										</div>
										<div class="col-md-9 form-group">
											<input type="password" class="form-control form-control-lg" name="password_old" required>
										</div>  
									</div> 
									<div class="row"> 
										<div class="col-md-3">
											<label>كلمة المرور الجديدة</label>
										</div>
										<div class="col-md-9 form-group">
											<input type="password" class="form-control form-control-lg" name="password_new" required> 
										</div>
									</div>
									<div class="row"> 
										<div class="col-md-3">
											<label>تأكيد كلمة المرور الجديدة</label>
										</div>
										<div class="col-md-9 form-group">
											<input type="password" class="form-control form-control-lg" name="password_confirm" required> 
										</div>
									</div>
									
									<hr class="my-3">
									
									<div class="row">
										<div class="col-sm-12 d-flex justify-content-end">
											<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
												<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
											</button> 
										</div> 
									</div>
								</div>
							</div>
						</div> 
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script>
	$('.form').submit(function(e) {  
		var form = $(this);     
		e.preventDefault(); 
		form.find(".btn-submit .spinner-border").toggleClass("d-none");
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
					if(res.status == "error"){
						Swal.fire("خطأ !!", res.res, "error");
					} else {
						runToastify(res.res);
						if( res.link != ""){
							location.href= res.link;
						}
					}
					form.find(".btn-submit .spinner-border").toggleClass("d-none");
					form.removeClass("disabled");
				}, 3000);
			},
			error: function() {  
				Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
			}
		});
    });
</script>