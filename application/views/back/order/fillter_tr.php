	
	<?php 
	if(!empty($view)){
		foreach($view as $v){?>
		<tr> 
			<td> 
				<div class="avatar avatar-lg me-3">
					<img src="<?= site_url().$v->customer_logo?>" alt="<?= $v->customer_name?>" srcset="">
				</div>
				<?= $v->customer_name?> 
			</td> 
			<td> <?= $v->order_create_at?> </td>  
			<td> <?= json_decode($v->card_name)->ar ?>  </td> 
			<td> <?= $v->quantity?> </td> 
			<td> <?= $v->price?> </td>
			<td> <?= $v->total?> </td>
			<td> <span class="badge <?= $v->order_status_color?>"> <?= $v->order_status_name?> </span> </td>
			<td>
				<?php if($v->order_status_id == 1 or $v->order_status_id == 2){?>
				<a href="<?= site_url()?>order/view_order/<?= $v->order_id?>" class="btn btn-sm btn-primary"> عرض الطلب</a>
				<?php }?>
			</td> 
		</tr>	
		<?php }?>
	<?php } else {?>
		<tr> 
			<td colspan="8">
				<div class="alert alert-danger">
					<h4 class="alert-heading"> خطأ </h4>
					<p>لا تتوفر بيانات لعرضها</p>
				</div>
			</td>
		</tr>
	<?php }?>