/*
 * Basic struture of Plugin
 */
var RoboCrop = function() {
	this.icons = {
		apply: '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 442.533 442.533" xml:space="preserve"><path fill="#fff" d="M434.539,98.499l-38.828-38.828c-5.324-5.328-11.799-7.993-19.41-7.993c-7.618,0-14.093,2.665-19.417,7.993L169.59,247.248   l-83.939-84.225c-5.33-5.33-11.801-7.992-19.412-7.992c-7.616,0-14.087,2.662-19.417,7.992L7.994,201.852   C2.664,207.181,0,213.654,0,221.269c0,7.609,2.664,14.088,7.994,19.416l103.351,103.349l38.831,38.828   c5.327,5.332,11.8,7.994,19.414,7.994c7.611,0,14.084-2.669,19.414-7.994l38.83-38.828L434.539,137.33   c5.325-5.33,7.994-11.802,7.994-19.417C442.537,110.302,439.864,103.829,434.539,98.499z"/></svg>',
        cancel: '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 511.63 511.631" xml:space="preserve"><path fill="#fff" d="M496.5,233.842c-30.841-76.706-114.112-115.06-249.823-115.06h-63.953V45.693c0-4.952-1.809-9.235-5.424-12.85   c-3.617-3.617-7.896-5.426-12.847-5.426c-4.952,0-9.235,1.809-12.85,5.426L5.424,179.021C1.809,182.641,0,186.922,0,191.871   c0,4.948,1.809,9.229,5.424,12.847L151.604,350.9c3.619,3.613,7.902,5.428,12.85,5.428c4.947,0,9.229-1.814,12.847-5.428   c3.616-3.614,5.424-7.898,5.424-12.848v-73.094h63.953c18.649,0,35.349,0.568,50.099,1.708c14.749,1.143,29.413,3.189,43.968,6.143   c14.564,2.95,27.224,6.991,37.979,12.135c10.753,5.144,20.794,11.756,30.122,19.842c9.329,8.094,16.943,17.7,22.847,28.839   c5.896,11.136,10.513,24.311,13.846,39.539c3.326,15.229,4.997,32.456,4.997,51.675c0,10.466-0.479,22.176-1.428,35.118   c0,1.137-0.236,3.375-0.715,6.708c-0.473,3.333-0.712,5.852-0.712,7.562c0,2.851,0.808,5.232,2.423,7.136   c1.622,1.902,3.86,2.851,6.714,2.851c3.046,0,5.708-1.615,7.994-4.853c1.328-1.711,2.561-3.806,3.71-6.283   c1.143-2.471,2.43-5.325,3.854-8.562c1.431-3.237,2.43-5.513,2.998-6.848c24.17-54.238,36.258-97.158,36.258-128.756   C511.63,291.039,506.589,259.344,496.5,233.842z"/></svg>',
        flip_x: '<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 444.819 444.819" xml:space="preserve"><path fill="#fff" d="M352.025,196.712L165.884,10.848C159.029,3.615,150.469,0,140.187,0c-10.282,0-18.842,3.619-25.697,10.848L92.792,32.264   c-7.044,7.043-10.566,15.604-10.566,25.692c0,9.897,3.521,18.56,10.566,25.981l138.753,138.473L92.786,361.168   c-7.042,7.043-10.564,15.604-10.564,25.693c0,9.896,3.521,18.562,10.564,25.98l21.7,21.413   c7.043,7.043,15.612,10.564,25.697,10.564c10.089,0,18.656-3.521,25.697-10.564l186.145-185.864   c7.046-7.423,10.571-16.084,10.571-25.981C362.597,212.321,359.071,203.755,352.025,196.712z"/></svg>',
        flip_y: '<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 444.819 444.819" xml:space="preserve"><path fill="#fff" d="M433.968,278.657L248.387,92.79c-7.419-7.044-16.08-10.566-25.977-10.566c-10.088,0-18.652,3.521-25.697,10.566   L10.848,278.657C3.615,285.887,0,294.549,0,304.637c0,10.28,3.619,18.843,10.848,25.693l21.411,21.413   c6.854,7.23,15.42,10.852,25.697,10.852c10.278,0,18.842-3.621,25.697-10.852L222.41,213.271L361.168,351.74   c6.848,7.228,15.413,10.852,25.7,10.852c10.082,0,18.747-3.624,25.975-10.852l21.409-21.412   c7.043-7.043,10.567-15.608,10.567-25.693C444.819,294.545,441.205,285.884,433.968,278.657z"/></svg>',
        crop: '<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 444.819 444.819" xml:space="preserve"><path fill="#fff" d="M465.948,328.897h-63.953V85.936l70.517-70.233c1.711-1.903,2.566-4.089,2.566-6.565c0-2.478-0.855-4.665-2.566-6.567   C470.609,0.859,468.419,0,465.948,0c-2.478,0-4.668,0.855-6.57,2.57l-70.237,70.521H146.18V9.137c0-2.667-0.855-4.858-2.57-6.567   C141.897,0.859,139.71,0,137.042,0H82.227c-2.665,0-4.858,0.855-6.567,2.57c-1.711,1.713-2.57,3.903-2.57,6.567v63.954H9.136   c-2.666,0-4.856,0.854-6.567,2.568C0.859,77.372,0,79.562,0,82.226v54.818c0,2.666,0.855,4.856,2.568,6.565   c1.714,1.711,3.905,2.57,6.567,2.57h63.954V392.86c0,2.666,0.855,4.856,2.57,6.561c1.713,1.711,3.903,2.573,6.567,2.573h246.678   v63.953c0,2.663,0.855,4.854,2.566,6.564c1.708,1.711,3.898,2.566,6.57,2.566h54.816c2.666,0,4.856-0.855,6.563-2.566   c1.712-1.711,2.574-3.901,2.574-6.564v-63.953h63.953c2.662,0,4.853-0.862,6.56-2.573c1.712-1.704,2.567-3.895,2.567-6.561v-54.819   c0-2.669-0.855-4.863-2.567-6.57C470.801,329.76,468.61,328.897,465.948,328.897z M146.18,146.174h169.881L146.18,316.054V146.174z    M328.904,328.897H159.026l169.878-169.88V328.897z"/></svg>',
        invert: '<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 444.819 444.819" xml:space="preserve"><path d="M317.769,368.589c-1.712-2.094-4.09-3.142-7.132-3.142H146.181V255.81h54.814c4.948,0,9.233-1.809,12.847-5.426    c3.616-3.616,5.424-7.898,5.424-12.85c0-4.565-1.431-8.47-4.283-11.704l-91.359-109.636c-3.617-4.184-8.28-6.279-13.99-6.279    c-5.712,0-10.373,2.092-13.988,6.279L4.285,225.83C1.425,229.064,0,232.969,0,237.534c0,4.952,1.811,9.234,5.424,12.85    c3.617,3.617,7.902,5.426,12.85,5.426h54.818v118.775v45.679v3.138v3.714c0,0.574,0.094,1.67,0.284,3.288    c0.191,1.619,0.479,2.714,0.859,3.282c0.378,0.575,0.903,1.335,1.569,2.286c0.662,0.951,1.521,1.622,2.565,1.998    c1.047,0.377,2.334,0.568,3.858,0.568h274.088c2.471,0,4.613-0.903,6.42-2.711c1.807-1.807,2.71-3.948,2.71-6.42    c0-1.909-0.663-3.9-1.995-6.002L317.769,368.589z" fill="#FFFFFF"/><path d="M542.748,297.788c-3.614-3.61-7.898-5.424-12.847-5.424h-54.816V173.593V127.91v-3.14v-3.711    c0-0.572-0.096-1.665-0.288-3.287c-0.191-1.619-0.479-2.712-0.855-3.284c-0.379-0.571-0.903-1.334-1.57-2.284    c-0.667-0.949-1.522-1.617-2.57-1.999c-1.047-0.378-2.327-0.571-3.854-0.571H191.86c-2.474,0-4.611,0.905-6.423,2.712    c-1.805,1.809-2.708,3.951-2.708,6.423c0,2.093,0.662,3.996,1.997,5.71l45.679,54.818c1.713,2.284,4.093,3.426,7.137,3.426    h164.453v109.634h-54.816c-4.948,0-9.232,1.81-12.847,5.42c-3.617,3.621-5.427,7.909-5.427,12.854    c0,4.568,1.43,8.466,4.287,11.707l91.361,109.632c3.806,4.381,8.467,6.567,13.99,6.567c5.514,0,10.174-2.187,13.983-6.567    l91.361-109.632c2.851-3.241,4.284-7.139,4.284-11.707C548.176,305.689,546.361,301.405,542.748,297.788z" fill="#FFFFFF"/></svg>'
	};
	this.image = {
		cropped: false,
		max_width: 2048,
		max_height: 1556,
		zoom: {
			speed: 10
		},
		resolutions: {
			auto: {
				w: 0,
				h: 0
			},
			max: {
				w: 0,
				h: 0
			},
			small: {
				w: 0,
				h: 0
			}
		}
	};
	this.hidePageScroll = false;//true will generate error in IE
	this.imageElement = null;
	this.container;
	this.event_state = {};
	this.resize_canvas=document.createElement('canvas');
	this.orig_src = new Image();
	this.image_target;
	this.crop_canvas;
	this.cropBorder;
	this.autoSize = true;
	this.watermarks = {};

	//crop
	this.cropValues = {
		enabled: false,
		width: {
			value: 200,//default value
			resize: false,
			operator: '=',
			min: {
				value: 200,
				operator: '>=',
			},
			max: {
				value: false,
				operator: false
			}
		},
		height: {
			value: 200,//default value
			resize: false,
			operator: '=',
			min: {
				value: 200,
				operator: '>=',
			},
			max: {
				value: false,
				operator: false
			}
		}
	};
	
	//mouse
    this.mouse = {};
    this.width;
    this.height;
    this.left;
    this.top;
    this.offset;
    this.touches;

	//external events
	this.events = {
		upload: {
			before: false,
			end: false,
			progress: false
		},
		apply: null
	};

	if(!$('body #crop-editor').length > 0)
		$('body').append('<div id="crop-editor"></div>');
	
	$('#crop-editor').append('<div class="editor-busy-container"><div class="editor-busy"></div></div>');

	//Main menu
	$('#crop-editor').append('<div class="editor-main-menu"></div>');
	$('#crop-editor .editor-main-menu')
		.append('<button type="button" class="cancel">'+this.icons.cancel+'</button>')
		.append('<button type="button" class="apply">'+this.icons.apply+'</button>');

	//Left menu
	$('#crop-editor').append('<div class="image-actions"></div>');
	$('#crop-editor .image-actions')
		.append('<button type="button" class="btn-main-menu-action flip-x">'+this.icons.flip_x+'</button>')
		.append('<button type="button" class="btn-main-menu-action flip-y">'+this.icons.flip_y+'</button>')
		.append('<button type="button" class="btn-main-menu-action invert">'+this.icons.invert+'</button>')
		.append('<button type="button" class="btn-main-menu-action crop">'+this.icons.crop+'</button>');
	
	//hide left menu by default
	$('.btn-main-menu-action').hide();

	//Right menu
	$('#crop-editor').append('<div class="image-resolutions"></div>');
	$('#crop-editor .image-resolutions')
		.append('<button type="button" class="img-max">max</button>')
		.append('<button type="button" class="img-auto">auto</button>')
		.append('<button type="button" class="img-small">min</button>');
};
RoboCrop.prototype.busy = function(value) {
	if(value === true){
		if(!$(this.imageElement).find('.loader').length)
			$(this.imageElement).prepend('<div class="loader"></div>').addClass('busy');
	}else{
		$(this.imageElement).find('.loader').remove();
		$(this.imageElement).removeClass('busy');
	}
};
RoboCrop.prototype.cropInit = function() {
	var crop = $(robocrop.imageElement).data('crop');
	if(crop !== undefined){
		crop = crop.split(',');
		if(crop.length === 2){
			var regex_min = /\B(\=|\>|\<|\>\=|\<\=)(\d+)/g;
			var regex_max = /\b(\=|\>|\<|\>\=|\<\=)(\d+)/g;
			var min_w = regex_min.exec(crop[0]);
			var max_w = regex_max.exec(crop[0]);
			regex_min.lastIndex = 0;
			regex_max.lastIndex = 0;
			var min_h = regex_min.exec(crop[1]);
			var max_h = regex_max.exec(crop[1]);

			if(min_w !== null){
				this.cropValues.width.min.value = this.cropValues.width.value = parseInt(min_w[2]);
				this.cropValues.width.min.operator = min_w[1];
				this.cropValues.width.resize = min_w[1] === '=' ? false : true;
			}
			if(max_w !== null){
				this.cropValues.width.max.value = parseInt(max_w[2]);
				this.cropValues.width.max.operator = max_w[1];
			}else{
				this.cropValues.width.max.value = false;
				this.cropValues.width.max.operator = false;
			}

			if(min_h !== null){
				this.cropValues.height.min.value = this.cropValues.height.value = parseInt(min_h[2]);
				this.cropValues.height.min.operator = min_h[1];
				this.cropValues.height.resize = min_h[1] === '=' ? false : true;
			}
			if(max_h !== null){
				this.cropValues.height.max.value = parseInt(max_h[2]);
				this.cropValues.height.max.operator = max_h[1];
			}else{
				this.cropValues.height.max.value = false;
				this.cropValues.height.max.operator = false;
			}
		}
	}
};
/*
 * Valid extensions
 */
RoboCrop.prototype.toggleCrop = function(param) {
		this.cropValues.enabled = param === undefined ? !this.cropValues.enabled : (param === true ? param : false);
		if(this.cropValues.enabled){
			this.setCropArea(this.cropValues.width.value ,this.cropValues.height.value,this.cropBorder,true);
			var self = this;
			this.crop_area = $('#crop-editor .crop-area');
			this.crop_area.on('mousedown touchstart', function(e){
				self.startMoving(e,self,true);
			});
		}else{
			$('#crop-editor .crop-area').remove();
		}
};
/*
 * Valid extensions
 */
RoboCrop.prototype.validExtension = function(file, check) {
	if(file.type !== undefined){
		switch(file.type)
		{
			case "image/jpg": return true;
			case "image/jpeg": return true;
			case "image/png": return true;
			case "image/bmp": return true;
			case "image/gif": return true;
			default :return false;
		}
	}else{
		switch(file)
		{
			case "jpg": return check === true ? true : 'jpeg';
			case "jpeg": return check === true ? true : file;
			case "png": return check === true ? true : file;
			case "bmp": return check === true ? true : file;
			case "gif": return check === true ? true : file;
			default :return check === true ? false : 'png';
		}
	}
};
//After image loaded render inside editor
RoboCrop.prototype.init = function(img) {
	this.image.cropped = false;
	if(this.hidePageScroll){
		$('html,body,#crop-editor').css('overflow','hidden');
	}
	if(!$('#crop-editor .resize-image').length)
	{
		$('#crop-editor').append('<canvas class="resize-image"></canvas>');
		$('#crop-editor .resize-image').wrap('<div class="resize-container"></div>').before(
		'<span class="resize-handle resize-handle-nw"></span>').before(
		'<span class="resize-handle resize-handle-ne"></span>').after(
		'<span class="resize-handle resize-handle-se"></span>').after(
		'<span class="resize-handle resize-handle-sw"></span>');

		//Image buttons
		$('#crop-editor').find('.resize-container')
		.prepend('<button type="button" class="btn-crop-tool flip-x">'+this.icons.flip_x+'</button>')
		.prepend('<button type="button" class="btn-crop-tool flip-y">'+this.icons.flip_y+'</button>')
		.prepend('<button type="button" class="btn-crop-tool invert">'+this.icons.invert+'</button>')
		.prepend('<button type="button" class="btn-crop-tool crop">'+this.icons.crop+'</button>');
		
		this.container = $('#crop-editor .resize-container');
	}
	var canvas = $('#crop-editor .resize-image').get(0);

	if (this.autoSize == true) {
		var dim = this.getProportionalDimensions(img.width,img.height);
		canvas.width = dim['w'];
		canvas.height = dim['h'];
	} else {
		canvas.width = img.width;
		canvas.height = img.height;
	}
	
	canvas.getContext("2d").drawImage(img, 0, 0, canvas.width,canvas.height);

	this.orig_src.src = canvas.toDataURL("image/png");
	
	this.image_target = $('#crop-editor .resize-image');
	this.image_target.width = img.width;
	this.image_target.height = img.height;
	var self = this;
	this.container.on('mousedown touchstart', '.resize-handle', function(e){
		self.startResize(e);
	});
	this.container.on('mousedown touchstart', 'canvas', function(e){
		self.startMoving(e,self);
	});

    //Firefox fix, wait canvas load
    $('#crop-editor .resize-container').hide();

    //Time to update layout
    setTimeout(function(){
        $('#crop-editor .resize-container').show();

        //Adjust image to screen size
        this.resizeImage(this.image.resolutions.auto.w, this.image.resolutions.auto.h);

        this.centerImage();

        this.editorBusy(false);

        this.cropInit();

        var crop_open = $(this.imageElement).data('crop-open');
        if(crop_open === true)
            this.toggleCrop(true);
	}.bind(this), 1000);
	return true;
};
/*
 * Import an image from url
 */
RoboCrop.prototype.loadImageFromUrl = function(url) {
	this.editorBusy(true);
	if ($('#crop-editor').length && !$('#crop-editor .current-status').length)
	{
		$('#crop-editor').append('<div class="current-status"></div>');
	}
	var self = this;
	var img = new Image();
	img.onload = function() {
		return self.init(img);
	};
	if (img.addEventListener) {
		img.addEventListener('error', function(e) {
			e.preventDefault();
			return "Error: crossorigin";
		});
	} else {
		// Old IE uses .attachEvent instead
		img.attachEvent('onerror', function(e) {
			return "Error: crossorigin";
		});
	}
	img.setAttribute('crossOrigin', 'anonymous');
	$('#crop-editor .current-status').text('Loading...');
	img.src = url;
};
RoboCrop.prototype.editorBusy = function(value) {
	if(value === true){
		if(!$('#crop-editor').hasClass('busy'))
			$('#crop-editor').addClass('busy');
	}else{
		$('#crop-editor').removeClass('busy');
	}
};
RoboCrop.prototype.loadImage = function(sender) {
	this.editorBusy(true);
	var obj = sender;
	this.imageElement = $(sender).closest('.crop-element');
	if ($('#crop-editor').length && !$('#crop-editor .current-status').length)
	{
		$('#crop-editor').append('<div class="current-status"></div>');
	}
	var self = this;
	if (obj.files && obj.files[0]) {
		if(!this.validExtension(obj.files[0]))
			return 'invalid file Extension';
		var FR = new FileReader();
		FR.onload = function(e) {
			var img = new Image();
			img.onload = function() {
				return self.init(img);
			};
			img.src = e.target.result;
			//reset input
			obj.value = "";
		};
		FR.readAsDataURL(obj.files[0]);
	}
};
RoboCrop.prototype.dropImage = function(e){
	this.editorBusy(true);
	var self = this;
	this.imageElement = $(self).closest('.crop-element');
	if ($('#crop-editor').length && !$('#crop-editor .current-status').length)
		$('#crop-editor').append('<div class="current-status"></div>');
	var files = e.originalEvent.target.files || e.originalEvent.dataTransfer.files;
	if(files.length>0)
	{
		if (typeof FileReader != 'undefined' && self.validExtension(files[0]) === true) {
			var reader = new FileReader();
			reader.onload = function (e) {
				var img = new Image();
				img.onload = function() {
					return self.init(img);
				};
				img.src = e.target.result;
			};
			reader.readAsDataURL(files[0]);
		}else{
			this.editorBusy(false);
			$('#crop-editor .current-status').text('Invalid image');
		}
	}
};
/*
 * Get Proportional Dimensions
 */
RoboCrop.prototype.getProportionalDimensions = function(w,h) {
	var dimensions = new Array();
	//Max resolution
	if(w > this.image.max_width || h > this.image.max_height){
		if(this.image.max_width < w){
			this.image.resolutions.max.w = this.image.max_width;
			this.image.resolutions.max.h = ((dimensions['w'])/w)*h;

			dimensions['w'] = this.image.max_width;
			dimensions['h'] = ((dimensions['w'])/w)*h;
		}else{
			this.image.resolutions.max.h = this.image.max_height;
			this.image.resolutions.max.w = ((dimensions['h'])/h)*w;

			dimensions['h'] = this.image.max_height;
			dimensions['w'] = ((dimensions['h'])/h)*w;
		}
	}else{
		this.image.resolutions.max.w = w;
		this.image.resolutions.max.h = h;
		
		dimensions['w'] = w;	
		dimensions['h'] = h;
	}
	
	// Auto resolution
	var factor = 0.8;//80% of screen
	if(w > $('#crop-editor').width() || h > $('#crop-editor').height())
	{
		if(w > $('#crop-editor').width())
		{
			this.image.resolutions.auto.w = Math.ceil($('#crop-editor').width()*factor);
			this.image.resolutions.auto.h = Math.ceil((($('#crop-editor').width()*factor)/w)*h);
		}
		if(h > $('#crop-editor').height())
		{
			this.image.resolutions.auto.w = Math.ceil((($('#crop-editor').height()*factor)/h)*w);
			this.image.resolutions.auto.h = Math.ceil($('#crop-editor').height()*factor);
		}
	}
	else
	{
		this.image.resolutions.auto.w = Math.ceil(w);
		this.image.resolutions.auto.h = Math.ceil(h);
	}

	//Small resolution
	this.image.resolutions.small.w = Math.ceil(this.image.resolutions.auto.w/2);
	this.image.resolutions.small.h = Math.ceil(this.image.resolutions.auto.h/2);

	return dimensions;
};
/*
 * Keep touches events
 */
RoboCrop.prototype.saveEventState = function(e,crop) {
	this.event_state[crop ? 'crop_area_width':'container_width'] = this[crop ? 'crop_area':'container'].width();
	this.event_state[crop ? 'crop_area_height':'container_height'] = this[crop ? 'crop_area':'container'].height();
	this.event_state[crop ? 'crop_area_left':'container_left'] = this[crop ? 'crop_area':'container'].offset().left;
	this.event_state[crop ? 'crop_area_top':'container_top'] = this[crop ? 'crop_area':'container'].offset().top;
	this.event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX)
			+ $(window).scrollLeft();
	this.event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY)
			+ $(window).scrollTop();
	var es = this;
	if (typeof e.originalEvent.touches !== 'undefined') {
		this.event_state.touches = [];
		$.each(e.originalEvent.touches, function(i, ob) {
			es.event_state.touches[i] = {};
			es.event_state.touches[i].clientX = 0 + ob.clientX;
			es.event_state.touches[i].clientY = 0 + ob.clientY;
		});
	}
	this.event_state.evnt = e;
};
/*
 * Image resize started
 */
RoboCrop.prototype.startResize = function(e) {
	e.preventDefault();
	e.stopPropagation();
	this.saveEventState(e);
	var self = this;
	$(document).on('mousemove touchmove', function(e){
		self.resizing(e);
	});
	$(document).on('mouseup touchend', this.endResize);
};
/*
 * Image resize finished
 */
RoboCrop.prototype.endResize = function(e) {
	e.preventDefault();
	$(document).off('mouseup touchend', this.endResize);
	$(document).off('mousemove touchmove', this.resizing);
};
/*
 * Image movement start
 */
RoboCrop.prototype.startMoving = function(e,self,crop) {
	e.preventDefault();
	e.stopPropagation();
	var resize = false;
	if($(e.target).hasClass('resize-crop')){
		if($(e.target).hasClass('left')) resize = 'left';
		if($(e.target).hasClass('right')) resize = 'right';
		if($(e.target).hasClass('top')) resize = 'top';
		if($(e.target).hasClass('bottom')) resize = 'bottom';
	}
	self.saveEventState(e,crop ? true : false);
	$(document).on('mousemove touchmove', function(e){
		self.moving(e,crop,resize);
	});
	$(document).on('mouseup touchend', this.endMoving);
};
/*
 * Image movement end
 */
RoboCrop.prototype.endMoving = function(e) {
	e.preventDefault();
	$(document).off('mouseup touchend', this.endMoving);
	$(document).off('mousemove touchmove', this.moving);
};
RoboCrop.prototype.cropResize = function(position) {
	var left = $('#crop-editor').find('.crop-area').offset().left;
	var container_left = $('#crop-editor').find('.resize-container').offset().left;
	var top = $('#crop-editor').find('.crop-area').offset().top;
	var container_top = $('#crop-editor').find('.resize-container').offset().top;
	var width = $('#crop-editor').find('.crop-area').width();
	var container_width = $('#crop-editor').find('.resize-container').width();
	var height = $('#crop-editor').find('.crop-area').height();
	var container_height = $('#crop-editor').find('.resize-container').height();
	var initial_width = this.cropValues.width.initial;
	var initial_height = this.cropValues.height.initial;
	var value = 0;
	if(position === 'left'){
		var crop_btn_size = 20/2;
		value  = (left-this.mouse.x)+width-crop_btn_size;
	}else if(position === 'right'){
		var crop_btn_size = 20;
		value  = this.mouse.x-left-crop_btn_size;
	}else if(position === 'top'){
		var crop_btn_size = 20/2;
		value = (top-this.mouse.y)+height-crop_btn_size;
	}else if(position === 'bottom'){
		var crop_btn_size = 20;
		value = this.mouse.y-top-crop_btn_size;
	}

	//max size validations
	if(position === 'top' || position === 'bottom'){
		//Top limit
		if(top <= container_top && value > this.cropValues.height.value)
			return;
		//Bottom limit
		if(top+height+10 >= container_top + container_height && value > this.cropValues.height.value)
			return;
	}
	if(position === 'left' || position === 'right'){
		//Left limit
		if(left <= container_left && value > this.cropValues.width.value)
			return;
		//Right limit
		if(left+width+10 >= container_left + container_width && value > this.cropValues.width.value)
			return;
	}
	
	//resize validations
	if(position === 'left' || position === 'right')
		this.cropValues.width.value = this.validCropSize(value,this.cropValues.width);
	else
		this.cropValues.height.value = this.validCropSize(value,this.cropValues.height);

	this.setCropArea(this.cropValues.width.value ,this.cropValues.height.value,this.cropBorder,true);
};
RoboCrop.prototype.validCropSize = function(value, position) {	
	switch(position.min.operator){
		case '>=': value = value >= position.min.value ? value : position.min.value;break;
		case '<=': value = value <= position.min.value ? value : position.min.value;break;
		case '<': value = value < position.min.value ? value : position.min.value;break;
		case '>': value = value > position.min.value ? value : position.min.value;break;
		case '=': value = value == position.min.value ? value : position.min.value;break;
	}
	switch(position.max.operator){
		case '>=': value = position.max.value === false || value >= position.max.value ? value : position.max.value;break;
		case '<=': value = position.max.value === false || value <= position.max.value ? value : position.max.value;break;
		case '<': value = position.max.value === false || value < position.max.value ? value : position.max.value;break;
		case '>': value = position.max.value === false || value > position.max.value ? value : position.max.value;break;
		case '=': value = position.max.value === false || value == position.max.value ? value : position.max.value;break;
	}
	return Math.ceil(value);
};
RoboCrop.prototype.cropConflict = function() {
	if(this.cropValues.enabled){
		var crop_offset = $('#crop-editor').find('.crop-area').offset();
		var container_offset = $('#crop-editor').find('.resize-container').offset();
		if(container_offset == undefined || crop_offset == undefined)
			return false;
		var crop_size = {
			'width':$('#crop-editor').find('.crop-area').width(),
			'height':$('#crop-editor').find('.crop-area').height()
		};
		var container_size = {
			'width':$('#crop-editor').find('.resize-container').width(),
			'height':$('#crop-editor').find('.resize-container').height()
		};
		//Bottom limit
		var container_padding_bottom = 12;
		if((container_offset.top+container_size.height-container_padding_bottom) - (crop_offset.top+crop_size.height) <= 0){
			return true;
		}

		//Right limit
		var container_padding_right = 8;
		if((container_offset.left+container_size.width-container_padding_right) - (crop_offset.left+crop_size.width) <= 0){
			return true;
		}
	}
	return false;
};
/*
 * Move the image using pan
 */
RoboCrop.prototype.moving = function(e,crop,resize) {
	e.preventDefault();
	e.stopPropagation();
	this.touches = e.originalEvent.touches;
	
	this.mouse.x = (e.clientX || e.pageX || (this.touches !== undefined && this.touches[0].clientX)) + $(window).scrollLeft();
	this.mouse.y = (e.clientY || e.pageY || (this.touches !== undefined && this.touches[0].clientY)) + $(window).scrollTop();

	if(crop && resize){
		this.cropResize(resize);
		return;
	}

	var element = crop ? this.crop_area : this.container;
	var element_left = crop ? this.event_state.crop_area_left : this.event_state.container_left;
	var element_top = crop ? this.event_state.crop_area_top : this.event_state.container_top;
	var element_height = crop ? this.event_state.crop_area_height : this.event_state.container_height;
	var element_width = crop ? this.event_state.crop_area_width : this.event_state.container_width;

	var top = this.mouse.y - (this.event_state.mouse_y - element_top); 
	var left = this.mouse.x - (this.event_state.mouse_x - element_left); 
	var crop_offset = $('#crop-editor').find('.crop-area').offset();
	var container_offset = $('#crop-editor').find('.resize-container').offset();
	var crop_size = {
		'width':$('#crop-editor').find('.crop-area').width(),
		'height':$('#crop-editor').find('.crop-area').height()
	};
	var container_size = {
		'width':$('#crop-editor').find('.resize-container').width(),
		'height':$('#crop-editor').find('.resize-container').height()
	};

	//keep button visible
	if(container_offset.left <= 0 || container_offset.top <= 0){
		$('.btn-main-menu-action').show(200);
		$('.btn-crop-tool').hide(200);
	}else{
		$('.btn-main-menu-action').hide(200);
		$('.btn-crop-tool').show(200);
	}
	
	if(this.cropValues.enabled && crop){
		//Top limit
		if(crop_offset.top-container_offset.top <= 0){
			if(top <= element_top)
				top = container_offset.top;
		}

		//Left limit
		if(crop_offset.left-container_offset.left <= 0){
			if(left <= element_left)
				left = container_offset.left;
		}
		
		//Bottom limit
		var container_padding_bottom = 12;
		if((container_offset.top+container_size.height-container_padding_bottom) - (crop_offset.top+crop_size.height) <= 0){
			if((top+crop_size.height)>(container_offset.top+container_size.height-container_padding_bottom))
				top = container_offset.top-container_padding_bottom+(container_size.height-crop_size.height);
		}

		//Right limit
		var container_padding_right = 8;
		if((container_offset.left+container_size.width-container_padding_right) - (crop_offset.left+crop_size.width) <= 0){
			if((left+crop_size.width)>(container_offset.left+container_size.width-container_padding_right))
				left = container_offset.left-container_padding_right+(container_size.width-crop_size.width);
		}
	}
	
	element.offset({
		'left' : left,
		'top' : top
	});
	
	if (this.event_state.touches && this.event_state.touches.length > 1
			&& this.touches.length > 1) {
		var width = element_width, height = element_height;
		var a = this.event_state.touches[0].clientX
				- this.event_state.touches[1].clientX;
		a = a * a;
		var b = this.event_state.touches[0].clientY
				- this.event_state.touches[1].clientY;
		b = b * b;
		var dist1 = Math.sqrt(a + b);
		a = e.originalEvent.touches[0].clientX - this.touches[1].clientX;
		a = a * a;
		b = e.originalEvent.touches[0].clientY - this.touches[1].clientY;
		b = b * b;
		var dist2 = Math.sqrt(a + b);
		var ratio = dist2 / dist1;
		width = width * ratio;
		height = height * ratio;
		if(crop !== true){
			this.resizeImage(width, height);
			this.setChangesStateOn(true);
		}
	}
};
/*
 * Handle the resize request
 */
RoboCrop.prototype.resizing = function(e) {
	this.offset = this.container.offset();
	this.mouse.x = (e.clientX || e.pageX || (e.originalEvent.touches !== undefined && e.originalEvent.touches[0].clientX)) + $(window).scrollLeft();
	this.mouse.y = (e.clientY || e.pageY || (e.originalEvent.touches !== undefined && e.originalEvent.touches[0].clientY)) + $(window).scrollTop();
	if ($(this.event_state.evnt.target).hasClass('resize-handle-se')) {
		this.width = this.mouse.x - this.event_state.container_left;
		this.height = this.mouse.y - this.event_state.container_top;
		this.left = this.event_state.container_left;
		this.top = this.event_state.container_top;
	} else if ($(this.event_state.evnt.target).hasClass('resize-handle-sw')) {
		this.width = this.event_state.container_width
				- (this.mouse.x - this.event_state.container_left);
		this.height = this.mouse.y - this.event_state.container_top;
		this.left = this.mouse.x;
		this.top = this.event_state.container_top;

	} else if ($(this.event_state.evnt.target).hasClass('resize-handle-nw')) {
		this.width = this.event_state.container_width
				- (this.mouse.x - this.event_state.container_left);
		this.height = this.event_state.container_height
				- (this.mouse.y - this.event_state.container_top);
		this.left = this.mouse.x;
		this.top = this.mouse.y;
		if (this.constrain || e.shiftKey) {
			this.top = this.mouse.y - ((this.width / this.orig_src.width * this.orig_src.height) - this.height);
		}
	} else if ($(this.event_state.evnt.target).hasClass('resize-handle-ne')) {
		this.width = this.mouse.x - this.event_state.container_left;
		this.height = this.event_state.container_height
				- (this.mouse.y - this.event_state.container_top);
		this.left = this.event_state.container_left;
		this.top = this.mouse.y;
		if (this.constrain || e.shiftKey) {
			this.top = this.mouse.y
					- ((this.width / this.orig_src.width * this.orig_src.height) - this.height);
		}
	}
	if (this.constrain || e.shiftKey) {
		this.height = this.width / this.orig_src.width * this.orig_src.height;
	}
	if (this.width > 0 && this.height > 0) {
		
		//size validation
		var container_padding = 8;
		var crop_offset = $('#crop-editor').find('.crop-area').offset();
		var container_offset = $('#crop-editor').find('.resize-container').offset();
		var crop_size = {
			'width':$('#crop-editor').find('.crop-area').width(),
			'height':$('#crop-editor').find('.crop-area').height()
		};
		var container_size = {
			'width':$('#crop-editor').find('.resize-container').width(),
			'height':$('#crop-editor').find('.resize-container').height()
		};

		if(this.cropValues.enabled){
			//Right size validation
			if(this.width+container_offset.left-container_padding <= crop_offset.left+crop_size.width)
				return;

			//Bottom size validation
			if(this.height+container_offset.top-container_padding <= crop_offset.top+crop_size.height)
				return;
		}

		this.resizeImage(this.width, this.height);
		this.container.offset({
			'left' : this.left,
			'top' : this.top
		});
	}
	$('#crop-editor .current-status').text(this.getImageSize()['w']+'x'+this.getImageSize()['h']);
};
/*
 * Return the current image size
 */
RoboCrop.prototype.getImageSize = function() {
	var dimensions = new Array();
	dimensions['w'] = ($('#crop-editor .resize-image').attr('width') !== undefined) ? $('#crop-editor .resize-image').attr('width') : 0;
	dimensions['h'] = ($('#crop-editor .resize-image').attr('height') !== undefined) ? $('#crop-editor .resize-image').attr('height') : 0;
	return dimensions;
};
/*
 * Resize the image using corner buttons
 */
RoboCrop.prototype.resizeImage = function(width, height) {
	width = Math.ceil(width);
	height = Math.ceil(height);
	this.resize_canvas.width = width;
	this.resize_canvas.height = height;
	this.resize_canvas.getContext('2d').drawImage(this.orig_src, 0, 0, width, height);
	this.image_target.width = width;
	this.image_target.height = height;
	$('#crop-editor .resize-image').attr('width',Math.ceil(width));
	$('#crop-editor .resize-image').attr('height',Math.ceil(height));
	this.image_target.get(0).getContext('2d').drawImage(this.resize_canvas, 0, 0);

	$('#crop-editor .current-status').text(this.getImageSize()['w']+'x'+this.getImageSize()['h']);

	//disable crop if crop area is to big
	if(this.cropConflict()){
		$('#crop-editor').find('.crop-area').remove();
		this.cropValues.enabled = false;
	}
};
/*
 * Define de crop area
 */
RoboCrop.prototype.setCropArea = function(width, height, border, apply) {
	if(width > $('#crop-editor').find('.resize-container').width() || height > $('#crop-editor').find('.resize-container').height()){
		this.cropValues.enabled = false;
		$('#crop-editor .current-status').text('Picture is too small to be cropped.');
		return;
	}

	border = (typeof border === 'undefined') ? 4 : border;
	this.cropBorder = border;
	this.cropValues.width.value  = width;
	this.cropValues.height.value = height;
	if(apply !== true)
		return;
	var areaBorder = 0;
	width += areaBorder;
	height += areaBorder;
	if(!$('#crop-editor').find('.resize-container .crop-area').length)
		$('#crop-editor').find('.resize-container').prepend('<div class="crop-area"><span class="crop-size">200x200</span><span class="resize-crop top"></span><span class="resize-crop bottom"></span><span class="resize-crop left"></span><span class="resize-crop right"></span></div>');
	
	//remove previous resize state
	$('#crop-editor').find('.crop-area').removeClass('resize-w');
	$('#crop-editor').find('.crop-area').removeClass('resize-h');

	//resize width available
	if(this.cropValues.width.resize)
		$('#crop-editor').find('.crop-area').addClass('resize-w');
	//resize height available
	if(this.cropValues.height.resize)
		$('#crop-editor').find('.crop-area').addClass('resize-h');
	
	$('#crop-editor .crop-area').css({
	   'width' : this.cropValues.width.value +(this.cropBorder*2),
	   'height' : this.cropValues.height.value+(this.cropBorder*2),
	   'margin-left' : -1*((this.cropValues.width.value +(this.cropBorder*2))/2),
	   'margin-top' : -1*((this.cropValues.height.value+(this.cropBorder*2))/2)
	});

	//size label
	$('#crop-editor').find('.crop-size').text(this.cropValues.width.value+'x'+this.cropValues.height.value);
};
/*
 * Center image element
 */
RoboCrop.prototype.centerImage = function() {
	var left = $('#crop-editor').offset().left+($('#crop-editor').width() / 2 - this.container.width() / 2);
	var top = ($('#crop-editor').height()/2) - ($('#crop-editor .resize-container').height()/2);
	this.container.animate({
		'left' : left,
		'top' : top
	}, 10);
};
/*
 * Flip the image X
 */
RoboCrop.prototype.flipX = function() {
	this.editorBusy(true);

	//Time to update layout
	setTimeout(function(){
		//flip based on max size
		var current_w = this.image_target.width;
		var current_h = this.image_target.height;
		this.resizeImage(this.image.resolutions.max.w,this.image.resolutions.max.h);
		
		var ctx = this.image_target.get(0).getContext('2d');
		var w = ctx.canvas.width;
		var h = ctx.canvas.height;
		ctx.clearRect(0,0, w, h);
		ctx.save();
		ctx.scale(-1, 1);
		ctx.drawImage(this.orig_src, w * -1, 0, w, h);
		ctx.restore();
		this.orig_src.src = this.image_target.get(0).toDataURL("image/png");

		//resize back to current size
		this.resizeImage(current_w,current_h);

		this.editorBusy(false);
	}.bind(this), 10);
};
/*
 * Flip the image Y
 */
RoboCrop.prototype.flipY = function() {
	this.editorBusy(true);

	//Time to update layout
	setTimeout(function(){
		//flip based on max size
		var current_w = this.image_target.width;
		var current_h = this.image_target.height;
		this.resizeImage(this.image.resolutions.max.w,this.image.resolutions.max.h);

		var ctx = this.image_target.get(0).getContext('2d');
		var w = ctx.canvas.width;
		var h = ctx.canvas.height;
		ctx.clearRect(0,0, w, h);
		ctx.save();
		ctx.scale(1, -1);
		ctx.drawImage(this.orig_src, 0, h * -1, w, h);
		ctx.restore();
		this.orig_src.src = this.image_target.get(0).toDataURL("image/png");

		//resize back to current size
		this.resizeImage(current_w,current_h);
		
		this.editorBusy(false);
	}.bind(this), 10);
};
/*
 * Invert image dimensions
 */
RoboCrop.prototype.invertDimensions = function() {
	var ctx = this.image_target.get(0).getContext('2d');
	var w = ctx.canvas.width;
	var h = ctx.canvas.height;
	this.resizeImage(h,w);
	this.centerImage();
};
/*
 * RoboCrop the image
 */
RoboCrop.prototype.crop = function() {
	this.image.cropped = true;
	var crop_canvas, left = $('#crop-editor .crop-area').offset().left
			- this.container.offset().left, top = $('#crop-editor .crop-area').offset().top
			- this.container.offset().top, width = $('#crop-editor .crop-area').width(), height = $('#crop-editor .crop-area').height();

	crop_canvas = document.createElement('canvas');

	crop_canvas.width = width;
	crop_canvas.height = height;
	
	crop_canvas.getContext('2d').drawImage(this.image_target.get(0), left+this.cropBorder, top+this.cropBorder, width, height, 0, 0, width, height);
	
	this.orig_src.src = crop_canvas.toDataURL("image/png");

	$('#crop-editor .resize-image').get(0).getContext('2d').clearRect(0, 0, $('#crop-editor .resize-image').width(), $('#crop-editor .resize-image').height());
	
	width = Math.ceil(width);
	height = Math.ceil(height);
	this.resize_canvas.width = width;
	this.resize_canvas.height = height;
	this.image_target.width = width;
	this.image_target.height = height;
	$('#crop-editor .resize-image').attr('width',width);
	$('#crop-editor .resize-image').attr('height',height);
    
	this.centerImage();
	this.image_target.get(0).getContext('2d').drawImage(crop_canvas, 0, 0);
	$('#crop-editor .current-status').text(this.getImageSize()['w']+'x'+this.getImageSize()['h']);
};
/*
 * Get the current image as base64 image
 */
RoboCrop.prototype.getImageBase64 = function(format) {
	if(!$('#crop-editor .resize-container').length)
		return false;
	if(format !== 'png' 
	&& format !== 'jpeg'
	&& format !== 'jpg'
	&& format !== 'gif'
	&& format !== 'bmp')
		return false;//"invalid format";

	if(this.image_target === undefined)
		return false;//"image not loaded";
	return this.image_target.get(0).toDataURL("image/"+format);
};
/*
 * Remove the current image
 */
RoboCrop.prototype.clearImage = function() {
	if($('#crop-editor .resize-image').get(0) !== undefined){
		$('#crop-editor .resize-image').get(0).getContext('2d').clearRect(0, 0, $('#crop-editor .resize-image').width(), $('#crop-editor .resize-image').height());
		this.orig_src.src = $('#crop-editor .resize-image').get(0).toDataURL("image/png");
	}
	$('#crop-editor .resize-container').remove();
	$('#crop-editor .current-status').text('');
};
/*
 * Add Watermark
 */
RoboCrop.prototype.addWatermark = function(watermark) {
	this.busy(true);
	if(watermark.margin_top == undefined)
		watermark.margin_top = 0;
	if(watermark.margin_right == undefined)
		watermark.margin_right = 0;
	if(watermark.margin_bottom == undefined)
		watermark.margin_bottom = 0;
	if(watermark.margin_left == undefined)
		watermark.margin_left = 0;
	if(watermark.opacity == undefined)
		watermark.opacity = 1;
		
	var self = this;
	var img = new Image();
	img.onload = function() {
		var ctx = self.image_target.get(0).getContext('2d');
		var canvas = $('#crop-editor .resize-image').get(0);
		var w = canvas.width;
		var h = canvas.height;
		ctx.save();			

		var margin_x = watermark.margin_left-watermark.margin_right;
		var margin_y = watermark.margin_top-watermark.margin_bottom;
		
		ctx.globalAlpha = watermark.opacity;
		switch(watermark.position){
			case "top-left": ctx.drawImage(img, 0+watermark.margin_x, 0+margin_y); break;
			case "bottom-left": ctx.drawImage(img, 0+margin_x, h-img.height+margin_y); break;
			case "top-right": ctx.drawImage(img, w-img.width+margin_x, 0+margin_y); break;
			case "center": ctx.drawImage(img, w/2-img.width/2+margin_x, h/2-img.height/2+margin_y); break;
			case "bottom-right": ctx.drawImage(img, w-img.width+margin_x, h-img.height+margin_y); break;
			default: ctx.drawImage(img, w-img.width+margin_x, h-img.height+margin_y); break;
		}
		ctx.restore();
		var ext = $(self.imageElement).data('ext');
		ext = self.validExtension(ext ? ext : 'png');
		self.orig_src.src = self.image_target.get(0).toDataURL("image/"+ext);
		self.apply(self.orig_src.src);
	};
	if (img.addEventListener) {
		img.addEventListener('error', function(e) {
			e.preventDefault();
			return "Error: crossorigin";
		});
	} else {
		// Old IE uses .attachEvent instead
		img.attachEvent('onerror', function(e) {
			return "Error: crossorigin";
		});
	}
	img.setAttribute('crossOrigin', 'anonymous');
	img.src = watermark.file;
};
RoboCrop.prototype.uploadPicture = function(picture,url){
	var sender = this;
	var data = new FormData();
	data.append('picture', JSON.stringify(picture));
    var request = new XMLHttpRequest();
	if(this.events.upload.before){
		var additional = this.events.upload.before(picture);
		$.each(additional, function( index, newData ){
			data.append(newData.name,newData.value);
		});
	}
    request.onreadystatechange = function(){
        if(request.readyState == 4){
			try {
                var response = JSON.parse(request.response);
            } catch (e){
                response = false;
            }
            if(sender.events.upload.end !== false)
				sender.events.upload['end'](response);
        }
    };
    var progress = function(e){
		if(sender.events.upload.progress !== false)
			sender.events.upload['progress'](picture,e.loaded,e.total);
    };
    request.addEventListener('progress',progress, false);
    request.upload.addEventListener('progress',progress, false);
    request.open('POST', url);
    request.send(data);
};
RoboCrop.prototype.apply = function(imageData){
	$('html,body,#crop-editor').css('overflow','initial');
	this.busy(true);
	var ext = $(this.imageElement).data('ext');
	ext = this.validExtension(ext ? ext : 'png');
	var imageUrl = imageData === undefined ? this.getImageBase64(ext) : imageData;
	var fileExt = imageUrl.substring("data:image/".length, imageUrl.indexOf(";base64"));
	ext = fileExt === 'png' ? fileExt : $(this.imageElement).data('ext');

	$(this.imageElement).find('img').first().attr('src',imageUrl);
	var name = $(this.imageElement).data('name');
	name = name === undefined ? 'crop_image' : name;
	if(!$(this.imageElement).find('input[type=hidden]').length){
		$(this.imageElement).append('<input type="hidden" name="'+name+'" value=""/>');
	}
	$(this.imageElement).find('input[type=hidden]').val(imageUrl);

	//upload
	var imagename = $(this.imageElement).data('imagename');
	imagename = imagename === undefined ? '' : imagename
	var url = $(this.imageElement).data('upload');
	var dim = this.getImageSize();
	var head = 'data:image/png;base64,';
	var fileSize = Math.round((imageUrl.length - head.length)*3/4);
	if(url !== undefined){
		var picture = {
			'name': name,
			'imagename': imagename,
			'ext': ext,
			'width': dim['w'],
			'height': dim['h'],
			'size': fileSize,
			'data': imageUrl
		};
		this.uploadPicture(picture,url);
	}
	this.clearImage();
	this.busy(false);

	//Mark as a not empty element
	$(this.imageElement).addClass('not-empty');

	//call apply event
	if(this.events.apply)
		this.events.apply({
			'name':name,
			'imagename': imagename,
			'ext':ext,
			'width': dim['w'],
			'height': dim['h'],
			'size':fileSize,
			'data': imageUrl
		});
};
//App
var robocrop = new RoboCrop();

//events
$(".crop-element").each(function() {
	var url = $(this).closest('.crop-element').find('img').attr('src');
	if(url !== undefined && url.length <= 0)
		$(this).addClass('not-empty');
});
$(document).on("click",".btn-crop-tool.flip-x,.btn-main-menu-action.flip-x",function() {robocrop.flipX();});
$(document).on("click",".btn-crop-tool.flip-y,.btn-main-menu-action.flip-y",function() {robocrop.flipY();});
$(document).on("click",".btn-crop-tool.invert,.btn-main-menu-action.invert",function() {robocrop.invertDimensions();});
$(document).on("click",".btn-crop-tool.crop,.btn-main-menu-action.crop",function() {robocrop.toggleCrop();});
$(document).on("click",".crop-element .edit",function(e) {
	e.preventDefault();
	e.stopPropagation();
	var url = $(this).closest('.crop-element').find('img').attr('src');
	if(url !== undefined && url.length > 0){
		
		//get original image name
		var name = url.split('\\').pop();
		var ext = name.split('.').pop();
		if(robocrop.validExtension(ext)){
			$(this).closest('.crop-element').data('imagename',name);
		}
		robocrop.clearImage();
		robocrop.imageElement = $(this).closest('.crop-element');
		robocrop.loadImageFromUrl(url);
		$('#crop-editor').addClass('open');
	}
});
$('#crop-editor').on('dragover', function(e) {
	e.stopPropagation();
	e.preventDefault();
});
$('#crop-editor').on('drop', function(e) {
	e.stopPropagation();
	e.preventDefault();

	//get original image name
	var files = e.originalEvent.target.files || e.originalEvent.dataTransfer.files;
	var file = files.length > 0 ? files[0] : false;
	if(file){
		var ext = file.name.split('.').pop();
		if(robocrop.validExtension(ext,true)){
			$(this).closest('.crop-element').data('imagename',file.name);
			robocrop.toggleCrop(false);//turn off crop
			robocrop.clearImage();
			robocrop.dropImage(e);
		}
		else{
			$('#crop-editor .current-status').text('Invalid image');
		}
	}
});
$(document).on("click","#crop-editor.busy",function(e) {
	e.preventDefault();
	e.stopPropagation();
});
$(document).on("click","#crop-editor .image-resolutions .img-max",function() {
	robocrop.resizeImage(robocrop.image.resolutions.max.w,robocrop.image.resolutions.max.h);
	robocrop.centerImage();
});
$(document).on("click","#crop-editor .image-resolutions .img-auto",function() {
	robocrop.resizeImage(robocrop.image.resolutions.auto.w,robocrop.image.resolutions.auto.h);
	robocrop.centerImage();
});
$(document).on("click","#crop-editor .image-resolutions .img-small",function() {
	robocrop.resizeImage(robocrop.image.resolutions.small.w,robocrop.image.resolutions.small.h);
	robocrop.centerImage();
});
$(document).on("click",".crop-element.busy",function(e) {
	e.preventDefault();
	e.stopPropagation();
});
$(document).on("click","#crop-editor .editor-main-menu .cancel",function() {
	robocrop.clearImage();
	$('html,body,#crop-editor').css('overflow','initial');
	$('#crop-editor').removeClass('open');
});
$(document).on("change",'.crop-element input:file',function() {
	
	//get original image name
	var name = $(this).val().split('\\').pop();
	var ext = name.split('.').pop();
	if(robocrop.validExtension(ext))
		$(this).closest('.crop-element').data('imagename',name);

	robocrop.clearImage();
	robocrop.loadImage(this);
	$('#crop-editor').addClass('open');
});
$(document).on("click","#crop-editor .editor-main-menu .apply",function() {
	if(robocrop.cropValues.enabled){
		robocrop.crop();
		robocrop.toggleCrop(false);
	}
	//RoboCrop required validation
	var crop_required = $(robocrop.imageElement).data('crop-required');
	var width = $('#crop-editor .resize-image').width();
	var height = $('#crop-editor .resize-image').height();
	var valid_width = robocrop.validCropSize(width,robocrop.cropValues.width);
	var valid_height = robocrop.validCropSize(height,robocrop.cropValues.height);
	if(crop_required === true && (width != valid_width  || height != valid_height)){
		$('#crop-editor .current-status').text('RoboCrop is required');
		return;
	}

	var watermark = $(robocrop.imageElement).data('watermark');
	if(name !== undefined && robocrop.watermarks[watermark] !== undefined){
		robocrop.addWatermark(robocrop.watermarks[watermark]);
	}else{
		robocrop.apply();
	}
	$('#crop-editor').removeClass('open');
});

//IE, Opera, Safari
$('#crop-editor').bind('mousewheel', function(e){
	if($('#crop-editor').hasClass('busy'))
		return;
	var w = parseInt(robocrop.getImageSize()['w']);
	var h = parseInt(robocrop.getImageSize()['h']);
	if(e.originalEvent.wheelDelta /120 > 0) {
		//scroll down
		robocrop.resizeImage(w+robocrop.image.zoom.speed,h+robocrop.image.zoom.speed);
	}
	else{
		//scroll up
		if(w-robocrop.image.zoom.speed > 50 && h-robocrop.image.zoom.speed > 50)
			robocrop.resizeImage(w-robocrop.image.zoom.speed,h-robocrop.image.zoom.speed);
	}
	robocrop.centerImage();
});
//Firefox
 $('#crop-editor').bind('DOMMouseScroll', function(e){
	if($('#crop-editor').hasClass('busy'))
		return;
	var w = parseInt(robocrop.getImageSize()['w']);
	var h = parseInt(robocrop.getImageSize()['h']);
	if(e.originalEvent.detail > 0) {
		//scroll down
		robocrop.resizeImage(w+robocrop.image.zoom.speed,h+robocrop.image.zoom.speed);
	}else {
		//scroll up
		if(w-robocrop.image.zoom.speed > 50 && h-robocrop.image.zoom.speed > 50)
			robocrop.resizeImage(w-robocrop.image.zoom.speed,h-robocrop.image.zoom.speed);
	}
	robocrop.centerImage();
	//prevent page fom scrolling
	return false;
 });