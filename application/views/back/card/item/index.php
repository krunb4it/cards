<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>البطاقات القابلة للبيع</h3>
					<p class="text-subtitle text-muted">عرض كافة البطاقات الالكترونية</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>card">البطاقات الالكترونية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>card/card_item/<?= $card_info->card_id?>"> <?= json_decode($card_info->card_name)->ar?></a></li> 
							<li class="breadcrumb-item active">البطاقات القابلة للبيع</li>
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
							<h4 class="card-title">البطاقات القابلة للبيع</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>card/new_card_item/<?= $card_info->card_id?>"> اضافة بطاقة الكترونية جديدة</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table mb-0">
									<tr>
										<td>رقم البطاقة</td> 
										<td>تاريخ الانتهاء</td>
										<td>حالة البطاقة</td>
										<td>تاريخ الاضافة</td>
										<td>تمت بواسطة</td>
									</tr>
									<?php foreach($view as $v){?>
									<tr>
										<td > <?= $v->card_item_code?> </td> 
										<td > <?= $v->card_item_end?> </td>
										<td>
											<?php if($v->card_item_used == 0){ ?>
												<span class="badge bg-success">جديدة</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger">مستخدمة</span>
											<?php }?>
										</td>
										<td > <?= $v->card_item_at?> </td>
										<td > <?= $v->user_name?> </td>
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