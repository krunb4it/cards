

<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 

    <div id="main-content"> 
        <div class="page-heading">
            <h3>لوحة التحكم</h3>
        </div>
        <div class="page-content"> 
            <?php 
                $cards_amount = $this->db->where("card_amount", 0)->where("need_approval", 0)->get("card")->result();
                if(count($cards_amount) > 0){ 
                    $res = "هناك بطاقات عدد (". count($cards_amount) . ") بطاقة تحتاج الى شحن ، الرجاء قم بتعبئة رصيد لتلك البطاقات";
                	$title = "بطاقات منتهية";
                	sendAdminNotification($title, $res);
            ?>
			<div class="alert alert-danger">
				<h4 class="alert-heading">تحذير</h4>
				<p><?= $res?></p>
			</div>
			<?php }?> 
			
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="bi bi-people"></i> 
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">عدد الزبائن</h6>
                                            <h6 class="font-extrabold mb-0"><?= $this->db->count_all("customer")?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">الوكلاء</h6>
                                            <h6 class="font-extrabold mb-0">183.000</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="bi bi-card-text"></i> 
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">البطاقات</h6>
                                            <h6 class="font-extrabold mb-0"><?= $this->db->count_all("card")?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="bi bi-cart3"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">الطلبات</h6>
                                            <h6 class="font-extrabold mb-0"><?= $this->db->count_all("orders")?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row"> 
                        <div class="col-12 col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>الطلبات الاخيرة</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
												<tr>
													<td>الزبون</td>
													<td>تاريخ الطلب</td>
													<td>البطاقة</td>
													<td>الكمية</td>
													<td>السعر</td>
													<td>المجموع</td>
													<td>الحالة</td>
													<td>الخيارات</td>
												</tr>
                                            </thead>
                                            <tbody>
												<?php $orders = $this->db->limit(5)->order_by("orders.order_create_at", "DESC")
																	->join("card","card.card_id = orders.card_id","left")
																	->join("customer","customer.customer_id = orders.customer_id","left")
																	->join("order_status","order_status.order_status_id = orders.order_status_id","left")
																	->get("orders")->result();
												foreach($orders as $v){
                                                    if (! file_exists($v->customer_logo)) { 
                                                        //$name = $v->customer_name; 
                                                        $img = '<div class="avatar avatar-lg bg-primary me-2">
                                                                    <span class="avatar-content"><i class="iconly-boldProfile"></i></span>
                                                                </div>';
                                                    } else {
                                                        $img = '<div class="avatar avatar-lg me-2"><img src="'. site_url().$v->customer_logo .'" alt="" srcset=""></div>';
                                                    }
                                                ?>
												<tr> 
													<td>  
                                                        <?= $img?> 
														<?= $v->customer_name?> 
													</td> 
													<td> <?= $v->order_create_at?> </td>
													<td> <?= json_decode($v->card_name)->ar ?>  </td> 
													<td> <?= $v->quantity?> </td> 
													<td> <?= $v->price?> </td>
													<td> <?= $v->total?> </td>
													<td> <span class="badge <?= $v->order_status_color?>"> <?= $v->order_status_name?> </span> </td>
													<td>
														<a href="<?= site_url()?>order/view_order/<?= $v->order_id?>" class="btn btn-sm btn-primary"> عرض الطلب</a>
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
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>اجدد الزبائن</h4>
                        </div>
                        <div class="card-content pb-4">
							<?php $customer = $this->db->limit(4)->order_by("customer_create_at", "DESC")->get("customer")->result();
							foreach($customer as $c){?>
							<div class="recent-message d-flex px-4 py-3">
                                <?php 
                                    if (! file_exists($c->customer_logo)){
                                        //$name = $v->customer_name; 
                                        $img = '<div class="avatar avatar-lg  bg-primary me-3">
                                                    <span class="avatar-content"><i class="iconly-boldProfile"></i></span>
                                                </div>';
                                    } else {
                                        $img = '<div class="avatar avatar-lg me-3"><img src="'. site_url().$c->customer_logo .'" alt="" srcset=""></div>';
                                    }
                                ?>
								<?= $img?>
								<div class="name">
									<h5 class="mb-1"><?= $c->customer_name?></h5>
									<h6 class="text-muted mb-0"><?= $c->customer_email?></h6>
								</div>
							</div> 
							<?php }?>
                        </div>
                    </div> 
					<div class="card">
						<div class="card-header">
							<h4>البطاقات الاعلى مبيعاً</h4>
						</div>
						<?php 
							$orders_cards = $this->db
							->select("card_pic, card_name, sum(quantity) as s_quantity")
							->from("orders")->where("order_status_id = 3")
							->limit(4)
							->join("card","card.card_id = orders.card_id ","left")
							->group_by("orders.card_id")->get()->result();
							 
						?>
						<div class="card-body">
							<?php foreach($orders_cards as $order){?>
							<div class="row mb-3 align-items-center">
								<div class="col-8">
									<div class="d-flex align-items-center">
										<div class="avatar avatar-lg me-3">
											<img src="<?= site_url().$order->card_pic?>" alt="<?= json_decode($order->card_name)->ar?>" srcset="">
										</div>
										<p class="mb-0"><?= json_decode($order->card_name)->ar?></p>
									</div>
								</div>
								<div class="col-4">
									<h5 class="mb-0"><?= $order->s_quantity?></h5>
								</div> 
							</div>
							<?php } ?> 
						</div>
					</div> 
                </div>
            </section>
        </div>
    </div>
</div>
