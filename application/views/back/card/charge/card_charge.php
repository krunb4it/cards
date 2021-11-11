<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>حركات شحن الرصيد</h3>
					<p class="text-subtitle text-muted">عرض كافة حركات شحن رصيد البطاقة <?= json_decode($card_info->card_name)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item active">عرض كافة حركات شحن رصيد البطاقة <?= json_decode($card_info->card_name)->ar?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">عرض كافة حركات شحن رصيد البطاقة <?= json_decode($card_info->card_name)->ar?></h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>card/add_charge/<?= $card_info->card_id?>"> اضافة رصيد جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table mb-0">
									<tr> 
										<td>بواسطة</td> 
										<td>الكمية القديمة</td>
										<td>السعر القديم</td>
										<td>الكمية الجديدة</td>
										<td>السعر الجديد</td>
										<td>ملاحظات</td>
									</tr>
									<?php foreach($view as $v){?>
									<tr>  
										<td >
											<div class="d-flex">
												<div class="avatar me-3">
													<img src="<?= site_url().$v->user_pic?>" alt="" srcset="">
												</div>
												<div>
													<?=  $v->user_name?> <br>
													<?=  $v->card_charge_create_at?>
												</div>
											</div>
										</td>
										<td > <?=  $v->card_charge_old_amount?> </td>
										<td > <?=  $v->card_charge_old_price?> </td>
										<td > <?=  $v->card_charge_amount?> </td>
										<td > <?=  $v->card_charge_price?> </td>
										<td > <?=  $v->card_charge_note?> </td>
									</tr>	
									<?php }?>
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
	// change status 
	$(".form-switch").on("click", function(e){
		var val = $(this).find(".form-check-input").val();
		var id = $(this).find(".form-check-input").data("id"); 
		
		(val == 0) ? val = 1 : val = 0;
		$(this).find(".form-check-input").val(val);
		
		if(val == 0){
			$(".badge-lang-"+ id).removeClass("bg-success ").addClass("bg-danger").text("غير مفعل");
		} else {
			$(".badge-lang-"+ id).removeClass("bg-danger").addClass("bg-success ").text("مفعل");
		}
		$.ajax({
			type: "post",
			dataType: "html",
			url: "<?= site_url()?>card/update_card_status",
			data: {
				"card_active" : val,
				"card_id" : id,
				"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
			},
			success: function(res){ 
				var res = JSON.parse(res);
				runToastify(res.res);
			},
			error: function(){ 
			}
		});
	}); 
	
	// remove
	$('.btn-remove').click( function(){
		var id = $(this).data("id");
		Swal.fire({
			icon: 'warning',
			title: "حذف البطاقة الالكترونية",
			text: 'هل تريد حقاً حذف البطاقة الالكترونية ' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة البطاقة الالكترونية المحذوف',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>card/remove_card_id",
					data: {
						"card_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#card_id_"+ id).remove();
						runToastify(res.res);
					},
					error: function(){ 
					}
				});
			} else if (result.isDenied) {
				Swal.fire('Changes are not saved', '', 'info')
			}
		});
	});
</script> 