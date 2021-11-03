<?php $lang = $this->session->userdata("website_lang");?>
<section id="content-types"> 
	<div class="container">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="page-heading py-4">
					<div class="page-title">
						<div class="row">
							<div class="col-12 col-md-6 order-md-1 order-last">
								<h1>البطاقات</h1>
								<p class="text-subtitle text-muted">نستعرض لكم اهم واقوى التصنيفات الفرعية في الموقع</p> 
							</div>
							<div class="col-12 col-md-6 order-md-2 order-first">
								<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
										<li class="breadcrumb-item"><a href="<?= site_url()?>view_category">التصنيفات الرئيسية</a></li>
										<?php if($category_sub->category_root != 0){?>
										<li class="breadcrumb-item"><a href="<?= site_url()?>view_sub_category/<?= $category_main->category_id?>"><?= json_decode($category_main->category_name)->$lang?></a></li>
										<?php }?>
										<li class="breadcrumb-item active" aria-current="page"><?= json_decode($category_sub->category_name)->$lang?></li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php   
				for($c = 0 ; $c < count($cards); $c++){
			?>
			<div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">  
				<a href="#!" class="card card-open-modal" 
					data-card_id="<?= $cards[$c]["card_id"]?>"
					data-card_name="<?= $cards[$c]["card_name"]?>"
					data-card_offer="<?= $cards[$c]["card_offer"]?>"
					data-card_price="<?= $cards[$c]["card_price"]?>"
					data-offer_price="<?= $cards[$c]["offer_price"]?>"
					data-card_pic="<?= site_url().$cards[$c]["card_pic"]?>"
					data-card_note="<?= $cards[$c]["card_note"]?>"
					data-offer_end_date="<?= $cards[$c]["offer_end_date"]?>"
				>
					<div class="card-content">
						<img class="card-img-top img-fluid" src="<?= site_url().$cards[$c]["card_pic"] ?>" alt="<?= $cards[$c]["card_name"] ?>">
						<div class="card-body">
							<h3 class="card-title"><?= $cards[$c]["card_name"]?></h3>
							<?php if($cards[$c]["card_offer"] == 0){?>
							<p class="card-text"><?= $cards[$c]["card_price"]?> دينار</p>
							<?php } else {?>
							<p class="card-text">
								<span class="h5 me-2"><?= $cards[$c]["offer_price"]?> دينار</span> 
								<span class="text-decoration-line-through text-muted"><?= $cards[$c]["card_price"]?> دينار</span> 
							</p>
							<?php }?>
						</div>
					</div>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
</section>

<div class="modal fade" id="card_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"> 
            <div class="modal-body">
                <div class="container-fluid">
					<div class="pb-4 mb-4">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					
					<div class="text-center">
						<div class="pic mb-3">
							<img src="" width="150" alt="" id="card_pic">
						</div>
						<div class="contnet">
							<h4 id="card_name"></h4>
							<p id="card_note"></p>
							
							<h5 class="mt-4"> سعر البطاقة </h5>
							<p>
								<span id="offer_price" class="h5 me-2"> </span> 
								<span id="card_price" class="text-decoration-line-through text-muted"></span> 
							</p>
						</div>
					</div> 
					<form id="addToCart" class="" method="post" action="<?= site_url()?>addToCart">
						<div class="action">
							<div class="form-group">
								<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
								<input type="hidden" id="card_id" name="card_id">
								<input type="hidden" id="card_price_form" name="card_price">
								<input type="hidden" id="card_name_form" name="card_name">
								<input type="hidden" id="card_pic_form" name="card_pic">
								<label class="h5">الكمية المطلوبة</label>
								<input type="number" id="card_qty" name="card_qty" min="1" class="form-control form-control-lg text-center" required>
							</div>
						</div>
						
						<div class="text-center pt-4 mt-4 border-top">
							<button type="sbumit" class="btn btn-primary btn-submit me-2">
							<span class="spinner-border spinner-border-sm d-none me-3" role="status" aria-hidden="true"></span> 
							اضافة الى السلة
							</button>
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">الغاء</button>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	$(".card-open-modal").on("click", function(){
		var card_id = $(this).data('card_id'),
			card_name = $(this).data('card_name'),
			card_offer = $(this).data('card_offer'),
			card_price = $(this).data('card_price'),
			offer_price = $(this).data('offer_price'),
			card_pic = $(this).data('card_pic'),
			card_note = $(this).data('card_note'),
			offer_end_date = $(this).data('offer_end_date');
			
		$("#card_modal #card_id").val(card_id);
		$("#card_modal #card_pic").attr("src", card_pic);
		$("#card_modal #card_name").text(card_name);
		$("#card_modal #card_name_form").val(card_name);
		$("#card_modal #card_pic_form").val(card_pic);
		
		if( card_offer == 1){
			$("#card_modal #card_price_form").val(offer_price);
			$("#card_modal #offer_price").text(offer_price + " دينار");
			$("#card_modal #card_price").text(card_price + " دينار");
		} else {
			$("#card_modal #card_price_form").val(card_price);
			$("#card_modal #offer_price").text(card_price + " دينار");
			$("#card_modal #card_price").addClass("d-none");
		}
		$("#card_modal #card_note").text(card_note);
		
		$("#card_modal").modal("show");
	});
	
	
	$('#addToCart').submit(function(e) {  
		var form = $(this);     
		e.preventDefault(); 
		$(".btn-submit .spinner-border").toggleClass("d-none");
		form.addClass("disabled");
		
		$.ajax({
			type: "post", 
			dataType: "html",
			url: form.attr("action"),
			data: form.serialize(),
			success: function(res){
				var res = JSON.parse(res);
				setTimeout( function(){
					if(res.status == "error"){
						Swal.fire("خطأ !!", res.res, "error");
					} else {
						runToastify(res.res);
						$("#card_modal #card_qty").val("");
						$(".badge-cart").removeClass("d-none").text(res.cart_count);
						$("#card_modal").modal("hide");
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
</script>