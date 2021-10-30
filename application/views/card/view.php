<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 

		<?php 
			$category_id = $view->category_id;
			if($view->category_root == 0){
				$main_category_id = $view->category_id;
				$sub_category_id = "d-none";
			} else {
				$main_category_id = $view->category_root;
				$category_id = $view->category_id ;
				$sub_category_id = "";
			}
		?>
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= json_decode($view->card_name)->ar?></h3>
					<p class="text-subtitle text-muted">عرض بيانات البطاقة الالكترونية</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>card"> البطاقات الالكترونية</a></li> 
							<li class="breadcrumb-item active"><?= json_decode($view->card_name)->ar?></li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>card/update_card" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="card_id" value="<?= $view->card_id?>"> 
				
				<div class="row"> 
					<div class="col-lg-6"> 
						<div class="card">
							<div class="card-header">
								<h4 class="card-title"><?= json_decode($view->card_name)->ar?></h4>
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
											<div class="form-group row mb-4">
												<div class="col-md-4">
													<label>صورة البطاقة الالكترونية</label>
												</div> 
												<div class="col-md-8">
													<div class="upload-pic-box">
														<label for="profile_pic" class="view-pic">
															<img src="<?= site_url().$view->card_pic?>" class="img-fluid rounded preview-pic" width="150">
														</label>
														<input type="hidden"  name="last_card_pic" value="<?=$view->card_pic?>">
														<input type="file" class="form-control d-none upload-pic" id="profile_pic" name="card_pic" id="formFile" required>
														<div class="invalid-feedback">مطلوب</div>
														<small> يرجى ادراج صورة بالابعاد التالية
															<code dir="ltr" style="direction : ltr">(150px × 150px)</code>
														</small>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-4">
													<label>التصنيف الرئيسي</label>
												</div> 
												<div class="col-md-8">
													<select class="form-control form-control-lg form-select main-catrgory" name="category_id" required>
														<option value="" seleted disabled> اختر التصنيف الرئيسي</option>
														<?php foreach($category as $c){?>
														<option value="<?= $c->category_id?>" <?php if($main_category_id == $c->category_id) echo "selected";?> ><?= json_decode($c->category_name)->ar?></option>
														<?php }?>
													</select>
												</div>
											</div>

											<div class="form-group row sub-category-box <?= $sub_category_id?>">
												<div class="col-md-4">
													<label>التصنيف الفرعي</label>
												</div> 
												<div class="col-md-8">
													<select class="form-control form-control-lg form-select sub-category" name="category_id">
														<option value="" seleted disabled> اختر التصنيف الفرعي</option>
													</select>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-md-4">
													<label>الحد الادنى للصرف</label>
												</div> 
												<div class="col-md-8">
													<input type="number" min="1" class="form-control form-control-lg" name="card_min_amount" value="<?= $view->card_min_amount?>" required>	
												</div>
											</div>

											<div class="form-group row">
												<div class="col-md-4">
													<label>وقت المحدد لتنفيذ الخدمة</label>
												</div> 
												<div class="col-md-8">
													<input type="text" class="form-control form-control-lg" name="card_time_to_do" value="<?= $view->card_time_to_do?>" required>
												</div>
											</div>
											<?php foreach($language as $l){
												($l->lang_active == 0) ? $class = "d-none" : $class = "";
												$short = $l->lang_short;
											?>
											<div class="<?= $class?>">
												<div class="row"> 
													<div class="col-md-12"> <h4 class="py-4"><?= $l->lang_name?></h4></div>
												</div>
												<div class="row"> 
													<div class="col-md-3">
														<label>اسم البطاقة الالكترونية</label>
													</div>
													<div class="col-md-9 form-group">
														<input type="text" class="form-control form-control-lg" name="card_name[<?= $l->lang_short?>]" value="<?= json_decode($view->card_name)->$short?>">
													</div>
												</div>
												<div class="row"> 
													<div class="col-md-3">
														<label>تفاصيل البطاقة الالكترونية</label>
													</div>
													<div class="col-md-9 form-group">
														<textarea rows="4" class="form-control form-control-lg" name="card_note[<?= $l->lang_short?>]"><?= json_decode($view->card_note)->$short?></textarea>
													</div>
												</div>
											</div>
											<?php }?>

											<hr class="my-3">
											
											<div class="row">
												<div class="col-sm-12 d-flex justify-content-end">
													<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
														<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
													</button>
													<a href="<?= site_url()?>card" class="btn btn-light-secondary mb-1"> الغاء</a>
												</div> 
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
	$('#form').submit(function(e) {
		var form = $(this);
		e.preventDefault(); 
		$(".btn-submit .spinner-border").toggleClass("d-none");
		form.addClass("disabled");
		
		$.ajax({
			type: "post", 
			dataType: "html",
			url: form.attr("action"),
			//data: form.serialize(), 
			data:new FormData(this),
			processData:false,
			contentType:false,
			cache:false,
			async:false,
			success: function(res){
				var res = JSON.parse(res);
				setTimeout( function(){
					if(res.status == "error"){
						Swal.fire("خطأ !!", res.res, "error");
					} else {
						runToastify(res.res);
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
	
	$(".main-catrgory").change( function(){
		var category_id = $(this).val(); 
		get_sub_category(category_id)
	});

	<?php if($view->category_root != 0) {?>
		get_sub_category(<?= $view->category_root?>, <?= $view->category_id?>);
	<?php }?>

	function get_sub_category(category_root , category_id){
		$.ajax({
			type: "post", 
			dataType: "html",
			url: "<?=site_url()?>card/get_sub_category",
			data: {
				"category_root" : category_root,
				"category_id" : category_id,
				"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
			},
			success: function(res){
				if(res != false){
					$("select.sub-category").html(res).attr("required","required");
					$(".sub-category-box").removeClass("d-none");
				} else { 
					$("select.sub-category").html("").removeAttr("required");
					$(".sub-category-box").addClass("d-none");
				}
			},
			error: function() {
				Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
			}
		});
	}

</script>
