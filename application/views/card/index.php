<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>البطاقات الالكترونية</h3>
					<p class="text-subtitle text-muted">عرض كافة البطاقات الالكترونية</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item active">البطاقات الالكترونية</li>
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
							<h4 class="card-title">البطاقات الالكترونية</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>card/new_card"> اضافة بطاقة الكترونية جديدة</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table mb-0">
									<tr>
										<td>الصورة</td>
										<td>اسم البطاقة الالكترونية</td> 
										<td>التصنيف</td>
										<td>الرصيد المتوفر</td>
										<td>الحد الادنى للطلب</td>
										<td>وقت الخدمة</td>
										<td>الحالة</td>
										<td>تفعيل/ تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $s){?>
									<tr id="card_id_<?= $s->card_id;?>">
										<td width="150"><img src="<?= site_url().$s->card_pic?>" height="50" class="rounded" alt=""></td>
										<td > <?=  json_decode($s->card_name)->ar?> </td> 
										<td > <?=  json_decode($s->category_name)->ar?> </td>
										<td > <?=  $s->card_amount?> </td>
										<td > <?=  $s->card_min_amount?> </td>
										<td > <?=  $s->card_time_to_do?> </td>
										<td width="80">
											<?php if($s->card_active == 1){
												$checked = "checked";
											?>
												<span class="badge bg-success badge-lang-<?= $s->card_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger badge-lang-<?= $s->card_id;?>">غير مفعل</span>
											<?php }?>
										</td>
										<td width="50" class="text-bold-500">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" data-id="<?= $s->card_id;?>" value="<?= $s->card_active;?>" <?= $checked ?> >
											</div>
										</td>
										<td width="150" class="text-bold-500">
											<div class="btn-group">
												<button class="btn btn-light border dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
														aria-expanded="false"> الخيارات
												</button>
												<div class="dropdown-menu dropdown-menu-start" aria-labelledby="triggerId">
													<h6 class="dropdown-header"> الخيارات </h6>
													<a class="dropdown-item" href="#"> حركات الرصيد </a>
													<a class="dropdown-item" href="#"> حركات الشراء </a>
													<a class="dropdown-item" href="<?=site_url()?>card/view_card/<?= $s->card_id;?>"> تعديل</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item btn-remove text-danger" href="#" data-id="<?= $s->card_id;?>" data-title="<?= json_decode($s->card_name)->ar?>">حذف</a>
												</div>
											</div> 
										</td>
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