<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>الطلبات</h3>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item active">الطلبات</li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>

		<?php if($this->session->flashdata("error")){?>
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-warning alert-dismissible">
					<h4 class="alert-heading">تنويه</h4>
					<p> <?= $this->session->flashdata("error") ?></p>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			</div>
		</div>
		<?php }?>
		<div class="page-heading"> 
			<?php if($this->session->flashdata("error")){?>
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-danger alert-dismissible show fade">
						<?= $this->session->flashdata("error");?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">الطلبات</h4>
						</div>
						
						<div class="card-content">
							<div class="card-body bg-light" id="fillter-box">
								<form id="fillterForm" action="<?= site_url()?>order/get_order_filtter" method="post">
									<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
									<div class="row align-items-end mt-4">
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
											<label for="" class="mb-2">حالة الطلب</label>
											<select class="form-control form-control-lg choices" name="order_status_id">
												<option value="" disabled selected> اختر الحالة</option>
												<?php foreach($status as $s){?>
												<option value="<?= $s->order_status_id?>"> <?= $s->order_status_name?></option>
												<?php }?>
											</select>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
											<label for="" class="mb-2">بحث بواسطة الزبون</label>
											<select class="form-control form-control-lg choices" name="customer_id">
												<option value="" disabled selected> اختر الزبون</option>
												<?php foreach($customer as $c){?>
												<option value="<?= $c->customer_id?>"> <?= $c->customer_name?></option>
												<?php }?>
											</select>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
											<label for="" class="mb-2">بحث بواسطة البطاقة</label>
											<select class="form-control form-control-lg choices" name="card_id">
												<option value="" disabled selected> اختر البطاقة</option>
												<?php foreach($card as $ca){?>
												<option value="<?= $ca->card_id?>"> <?= json_decode($ca->card_name)->ar?></option>
												<?php }?>
											</select>
										</div>
										<div class="col-xl-4">
											<label for="" class="mb-2">بحث بواسطة التاريخ</label>
											<div class="row">
												<div class="col-sm-6 mb-sm-0 mb-3">
													<input type="date" class="form-control form-control-lg" name="date_from">
												</div>
												<div class="col-sm-6">
													<input type="date" class="form-control form-control-lg" name="date_to" value="<?= date("Y-m-d")?>">
												</div>
											</div>
										</div>
										<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6"> 
											<button type="submit" class="btn btn-success btn-submit">
												<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>	
												بحث 
											</button>
										</div>
									</div>
								</form>
							</div>
							<div class="card-body">
								<table class="table table-borderless mb-0" id="order_details">
									<thead>
										<tr>
											<td>الزبون</td>
											<td>تاريخ الطلب</td>
											<td>البطاقة</td>
											<td>الكمية</td>
											<td>السعر</td>
											<td>المجموع</td>
											<td>الحالة</td>
											<td>الخيارات</td>
										</tr>
									</thead>
									<tbody>
										<?php foreach($view as $v){?>
										<tr> 
											<td> 
												<div class="avatar avatar-lg me-3">
													<img src="<?= site_url().$v->customer_logo?>" alt="<?= $v->customer_name?>" srcset="">
												</div>
												<?= $v->customer_name?> 
											</td> 
											<td> <?= $v->order_create_at?> </td>  
											<td> <?= json_decode($v->card_name)->ar ?>  </td> 
											<td> <?= $v->quantity?> </td> 
											<td> <?= $v->price?> </td>
											<td> <?= $v->total?> </td>
											<td> <span class="badge <?= $v->order_status_color?>"> <?= $v->order_status_name?> </span> </td>
											<td>
												<?php if($v->order_status_id == 1 or $v->order_status_id == 2){?>
												<a href="<?= site_url()?>order/view_order/<?= $v->order_id?>" class="btn btn-sm btn-primary"> عرض الطلب</a>
												<?php }?>
											</td> 
										</tr>	
										<?php }?>
									</tbody>
								</table> 
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div>
	</div>
</div>

<script>
	$('#fillterForm').submit(function(e) {
		var form = $(this);
		e.preventDefault(); 
		form.find(".btn-submit .spinner-border").toggleClass("d-none");
		form.addClass("disabled");
		
		$.ajax({
			type: "post", 
			dataType: "html",
			url: form.attr("action"),
			data: form.serialize(),
			success: function(res){
				//var res = JSON.parse(res);
				setTimeout( function(){ 
					$("#order_details tbody").html(res);
					form[0].reset();
					form.find(".btn-submit .spinner-border").toggleClass("d-none");
					form.removeClass("disabled");
				}, 3000);
			},
			error: function() {
				Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
				form.find(".btn-submit .spinner-border").toggleClass("d-none");
				form.removeClass("disabled");
			}
		});
    });
</script>
