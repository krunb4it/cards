	
	<?php
	if(!empty( $view )){
		foreach($view as $v){
			
			if (! file_exists($v->customer_logo)){
				//$name = $v->customer_name; 
				$img = '<div class="avatar avatar-lg  bg-primary me-3">
							<span class="avatar-content"><i class="iconly-boldProfile"></i></span>
						</div>';
			} else {
				$img = '<div class="avatar avatar-lg me-3"><img src="'. site_url().$v->customer_logo .'" alt="" srcset=""></div>';
			}
		?>
		<tr> 
			<td > 
				<?= $img . $v->customer_name?>
			</td> 
			<td > <?= $v->customer_wallet_create_at?> </td> 
			<td>
				<?php if($v->customer_wallet_type_id == 1){ 
				?>
					<span class="badge bg-success"> شحن </span>
				<?php } else{ 
				?>
					<span class="badge bg-danger"> شراء </span>
				<?php }?>
			</td>
			<td > <?= $v->customer_wallet_old_balance?> </td> 
			<td > <?= $v->customer_wallet_new_balance?> </td> 
			<td > <?= $v->customer_wallet_total_balance?> </td>
			<td > <?= $v->user_name?></td>
			<td > <a class="btn btn-primary" href="<?= site_url().$v->bank_receipt?>" target="_blank"> المرفقات</a></td>
		</tr>	
		<?php }?>
	<?php } else { ?> 
		<tr> 
			<td colspan="8">
				<div class="alert alert-danger">
					<h4 class="alert-heading"> خطأ </h4>
					<p> لا تتوفر عمليات شحن او شراء للمحفظة الخاصة بهذا المستخدم</p>
				</div>
			</td>
		</tr>
	<?php }?>