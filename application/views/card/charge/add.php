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
					<p class="text-subtitle text-muted">شحن رصيد للبطاقة <?= json_decode($card_info->card_name)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>card">البطاقات الالكترونية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>card/card_charge/<?= $card_info->card_id?>">حركات شحن الرصيد</a></li> 
							<li class="breadcrumb-item active">شحن رصيد للبطاقة <?= json_decode($card_info->card_name)->ar?></li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>card/new_charge" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="card_id" value="<?= $card_info->card_id?>">
				 
				<div class="row"> 
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">شحن رصيد للبطاقة <?= json_decode($card_info->card_name)->ar?></h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="form-group row mb-4">
											<div class="col-md-4">
												<label>صورة البطاقة الالكترونية</label>
											</div> 
											<div class="col-md-8">
												<img src="<?= site_url().$card_info->card_pic?>" class="img-fluid rounded preview-pic" width="150">
												<h4 class="py-4"><?= json_decode($card_info->card_name)->ar?></h4>
											</div>
										</div> 
										
										<div class="form-group row mb-4">
											<div class="col-lg-3 col-md-4">
												<label>الكمية</label>
											</div> 
											<div class="col-md-8">
												<input type="number" name="card_charge_amount" min="1" class="form-control form-control-lg" required>
											</div>
										</div>
										<div class="form-group row mb-4">
											<div class="col-lg-3 col-md-4">
												<label>سعر البطاقة الواحدة</label>
											</div> 
											<div class="col-md-8">
												<input type="text" name="card_charge_price" class="form-control form-control-lg" required>
											</div>
										</div>
										<div class="form-group row mb-4">
											<div class="col-lg-3 col-md-4">
												<label>ملاحظات</label>
											</div> 
											<div class="col-md-8">
												<textarea rows="3" name="card_charge_note" class="form-control form-control-lg"></textarea>
											</div>
										</div>
										
										<hr class="my-3">
										
										<div class="row">
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>card/card_charge/<?= $card_info->card_id?>" class="btn btn-light-secondary mb-1"> الغاء</a>
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
