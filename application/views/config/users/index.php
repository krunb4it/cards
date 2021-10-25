<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>مستخدمي النظام</h3>
					<p class="text-subtitle text-muted">عرض كافة مستخدمي النظام</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active">مستخدمي النظام</li> 
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
							<h4 class="card-title">مستخدمي النظام</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>config/new_user"> اضافة مستخدم جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table table-borderless mb-0">
									<tr>
										<td>الصورة</td>
										<td>اسم المستخدم</td>
										<td>المجموعة</td>
										<td>البريد الالكتروني</td>
										<td>رقم الجوال</td>
										<td>الحالة</td>
										<td>تفعيل/ تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $s){?>
									<tr id="user_id_<?= $s->user_id;?>">
										<td width="150"><img src="<?= site_url().$s->user_pic?>" height="50" class="rounded" alt=""></td>
										<td > <?=  $s->user_name?> </td>
										<td > <?=  $s->admin_group_name?> </td>
										<td > <?=  $s->email?> </td>
										<td > <?=  $s->jawwal?> </td>
										<td width="80">
											<?php if($s->user_status == 1){
												$checked = "checked";
											?>
												<span class="badge bg-success badge-lang-<?= $s->user_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger badge-lang-<?= $s->user_id;?>">غير مفعل</span>
											<?php }?>
										</td>
										<td width="50" class="text-bold-500">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" data-id="<?= $s->user_id;?>" value="<?= $s->user_status;?>" <?= $checked ?> >
											</div>
										</td>
										<td width="150" class="text-bold-500">
											<a class="btn btn-info me-2" href="<?=site_url()?>config/view_user/<?= $s->user_id;?>"> تعديل</a>
											<a class="btn btn-danger btn-remove" href="#!" data-id="<?= $s->user_id;?>" data-title="<?= $s->user_name?>"> حذف </a>
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
			url: "<?= site_url()?>config/update_user_status",
			data: {
				"user_active" : val,
				"user_id" : id,
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
			title: "حذف المستخدم",
			text: 'هل تريد حقاً حذف المستخدم ' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة المستخدم المحذوف',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>config/remove_user_id",
					data: {
						"user_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#user_id_"+ id).remove();
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