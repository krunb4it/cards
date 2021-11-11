	
	<?php
	if(!empty( $view )){
		foreach($view as $v){?>
		<tr> 
			<td >
				<div class="avatar avatar-lg me-3">
					<img src="<?= site_url().$v->customer_logo?>" alt="<?= $v->customer_name?>" srcset="">
				</div>
				<?= $v->customer_name?>
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