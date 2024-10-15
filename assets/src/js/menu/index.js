(function ($) {
	class MenuOption {
		constructor() {
			this.initMenu();
			this.canvasMenu();
			this.megaCategoryMenu();
			this.bookmarkmsg();
		}

		initMenu() {
			if ($('.navbar-main').length) {
				$('.navbar-main .navbar-nav a').on('click', function () {
					$('.navbar-main .navbar-nav')
						.find('li.active a')
						.removeClass('active');
					$(this).parent('li a').addClass('active');
				});
			}
		}

		canvasMenu() {
			if ($('.canvas-btn').length) {
				$('.canvas-btn').on('click', function (e) {
					$('.accordion-menu .sub-menu').hide();
				});
			}

			// Toggle the sub-menu on click
			if ($('.accordion-menu').length) {
				$('.accordion-menu li.menu-item.active .arrow').click();

				$(document).on('click', '.accordion-menu .arrow', function () {
					const jQueryparent = jQuery( this ).parent();
					jQuery(this).next().stop().slideToggle();
					jQueryparent.toggleClass('open');
				});
			}
		}

		megaCategoryMenu() {
			if ($('.mega-menu-title').length) {
				// Product category menu open when click on it - Start
				$('.navbar-main .mega-menu-title').hover(
					function () {
						$('#mega_menu_block').addClass('d-block visible');
						$('#mega_menu_block').removeClass('d-none invisible');
					},
					function () {
						$('#mega_menu_block').removeClass('d-block visible');
						$('#mega_menu_block').addClass('d-none invisible');
					}
				);
				$('#mega_menu_block').hover(
					function () {
						$(this).addClass('d-block visible');
						$(this).removeClass('d-none invisible');
					},
					function () {
						$(this).removeClass('d-block visible');
						$(this).addClass('d-none invisible');
					}
				);
			}
		}

		bookmarkmsg() {
			if ($('.bookmark-btn').length) {
				$(document).on('click', '.bookmark-btn', function () {
					alert('Press Ctrl+D to bookmark this page.');
				});
			}
		}
	}

	new MenuOption();
} )( jQuery );
