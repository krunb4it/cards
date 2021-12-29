<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>اضافة بطاقة جديدة</h3>
					<p class="text-subtitle text-muted">اضافة بطاقة جديدة <?= json_decode($card_info->card_name)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>card">البطاقات الالكترونية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>card/card_item/<?= $card_info->card_id?>"> <?= json_decode($card_info->card_name)->ar?></a></li> 
							<li class="breadcrumb-item active">شحن بطاقات جديدة</li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>card/add_card_item" class="form form-horizontal">
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="card_id" value="<?= $card_info->card_id?>">
				 
				<div class="row"> 
					<div class="col-xl-6 col-lg-8">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">اضافة بطاقات <?= json_decode($card_info->card_name)->ar?></h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body"> 
										<div class="result-card-item"> </div>
										<div class="row"> 
											<div class="col-md-12">
												<div class="form-group">
													<label class="mb-3">كود البطاقة</label>
													<input type="text" id="card_item_code" name="card_item_code" class="form-control form-control-lg" required>
												</div>
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<div class="form-group ">
													<label class="mb-3">الرقم المرجعي</label> 
													<input type="text" id="card_item_reference" name="card_item_reference" class="form-control form-control-lg" required>
												</div>
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<div class="form-group ">
													<label class="mb-3">الرقم التسلسلي</label> 
													<input type="text" id="card_item_serial" name="card_item_serial" class="form-control form-control-lg" required>
												</div>
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<div class="form-group ">
													<label class="mb-3">تاريخ الانتهاء</label> 
													<input type="date" id="card_item_end" name="card_item_end" class="form-control form-control-lg" required>
												</div>
											</div>
										</div>
										<hr class="my-3">
										
										<div class="row">
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>card/card_item/<?= $card_info->card_id?>" class="btn btn-light-secondary mb-1"> الغاء</a>
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
/*
	var i = 1;
	function add_card_item(){
		var html = '\
			<div class="row align-items-end" id="item_id_'+ i +'"> \
				<div class="col-md-4 col-sm-6">\
					<div class="form-group ">\
						<label>الكود</label>\
						<input type="text" name="card_item_code[]" class="form-control form-control-lg" value="'+ $("#card_item_code").val() +'" required>\
					</div>\
				</div>\
				<div class="col-md-4 col-sm-6">\
					<div class="form-group ">\
						<label>الرقم السري</label> \
						<input type="text" name="card_item_password[]" class="form-control form-control-lg" value="'+ $("#card_item_password").val() +'" required>\
					</div>\
				</div>\
				<div class="col-md-3 col-sm-6">\
					<div class="form-group ">\
						<label>تاريخ الانتهاء</label> \
						<input type="date" name="card_item_end[]" class="form-control form-control-lg" value="'+ $("#card_item_end").val() +'" required>\
					</div>\
				</div>\
				<div class="col-md-1 col-sm-6">\
					<div class="form-group ">\
						<button type="button" class="btn btn-danger" onclick="remove_card_item('+ i +')"> حذف </button>\
					</div>\
				</div>\
			</div>\
		';
		$("#card_item_end, #card_item_password, #card_item_code").val("");
		$(".result-card-item").append(html);
		i++;
	}
	
	function remove_card_item(item_id){
		$(".result-card-item").find("#item_id_"+ item_id).remove();
	}
*/
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
						form[0].reset();
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
