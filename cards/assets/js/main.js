function slideToggle(t,e,o){0===t.clientHeight?j(t,e,o,!0):j(t,e,o)}function slideUp(t,e,o){j(t,e,o)}function slideDown(t,e,o){j(t,e,o,!0)}function j(t,e,o,i){void 0===e&&(e=400),void 0===i&&(i=!1),t.style.overflow="hidden",i&&(t.style.display="block");var p,l=window.getComputedStyle(t),n=parseFloat(l.getPropertyValue("height")),a=parseFloat(l.getPropertyValue("padding-top")),s=parseFloat(l.getPropertyValue("padding-bottom")),r=parseFloat(l.getPropertyValue("margin-top")),d=parseFloat(l.getPropertyValue("margin-bottom")),g=n/e,y=a/e,m=s/e,u=r/e,h=d/e;window.requestAnimationFrame(function l(x){void 0===p&&(p=x);var f=x-p;i?(t.style.height=g*f+"px",t.style.paddingTop=y*f+"px",t.style.paddingBottom=m*f+"px",t.style.marginTop=u*f+"px",t.style.marginBottom=h*f+"px"):(t.style.height=n-g*f+"px",t.style.paddingTop=a-y*f+"px",t.style.paddingBottom=s-m*f+"px",t.style.marginTop=r-u*f+"px",t.style.marginBottom=d-h*f+"px"),f>=e?(t.style.height="",t.style.paddingTop="",t.style.paddingBottom="",t.style.marginTop="",t.style.marginBottom="",t.style.overflow="",i||(t.style.display="none"),"function"==typeof o&&o()):window.requestAnimationFrame(l)})}

let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
for(var i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
	sidebarItems[i].querySelector('.sidebar-link').addEventListener('click', function(e) {
        e.preventDefault();
        
        let submenu = sidebarItem.querySelector('.submenu');
        if( submenu.classList.contains('active') ) submenu.style.display = "block"

        if( submenu.style.display == "none" ) submenu.classList.add('active')
        else submenu.classList.remove('active')
        slideToggle(submenu, 300)
    })
}

window.addEventListener('DOMContentLoaded', (event) => {
    var w = window.innerWidth;
    if(w < 1200) {
        document.getElementById('sidebar').classList.remove('active');
    }
});
window.addEventListener('resize', (event) => {
    var w = window.innerWidth;
    if(w < 1200) {
        document.getElementById('sidebar').classList.remove('active');
    }else{
        document.getElementById('sidebar').classList.add('active');
    }
});

document.querySelector('.burger-btn').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');
})
document.querySelector('.sidebar-hide').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('active');

})
 
// Perfect Scrollbar Init
if(typeof PerfectScrollbar == 'function') {
    const container = document.querySelector(".sidebar-wrapper");
    const ps = new PerfectScrollbar(container, {
        wheelPropagation: false
    });
}

// add page link to page item to pagination
$(".pagination li.page-item a").addClass("page-link");

// Scroll into active sidebar
//document.querySelector('.sidebar-item.active').scrollIntoView(false);

var site_url = $("#site_url").val();

// logout
function logout(){
    Swal.fire({
        icon: 'warning',
        title: "تسجيل خروج",
        text: 'هل تريد حقاً تسجيل الخروج من النظام ؟',
        showCancelButton: true,
        confirmButtonText: 'نعم',
        cancelButtonText: 'الغاء', 
        }).then((result) => { 
        if (result.isConfirmed) {
            location.href = site_url+"welcome/logout";
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    });
}


    /*---------------------------------
        img error
    ---------------------------------*/

    $(window).load(function() {
        $('img').each(function() {
            if ( !this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0){
                this.src = site_url+'assets/images/no-pic.jpg';
            }
        });
    }); 


// crop image
$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
        width:600,
        height:600,
        type:'square' //circle
    },
    boundary:{
        width: 750,
        height: 750
    }
});

$('#upload_image').on('change', function(){
    var folder = $(this).data("folder");
    
    var reader = new FileReader();
    reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function(){
            console.log('jQuery bind complete');
        });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal .crop_image').attr('data-folder', folder);
    $('#uploadimageModal').modal('show');
});

var name =$("#csrf-token").attr("name");
var token =$("#csrf-token").attr("value"); 

$('.crop_image').click(function(event){
    var folder = $(this).data("folder");
    $image_crop.croppie('result',{
        type: 'canvas',
        size: 'viewport'
    }).then(function(response){
        $.ajax({
            url: site_url+"welcome/crop_image",
            type: "POST",
            data:{
                "image": response,
                "folder": folder,
                "csrf_test_name":token
            },
            success:function(data){
                $('#uploadimageModal').modal('hide');
                $('#uploaded_image').html(data); 
                $("#upload_image_url").val($('#uploaded_image img').data("url"));
              console.log(data); 
            }
        });
    });
});


// textarea-editor
$('.textarea-editor').each(function(e){
    ClassicEditor
        .create(document.querySelector('#'+ this.id), {
            language: "ar",
            height: 500,
        })
        .then( editor => {
            editor.ui.view.editable.element.style.height = '300px';
        })
        .catch(error => {
            console.error(error);
        });
}); 

//taginput
$(".tagsinput").tagsinput();
$(".bootstrap-tagsinput input").addClass("form-control form-control-lg");

// FilePond

FilePond.registerPlugin(
    // validates the size of the file...
    FilePondPluginFileValidateSize,
    // validates the file type...
    FilePondPluginFileValidateType,

    // calculates & dds cropping info based on the input image dimensions and the set crop ratio...
    FilePondPluginImageCrop,
    // preview the image file type...
    FilePondPluginImagePreview,
    // filter the image file
//        FilePondPluginImageFilter,
    // corrects mobile image orientation...
    FilePondPluginImageExifOrientation,
    // calculates & adds resize information...
   // FilePondPluginImageResize,
);


$('.upload-img').each(function(e){
    FilePond.create( document.querySelector('#'+this.id), {
        allowImagePreview: true, 
        allowImageFilter: false,
        allowImageExifOrientation: false,
        allowImageCrop: false,
        acceptedFileTypes: ['image/png','image/jpg','image/jpeg'],
        fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise
            resolve(type);
        })
    });
});

function runToastify(res){
    Toastify({
        text: res,
        duration: 3000,
        close:true,
        gravity:"bottom",
        position: "right",
        backgroundColor: "#4fbe87",
    }).showToast();
}



// Generate a password string
function randString(id){
    var dataSet = $(id).attr('data-character-set').split(',');  
    var possible = '';
    if($.inArray('a-z', dataSet) >= 0){
        possible += 'abcdefghijklmnopqrstuvwxyz';
    }
    if($.inArray('A-Z', dataSet) >= 0){
        possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if($.inArray('0-9', dataSet) >= 0){
        possible += '0123456789';
    }
    /*
    if($.inArray('#', dataSet) >= 0){
        possible += '![]{}()%&*$#^<>~@|';
    }*/
    var text = '';
    for(var i=0; i < $(id).attr('data-size'); i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}
  
    // Create a new password on page load
    $('input[rel="gp"]').each(function(){
        $(this).val(randString($(this)));
    });
  
    // Create a new password
    $(".getNewPass").click(function(){
        var field = $(this).closest('div').find('input[rel="gp"]');
        field.val(randString(field));
    });
  
    // Auto Select Pass On Focus
    $('input[rel="gp"]').on("click", function () {
        $(this).select();
    });
  
    // View Upload pic
    
    $('.view-pic').on("click", function () {
        $('.upload-pic').change( function (){
            var location_pic = $(this).parent().find('.view-pic .preview-pic');
            readURL(this, location_pic);
        });
    });
    function readURL(input, location_pic) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                location_pic.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
	}