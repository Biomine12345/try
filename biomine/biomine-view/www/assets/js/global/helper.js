(function($, Helper, undefined) {
  "use strict";

  // Initializes form validation configs.
  Helper.initFormValidate = function(jqForm, validate) {
    // for more info visit the official plugin documentation:
    // http://docs.jquery.com/Plugins/Validation

    jqForm.validate(jQuery.extend({
      errorElement: 'span', // default input error message container
      errorClass: 'help-block help-block-error', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      //ignore: "",  // validate all fields including form hidden input
      messages: {},
      rules: {},

      // Display error alert on form submit.
      invalidHandler: function(event, validator) {
        Helper.notifyFailure('You have some input errors. Please check.')
      },

      // Highlight error inputs.
      highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
      },

      // Revert the change done by hightlight.
      unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
      },

      success: function(label) {
        label.closest('.form-group').removeClass('has-error');
      },

      //submitHandler: function (form) {
      //},

      errorPlacement: function(error, element) {
        if (element.attr("data-error-container")) {
          error.appendTo(element.attr("data-error-container"));
        } else {
          error.insertAfter(element); // for other inputs, just perform default behavior
        }
      }
    }, validate));
  };

  // Initializes a datatable with the basic options.
  Helper.initDataTable = function(jqTable, options) {
    var dataTable = jqTable.DataTable(jQuery.extend({
      "lengthMenu": [
        [25, 50, 75, 100, -1],
        [25, 50, 75, 100, 'All'] // change per page values here
      ],
      // set the initial value
      "pageLength": 25,

      "language": {
        "lengthMenu": "Show _MENU_ entries"
      },

      "scrollX": true,
      "scrollXInner": '100%'
      //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
    }, options));

    var tableWrapper = $('#' + jqTable.attr('id') + '_wrapper');
    tableWrapper.find('.dataTables_length select').select2({
      showSearchInput: false //hide search box with special css class
    }); // initialize select2 dropdown

    return dataTable;
  };

  // Initializes date pickers.
  Helper.initDatePickers = function(scope) {
    if (jQuery().datepicker) {
      $('.date-picker', scope).datepicker({
        format: 'mm/dd/yyyy',
        rtl: App.isRTL(),
        orientation: "left",
        autoclose: true
      }).on('changeDate', function() {
        var jqInput = $('input', this);
        if (jqInput.val().indexOf('_') < 0) {
          jqInput.valid();
        }
      });

      //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */
  };

  // Initializes datetime pickers.
  Helper.initDateTimePickers = function(scope) {
    if (jQuery().datetimepicker) {
      $('.form_datetime', scope).datetimepicker({
        format: 'mm/dd/yyyy hh:ii:ss',
        isRTL: App.isRTL(),
        pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
        minuteStep: 1,
        forceParse: false, /* Avoid wrongly resets when editing the datetime input directly. */
        initialDate: new Date(new Date().setHours(0,0,0,0)), /* Make the 'ss' part to always be 00 after selection. */
        autoclose: true
      }).on('changeDate', function() {
        var jqInput = $('input', this);
        if (jqInput.val().indexOf('_') < 0) {
          jqInput.valid();
        }
      });
    }
  };

  // Initializes time pickers.
  Helper.initTimePickers = function(scope, options) {
    if (jQuery().clockpicker) {
      $('.clockpicker', scope).clockpicker($.extend({
        autoclose: true
      }, options));
      $('.clockpicker-btn', scope).click(function() {
        $(this).parents('.clockpicker').eq(0).clockpicker('show');
        return false;
      });
    }
  };

  // Initializes input masks.
  Helper.initInputMasks = function(scope, options) {
    $(function($) {
      $('.ssn-mask', scope).inputmask('999-99-9999', jQuery.extend({clearIncomplete: true}, options));
      $('.phone-mask', scope).inputmask('(999) 999-9999', jQuery.extend({clearIncomplete: true}, options));
      $('.unit-mask', scope).inputmask('Regex', jQuery.extend({
        regex: '[0-9]+\\.*[0-9]*',
        clearIncomplete: true
      }, options));
      $('.date-mask', scope).inputmask('mm/dd/yyyy', jQuery.extend({
        placeholder: '__/__/____', /* The default mm/dd/yyyy is same as the input placeholder, causing it not to disappear when un-hover. */
        clearIncomplete: true
      }, options));
      $('.time-mask', scope).inputmask('time', jQuery.extend({
        mask: 'h:s',
        clearIncomplete: true
      }, options));
      $('.datetime-mask', scope).inputmask('mm/dd/yyyy hh:mm:ss', jQuery.extend({
        mask: 'm/d/y h:s:s',
        clearIncomplete: true
      }, options));
    });
  };

  // Initializes select2 controls.
  Helper.initSelect2 = function(scope) {
    if (jQuery().select2) {
      $('.select2', scope).select2({
        theme: 'bootstrap',
        placeholder: 'Select...',
        allowClear: true,
        width: 'auto'
      });
    }
  };

  Helper.getSelectedOpt = function(jqSelect) {
    return jqSelect.children('option:selected');
  };

  Helper.resetValidate = function(jqForm) {
    jqForm.validate().resetForm();
    jqForm.find('.form-group').removeClass('has-error');
  };

  // Makes an AJAX post call.
  Helper.callAjax = function(method, postData) {
    return Helper.callAjaxWithUrl(method, postData, location.href);
  };

  // Makes an AJAX post call.
  Helper.callAjaxWithUrl = function(method, postData, postUrl) {
    // Append method name.
    if ($.type(postData) === "string") {
      postData += '&method=' + method;
    } else if (postData instanceof Object) {
      postData['method'] = method;
    }

    // Initiate ajax call and return the promise (deferred object).
    return $.ajax({
        type    : 'POST',
        url     : postUrl,
        data    : postData,
        dataType: 'json',
        encode  : true
      }).done(function(data) { // place success code here
        if (Helper.isCallSucceeded(data)) {
          Helper.notifySuccess(data['message']);
        } else {
          Helper.notifyFailure(data['message']);
        }
      }).fail(function(data) { // place error code here
        if (data.getResponseHeader('LoginRequired')) {
          location.reload(); // A reload to trigger the login page.
        } else {
          Helper.notifyFailure('Failure: The server is busy, please try again later.');
        }
      });
  };

  Helper.isCallSucceeded = function(data) {
    return data['error_code'] === 0;
  };

  // Unlike jQuery.serialize, this method does not skip disabled elements.
  Helper.serialize = function(element) {
    var serialized = {};
    var $inputs = $('input[name],select[name],textarea[name]', element);
    $.map($inputs, function(el, index) {
      if (el.type === 'checkbox') {
        if (el.checked) {
          if (serialized[el.name]) {
            serialized[el.name].push(el.value);
          } else {
            serialized[el.name] = [el.value];
          }
        }
      } else if (el.type === 'radio') {
        if (el.checked) {
          serialized[el.name] = el.value;
        }
      } else {
        serialized[el.name] = el.value;
      }
    });
    return serialized;
  };

  // Uploads a file using AJAX.
  Helper.uploadFileAjax = function(method, uploadForm, extraPostData) {
    // Create a FormData object from the file uploading form.
    var formData = new FormData(uploadForm);

    // Put extra post data into the FormData object.
    for (var key in extraPostData) {
      if (extraPostData.hasOwnProperty(key)) {
        formData.append(key, extraPostData[key]);
      }
    }
    formData.append('method', method);

    // Initiate ajax call.
    return $.ajax({
        type       : 'POST',
        url        : location.href,
        data       : formData,
        dataType   : 'json',
        mimeType   : "multipart/form-data",
        contentType: false,
        cache      : false,
        processData: false
      }).done(function(data) {
        // place success code here
        if (Helper.isCallSucceeded(data)) {
          Helper.notifySuccess(data['message']);
        } else {
          Helper.notifyFailure(data['message']);
        }
      }).fail(function(data) {
        // place error code here
        Helper.notifyFailure('Failure: The server is busy, please try again later.');
      });
  };

  // Makes an AJAX load call.
  Helper.load = function(method, postData, jqLoadTo, callback) {
    // Append method name.
    if ($.type(postData) === "string") {
      postData += '&method=' + method;
    } else if (postData instanceof Object) {
      postData['method'] = method;
    }

    // Initiate the load call.
    jqLoadTo.load(location.href, postData, function(response, status, xhr) {
      if (status !== 'error') {
        if (callback) {
          callback();
        }
      } else {
        if (xhr.getResponseHeader('LoginRequired')) {
          location.reload(); // A reload to trigger the login page.
        } else {
          Helper.notifyFailure('Failure: The server is busy, please try again later.');
        }
      }
    });
  };

  // Makes an AJAX reload call.
  Helper.reload = function(method, postData, container, selector) {
    return Helper.reloadWithUrl(method, postData, location.href, container, selector);
  };

  // Makes an AJAX reload call.
  Helper.reloadWithUrl = function(method, postData, postUrl, container, selector) {
    // Append method name.
    if ($.type(postData) === "string") {
      postData += '&method=' + method;
    } else if (postData instanceof Object) {
      postData['method'] = method;
    }

    // Initiate ajax call and return the promise (deferred object).
    return $.ajax({
        type    : 'POST',
        url     : postUrl,
        data    : postData,
        dataType: 'html',
        encode  : true
      }).done(function(data) { // place success code here
        Helper.findInclSelf(container, selector).empty()
            .append(Helper.findInclSelf($(data), selector).children());
      }).fail(function(data) { // place error code here
        if (data.getResponseHeader('LoginRequired')) {
          location.reload(); // A reload to trigger the login page.
        } else {
          Helper.notifyFailure('Failure: The server is busy, please try again later.');
        }
      });
  };

  // Makes an AJAX call to fetch a piece of data. Different from load and reload methods, this
  // method does not place the fetched data to any element. It just return the fetched data directly.
  Helper.fetchWithUrl = function(method, postData, postUrl) {
    // Append method name.
    if ($.type(postData) === "string") {
      postData += '&method=' + method;
    } else if (postData instanceof Object) {
      postData['method'] = method;
    }

    // Initiate ajax call and return the promise (deferred object).
    return $.ajax({
      type    : 'POST',
      url     : postUrl,
      data    : postData,
      dataType: 'html',
      encode  : true
    }).fail(function(data) { // place error code here
      if (data.getResponseHeader('LoginRequired')) {
        location.reload(); // A reload to trigger the login page.
      } else {
        Helper.notifyFailure('Failure: The server is busy, please try again later.');
      }
    });
  };

  Helper.createFromTemplate = function(jqTemplate) {
    return $.parseHTML($.trim(jqTemplate.html()))[0];
  };

  Helper.notifySuccess = function(msg) {
    if (msg) {
      toastr['success'](msg)
    }
  };

  Helper.notifyFailure = function(msg) {
    if (msg) {
      toastr['error'](msg)
    }
  };

  Helper.notifyWarning = function(msg) {
    if (msg) {
      toastr['warning'](msg)
    }
  };

  Helper.usToStdDate = function(date) {
    var parts = date.split('/');
    if (parts.length === 3) {
      return parts[2] + "-" + parts[0] + "-" + parts[1];
    } else {
      return date;
    }
  };

  Helper.delayNavigate = function(href, wait /* in milliseconds */) {
    setTimeout(function() {
      window.location.href = href;
    }, wait);
  };

  Helper.findInclSelf = function($element, selector) {
    return $element.is(selector) ? $element : $element.find(selector);
  }
}(jQuery, window.Helper = window.Helper || {}));
