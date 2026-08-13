(function($) {
$(function() {
	var $searchPopup = $('.PopupSearch').first();
	var $searchAnchor = $('<span class="PopupSearchAnchor" hidden aria-hidden="true"></span>');
	var searchResultObserver = null;
	var searchOpen = false;
	if ($searchPopup.length) {
		$searchAnchor.insertBefore($searchPopup);
	}
	function adoptSearchResult() {
		var $result = $('div.title-search-result').first();
		var $titleSearch = $searchPopup.find('#title-search').first();
		if ($result.length && $titleSearch.length && !$result.closest('.PopupSearch').length) {
			$result.insertAfter($titleSearch);
		}
	}
	function lockSearchPage() {
		if (searchOpen) {
			return;
		}
		searchOpen = true;
		$('body').addClass('PopupSearchOpen');
	}
	function unlockSearchPage() {
		if (!searchOpen) {
			return;
		}
		searchOpen = false;
		$('body').removeClass('PopupSearchOpen');
	}
	$('.SearchPopup').click(
					function() {
						if (!$searchPopup.length) {
							return false;
						}
						lockSearchPage();
						$searchPopup.appendTo(document.body).stop(true, true).attr('aria-hidden', 'false').show();
						$('#title-search-input').trigger('focus');
						adoptSearchResult();
						if (window.MutationObserver && !searchResultObserver) {
							searchResultObserver = new MutationObserver(adoptSearchResult);
							searchResultObserver.observe(document.body, {childList: true, subtree: true});
						}
						$('.SearchPopup').attr('aria-expanded', 'true');
						return false;
					});

				$('.SearchClose').click(
					function() {
						$searchPopup.stop(true, true).hide().attr('aria-hidden', 'true').insertAfter($searchAnchor);
						unlockSearchPage();
						if (searchResultObserver) {
							searchResultObserver.disconnect();
							searchResultObserver = null;
						}
						$('.SearchPopup').attr('aria-expanded', 'false');
						return false;
					});

				$(document).on('keydown', function(event) {
					if (event.key === 'Escape' && $searchPopup.attr('aria-hidden') === 'false') {
						$('.SearchClose').trigger('click');
					}
				});
    $("#owl-demo").owlCarousel({
        pagination : true,
		slideSpeed : 300,
        navigation : false,
		paginationSpeed : 400,
		singleItem : true
    });
    $("#Gallery").owlCarousel({
        pagination : true,
		slideSpeed : 300,
        navigation : false,
		paginationSpeed : 400,
		singleItem : true
    });
    $("#Reviews").owlCarousel({
        pagination : true,
		slideSpeed : 300,
        navigation : true,
		paginationSpeed : 400,
		singleItem : true
    });
	$(".panel-collapse").on("hidden.bs.collapse",function(){$(this).parent().toggleClass("opened")});$(".panel-collapse").on("show.bs.collapse",function(){$(this).parent().toggleClass("opened")});
	$('ul.Tabs').on('click', 'li:not(.Active)', function() {
		$(this)
			.addClass('Active').siblings().removeClass('Active')
			.closest('div.ServicesTabs').find('div.Box').removeClass('Active').eq($(this).index()).addClass('Active');
	});
	$('ul.Links').on('click', 'li:not(.Active)', function() {
		$(this)
			.addClass('Active').siblings().removeClass('Active')
			.closest('div.ProductTabs').find('div.BoxInfo').removeClass('Active').eq($(this).index()).addClass('Active');
	});jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
})

})(jQuery)
