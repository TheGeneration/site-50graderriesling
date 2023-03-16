/**
 * Class for AgeValidation functions
 */
class AgeValidation {
	/**
	 * This runs on load
	 */
	constructor() {
		this.popup = document.querySelector('#age-validation');
		this.btn = this.popup.querySelector('#age-validation-btn .btn');
		this.popupClass = 'is-open';
		this.cookieName = 'age_validation';
		this.cookieLength = 1; // days
		this.delay = 0.5; // Seconds
	}

	/**
	 * Initialize function
	 *
	 * @return {void}
	 */
	init() {
		this.addEventlisteners();
		this.checkCookie();
	}

	/**
	 * Eventlisteners
	 *
	 * @return {void}
	 */
	addEventlisteners() {
		this.btn.addEventListener('click', this.confirmAge.bind(this));
	}

	/**
	 * Open age validation popup
	 *
	 * @return {void}
	 */
	openPopup() {
		setTimeout(() => {
			this.popup.classList.add(this.popupClass);
		}, this.delay * 1000);
	}

	/**
	 * Set cookie
	 *
	 * @param {String} cookieName
	 * @param {Int} value
	 * @param {Int} expiry
	 *
	 * @return {void}
	 */
	setCookie(cookieName, value, expiry) {
		const date = new Date();
		date.setTime(date.getTime() + expiry * 24 * 60 * 60 * 1000);
		const expires = 'expires=' + date.toUTCString();
		document.cookie = cookieName + '=' + value + ';' + expires + ';path=/';
	}

	/**
	 * Get cookie
	 *
	 * @param {String} cookieName
	 * @return {void}
	 */
	getCookie(cookieName) {
		const name = cookieName + '=';
		const spli = document.cookie.split(';');
		for (let j = 0; j < spli.length; j++) {
			let char = spli[j];
			while (char.charAt(0) == ' ') {
				char = char.substring(1);
			}
			if (char.indexOf(name) == 0) {
				return char.substring(name.length, char.length);
			}
		}
		return '';
	}

	/**
	 * Check cookie
	 *
	 * @return {void}
	 */
	checkCookie() {
		const cookie = this.getCookie(this.cookieName);
		if (cookie == '') {
			this.openPopup();
		}
	}

	/**
	 * Confirms age click
	 *
	 * @param {Event} e
	 * @return {void}
	 */
	confirmAge(e) {
		e.preventDefault();
		this.setCookie(this.cookieName, true, this.cookieLength);
		this.popup.classList.remove(this.popupClass);
	}
}

/**
 * Fire when DOM is ready
 */
function domReadyAgeValidation() {
	if (document.querySelector('#age-validation')) {
		const ageValidation = new AgeValidation();
		ageValidation.init();
	}
}
if (
	document.readyState === 'complete' ||
	document.readyState === 'interactive'
) {
	domReadyAgeValidation();
} else {
	document.addEventListener('DOMContentLoaded', domReadyAgeValidation);
}
