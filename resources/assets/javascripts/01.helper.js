/* eslint-disable no-unused-vars */

/**
 * Helper object for reusable code
 */
class Helper {
	/**
	 * Slide up the provided element
	 *
	 * @param {HTMLElement} element
	 * @param {Number} duration
	 * @return {void}
	 */
	static slideUp(element, duration = 500) {
		if (!element.gtSlideQueue) {
			element.gtSlideQueue = [];
		}

		const doSlide = () => {
			element.style.transitionProperty = 'height, margin, padding';
			element.style.transitionDuration = duration + 'ms';
			element.style.boxSizing = 'border-box';
			element.style.height = element.offsetHeight + 'px';
			element.offsetHeight;
			element.style.overflow = 'hidden';
			element.style.height = 0;
			element.style.paddingTop = 0;
			element.style.paddingBottom = 0;
			element.style.marginTop = 0;
			element.style.marginBottom = 0;

			setTimeout(() => {
				// Remove this callback from the queue
				element.gtSlideQueue.shift();

				element.style.display = 'none';
				element.style.removeProperty('height');
				element.style.removeProperty('padding-top');
				element.style.removeProperty('padding-bottom');
				element.style.removeProperty('margin-top');
				element.style.removeProperty('margin-bottom');
				element.style.removeProperty('overflow');
				element.style.removeProperty('transition-duration');
				element.style.removeProperty('transition-property');

				if (element.gtSlideQueue.length > 0) {
					// Call next slide in the queue
					element.gtSlideQueue[0]();
				}
			}, duration);
		};

		if (element.gtSlideQueue.length <= 0) {
			doSlide();
		}

		element.gtSlideQueue.push(doSlide);
	}

	/**
	 * Slide down the provided element
	 *
	 * @param {HTMLElement} element
	 * @param {Number} duration
	 * @return {void}
	 */
	static slideDown(element, duration = 500) {
		if (!element.gtSlideQueue) {
			element.gtSlideQueue = [];
		}

		const doSlide = () => {
			element.style.removeProperty('display');
			let display = window.getComputedStyle(element).display;

			if (display === 'none') {
				display = 'block';
			}

			element.style.display = display;
			const height = element.offsetHeight;
			element.style.overflow = 'hidden';
			element.style.height = 0;
			element.style.paddingTop = 0;
			element.style.paddingBottom = 0;
			element.style.marginTop = 0;
			element.style.marginBottom = 0;
			element.offsetHeight;
			element.style.boxSizing = 'border-box';
			element.style.transitionProperty = 'height, margin, padding';
			element.style.transitionDuration = duration + 'ms';
			element.style.height = height + 'px';
			element.style.removeProperty('padding-top');
			element.style.removeProperty('padding-bottom');
			element.style.removeProperty('margin-top');
			element.style.removeProperty('margin-bottom');

			setTimeout(() => {
				// Remove this callback from the queue
				element.gtSlideQueue.shift();

				element.style.removeProperty('height');
				element.style.removeProperty('overflow');
				element.style.removeProperty('transition-duration');
				element.style.removeProperty('transition-property');

				if (element.gtSlideQueue.length > 0) {
					// Call next slide in the queue
					element.gtSlideQueue[0]();
				}
			}, duration);
		};

		if (element.gtSlideQueue.length <= 0) {
			doSlide();
		}

		element.gtSlideQueue.push(doSlide);
	}
}
/* eslint-enable no-unused-vars */
