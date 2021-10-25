<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>بيانات التواصل</h3>
					<p class="text-subtitle text-muted">اعدادات بيانات التواصل </p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active" aria-current="page">اعدادات بيانات التواصل</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>config/update_contact" class="form form-horizontal needs-validation" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">اعدادات بيانات التواصل</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col-md-3">
												<label>البريد الالكتروني</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="email" class="form-control form-control-lg" name="email" value="<?= $view->email?>"> 
											</div> 
										</div>
										<div class="row">
											<div class="col-md-3">
												<label>رقم الجوال</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="tel" class="form-control form-control-lg" name="jawwal" value="<?= $view->jawwal?>"> 
											</div> 
										</div>
										<div class="row">
											<div class="col-md-3">
												<label>رقم الهاتف</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="tel" class="form-control form-control-lg" name="phone" value="<?= $view->phone?>"> 
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
	$("form").on("submit", function(e){
		var form = $(this);
		e.preventDefault();
		if (form[0].checkValidity() === false) {
			e.stopPropagation();
		} else {
			$(".btn-submit .spinner-border").toggleClass("d-none");
			form.addClass("disabled");
			setTimeout( function(){
				$.ajax({
					type: "post",
					dataType: "html",
					url: form.attr("action"),
					data: form.serialize(),
					success: function(res){ 
						var res = JSON.parse(res); 
						runToastify(res.res);
					},
					error: function(){ 
					}
				});
				$(".btn-submit .spinner-border").toggleClass("d-none");
				form.removeClass("disabled");
			}, 3000);
		}
	});
</script> 