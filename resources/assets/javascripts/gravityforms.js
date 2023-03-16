/**
 * Class for Gravity forms functions
 */
class GravityForms {
	/**
	 * This runs on load
	 *
	 * @param {Object} gform
	 */
	constructor(gform) {
		this.gform = gform;
		this.formTextarea = this.gform.querySelectorAll('textarea');
		this.gformBtn = this.gform.querySelector('.gform_button[type="submit"]');
	}

	/**
	 * Initialize function
	 *
	 * @return {void}
	 */
	init() {
		this.addEventListeners();
	}

	/**
	 * Adding event listeners for the gravity forms
	 *
	 * @return {void}
	 */
	addEventListeners() {
		jQuery(document).on('gform_post_render', this.formRender.bind(this));
		this.gformBtn.addEventListener('click', this.submitAnimation.bind(this));
		this.handleTextArea(this.formTextarea);
	}

	/**
	 * Animation on form submit
	 *
	 * @return {void}
	 */
	submitAnimation() {
		this.gform.classList.add('submitting');
	}

	/**
	 * Set event listeners on textarea inputs
	 *
	 * @param {Array} formTextarea
	 * @return {void}
	 */
	handleTextArea(formTextarea) {
		formTextarea.forEach((el) => {
			el.addEventListener('input', (e) => {
				this.calculateTextareaHeight(el);
			});
		});
	}

	/**
	 * Functions on form render
	 *
	 * @return {void}
	 */
	formRender() {
		const textAreas = this.gform.querySelectorAll('textarea');
		this.gform.classList.remove('submitting');
		textAreas.forEach((el) => {
			this.calculateTextareaHeight(el);
		});
		this.handleTextArea(textAreas);
	}

	/**
	 * Calculate textareas height on input
	 *
	 * @param {Object} textarea
	 * @return {void}
	 */
	calculateTextareaHeight(textarea) {
		if (textarea.length <= 0) {
			return;
		}

		const el = textarea;
		let offset = textarea.dataset['autoresize-offset'] || false;

		if (offset === false) {
			offset = el.offsetHeight - el.clientHeight;
			textarea.dataset[('autoresize-offset', offset)];
		}

		textarea.style.minHeight = 'auto';
		textarea.style.minHeight = el.scrollHeight + offset + 'px';
	}
}

document.querySelectorAll('.gform_wrapper').forEach((item) => {
	const gravityForms = new GravityForms(item);
	gravityForms.init();
});
