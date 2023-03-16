/**
 * Class for header functions
 */
class Header {
	/**
	 * This runs on load
	 */
	constructor() {
		this.header = document.querySelector('#header');
		this.currentScrollPosition = window.pageYOffset;
		this.lastScrollPosition = this.currentScrollPosition;
		this.scrollBreakpoint = 20;
		this.bodyElem = document.querySelector('body');
		this.hasSubmenuItems = document.querySelectorAll(
			'#header .menu .menu-item-has-children > a'
		);
		this.mobileHandlers = document.querySelectorAll(
			'#mobile-menu, #mobile-icon'
		);
		this.mobileMenu = document.querySelector('#mobile-menu');
		this.mobileMenuOpened = false;
		this.mobileMenuArrows = this.mobileMenu.querySelectorAll('.menu-arrow');
	}

	/**
	 * Initialize function
	 *
	 * @return {void}
	 */
	init() {
		this.addEventlisteners();
	}

	/**
	 * Event listeners
	 *
	 * @return {void}
	 */
	addEventlisteners() {
		document
			.querySelectorAll('#mobile-icon, #mobile-menu .mobile-overlay')
			.forEach((item) => {
				item.addEventListener('click', this.showHideMobileMenu.bind(this));
			});

		if (this.mobileMenuArrows !== null) {
			this.mobileMenuArrows.forEach((item) => {
				item.addEventListener('click', this.toggleSubMenu.bind(this));
			});
		}

		window.addEventListener('load', this.handleStickyHeader.bind(this));
		window.addEventListener('scroll', this.handleStickyHeader.bind(this));
		window.addEventListener('resize', this.handleStickyHeader.bind(this));
		document.addEventListener('click', this.closeOnClick.bind(this));

		if (this.hasSubmenuItems) {
			this.hasSubmenuItems.forEach((item) => {
				item.addEventListener('click', this.handleSubMenu.bind(this));
			});
		}
	}

	/**
	 * Close elements on outside click
	 *
	 * @param {Event} e
	 * @return {void}
	 */
	closeOnClick(e) {
		if (!e.target.closest('.menu-item-has-children')) {
			document
				.querySelectorAll('#header .menu-item-has-children .sub-menu')
				.forEach((menu) => {
					menu.classList.remove('open');
				});
		}
	}

	/**
	 * Handles sub-menu classes
	 *
	 * @param {Event} e
	 * @return {void}
	 */
	handleSubMenu(e) {
		e.preventDefault();
		const subMenu = e.target.closest('.menu-item').querySelector('.sub-menu');
		subMenu.classList.toggle('open');
	}

	/**
	 * Toggle or hide mobilemeny
	 *
	 * @param {HTMLElement} el
	 * @return {void}
	 */
	showHideMobileMenu(el) {
		if (el.currentTarget.classList.contains('mobile-overlay')) {
			this.hideMobileMenu();
		} else {
			if (this.mobileMenuOpened) {
				this.hideMobileMenu();
			} else {
				this.showMobileMenu();
			}
		}
	}

	/**
	 * Hide mobile meny handler
	 *
	 * @return {void}
	 */
	hideMobileMenu() {
		this.bodyElem.classList.remove('mobile-open');
		this.mobileHandlers.forEach((item) => {
			item.classList.remove('open');
		});
		this.mobileMenuOpened = false;
	}

	/**
	 * Show mobile meny handler
	 *
	 * @return {void}
	 */
	showMobileMenu() {
		this.bodyElem.classList.add('mobile-open');
		this.mobileHandlers.forEach((item) => {
			item.classList.add('open');
		});
		this.mobileMenuOpened = true;
	}

	/**
	 * Toggle submenu in mobile
	 *
	 * @param {HTMLElement} el
	 * @return {void}
	 */
	toggleSubMenu(el) {
		const parentMenuItem = el.currentTarget.closest('.menu-item-has-children');
		if (!parentMenuItem.classList.contains('opened')) {
			parentMenuItem.classList.add('opened');
			Helper.slideDown(parentMenuItem.querySelector('.sub-menu'));
			return;
		}

		parentMenuItem.classList.remove('opened');
		Helper.slideUp(parentMenuItem.querySelector('.sub-menu'));

		/**
		 * Close all opened child-parents when main-parent is closed
		 */
		parentMenuItem.querySelectorAll('.opened').forEach((parent) => {
			parent.classList.remove('opened');
		});
		parentMenuItem.querySelectorAll('.sub-menu').forEach((subMenu) => {
			Helper.slideUp(subMenu);
		});
	}

	/**
	 * Header fixed on scroll-up
	 *
	 * @return {void}
	 */
	handleStickyHeader() {
		this.currentScrollPosition = window.pageYOffset;

		if (this.currentScrollPosition > this.scrollBreakpoint) {
			if (this.currentScrollPosition < this.lastScrollPosition) {
				this.showStickyHeader();
			} else if (this.currentScrollPosition > this.lastScrollPosition) {
				this.hideStickyHeader();
			}
		} else {
			if (this.lastScrollPosition > this.scrollBreakpoint) {
				this.hideStickyHeader();
			} else {
				this.showStickyHeader();
			}
		}

		if (this.currentScrollPosition > this.scrollBreakpoint) {
			this.header.classList.add('scrolled');
		} else {
			this.header.classList.remove('scrolled', 'nav-down', 'nav-up');
		}

		this.lastScrollPosition = this.currentScrollPosition;
	}

	/**
	 * Hide sticky header handler
	 *
	 * @return {void}
	 */
	hideStickyHeader() {
		this.header.classList.remove('nav-down');
		this.header.classList.add('nav-up');
		this.hideMobileMenu();
	}

	/**
	 * Side sticky header handler
	 *
	 * @return {void}
	 */
	showStickyHeader() {
		this.header.classList.remove('nav-up');
		this.header.classList.add('nav-down');
	}
}

/**
 * Fire when DOM is ready
 */
function runHeader() {
	const header = new Header();
	header.init();
}

if (
	document.readyState === 'complete' ||
	document.readyState === 'interactive'
) {
	runHeader();
} else {
	document.addEventListener('DOMContentLoaded', runHeader);
}
