/**
 * Porto theme customizations. We don't want to modify its custom.js file, so
 * we use our own custom js file.
 */

(function(theme, $) {
  "use strict";

  $.extend(theme.PluginScrollToTop.defaults, {
    iconClass: 'fa fa-chevron-up'
  });
}).apply(this, [window.theme, jQuery]);
