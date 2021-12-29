 	<section>
		<div class="container">
			<div id="slider" class="carousel slide carousel-fade" data-bs-ride="carouselfade">
				<ol class="carousel-indicators">
					<?php 
						$lang = $this->session->userdata("website_lang");
						$x = 0;
						foreach($slider as $s){
							if($x == 0) { $class = "active"; } else { $class = "";}
					?>
					<li data-bs-target="#slider" data-bs-slide-to="<?= $x++;?>" class="<?= $class?>"></li> 
					<?php 
						}
					?>
				</ol>
				<div class="carousel-inner">
					<?php 
						$lang = $this->session->userdata("website_lang");
						$i = 0;
						foreach($slider as $s){
							if($i == 0) { $class = "active"; } else { $class = "";}
					?>
					<div class="carousel-item <?= $class?> carousel-item-start">
						<img src="<?=site_url().$s->slider_cover?>" class="d-block w-100" alt="<?= json_decode($s->slider_title)->$lang;?>" onerror="this.src='http://demo.bestdnnskins.com/portals/6/innerpage/banner3_04.jpg">
						<div class="carousel-caption d-none d-md-block">
							<h5><?= json_decode($s->slider_title)->$lang;?></h5>
							<p><?= json_decode($s->slider_details)->$lang;?></p>
						</div>
					</div>
					<?php
						$i++;
						}
					?>
				</div>
				<a class="carousel-control-prev" href="#slider" role="button" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</a>
				<a class="carousel-control-next" href="#slider" role="button" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</a>
			</div>
		</div>
	</section>