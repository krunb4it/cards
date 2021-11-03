<?php $lang = $this->session->userdata("website_lang");?>
<section id="content-types"> 
	<div class="container">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="page-heading py-4">
					<div class="page-title">
						<div class="row">
							<div class="col-12 col-lg-6 order-lg-1 order-last">
								<h1>السلة</h1>
								<p class="text-subtitle text-muted">هذه السلة تستعرض لكم المنتجات التي تود ان تقوم بشرائها</p> 
							</div>
							<div class="col-12 col-lg-6 order-lg-2 order-first">
								<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
										<li class="breadcrumb-item active" aria-current="page">السلة</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-end">
			<div class="col-xl-8">
				<div class="card">
					<div class="card-header">
						<h4> عرض المنتجات</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table mb-0">
								<tr>
									<td class="h6"> اسم المنتج </td>
									<td	class="h6"> الكمية </td>
									<td	class="h6"> السعر </td>
									<td	class="h6"> الاجمالي </td>
									<td></td>
								</tr>
								<?php 
								foreach($this->cart->contents() as $items) { ?>
								<tr>
									<td>
										<img src="<?php if(isset($items["pic"])) echo $items["pic"]?>" height="50" class="me-2">
										<?= $items["name"]?>
									</td>
									<td><?= $items["qty"]?></td>
									<td><?= $items["price"]?> دينار</td>
									<td><?= $items["subtotal"]?></td>
									<td><button type="button" name="remove" class="btn btn-danger remove_item" data-id="<?= $items["rowid"]?>" data-title="<?= $items["name"]?>"> <i class="bi bi-trash"></i> </button></td>
								</tr>
								<?php }?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-5 col-md-6">
				<div class="card"><div class="card-header">
						<h4>تفاصيل الطلب</h4>
					</div>
					<div class="card-body"> 
						<div class="table-responsive">
							<table class="table table-borderless">
								<tr>
									<td> اجمالي الفاتورة</td>
									<th class="text-end"> <?= $this->cart->total();?>  دينار</th>
								</tr>
								<tr>
									<td> الشحن والتوصيل</td>
									<th class="text-end">  0 دينار</th>
								</tr>
								<tr>
									<td> الضريبة المضافة</td>
									<th class="text-end">  0 دينار</th>
								</tr>
								<tr>
									<td colspan="2" class="p-0"> <hr class=""></td> 
								</tr>
								<tr>
									<td> المجموع الكلي</td>
									<th class="text-end"> <?= $this->cart->total();?>  دينار</th>
								</tr>
							</table>
						</div>
						<hr class="border-top">
						
						<div class="row my-4">
							<div class="col-6">
								<a href="" class="btn btn-success btn-block"> اتمام الشراء </a>
							</div>
							<div class="col-6">
								<a href="#!" class="btn btn-danger btn-block clear-cart"> حذف السلة </a>
							</div>
						</div>
						
						<p class="text-center">
							بمجرد ضغطك على زر اتمام الشراء فإنك توافق على 
							<a href="#!">الشروط والاحكام</a>
						</p>
					</div>
				</div>
			</div>
		</div> 
	</div>
</section> 
<script>
	 
	// remove
	$('.remove_item').click( function(){
		var id = $(this).data("id");
		Swal.fire({
			icon: 'warning',
			title: "حذف المنتج",
			text: 'هل تريد حقاً حذف المنتج' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة المنتج المحذوف',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء',
			confirmButtonColor: '#dc3545', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>removeFromCart",
					data: {
						"row_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						runToastify(res.res);
						setTimeout( function() { location.href = location.href; }, 1000);
					},
					error: function(){ 
					}
				});
			} else if (result.isDenied) {
				Swal.fire('Changes are not saved', '', 'info')
			}
		});
	});
	
	$('.clear-cart').click( function(){ 
		Swal.fire({
			icon: 'warning',
			title: "حذف السلة",
			text: 'هل تريد حقاً حذف السلة بالاضافة الى المنتجات التي تم اختيارها ؟',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء',
			confirmButtonColor: '#dc3545', 
			}).then((result) => { 
			if (result.isConfirmed){
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>clearCart",
					data: { 
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						runToastify(res.res);
						setTimeout( function()  { location.href = location.href; }, 1000);
						
					},
					error: function(){ 
					}
				});
			} else if (result.isDenied) {
				Swal.fire('Changes are not saved', '', 'info')
			}
		});
	});
	
	/*
	$('.add_cart').click(function(){
		var product_id = $(this).data("productid");
		var product_name = $(this).data("productname");
		var product_price = $(this).data("price");
		var quantity = $('#' + product_id).val();
		if(quantity != '' && quantity > 0)
		{
		$.ajax({
		url:"<?php echo base_url(); ?>shopping_cart/add",
		method:"POST",
		data:{product_id:product_id, product_name:product_name, product_price:product_price, quantity:quantity},
		success:function(data)
		{
		 alert("Product Added into Cart");
		 $('#cart_details').html(data);
		 $('#' + product_id).val('');
		}
		});
		}
		else
		{
		alert("Please Enter quantity");
		}
		});

		$('#cart_details').load("<?php echo base_url(); ?>shopping_cart/load");

		$(document).on('click', '.remove_inventory', function(){
		var row_id = $(this).attr("id");
		if(confirm("Are you sure you want to remove this?"))
		{
		$.ajax({
		url:"<?php echo base_url(); ?>shopping_cart/remove",
		method:"POST",
		data:{row_id:row_id},
		success:function(data)
		{
		 alert("Product removed from Cart");
		 $('#cart_details').html(data);
		}
		});
		}
		else
		{
		return false;
		}
	});
	*/
</script>