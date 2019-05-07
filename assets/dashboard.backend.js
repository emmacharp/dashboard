/**
* dashboard.backend
* @author Deux Huit Huit
*/
(function ($) {

	'use strict';

	var init = function () {
		var nav = window.Symphony.Elements.nav;
		var link = $('<li />');

		link.append($('<a />').attr({
			href: window.Symphony.Context.get('symphony') + '/extension/dashboard/index/'
		}).text(window.Symphony.Language.get('Dashboard')));

		nav.find('> ul').first().prepend(link);
	};

	$(init);

})(jQuery);
