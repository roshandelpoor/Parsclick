persian = {
	'0' : '&#1776;',
	'1' : '&#1777;',
	'2' : '&#1778;',
	'3' : '&#1779;',
	'4' : '&#1780;',
	'5' : '&#1781;',
	'6' : '&#1782;',
	'7' : '&#1783;',
	'8' : '&#1784;',
	'9' : '&#1785;',
	':' : ':',
};

$(function() {

	// auto size text area
	autosize(document.querySelectorAll('textarea'));

	// SLIDE UO MESSAGES AFTER 5 SECONDS
	$('.alert-dismissible').fadeIn(500).delay(7000).fadeOut(500).addClass('animated tada');

	// YOUTUBE INIT VIDEO PLAY
	$(".youtube").YouTubeModal({width : 640, height : 360});

	$('.collapse').css({'transition' : 'height .5s', 'overflow' : 'hidden'});

	// ACTIVATE COURSE TABS
	let hash = window.location.hash;
	hash && $('ul.nav a[href="' + hash + '"]').tab('show');

	/**
	 * This function will make menus drop automatically
	 * it targets the ul navigation and li drop-down
	 * and uses the jQuery hover() function to do that.
	 */
	$('ul.nav li.dropdown').hover(function() {
		$('.dropdown-menu', this).fadeIn();
	}, function() {
		$('.dropdown-menu', this).fadeOut('fast');
	}); // HOVER

	// SHOW TOOLTIPS
	$("[data-toggle='tooltip']").tooltip({animation : true});
	$("[data-toggle='popover']").popover({animation : true});

	// SHOW MODALS
	$('.modalphotos img').on('click', function() {
		$('#modal').modal({show : true});
		let mysrc      = this.src.substr(0, this.src.length - 7) + '.jpg';
		let modalimage = $('#modalimage');
		modalimage.css('width', "80%");
		modalimage.css('display', "block");
		modalimage.css('margin', "auto");
		modalimage.css('border-radius', "10px");
		modalimage.attr('src', mysrc);
		modalimage.on('click', function() {
			$('#modal').modal('hide');
		}); // HIDE MODAL
	}); // SHOW MODAL

	$('#notification').on('click', function() { $('#notifyModal').modal('show'); });

	// INPUT FILE STYLE
	let wrapper = $('<label/>').css({height : 0, width : 0, 'overflow' : 'hidden'});
	$(':file').wrap(wrapper);

	$('form.addtoplaylist').on('submit', function() {
		let that = $(this),
		    url  = that.attr('action'),
		    type = that.attr('method'),
		    data = {},
		    btn  = $("#btn");
		btn.prop('disabled', true);
		that.find('[name]').each(function() {
			let that   = $(this),
			    name   = that.attr('name');
			data[name] = that.val();
		});

		$.ajax({
			url     : url,
			type    : type,
			data    : data,
			success : function(html) {
				that.replaceWith('<a href="#" class="btn btn-info disabled"><i class="fa fa-check"></i> به لیست پخش اضافه شد</a>');
			}
		});
		return false;
	});

	$('form.removefromplaylist').on('submit', function() {
		let that = $(this),
		    url  = that.attr('action'),
		    type = that.attr('method'),
		    data = {},
		    btn  = $("#btn");
		btn.prop('disabled', true);
		that.find('[name]').each(function() {
			let that   = $(this),
			    name   = that.attr('name');
			data[name] = that.val();
		});

		$.ajax({
			url     : url,
			type    : type,
			data    : data,
			success : function(html) {
				that.replaceWith('<a href="#" class="btn btn-danger disabled"><i class="fa fa-check"></i> از لیست پخش حذف شد</a>');
			}
		});
		return false;
	});

	$('form.submit-comment').on('submit', function() {
		let that = $(this),
		    url  = that.attr('action'),
		    type = that.attr('method'),
		    data = {};
		that.find('[name]').each(function() {
			let that   = $(this),
			    name   = that.attr('name');
			data[name] = that.val();
		});

		$.ajax({
			url     : url,
			type    : type,
			data    : data,
			success : function(html) {
				$('.submit-comment textarea').val('');
				$('#forum').load(html + " #ajax-comments");
			}
		});
		return false;
	});

	$('form[data-remote]').on('submit', function(e) {
		let $btn = $(this).find('button').button('loading');
		setTimeout(function() {
			$btn.button('reset');
		}, 3600000); // 1000*60*60 (1 hour)
	});

	$('.confirmation').click(function(e) {
		let href = $(this).attr('href');

		swal({
			title              : "آیا مطمئن هستید؟",
			type               : "warning",
			showCancelButton   : true,
			confirmButtonColor : "#E74C3C",
			confirmButtonText  : "بله",
			cancelButtonText   : "خیر",
			closeOnConfirm     : true,
			closeOnCancel      : true
		}, function(isConfirm) {
			if (isConfirm) {
				window.location.href = href;
			}
		});

		return false;
	});

	let href     = document.location.href;
	let basename = href.substr(href.lastIndexOf('/') + 1);

	if (basename === 'faq') {
		$('a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
				let target = $(this.hash);
				target     = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html,body').animate({scrollTop : target.offset().top}, 1000);
					return false;
				}
			}
		});
	}

	setInterval(function() {
		let currentTime    = new Date();
		let currentHours   = currentTime.getHours();
		let currentMinutes = currentTime.getMinutes();
		let currentSeconds = currentTime.getSeconds();
		currentMinutes     = ( currentMinutes < 10 ? '0' : '' ) + currentMinutes;
		currentSeconds     = ( currentSeconds < 10 ? '0' : '' ) + currentSeconds;
		// let timeOfDay      = ( currentHours < 12 ) ? 'AM' : 'PM';
		// currentHours       = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
		currentHours = ( currentHours < 10 ? '0' : '' ) + currentHours;
		currentHours = ( currentHours === 0 ) ? 12 : currentHours;
		let output   = currentHours + ':' + currentMinutes + ':' + currentSeconds;
		let str      = '';
		let arr      = output.split('');

		for (let i = 0; i < arr.length; i++) {
			str += persian[arr[i]];
		}
		$('#persian-timer').html(str);
		$('#english-timer').html(output);
	}, 1000);

}); // jQuery IS LOADED -----------------------------------------------------------------------------------------------

popup = function(url, title, w, h) {
	let dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
	let dualScreenTop  = window.screenTop !== undefined ? window.screenTop : screen.top;
	title === undefined ? title = 'Parsclick' : title;
	w === undefined ? w = 1150 : w;
	h === undefined ? h = 650 : w;
	let width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
	let height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

	let left      = ((width / 2) - (w / 2)) + dualScreenLeft;
	let top       = ((height / 2) - (h / 2)) + dualScreenTop;
	let newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	// Puts focus on the newWindow
	if (window.focus) {
		newWindow.focus();
	}
};

/**
 * Variables to get the registration fields
 * @type {Element}
 */
let username      = document.getElementById('username');
let pass1         = document.getElementById('password');
let pass2         = document.getElementById('confirm_pass');
let firstname     = document.getElementById('first_name');
let lastname      = document.getElementById('last_name');
let email         = document.getElementById('email');
let message       = document.getElementById('confirmMessage');
let goodColor     = '#C8FAC8';
let badColor      = '#FAC8C8';
let mBadColor     = '#B94A48';
let usernameregex = /[^a-zA-Z0-9_.]/;
let passregex     = /[^A-Za-z0-9]/;

/**
 * Function to check the username
 * @returns {boolean} TRUE if validation passes and FALSE otherwise
 */
function checkUser() {
	if (usernameregex.test(username.value)) {
		username.style.backgroundColor = badColor;
		message.style.color            = mBadColor;
		message.innerHTML              = 'اسم کاربری نباید دارای حروف مخصوص باشد';
		return false;
	} else if (username.value.indexOf(' ') >= 0) {
		username.style.backgroundColor = badColor;
		message.style.color            = mBadColor;
		message.innerHTML              = 'در اسم کاربری نباید فاصله بکار رود';
		return false;
	} else if (username.value === '' || username.value === null) {
		username.style.backgroundColor = badColor;
		message.style.color            = mBadColor;
		message.innerHTML              = 'اسم کاربری نباید خالی بماند';
		return false;
	} else {
		username.style.backgroundColor = goodColor;
		message.style.color            = goodColor;
		message.innerHTML              = '';
		return true;
	}
}

/**
 * Function to check the first name
 * @returns {boolean} TRUE if validation passes and FALSE otherwise
 */
function checkfirstname() {
	if (firstname.value === '' || firstname.value === null || firstname.value === ' ') {
		firstname.style.backgroundColor = badColor;
		message.style.color             = mBadColor;
		message.innerHTML               = 'نام نباید خالی بماند';
		return false;
	} else {
		firstname.style.backgroundColor = goodColor;
		message.style.color             = goodColor;
		message.innerHTML               = '';
		return true;
	}
}

/**
 * Function to check the last name
 * @returns {boolean} TRUE if validation passes and FALSE otherwise
 */
function checklastname() {
	if (lastname.value === '' || lastname.value === null || lastname.value === ' ') {
		lastname.style.backgroundColor = badColor;
		message.style.color            = mBadColor;
		message.innerHTML              = "نام خانوادگی نباید خالی بماند";
		return false;
	} else {
		lastname.style.backgroundColor = goodColor;
		message.style.color            = goodColor;
		message.innerHTML              = '';
		return true;
	}
}

/**
 * Function to check the password
 * @returns {boolean} TRUE if validation passes and FALSE otherwise
 */
function checkPass() {
	if (pass1.value.length < 6) {
		pass1.style.backgroundColor = badColor;
		message.style.color         = mBadColor;
		message.innerHTML           = 'پسورد کمتر از ۶ کاراکتر است';
		return false;
	} else if (!passregex.test(pass1.value)) {
		pass1.style.backgroundColor = badColor;
		message.style.color         = mBadColor;
		message.innerHTML           = 'پسورد دارای حروف مخصوص نیست';
		return false;
	} else {
		pass1.style.backgroundColor = goodColor;
		message.style.color         = goodColor;
		message.innerHTML           = '';
		return true;
	}
}

/**
 * Function to check the password confirmation
 * @returns {boolean} TRUE if validation passes and FALSE otherwise
 */
function checkConfirmPass() {
	if (pass2.value.length < 6) {
		pass2.style.backgroundColor = badColor;
		message.style.color         = mBadColor;
		message.innerHTML           = 'پسورد کمتر از ۶ کاراکتر است';
		return false;
	} else if (!passregex.test(pass2.value)) {
		pass2.style.backgroundColor = badColor;
		message.style.color         = mBadColor;
		message.innerHTML           = 'پسوردها دارای حروف مخصوص نیستند';
		return false;
	} else if (pass1.value !== pass2.value) {
		pass2.style.backgroundColor = badColor;
		message.style.color         = mBadColor;
		message.innerHTML           = 'پسوردها مطابقت ندارند';
		return false;
	} else {
		pass2.style.backgroundColor = goodColor;
		message.style.color         = goodColor;
		message.innerHTML           = '';
		return true;
	}
}

/**
 * Function to check the email
 * @returns {boolean} TRUE if validation passes and FALSE otherwise
 */
function checkEmail() {
	let regExp = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;
	if (regExp.test(email.value) === false) {
		email.style.backgroundColor = badColor;
		message.style.color         = mBadColor;
		message.innerHTML           = 'ایمیل معتبر نیست';
		return false;
	} else {
		email.style.backgroundColor = goodColor;
		message.style.color         = goodColor;
		message.innerHTML           = '';
		return true;
	}
}

/**
 * Initializing WOW animation:
 * WOW is used when user reaches the specific height,
 * WOW used animate.css file in order to work
 */
wow = new WOW({animateClass : 'animated', offset : 100});
wow.init();
/**
 * data-wow-delay="2s"
 * data-wow-offset="300"
 * data-wow-duration="4s"
 * data-wow-iteration="infinite"
 */