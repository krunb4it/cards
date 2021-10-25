<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="currency-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>العملات</h3>
					<p class="text-subtitle text-muted">اعدادات العملات</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active" aria-current="currency">اعدادات العملات</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="currency-heading"> 
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">اعدادات العملات</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a href="<?= site_url()?>config/add_currency" class="btn btn-primary"> اضافة عملة جديدة</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table  mb-0">
									<tr> 
										<td>اسم العملة</td>
										<td>اختصار العملة</td>
										<td>الحالة</td>
										<td>تفعيل / تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $p){?>
									<tr id="currency_<?= $p->currency_id;?>"> 
										<td><?= json_decode($p->currency_name)->ar?></td> 
										<td><?= json_decode($p->currency_short)->ar?></td>  
										<td>
											<?php if($p->currency_active == 1){
												$checked = "checked";
											?>
												<span class="badge bg-success badge-lang-<?= $p->currency_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger badge-lang-<?= $p->currency_id;?>">غير مفعل</span>
											<?php }?>
										</td>
										<td class="text-bold-500">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" data-id="<?= $p->currency_id;?>" value="<?= $p->currency_active;?>" <?= $checked ?> >
											</div>
										</td>
										<td class="text-bold-500">
											<a class="btn btn-info ms-3" href="<?=site_url()?>config/view_currency/<?= $p->currency_id;?>"> تعديل</a>
											<a class="btn btn-danger btn-remove" href="#!" data-id="<?= $p->currency_id;?>" data-title="<?= json_decode($p->currency_name)->ar?>"> حذف </a>
										</td>
									</tr>	
									<?php } ?>
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
			url: "<?= site_url()?>config/update_currency_status",
			data: {
				"currency_active" : val,
				"currency_id" : id,
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
			title: "حذف العملة",
			text: 'هل تريد حقاً حذف العملة ' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة العملة المحذوفة',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>config/remove_currency_id",
					data: {
						"currency_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#currency_"+ id).remove();
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