<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="<?= site_url()?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= site_url()?>assets/vendors/iconly/bold.css"> 
    <link rel="stylesheet" href="<?= site_url()?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= site_url()?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= site_url()?>assets/css/app.css">
    <link rel="stylesheet" href="<?= site_url()?>assets/css/croppie.css"> 
    <link rel="stylesheet" href="<?= site_url()?>assets/vendors/choices.js/choices.min.css" /> 
    <link rel="stylesheet" href="<?= site_url()?>assets/vendors/taginput/tagsinput.css" />  
    <link rel="stylesheet" href="<?= site_url()?>assets/vendors/toastify/toastify.css">
	
	
	<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
	<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
     
    <link rel="stylesheet" href="<?= site_url()?>assets/css/custom.css">
    <link rel="shortcut icon" href="<?= site_url()?>assets/images/favicon.svg" type="image/x-icon">
   
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>

<body>
  <div id="app">
  <input id="csrf-token" type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
  <input id="site_url" type="hidden" value="<?=site_url()?>">
