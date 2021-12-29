<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>شحن رصيد</h3>
					<p class="text-subtitle text-muted">شحن رصيد لزبون </p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>wallet">المحفظة</a></li> 
							<li class="breadcrumb-item active">شحن رصيد لزبون </li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>wallet/do_charge_wallet" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				
				<div class="row"> 
					<div class="col-xl-6 col-lg-9"> 
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">شحن رصيد لزبون </h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row mb-4">
											<div class="col-md-3">
												<label>صورة الايصال</label>
											</div> 
											<div class="col-md-9"> 
												<div class="upload-pic-box">
													<label for="profile_pic" class="view-pic">
														<img src=" " class="img-fluid rounded preview-pic" width="250">
													</label>
													<input type="file" class="form-control d-none required upload-pic" id="profile_pic" name="bank_receipt" id="formFile" required>
													<div class="invalid-feedback">مطلوب</div> 
													<small> يرجى ادراج صورة بالابعاد التالية 
														<code dir="ltr" style="direction : ltr">(120px × 120px)</code>
													</small> 
												</div>	 
											</div>
										</div> 
										
										<div class="row"> 
											<div class="col-md-3">
												<label>اسم الزبون</label>
											</div>
											<div class="col-md-9 form-group">
												<select class="form-control form-control-lg choices" name="customer_id" required>
													<option value="" disabled selected> اختر الزبون</option>
													<?php foreach($customer as $c){?>
													<option value="<?= $c->customer_id?>"> <?= $c->customer_name?></option>
													<?php }?>
												</select>
											</div>  
										</div>
										
										<div class="row"> 
											<div class="col-md-3">
												<label>طريقة الشحن</label>
											</div>
											<div class="col-md-9 form-group">
												<select class="form-control form-control-lg choices" name="payment_way_id" required>
													<option value="" disabled selected> اختر طريقة الشحن</option>
													<?php foreach($payment_way as $p){?>
													<option value="<?= $p->payment_way_id?>"> <?= json_decode($p->payment_way_name)->ar?></option>
													<?php }?>
												</select>
											</div>  
										</div>
										
										<div class="row"> 
											<div class="col-md-3">
												<label>العملية</label>
											</div>
											<div class="col-md-9 form-group">
												<select class="form-control form-control-lg choices" name="customer_wallet_type_id" required>
													<option value="1"> شحن المحفظة</option>
												</select>
											</div>  
										</div>
										
										<div class="row"> 
											<div class="col-md-3">
												<label>المبلغ المراد شحنه</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control form-control-lg" name="customer_wallet_new_balance" required>
											</div>  
										</div>
										
										<hr class="my-3">
										
										<div class="row">  
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>wallet" class="btn btn-light-secondary mb-1"> الغاء</a>
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
