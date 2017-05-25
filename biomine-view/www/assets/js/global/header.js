/**
 * Header initializations that should be applied to all pages.
 */
(function($, Header, undefined) {
  "use strict";

  // Initializes the module.
  Header.init = function() {
    initLanguage();
  };

  // Initializes the language selection.
  var initLanguage = function() {
    $(document).on('click','.switch-lang', function() {
      window.location.href = new URI().subdomain($(this).data('lang'));
    });
  };

}(jQuery, window.Header = window.Header || {}));
