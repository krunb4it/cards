<!DOCTYPE html>
<html lang="en" dir="rtl">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Error 404</title>  
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"> 
		<link rel="stylesheet" href="<?=site_url()?>assets/css/app.css">
		<link rel="stylesheet" href="<?=site_url()?>assets/css/pages/error.css">
		<link rel="stylesheet" href="<?=site_url()?>assets/css/custom.css">
	</head>  
	<body>
		<div id="error"> 
			<div class="error-page container">
				<div class="col-lg-6 col-md-8 col-12 offset-lg-3 offset-md-2">
					<img class="img-error" src="<?=site_url()?>assets/images/samples/error-404.png" alt="Not Found">
					<div class="text-center">
						<h1 class="error-title">خطا 404</h1>
						<p class='fs-5 text-gray-600'>الصفحة التي تبحث عنها غير موجودة.</p>
						<a href="<?=site_url()?>" class="btn btn-lg btn-outline-primary mt-3">الرئيسية</a>
					</div>
				</div>
			</div> 
		</div>
	</body>

</html>