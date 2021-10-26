<!DOCTYPE html>
<html lang="en" dir="rtl">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>تسجيل الدخول الى اللوحة</title>  
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
		<link rel="stylesheet" href="<?=site_url()?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
		<link rel="stylesheet" href="<?=site_url()?>assets/css/app.css">
		<link rel="stylesheet" href="<?=site_url()?>assets/css/pages/auth.css"> 
		<link rel="stylesheet" href="<?=site_url()?>assets/vendors/toastify/toastify.css">
		<link rel="stylesheet" href="<?=site_url()?>assets/css/custom.css">
	</head>

	<body>
		<div id="auth">

			<div class="row h-100">
				<div class="col-lg-5 col-12">
					<div id="auth-left">
						<div class="auth-logo">
							<a href="index.html"><img src="<?=site_url()?>assets/images/logo/logo.png" alt="Logo"></a>
						</div>
						<h1 class="auth-title">تسجيل الدخول</h1>
						<p class="auth-subtitle mb-5">الرجاء ادخال البريد الالكتروني وكلمة المرور بشكل صحيح</p>

						<form id="do_login" method="POST" action="<?=site_url()?>welcome/do_login">
							<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
							<div class="form-group position-relative has-icon-left mb-4">
								<input type="email" class="form-control form-control-xl" name="email" placeholder="البريد الالكتروني" required>
								<div class="form-control-icon">
									<i class="bi bi-person"></i>
								</div>
							</div>
							<div class="form-group position-relative has-icon-left mb-4">
								<input type="password" class="form-control form-control-xl" name="password" placeholder="كلمة المرور" required>
								<div class="form-control-icon">
									<i class="bi bi-shield-lock"></i>
								</div>
							</div>
							<button class="btn btn-primary btn-block btn-lg shadow-lg mt-5 btn-submit" type="submit">
								<span class="spinner-border spinner-sm d-none mt-2" role="status" aria-hidden="true"></span>
								<span> دخول </span>
							</button>
						</form>
						<div class="text-center mt-5 text-lg fs-4">
							<p><a class="font-bold" href="auth-forgot-password.html"> هل نسيت كلمة المرور ؟</a>.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-7 d-none d-lg-block">
					<div id="auth-right">

					</div>
				</div>
			</div>

		</div>
		 
        <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="<?=site_url()?>assets/vendors/toastify/toastify.js"></script>
		<script> 
			$("form").on("submit", function(e){
				e.preventDefault();
				var form = $(this);
				e.preventDefault();  
				if (form[0].checkValidity() === false) {
					e.stopPropagation();
				} else {
					$(".btn-submit .spinner-border").toggleClass("d-none");
					form.addClass("disabled");
					setTimeout( function(){
						$.ajax({
							type: "post",
							dataType: "html",
							url: form.attr("action"),
							data: form.serialize(),
							success: function(res){ 
								var res = JSON.parse(res); 
								if(res.status == 1){
									Toastify({
										text: res.res,
										duration: 3000,
										close:true,
										gravity:"bottom",
										position: "right",
										backgroundColor: "#4fbe87",
									}).showToast();

									setTimeout(function(){
										window.location.href = "<?= site_url()?>";
									}, 2000);
								} else {
									Toastify({
										text: res.res,
										duration: 3000,
										close:true,
										gravity:"bottom",
										position: "right",
										backgroundColor: "#dc3545",
									}).showToast(); 
								}
							},
							error: function(){
								toastr["error"]("ُbad request ..!");
							}
						});
						$(".btn-submit .spinner-border").toggleClass("d-none");
						form.removeClass("disabled");
					}, 3000);
				}
			});
	</script> 
	</body> 
</html>

	