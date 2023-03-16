/**
 * Class for Review functions
 */
class Review {
	/**
	 * This runs on load
	 */
	constructor() {
		this.module = '.module-gc-review';
		this.formWrapper = '.gc-review-form-wrapper';
		this.btn = document.querySelector('.gc-review-btn button');
		this.openClass = 'open';
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
	 * Eventlisteners
	 *
	 * @return {void}
	 */
	addEventlisteners() {
		this.btn.addEventListener('click', this.toggleReviewForm.bind(this));
	}

	/**
	 * Toggle review form
	 *
	 * @param {Event} e
	 * @return {void}
	 */
	toggleReviewForm(e) {
		const wrapper = e.target
			.closest(this.module)
			.querySelector(this.formWrapper);
		if (wrapper.classList.contains(this.openClass)) {
			wrapper.classList.remove(this.openClass);
			Helper.slideUp(wrapper);
		} else {
			wrapper.classList.add(this.openClass);
			Helper.slideDown(wrapper);
		}
	}
}

/**
 * Fire when DOM is ready
 */
function domReadyReview() {
	if (document.querySelector('.gc-review-btn')) {
		const review = new Review();
		review.init();
	}
}
if (
	document.readyState === 'complete' ||
	document.readyState === 'interactive'
) {
	domReadyReview();
} else {
	document.addEventListener('DOMContentLoaded', domReadyReview);
}
