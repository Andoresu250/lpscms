'use strict';

(function ($, wp) {

  var $button = $('button.jupiterx-core-install-plugin'),
      $notice = $('.jupiterx-core-install-notice'),
      onProcess = false,
      installPlugin = void 0,
      activatePlugin = void 0,
      installCompleted = void 0,
      printError = void 0;

  /**
   * Plugin installation.
   */
  installPlugin = function installPlugin() {
    var data = {
      '_wpnonce': $('#jupiterx-core-installer-notice-nonce').val()
    };

    $button.addClass('updating-message').text(jupiterxCoreInstall.i18n.installing);

    wp.ajax.post('jupiterx_core_install_plugin', data).done(function (res) {
      if (res.activateUrl) {
        setTimeout(function () {
          activatePlugin(res.activateUrl);
        }, 800);
      }
    }).fail(function (res) {
      printError(res.errorMessage);
    });
  };

  /**
   * Plugin activation.
   */
  activatePlugin = function activatePlugin(url) {
    var data = {
      type: 'GET',
      url: url,
      success: function success() {
        setTimeout(function () {
          installCompleted();
        }, 800);
      },
      error: function error() {
        printError(jupiterxCoreInstall.i18n.errorActivating);
      }
    };

    $button.addClass('updating-message').text(jupiterxCoreInstall.i18n.activating);

    $.ajax(data);
  };

  /**
   * On plugin installation completed.
   */
  installCompleted = function installCompleted() {
    $button.removeClass('updating-message button-primary').toggleClass('button-disabled').text(jupiterxCoreInstall.i18n.completed);

    location.replace(jupiterxCoreInstall.controlPanelUrl);
  };

  /**
   * Replace notice with new error notice.
   */
  printError = function printError(message) {
    wp.updates.addAdminNotice({
      selector: '.jupiterx-core-install-notice',
      id: 'unknown_error',
      className: 'notice-error is-dismissible',
      message: message
    });
  };

  $button.on('click', function (event) {
    event.preventDefault();

    // This event can only be instantiated once.
    if (!onProcess) {
      onProcess = true;
      installPlugin();
    }
  });

  /**
   * Hide admin notice after dismissed by user.
   */
  $(document).on('click', $notice.selector + ' .notice-dismiss', function () {
    var data = {
      _wpnonce: $('#jupiterx-core-installer-notice-nonce').val(),
      state: 'disabled'
    };

    wp.ajax.post('jupiterx_core_install_plugin_notice', data);

    $notice.slideUp();
  });
})(jQuery, wp);