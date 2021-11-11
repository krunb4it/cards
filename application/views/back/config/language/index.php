<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>لغات الموقع</h3>
					<p class="text-subtitle text-muted">اعدادات لغات الموقع</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active" aria-current="page">لغات الموقع</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>config/update_lang" class="form form-horizontal needs-validation" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">لغات الموقع</h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-lg">
											<thead>
												<tr>
													<th>اللغة</th>
													<th>الحالة</th>
													<th>تفعيل</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($language as $l){ ?>
												<tr >
													<td class="text-bold-500"><?= $l->lang_name?></td>
													<td>
														<?php if($l->lang_active == 1){
															$checked = "checked";
														?>
															<span class="badge bg-success badge-lang-<?= $l->lang_id;?>">مفعل</span>
														<?php } else{
															$checked = "";
														?>
															<span class="badge bg-danger badge-lang-<?= $l->lang_id;?>">غير مفعل</span>
														<?php }?>
													</td>
													<td class="text-bold-500">
														<div class="form-check form-switch">
															<input class="form-check-input" type="checkbox" data-id="<?= $l->lang_id;?>" value="<?= $l->lang_active;?>" <?= $checked ?> >
														</div>
													</td> 
												</tr>
												<?php }?>
											</tbody>
										</table>
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
			url: "<?= site_url()?>config/update_language",
			data: {
				"lang_active" :  val,
				"lang_id" :  id,
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
	 
</script> 