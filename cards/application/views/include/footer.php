
        </div>


        <div id="uploadimageModal" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="image_demo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success crop_image me-3">قص الصورة</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">الغاء</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?=site_url()?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="<?=site_url()?>assets/js/bootstrap.bundle.min.js"></script>
        <!-- 
        <script src="<?=site_url()?>assets/vendors/apexcharts/apexcharts.js"></script>
        <script src="<?=site_url()?>assets/js/pages/dashboard.js"></script>
         -->
        
		<!-- filepond validation -->
		<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
		<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

		<!-- image editor -->
		<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
		<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
		<script src="https://unpkg.com/filepond-plugin-image-filter/dist/filepond-plugin-image-filter.js"></script>
		<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

        <!-- Custom file -->
        <script src="<?=site_url()?>assets/vendors/toastify/toastify.js"></script>
        <script src="<?=site_url()?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
        <script src="<?=site_url()?>assets/js/croppie.js"></script> 
		<!--
        <script src="<?=site_url()?>assets/js/jquery-sortable.js"></script> 
		-->
        <script src="<?=site_url()?>assets/vendors/choices.js/choices.min.js"></script>
        <script src="<?=site_url()?>assets/vendors/ckeditor/ckeditor.js"></script>
        <script src="<?=site_url()?>assets/vendors/taginput/tagsinput.js"></script> 
		<script src="<?=site_url()?>assets/vendors/simple-datatables/simple-datatables.js"></script>
    
		<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        
        <script src="<?=site_url()?>assets/js/main.js"></script> 
	 
		<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script> 
		<script>  
		
			
			var firebaseConfig = {
				apiKey: "AIzaSyBmG7zLAtmT_MjcMR9M6WGpOguaE8BRn3c",
				authDomain: "extracards-77a65.firebaseapp.com",
				projectId: "extracards-77a65",
				storageBucket: "extracards-77a65.appspot.com",
				messagingSenderId: "749771690290",
				appId: "1:749771690290:web:eebcf6c9606dd110f4c72b",
				measurementId: "${config.measurementId}"
			}; 
			/*
			const firebaseConfig = {
				apiKey: "AIzaSyDpEj1DsnAR_D8l3o7fWBarof5GzBEcbbs",
				authDomain: "alaa1-6d57a.firebaseapp.com",
				projectId: "alaa1-6d57a",
				storageBucket: "alaa1-6d57a.appspot.com",
				messagingSenderId: "326280444803",
				appId: "1:326280444803:web:f43c29443d663bb832d4b6",
				measurementId: "G-P7P76E8860"
			};*/
			  
			firebase.initializeApp(firebaseConfig);
			const messaging = firebase.messaging();
		  
			function initFirebaseMessagingRegistration() {
				messaging
				.requestPermission()
				.then(function () {
					return messaging.getToken()
				})
				.then(function(token) {
					console.log(token);
				});
			}  
			  
			messaging.onMessage(function(payload) {
				const noteTitle = payload.notification.title;
				const noteOptions = {
					body: payload.notification.body,
					icon: payload.notification.icon,
				};
				new Notification(noteTitle, noteOptions);
			});
			
			initFirebaseMessagingRegistration();
			
		</script>
    </body>
</html>


