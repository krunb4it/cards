<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= $view->user_name?></h3>
					<p class="text-subtitle text-muted">عرض بيانات المستخدم</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config/users"> المستخدمين</a></li> 
							<li class="breadcrumb-item active"><?= $view->user_name?> </li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>config/update_user" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="user_id" value="<?= $view->user_id?>"> 
				
				<div class="row"> 
					<div class="col-lg-6"> 
						<div class="card">
							<div class="card-header">
								<h4 class="card-title"><?= $view->user_name?></h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row mb-4">
											<div class="col-md-3">
												<label>صورة المستخدم</label>
											</div> 
											<div class="col-md-9">  
												<img src="<?= site_url().$view->user_pic?>" class="img-fluid rounded" width="150"> 
												<input type="file" class="form-control" name="user_pic" id="formFile"> 
												<input type="hidden" class="form-control" name="last_user_pic" value="<?= $view->user_pic?>"> 
												<small> يرجى ادراج صورة بالابعاد التالية 
													<code dir="ltr" style="direction : ltr">(120px × 120px)</code>
												</small>
											</div>
										</div> 
										
										<div class="row"> 
											<div class="col-md-3">
												<label>اسم المستخدم</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control form-control-lg" name="user_name" required value="<?= $view->user_name?>"> 
											</div>  
										</div> 
										<div class="row"> 
											<div class="col-md-3">
												<label>البريد الالكتروني</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="email" class="form-control form-control-lg" name="email" required value="<?= $view->email?>"> 
											</div>  
										</div>
										<div class="row"> 
											<div class="col-md-3">
												<label>رقم الجوال</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="email" class="form-control form-control-lg" name="jawwal" value="<?= $view->jawwal?>"> 
											</div>  
										</div> 
										<div class="row"> 
											<div class="col-md-3">
												<label>المجموعة</label>
											</div>
											<div class="col-md-9 form-group">
												<select name="group_id" class="form-control form-control-lg" required>
													<option value="" disabled> اختر المجموعة</option>
													<?php foreach($admin_group as $ag){?>
													<option value="<?= $ag->admin_group_id?>" <?php if($view->group_id == $ag->admin_group_id) echo "selected";?>><?= $ag->admin_group_name?></option>
													<?php } ?>
												</select>
											</div>  
										</div>
										
										<hr class="my-3">
										
										<div class="row">  
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>config/users" class="btn btn-light-secondary mb-1"> الغاء</a>
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
					if(res.status == "error"){
						Swal.fire("خطأ !!", res.res, "error");
					} else {
						runToastify(res.res);
					}
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
