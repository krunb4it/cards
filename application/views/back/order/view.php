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
							<li class="breadcrumb-item"><a href="<?= site_url()?>/order">الطلبات</a></li> 
							<li class="breadcrumb-item active"> عرض الطلب </li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
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
							<h4 class="card-title">عرض الطلب</h4>
						</div>
						<div class="card-content">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<h5 class="mb-4">بيانات الزبون</h5>
										<table class="table table-bordered">
											<tr>
												<td> اسم الزبون </td>
												<th> <?= $view->customer_name?></th>
											</tr>
											<tr>
												<td> البريد الالكتروني </td>
												<th> <?= $view->customer_email?></th>
											</tr>
											<tr>
												<td> رقم الجوال </td>
												<th> <?= $view->customer_jawwal?></th>
											</tr>
											<tr>
												<td> رصيد المحفظة </td>
												<th> <?= $view->customer_balance?> د.أ</th>
											</tr> 
											<tr>
												<td> تاريخ الطلب</td>
												<th> <?= $view->order_create_at?></th>
											</tr>
											<tr>
												<td> الحالة </td>
												<th> <span class="badge <?= $view->order_status_color?>"> <?= $view->order_status_name?> </span> </th>
											</tr>
										</table>
									</div>
									<div class="col-lg-4">
										<h5 class="mb-4">بيانات الطلب</h5>
										<table class="table table-bordered"> 
											<tr>
												<td> البطاقة</td>
												<th> <?= json_decode($view->card_name)->ar?></th>
											</tr>
											<tr>
												<td> الكمية المتوفرة </td>
												<th> <span class="text-success"><?= $view->card_amount?></span></th>
											</tr>
											<tr>
												<td> الكمية المطلوبة </td>
												<th> <?= $view->quantity?></th>
											</tr>
											<tr>
												<td> السعر </td>
												<th> <?= $view->price?></th>
											</tr>
											<tr>
												<td> المجموع </td>
												<th> <?= $view->total?></th>
											</tr>
										</table>
									</div>
									<div class="col-lg-4">
										<form id="form" method="post" action="<?= site_url()?>order/order_change_status" class="form form-horizontal">
											<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
											<input type="hidden" name="order_id" value="<?=$view->order_id?>">
					
											<div class="form-group"> 
												<label class="mb-4">الحالة</label>
												<select class="form-control form-control-lg choices" name="order_status_id">
													<option></option>
													<?php foreach($order_status as $os){?>
													<option value="<?= $os->order_status_id?>" <?php if($view->order_status_id == $os->order_status_id) echo "selected";?>><?= $os->order_status_name?></option>
													<?php }?>
												</select>
											</div>
											
											<div class="form-group"> 
												<label class="mb-4">ملاحظات</label>
												<textarea rows="3" class="form-control" name="order_note"></textarea>
											</div>
											
											<div class="form-group"> 
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>order" class="btn btn-light-secondary mb-1"> الغاء</a>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div> 
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