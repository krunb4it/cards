<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>الوكلاء</h3>
					<p class="text-subtitle text-muted">عرض كافة الوكلاء</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item active">الوكلاء</li> 
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
							<h4 class="card-title">الوكلاء</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>agent/new_agent"> اضافة وكيل جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table table-borderless mb-0">
									<tr>
										<td>الصورة</td>
										<td>اسم الوكيل</td> 
										<td>البريد الالكتروني</td>
										<td>رقم الجوال</td>
										<td>الحالة</td>
										<td>تفعيل/ تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $s){?>
									<tr id="agent_id_<?= $s->agent_id;?>">
										<td width="150"><img src="<?= site_url().$s->agent_logo?>" height="50" class="rounded" alt=""></td>
										<td > <?=  $s->agent_name?> </td> 
										<td > <?=  $s->agent_email?> </td>
										<td > <?=  $s->agent_jawwal?> </td>
										<td width="80">
											<?php if($s->agent_active == 1){
												$checked = "checked";
											?>
												<span class="badge bg-success badge-lang-<?= $s->agent_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger badge-lang-<?= $s->agent_id;?>">غير مفعل</span>
											<?php }?>
										</td>
										<td width="50" class="text-bold-500">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" data-id="<?= $s->agent_id;?>" value="<?= $s->agent_active;?>" <?= $checked ?> >
											</div>
										</td>
										<td width="150" class="text-bold-500">
											<a class="btn btn-info me-2" href="<?=site_url()?>agent/view_agent/<?= $s->agent_id;?>"> تعديل</a>
											<a class="btn btn-danger btn-remove" href="#!" data-id="<?= $s->agent_id;?>" data-title="<?= $s->agent_name?>"> حذف </a>
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
			url: "<?= site_url()?>agent/update_agent_status",
			data: {
				"agent_active" : val,
				"agent_id" : id,
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
			title: "حذف الوكيل",
			text: 'هل تريد حقاً حذف الوكيل ' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة الوكيل المحذوف',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>agent/remove_agent_id",
					data: {
						"agent_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#agent_id_"+ id).remove();
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