<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>صفحات الموقع</h3>
					<p class="text-subtitle text-muted">اعدادات صفحات الموقع</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active" aria-current="page">اعدادات صفحات الموقع</li>
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
							<h4 class="card-title">اعدادات صفحات الموقع</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table  mb-0">
									<tr>
										<td>الصورة</td>
										<td>عنوان الصفحة</td>
										<td>اخر تحديث</td>
										<td>الحالة</td>
										<td>تفعيل / تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $p){?>
									<tr >
										<td><img src="<?= site_url().$p->page_cover?>" height="50" class="rounded" alt=""></td>
										<td>
											<?= json_decode($p->page_title)->ar?>
											<br>
											<small class="text-muted"> - <?= json_decode($p->page_sub_title)->ar?></small>
										</td> 
										<td><?= $p->page_update_at?></td>
										<td>
											<?php if($p->page_active == 1){
												$checked = "checked";
											?>
												<span class="badge bg-success badge-lang-<?= $p->page_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger badge-lang-<?= $p->page_id;?>">غير مفعل</span>
											<?php }?>
										</td>
										<td class="text-bold-500">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" data-id="<?= $p->page_id;?>" value="<?= $p->page_active;?>" <?= $checked ?> >
											</div>
										</td>
										<td class="text-bold-500">
											<a class="btn btn-info" href="<?=site_url()?>config/view_page/<?= $p->page_id;?>"> تعديل</a>
										</td>
									</tr>	
									<?php } ?>
								</table>
								<ul class="list-group sorted_table">
									<?php /* foreach($view as $p){?>
									<li class="list-group-item" id="s_<?= $p->page_id;?>">
										<div class="table-responsive">
											<table class="table table-borderless mb-0">
												<tr class="placeholder">
													<td><img src="<?= site_url().$p->page_cover?>" height="50" class="rounded" alt=""></td>
													<td><?= json_decode($p->page_title)->ar?></td> 
													<td><?= $p->page_update_at?></td>
													<td>
														<?php if($p->page_active == 1){
															$checked = "checked";
														?>
															<span class="badge bg-success badge-lang-<?= $p->page_id;?>">مفعل</span>
														<?php } else{
															$checked = "";
														?>
															<span class="badge bg-danger badge-lang-<?= $p->page_id;?>">غير مفعل</span>
														<?php }?>
													</td>
													<td class="text-bold-500">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" data-id="<?= $p->page_id;?>" value="<?= $p->page_active;?>" <?= $checked ?> >
														</div>
													</td>
													<td class="text-bold-500">
														<a class="btn btn-info" href="<?=site_url()?>config/view_page/<?= $p->page_id;?>"> تعديل</a>
													</td>
												</tr>	
											</table>
										</div>
									</li>
									<?php } */?>
								</ul> 
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
			url: "<?= site_url()?>config/update_page_status",
			data: {
				"page_active" : val,
				"page_id" : id,
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
	
	// Sortable rows 
	$('.sorted_table').sortable({
		update: function(evt, ui) {   
			$.ajax({ 
				type: 'POST',
				url: '<?= site_url()?>config/update_page_order',
				dataType: 'json',
				data: $('.sorted_table').sortable('serialize'),
				success: function(res) { 
					runToastify(res.res);
				}
			});
		}
	});
</script> 