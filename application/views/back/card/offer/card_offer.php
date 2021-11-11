<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>العروض</h3>
					<p class="text-subtitle text-muted">عرض كافة العروض الخاصة بالبطاقة <?= json_decode($card_info->card_name)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item active">عرض كافة العروض الخاصة بالبطاقة <?= json_decode($card_info->card_name)->ar?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<?php 
			$btn_class="";
			if(!empty($have_offer)){
				$btn_class= "disabled";	
			?>
			<div class="row">
				<div class="col-lg-12">
					<div class="alert alert-warning alert-dismissible">
						<h4 class="alert-heading">تنويه</h4>
						<p> يوجد عرض لهذه البطاقة ، لا يمكنك اضافة على البطاقة لحين انتهاء العرض المتوفر حاليا|ً</p>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">عرض كافة العروض الخاصة بالبطاقة <?= json_decode($card_info->card_name)->ar?></h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary <?=$btn_class?>" href="<?=site_url()?>card/add_offer/<?= $card_info->card_id?>" <?=$btn_class?>> اضافة عرض جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table mb-0">
									<tr> 
										<th>بواسطة</th> 
										<th>تاريخ البداية</th>
										<th>تاريخ الانتهاء</th>
										<th>السعر القديم</th>
										<th>السعر الجديد</th>
										<th>الحالة</th>
										<th>ملاحظات</th>
									</tr>
									<?php foreach($view as $v){?>
									<tr>  
										<td >
											<div class="d-flex">
												<div class="avatar avatar-lg me-3">
													<img src="<?= site_url().$v->user_pic?>" alt="" srcset="">
												</div>
												<div>
													<?=  $v->user_name?> <br>
													<?=  $v->card_offer_create_at?>
												</div>
											</div>
										</td> 
										<td > <?=  $v->card_offer_start_date?> </td> 
										<td > <?=  $v->card_offer_end_date?> </td> 
										<td > <?=  $v->card_offer_old_price?> </td> 
										<td > <?=  $v->card_offer_new_price?> </td>
										<td > 
											<?php 
												$date = date("Y-m-d");
												if($date < $v->card_offer_start_date){ ?>
												<span class="badge bg-info">ستبدأ قريباً</span>
											<?php
												}
												if( ($date >= $v->card_offer_start_date) and ($date <= $v->card_offer_end_date)){ ?>
												<span class="badge bg-success"> تحت العرض</span>
											<?php 
												} 
												if($date > $v->card_offer_end_date){ ?>
												<span class="badge bg-dark"> العرض منتهي</span>
											<?php 
												}
											?>
										</td>
										<td > <?=  $v->card_offer_note?> </td>
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