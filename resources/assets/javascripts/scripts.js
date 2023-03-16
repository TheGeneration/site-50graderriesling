/**
 * Class for Scripts functions
 */
class Scripts {
	/**
	 * This runs on load
	 */
	constructor() {
		this.init();
	}

	/**
	 * Initialize function
	 *
	 * @return {void}
	 */
	init() {
	}
}

/**
 * Fire when DOM is ready
 */
function domReadyScripts() {
	new Scripts();
}
if (
	document.readyState === 'complete' ||
	document.readyState === 'interactive'
) {
	domReadyScripts();
} else {
	document.addEventListener('DOMContentLoaded', domReadyScripts);
}

/**
 * Handle WP a11y (DO NOT REMOVE)
 *
 */
const newWp = typeof wp !== 'undefined' ? wp : {};

newWp.a11y = {
	speak() {},
};

wp = newWp;
