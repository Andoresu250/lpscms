( function( $, wp ) {

  window.jupiterx || {};

  /**
   * Modal for upgrading theme.
   *
   * Initialize a new instance of modal where users can activate and install Jupiter X Pro plugin.
   *
   * @since 1.3.0
   */
  function upgrade( url ) {
    let $template = $( wp.template( 'jupiterx-upgrade' )( { url } ) ),
      $steps = $template.find( '.jupiterx-upgrade-step' ),
      $apiKey = $template.find( '.jupiterx-upgrade-api-key' ),
      $activateBtn = $template.find( '.jupiterx-upgrade-activate' ),
      maxStep = $steps.length,
      step = 0;

    function next() {
      $( $steps[ step ] ).toggleClass( 'active done' );

      step++;

      if ( step >= maxStep ) {
        done();
        return;
      }

      $( $steps[ step ] ).addClass( 'active' );
    }

    function activate() {
      $activateBtn
        .attr( 'disabled', 'disabled' )
        .append( '<span class="jupiterx-spin jupiterx-icon-circle-notch"></span>' );

      $.ajax( {
        type: 'POST',
        url: wp.ajax.settings.url,
        data: {
          action: 'jupiterx_api',
          type: 'activate',
          api_key: $apiKey.val()
        },
        success: function( res ) {
          let data = res.data || {};

          if ( data.status ) {
            $apiKey
              .removeClass( 'invalid' )
              .attr( 'disabled', 'disabled' );

            $activateBtn
              .attr( 'disabled', 'disabled' )
              .find( '.jupiterx-icon-circle-notch' )
                .remove()

            next();
            install();
          } else {
            $apiKey
              .addClass( 'invalid' );

            $activateBtn
              .removeAttr( 'disabled' )
              .find( '.jupiterx-icon-circle-notch' )
                .remove();
          }
        }
      } );
    }

    function install() {
      let size = 40,
        progress;

      $template
        .find( '.jupiterx-upgrade-install-progress' )
        .prepend( wp.template('jupiterx-progress-bar')() );

      progress = setInterval( function() {
        if ( size > 100 ) {
          clearTimeout( progress );
          return;
        }

        $template
          .find( '.progress-bar' )
          .css( 'width', `${size}%` );

        size += 20;
      }, 3000 );

      $.ajax( {
        type: 'POST',
        url: wp.ajax.settings.url,
        data: {
          action: 'jupiterx_api',
          type: 'install_plugins',
          plugins: [
            'jupiterx-pro',
          ]
        },
        success: function( res ) {
          let data = res.data || {};

          if ( data.status ) {
            next();
          }
        }
      } );
    }

    function done() {
      let $footerHTML = $( '\
        <div class="jupiterx-upgrade-footer">\
          <span class="jupiterx-upgrade-learn-more">\
            <i class="jupiterx-icon-external-link-alt"></i>\
            <a target="_blank" href="https://help.artbees.net/getting-started/jupiter-x-pro">Learn more about Pro features</a>\
          </span>\
          <button class="btn btn-primary">Done</button>\
        </div>\
      ' );

      $footerHTML.find( 'button' ).click( function ( event ) {
        event.preventDefault();
        window.location = window.location.href.split('#')[0]
      } );

      jupiterx_modal( {
        modalCustomClass: 'jupiterx-modal-upgrade jupiterx-modal-upgrade-done',
        title: 'Jupiter X is upgraded',
        text: 'Congrats! you have successfully upgraded to Jupiter X Pro. Now you can enjoy working with Jupiter X at its maximum potential.',
        footerHTML: $footerHTML,
        showCloseButton: false,
        showCancelButton: false,
        closeOnOutsideClick: false,
        type: false,
        icon: 'jupiterx-icon-pro'
      } );
    }

    $template.on( 'click', '.active .jupiterx-upgrade-buy-pro', function() {
      next();
    } );

    $template.on( 'click', '.active .jupiterx-upgrade-activate', function( event ) {
      event.preventDefault();
      activate();
    } );

    jupiterx_modal( {
      modalCustomClass: 'jupiterx-modal-upgrade',
      title: 'Upgrade Jupiter X',
      text: $template,
      showCancelButton: false,
      showConfirmButton: false,
      closeOnOutsideClick: false,
      type: false,
      icon: 'jupiterx-icon-pro'
    } );
  }

  /**
   * Modal for activating api key.
   *
   * Initialize a new instance of modal where users can activate API.
   *
   * @since 1.3.0
   */
  function activateInit() {
    let $template = $( wp.template( 'jupiterx-activate' )() ),
      $apiKey = $template.find( '.jupiterx-upgrade-api-key' ),
      $activateBtn = $template.find( '.jupiterx-upgrade-activate' );

    let $footerHTML = $( '\
      <div class="jupiterx-upgrade-footer">\
        <span class="jupiterx-upgrade-learn-more">\
          <i class="jupiterx-icon-external-link-alt"></i>\
          <a target="_blank" href="https://help.artbees.net/getting-started/jupiter-x-pro">Learn more about Pro features</a>\
        </span>\
        <button class="btn btn-primary">Done</button>\
      </div>\
    ' );

    $footerHTML.find( 'button' ).click( function ( event ) {
      event.preventDefault();
      window.location = window.location.href.split('#')[0]
    } );

    function activate() {
      $activateBtn
        .attr( 'disabled', 'disabled' )
        .append( '<span class="jupiterx-spin jupiterx-icon-circle-notch"></span>' );

      $.ajax( {
        type: 'POST',
        url: wp.ajax.settings.url,
        data: {
          action: 'jupiterx_api',
          type: 'activate',
          api_key: $apiKey.val()
        },
        success: function( res ) {
          let data = res.data || {};

          function done() {
            jupiterx_modal( {
              modalCustomClass: 'jupiterx-modal-upgrade jupiterx-modal-upgrade-done',
              title: 'Jupiter X is activated',
              text: 'Congrats! Jupiter X is activated successfully. Now you can enjoy working with Jupiter at its maximum potential.',
              footerHTML: $footerHTML,
              showCloseButton: false,
              showCancelButton: false,
              closeOnOutsideClick: false,
              type: false,
              icon: 'jupiterx-icon-check'
            } );
          }

          function error() {
            jupiterx_modal( {
              modalCustomClass: 'jupiterx-modal-upgrade jupiterx-modal-upgrade-done',
              title: 'Oops! Registration was unsuccessful.',
              text: 'Your API key could not be verified. There is no such API key or it is used in another site',
              footerHTML: $footerHTML,
              showCloseButton: false,
              showCancelButton: false,
              closeOnOutsideClick: false,
              type: false,
              icon: 'jupiterx-icon-times'
            } );
          }

          if ( data.status ) {
            $apiKey
              .removeClass( 'invalid' )
              .attr( 'disabled', 'disabled' );

            $activateBtn
              .attr( 'disabled', 'disabled' )
              .find( '.jupiterx-icon-circle-notch' )
                .remove();

            $.ajax( {
              type: 'POST',
              url: wp.ajax.settings.url,
              data: {
                action: 'jupiterx_api',
                type: 'install_plugins',
                plugins: [
                  'jupiterx-pro',
                ]
              },
              success: function( res ) {
                let data = res.data || {};

                if ( data.status ) {
                  done();
                } else {
                  error();
                }
              }
            } );
          } else {
            $apiKey
              .addClass( 'invalid' );

            $activateBtn
              .find( '.jupiterx-icon-circle-notch' )
                .remove();

            error();
          }
        }
      } );
    }

    $template.on( 'click', '.jupiterx-upgrade-activate', function( event ) {
      event.preventDefault();
      activate();
    } );

    jupiterx_modal( {
      modalCustomClass: 'jupiterx-modal-upgrade',
      title: 'Activate Jupiter X',
      text: $template,
      showCancelButton: false,
      showConfirmButton: false,
      closeOnOutsideClick: false,
      type: false,
      icon: 'jupiterx-icon-key'
    } );
  }

  /**
   * Modal for installing Jupiter X Pro plugin.
   *
   * @since 1.3.0
   */
  function installPro() {
    function installNow() {
      let $template = $( '<div></div>' ),
      size = 40,
      progress;

      $template
        .prepend( wp.template('jupiterx-progress-bar')() );

      progress = setInterval( function() {
        if ( size > 100 ) {
          clearTimeout( progress );
          return;
        }

        $template
          .find( '.progress-bar' )
          .css( 'width', `${size}%` );

        size += 20;
      }, 3000 );

      $.ajax( {
        type: 'POST',
        url: wp.ajax.settings.url,
        data: {
          action: 'jupiterx_api',
          type: 'install_plugins',
          plugins: [
            'jupiterx-pro',
          ]
        },
        success: function( res ) {
          let data = res.data || {};

          if ( data.status ) {
            let $footerHTML = $('\
                <div class="jupiterx-upgrade-footer">\
                  <span class="jupiterx-upgrade-learn-more"></span>\
                  <button class="btn btn-primary">Done</button>\
                </div>\
              ' );

            $footerHTML.find( 'button' ).click( function ( event ) {
              event.preventDefault();
              window.location.reload( true );
            } );

            jupiterx_modal( {
              modalCustomClass: 'jupiterx-modal-upgrade',
              title: '🎉 Jupiter X Pro plugin installed',
              text: 'Congrats! You have successfully activated Jupiter X Pro plugin. Now you can enjoy working with Jupiter X at its maximum potential.',
              footerHTML: $footerHTML,
              showCloseButton: false,
              showCancelButton: false,
              closeOnOutsideClick: false,
              type: false,
            } );
          } else {
            jupiterx_modal( {
              modalCustomClass: 'jupiterx-modal-upgrade jupiterx-modal-upgrade-done',
              title: 'Oops! Plugin installation was unsuccessful.',
              text: data.message,
              showCloseButton: false,
              showCancelButton: false,
              closeOnOutsideClick: false,
              type: false,
              icon: 'jupiterx-icon-times'
            } );
          }
        }
      } );

      jupiterx_modal( {
        modalCustomClass: 'jupiterx-modal-upgrade',
        title: 'Installing Jupiter X Pro Plugin',
        text: $template,
        showCancelButton: false,
        showConfirmButton: false,
        closeOnOutsideClick: false,
        type: false,
        icon: 'jupiterx-icon-pro',
      } );
    }

    jupiterx_modal( {
      modalCustomClass: 'jupiterx-modal-upgrade',
      title: 'Jupiter X Pro Plugin',
      text: 'Please go to Control Panel > Plugins and activate Jupiter X Pro plugin.',
      showCancelButton: false,
      showConfirmButton: true,
      confirmButtonText: 'Install Plugin',
      closeOnOutsideClick: false,
      type: false,
      icon: 'jupiterx-icon-pro',
      onConfirm: function() {
        installNow();
      }
    } );
  }

  /**
   * Update plugins notice.
   *
   * @since 1.3.0
   */
  function updatePluginsNotce() {
    let $hidden = $( '.jupiterx-update-plugins-notice input[type=hidden]' );

    if ( ! $hidden.length ) {
      return;
    }

    let plugins = JSON.parse( $hidden.val() );

    if ( ! plugins.length ) {
      return;
    }

    let updates = plugins.filter( function( plugin ) {
      return plugin['action'] === 'update';
    } );

    let installs = plugins.filter( function( plugin ) {
      return plugin['action'] === 'install';
    } );

    function successNotice() {
      wp.updates.addAdminNotice( {
        selector: '.jupiterx-update-plugins-notice',
        className: 'notice-success is-dismissible',
        message: 'Plugins are successfully updated.'
      } );
    }

    function errorNotice( message ) {
      wp.updates.addAdminNotice( {
        selector: '.jupiterx-update-plugins-notice',
        className: 'notice-error is-dismissible',
        message: message
      } );
    }

    function updatePlugins() {
      let plugin = updates.shift();

      wp.updates.ajaxLocked = false;

      wp.updates.ajax( 'update-plugin', {
        plugin: plugin['basename'],
        slug: plugin['slug'],
        success: function() {
          if ( updates.length ) {
            updatePlugins();
          } else if ( installs.length ) {
            installPlugins();
          } else {
            successNotice();
          }
        },
        error: function( res ) {
          errorNotice( res.debug[ res.debug.length - 1 ] );
        }
      } );
    }

    function installPlugins() {
      $.ajax( {
        type: 'POST',
        url: wp.ajax.settings.url,
        data: {
          action: 'jupiterx_api',
          type: 'install_plugins',
          plugins: installs.map( function( plugin ) {
            return plugin['slug'];
          } )
        },
        success: function( res ) {
          let data = res.data || {};

          if ( data.status ) {
            console.log( 'Success installing plugins.' );
            successNotice();
          } else {
            errorNotice( 'There was some error installing plugins.' );
          }
        }
      } );
    }

    if ( updates.length ) {
      updatePlugins();
    } else if ( installs.length ) {
      installPlugins();
    }
  }

  /**
   * Update plugins modal.
   *
   * @since 1.3.0
   *
   * @param {array} plugins
   */
  function updatePluginsModal( plugins ) {
    if ( typeof plugins === 'undefined' || ! plugins.length ) {
      return;
    }

    let updates = plugins.filter( function( plugin ) {
      return plugin['action'] === 'update';
    } );

    let installs = plugins.filter( function( plugin ) {
      return plugin['action'] === 'install';
    } );

    function updatePluginsNow() {
      let $template = $( '<div></div>' )

      $template
        .prepend( wp.template('jupiterx-progress-bar')() )
        .find( '.progress-bar' )
          .css( 'width', '100%' );

      function successModal() {
        let $footerHTML = $('\
            <div class="jupiterx-upgrade-footer">\
              <span class="jupiterx-upgrade-learn-more"></span>\
              <button class="btn btn-primary">Ok</button>\
            </div>\
          ' );

        $footerHTML.find( 'button' ).click( function ( event ) {
          event.preventDefault();
          window.location.reload( true );
        } );

        jupiterx_modal( {
          modalCustomClass: 'jupiterx-modal-update-plugins',
          title: '🎉 Update successful',
          text: 'You have successfully updated your plugins to latest version.',
          footerHTML: $footerHTML,
          showCloseButton: false,
          showCancelButton: false,
          closeOnOutsideClick: false,
          type: false,
        } );
      }

      function errorModal( message ) {
        jupiterx_modal( {
          modalCustomClass: 'jupiterx-modal-update-plugins',
          title: 'Oops! Plugins update was unsuccessful.',
          text: message,
          showCloseButton: false,
          showCancelButton: false,
          closeOnOutsideClick: false,
          type: false,
          icon: 'jupiterx-icon-times'
        } );
      }

      function updatePlugins() {
        let plugin = updates.shift();

        wp.updates.ajaxLocked = false;

        wp.updates.ajax( 'update-plugin', {
          plugin: plugin['basename'],
          slug: plugin['slug'],
          success: function() {
            if ( updates.length ) {
              updatePlugins();
            } else if ( installs.length ) {
              installPlugins();
            } else {
              successModal();
            }
          },
          error: function( res ) {
            errorModal( res.debug[ res.debug.length - 1 ] );
          }
        } );
      }

      function installPlugins() {
        $.ajax( {
          type: 'POST',
          url: wp.ajax.settings.url,
          data: {
            action: 'jupiterx_api',
            type: 'install_plugins',
            plugins: installs.map( function( plugin ) {
              return plugin['slug'];
            } )
          },
          success: function( res ) {
            let data = res.data || {};

            if ( data.status ) {
              console.log( 'Success installing plugins.' );
              successModal();
            } else {
              errorModal( 'There was some error installing plugins.' );
            }
          }
        } );
      }

      if ( updates.length ) {
        updatePlugins();
      } else if ( installs.length ) {
        installPlugins();
      }

      jupiterx_modal( {
        modalCustomClass: 'jupiterx-modal-update-plugins',
        title: 'Updating plugins',
        text: $template,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        closeOnOutsideClick: false,
        type: false,
        icon: 'jupiterx-icon-info-circle'
      } );
    }

    let $updatePluginsFooter = $('\
        <div class="jupiterx-update-plugins-footer">\
          <span class="jupiterx-update-plugins-learn-more">\
            <i class="jupiterx-icon-question-circle"></i>\
            <a target="_blank" href="https://help.artbees.net/maintenance/updating-the-plugins/updating-bundled-plugins">Learn More</a>\
          </span>\
          <button class="btn btn-primary">Update Plugins</button>\
        </div>\
      ' );

    $updatePluginsFooter.find( 'button' ).click( function ( event ) {
      event.preventDefault();
      updatePluginsNow();
    } );

    let pluginNames = [];

    plugins.forEach( function( pluginData ) {
      pluginNames.push( `<span class="jupiterx-update-plugins-name">${pluginData['name']}</span>` );
    } );

    jupiterx_modal( {
      modalCustomClass: 'jupiterx-modal-update-plugins',
      footerHTML: $updatePluginsFooter,
      title: 'Theme update failed',
      text: `New updates are available for these essential plugins. Jupiter X may not work properly without the latest version of these plugins. ${pluginNames.join( '' )}`,
      showCancelButton: false,
      showConfirmButton: false,
      closeOnOutsideClick: false,
      type: false,
      icon: 'jupiterx-icon-info-circle'
    } );
  }

  window.jupiterx = jQuery.extend( {}, window.jupiterx, {
    upgrade,
    activateInit,
    installPro,
    updatePluginsNotce,
    updatePluginsModal
  } );

  $( document ).on( 'click', '.jupiterx-upgrade-modal-trigger, #jupiterx-popup-jupiterx_pro', function( event ) {
    event.preventDefault();

    if ( typeof jupiterxPremium !== 'undefined' ) {
      jupiterx.activateInit();
    } else {
      jupiterx.upgrade( event.target.getAttribute( 'data-upgrade-link' ) );
    }
  } );

  $( document ).on( 'click', '.jupiterx-update-plugins-notice-button', function( event ) {
    event.preventDefault();

    $( event.target )
      .addClass( 'updating-message' )
      .text( 'Updating Plugins' );

    updatePluginsNotce();
  } );

} )( jQuery, wp )
