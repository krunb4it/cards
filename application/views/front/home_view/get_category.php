<section id="content-types"> 
	<div class="container">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="page-heading py-4">
					<div class="page-title"> 
						<h2>التصنيفات الرئيسية</h2>
						<p class="text-subtitle text-muted">نستعرض لكم اهم واقوى التصنيفات الرئيسية في الموقع</p> 
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php 
			function create_slug($string){
			   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
			   return $slug;
			}
				$lang = $this->session->userdata("website_lang"); 
				foreach($category as $c){ 
			?>
			<div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">  
				<a href="<?= site_url()?>view_sub_category/<?= $c->category_id?>" class="card">
					<div class="card-content">
						<img class="card-img-top img-fluid" src="<?= site_url().$c->category_pic?>" alt="<?= json_decode($c->category_name)->$lang?>">
						<div class="card-body">
							<h3 class="card-title"><?= json_decode($c->category_name)->$lang?></h3>
							<p class="card-text"><?= json_decode($c->category_details)->$lang?></p>
						</div>
					</div>
				</a>
			</div>
				<?php } ?>
		</div>
	</div>
</section>