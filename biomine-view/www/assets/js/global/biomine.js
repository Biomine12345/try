/**
 * Global initializations that should be applied to all pages.
 */
(function($, Biomine, undefined) {
  "use strict";

  // Initializes the module.
  Biomine.init = function() {
    initNotification();
    extendjQuery();
    imageFallback();
    addEventHandlers();
  };

  // Initializes the global notification bar.
  var initNotification = function() {
    $(document).ready(function() {
      toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': true,
        'positionClass': 'toast-bottom-left',
        'preventDuplicates': false,
        'onclick': null,
        'showDuration': '300',
        'hideDuration': '1000',
        'timeOut': '7000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut'
      }
    });
  };

  // Adds additional jQuery functions.
  var extendjQuery = function() {
    jQuery.fn.extend({
      findName: function(name) {
        return this.find("[name='" + name + "']");
      },

      findNameRegex: function(regex) {
        return this.find('*').filter(function() {
          return new RegExp(regex).test(this.name);
        });
      },

      filterName: function(name) {
        return this.filter("[name='" + name + "']");
      },

      enable: function() {
        return this.prop('disabled', false);
      },

      disable: function() {
        return this.prop('disabled', true);
      },

      hideFormGroup: function() {
        return this.closest('.form-group').hide();
      },

      showFormGroup: function() {
        return this.closest('.form-group').show();
      }
    });

    if ($.validator) {
      $.validator.addMethod('regex', function(value, element, regexpr) {
        return regexpr.test(value);
      });

      $.validator.addMethod('time', function(value, element) {
        return this.optional(element) || /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/i.test(value);
      }, 'Please enter a valid time.');

      $.validator.addMethod('positive', function(value) {
        return Number(value) > 0;
      }, 'Please enter a positive number.');

      $.validator.addMethod('onOrAfter', function(value1, element, compareTo) {
        var split1 = value1.split('/');
        var split2 = compareTo.value.split('/');
        if (split1.length === 3 && split2.length === 3) {
          return new Date(split1[2], split1[0] - 1, split1[1]) >=
              new Date(split2[2], split2[0] - 1, split2[1]);
        } else {
          return true;
        }
      }, 'Please enter a later date.');
    }
  };

  var imageFallback = function() {
    $('img[data-src-error]').on('error', function() {
      $(this).attr('src', $(this).data('src-error'));
    }).each(function() {
      if ($(this).attr('src') === '') {
        $(this).attr('src', $(this).data('src-error'));
      }
    });
  };

  var addEventHandlers = function() {
  }
}(jQuery, window.Biomine = window.Biomine || {}));
