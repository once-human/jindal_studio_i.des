;(function ($) {
	
	$(document).ready(ready);
	
	function ready() {
		
		let searchForm = $('form.liquid-wc-product-search'),
		searchFieldInput = $('[id*=liquid-wc-product-search-field-input-]'),
		searchFieldSelect = $('[id*=liquid-wc-product-search-field-select-]'),
		timeOut;
		
		if (!searchForm.hasClass('liquid-wc-product-search-ajax-enabled')) return;
		
		searchFieldInput.on('input', searchFieldInputChange);
		searchFieldSelect.on('change', searchFieldInputChange);
		$(window).on('click', hideSearchResults);
		
		function searchFieldInputChange() {
			let inputVal = searchFieldInput.val();
			
			if (timeOut) clearTimeout(timeOut);
			
			if (inputVal.length > 2) {
				timeOut = setTimeout(showSearchResults, 300);
			} else {
				hideSearchResults();
			}
		}
		
		function showSearchResults() {
			
			hideSearchResults();
			
			$.ajax({
				type: "post",
				url: wcLiquid.ajaxUrl,
				data: {
					action: "liquid_wc_get_products_by_input_text",
					searchText: searchFieldInput.val(),
					termId: searchFieldSelect.find('option:selected').data('term-id')
				},
				beforeSend: function () {
					searchForm.addClass('loading');
				},
				success: function (response) {
					if (response.success === true) {
						searchForm.append(response.data.html);
						viewAllInit();
						searchForm.removeClass('loading');
					}
				}
			});
		}
		
		function hideSearchResults() {
			$('.liquid-wc-product-search-results').remove();
		}
		
		function viewAllInit() {
			$(document).on('click', '.ld-wc-search-view-all', function (e) {
				e.preventDefault();
				searchForm.trigger('submit');
			});
		}
		
	}
	
})(jQuery);