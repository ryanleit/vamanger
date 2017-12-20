var deletedAvatar = $("#deletedAvatar").val();
var validProfile = {};
var startCheck = true;
var profileForm = {
    initForm: function() {
        profileForm.formUiInit();
        profileForm.validatorForm();
       // profileForm.addEventButtonUploadClick();
       // profileForm.customizeUploadImage();
       // profileForm.removeImage();
       // profileForm.addEventSubmitForm();       
      
    },
    formUiInit: function(){
        $("#country_id").select2({
            placeholder: "Countries",
            allowClear: true,
            /*initSelection: function(element, callback) {
            // the input tag has a value attribute preloaded that points to a preselected repository's id
            // this function resolves that id attribute to an object that select2 can render
            // using its formatResult renderer - that way the repository name is shown preselected
            var id = $(element).val();
            if (id !== "") {
                $.ajax("https://api.github.com/repositories/" + id, {
                    dataType: "json"
                }).done(function(data) { callback(data); });
            }
            },*/
        });
        var telInput = $('#phone');
        telInput.intlTelInput({
            utilsScript: '/intl-tel-input/js/utils.js',
            formatOnDisplay: false,
           // autoPlaceholder: false,               
            preferredCountries: ['fr', 'us', 'vn']
        });
        telInput.on("countrychange", function(e, countryData) {
            if(countryData){
                var iso2 = countryData.iso2;
                $('#country_id').val(iso2).trigger("change");
            }
        });
       
    },    
    validatorForm: function(){
       $.validator.addMethod(
        'atLeastOneNumberAndLetter',
        function (value, element) {
            if(value ==='') return true;
            var checkPass = value.match(/^(?=\S*?[A-Z])(?=\S*?[0-9])\S{9,}$/);                    
            if (checkPass !== null) return true;

            return false;
        },
        'Min. 9 characters, 1 number, 1 capital letter.'
        );
        validProfile = $("#profile-form").validate({
            ignore: [],
            onkeyup: false,
            errorElement: "li",
            focusInvalid: true,
            focusCleanup:true,
            highlight: function (element) {
                $(element).parent().addClass('has-error');
                $(element).addClass('field-error');
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('has-error');
                $(element).removeClass('field-error');
            },            
            success: function(error,element){
                //validSignupForm.addMessageGuideForFied(error);
                profileForm.removeErrorMessage(error,element,'profile');
            },
            errorPlacement: function (error, element) {
                profileForm.showErrorMessage(error,element,'profile');
            },            
            submitHandler: function(form) {
                // do other things for a valid form
                var ntlNumber = $("#phone").intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
                if($("#phone").val() !== ''){
                    $("#phone").val(ntlNumber);
                }
                form.submit();
            },
            rules: {
                user_email: {
                    required:true,
                    email: true,
                    maxlength: 255,
                    remote: {
                        url: '/ajax/email-check',
                        type: 'post',
                        dataType: 'json',                            
                    }
                },                              
                user_password: {
                    //required: true,
                    minlength: 9,
                    atLeastOneNumberAndLetter: true
                },
                user_password_confirmation: {                          
                    equalTo: "#user-password"
                },
                company: {                    
                    maxlength: 255
                },                                     
                name: {
                    required:true,                        
                    maxlength: 255
                },
                address: {
                    //required:true,                        
                    maxlength: 255
                },                
                city: {
                    //required: true,
                    maxlength: 255
                },
                country_id: {
                    required: true
                },              
            },           
        });      
    },
    showErrorMessage: function(error, element, formType){
        if(startCheck){
            $(".alert-success").remove();
            $("#div-error-message-old").remove();
            startCheck = false;
        }
        var id = $(error).attr('id');
        $("#"+id).remove();
        console.log(error,element);       
        if($("#ul-error-messages li").length === 0 ){
            $("#div-error-messages").show();
        }

        $("#ul-error-messages").append(error);                              
    },
    
    removeErrorMessage: function(error,element,formType){
        if(startCheck){
            $("#div-error-message-old").remove();
            $(".alert-success").remove();
            startCheck = false;
        }
        $(error).remove();
       
        if($("#ul-error-messages li").length === 0 ){
           $("#div-error-messages").hide();
        }        
    },
   
    addEventSubmitForm: function(){
        $("#profile-form").submit(function(){
            $("#deletedAvatar").val(deletedAvatar);
        });
    },
     addEventButtonUploadClick: function(){
        $("#button-upload").click(function(){
            $('#avatar-img').trigger("click");
        });
    },
    removeImage: function(){
        $("#remove-image").click(function(){
            deletedAvatar = 'true';
            $('#av-preview img').remove();
            $('#av-preview').append('<img style="width:201px;height:200px;" src="/images/users/default_avatar.png" class="file-preview-image" alt="avatar default" title="avatar default">');
        });
    },
    customizeUploadImage:function(){
        $('#avatar-img').change(function(e) {
            var file = this.files[0];
            var reader = new FileReader();
            var image = new Image();
            reader.readAsDataURL(file);            
            reader.onload = function(_file) {
                image.src = _file.target.result;
                image.onload = function() {
                    if (~~(file.size / 1024) < 500) {
                        var fileExt = file.name.split('.').pop();
                        if($.inArray(fileExt,['jpeg','jpg','gif','png']) >= 0){

                            $('#av-preview img').remove();
                            $('#av-preview').append('<img style="width:201px;height:200px;" src="' + this.src + '">');
                            profileForm.displayErrorImage('',false);
                        }else{
                            var mes = fileExt + " extension is not supported!";
                           s
                            profileForm.displayErrorImage(mes,true);
                        }
                    } else {                                
                        var mes = "Image size must be less than 500Kb!.";                        
                        profileForm.displayErrorImage(mes,true);
                    }
                };
                image.onerror = function() {
                   // not image
                   //var mes = "Please choose image file!.";
                   var mes = "Image file is not valid!.";
                   profileForm.displayErrorImage(mes,true);
                };
            };
        });
    },
    displayErrorImage: function(mes,error){
        if(error){
            $("#avatar-error").html('<strong>'+mes+'</strong>');
            $("#avatar-error").show();
        }else{
            $("#avatar-error").html("");
            $("#avatar-error").hide();
        }                
    }
}
$( document ).ready(function() {profileForm.initForm();});