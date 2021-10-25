<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>البوم صور الاعلانات</h3>
					<p class="text-subtitle text-muted">البوم صور الاعلانات</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active"> البوم صور الاعلانات </li> 
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
							<h4 class="card-title">البوم صور الاعلانات</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>config/new_slider/"> اضافة اعلان جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body">
								<ul class="list-group sorted_table">
									<?php foreach($view as $s){?>
									<li class="list-group-item" id="s_<?= $s->slider_id;?>">
										<div class="table-responsive">
											<table class="table w-auto table-borderless mb-0">
												<tr >
													<td width="150"><img src="<?= site_url().$s->slider_cover?>" height="50" class="rounded" alt=""></td>
													<td width="500">
														<?= json_decode($s->slider_title)->ar?>
														<br>
														<small class="text-muted"> - <?= json_decode($s->slider_sub_title)->ar?></small>
													</td>
													<td width="80">
														<?php if($s->slider_active == 1){
															$checked = "checked";
														?>
															<span class="badge bg-success badge-lang-<?= $s->slider_id;?>">مفعل</span>
														<?php } else{
															$checked = "";
														?>
															<span class="badge bg-danger badge-lang-<?= $s->slider_id;?>">غير مفعل</span>
														<?php }?>
													</td>
													<td width="50" class="text-bold-500">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" data-id="<?= $s->slider_id;?>" value="<?= $s->slider_active;?>" <?= $checked ?> >
														</div>
													</td>
													<td width="150" class="text-bold-500">
														<a class="btn btn-info me-2" href="<?=site_url()?>config/view_slider/<?= $s->slider_id;?>"> تعديل</a>
														<a class="btn btn-danger btn-remove" href="#!" data-id="<?= $s->slider_id;?>" data-title="<?= json_decode($s->slider_title)->ar?>"> حذف </a>
													</td>
												</tr>	
											</table>
										</div>
									</li>
									<?php }?>
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
			url: "<?= site_url()?>config/update_slider_status",
			data: {
				"slider_active" : val,
				"slider_id" : id,
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
				url: '<?= site_url()?>config/update_slider_order',
				dataType: 'json',
				data: $('.sorted_table').sortable('serialize'),
				success: function(res) { 
					runToastify(res.res);
				}
			});
		}
	});
	
	// remove
	$('.btn-remove').click( function(){
		var id = $(this).data("id");
		Swal.fire({
			icon: 'warning',
			title: "حذف الاعلان",
			text: 'هل تريد حقاً حذف الاعلان ' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة الاعلان المحذوف',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>config/remove_slider_id",
					data: {
						"slider_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#s_"+ id).remove();
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