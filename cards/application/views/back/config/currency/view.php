<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= json_decode($view->currency_name)->ar?></h3>
					<p class="text-subtitle text-muted">اعدادات العملات</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config/currency">اعدادات العملات</a></li>
							<li class="breadcrumb-item active" aria-current="currency">صفحة <?= json_decode($view->currency_name)->ar?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>config/update_currency" class="form form-horizontal needs-validation" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="currency_id" value="<?= $view->currency_id?>"> 
				
				<div class="row"> 
					<div class="col-lg-6"> 
						<div class="card">
							<div class="card-header">
								<h4 class="card-title"><?= json_decode($view->currency_name)->ar?></h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<?php foreach($language as $l){ 
											$short = $l->lang_short;
										?>
										<div class="<?php if($l->lang_active == 0) echo "d-none";?>">
											<h5 class="pb-3"><?= $l->lang_name?></h5>
											<div class="row"> 
												<div class="col-md-3">
													<label>اسم العملة</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg" name="currency_name[<?= $short?>]" required value="<?= json_decode($view->currency_name)->$short?>" > 
												</div>
											</div>
											<div class="row"> 
												<div class="col-md-3">
													<label>اختصار العملة</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg" name="currency_short[<?= $short?>]" required value="<?= json_decode($view->currency_short)->$short?>" > 
												</div>
											</div>
										</div> 
										<hr class="my-3"> 
										
										<?php }?>
										
										<div class="row">  
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>config/currency" class="btn btn-light-secondary mb-1"> الغاء</a>
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
			data: form.serialize(),  
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
