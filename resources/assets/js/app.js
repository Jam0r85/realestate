$(document).ready(function($) {

    // Fade flash notifications
    $('.is-flash-message').delay(3000).fadeOut(350);

    // Initiate select2
    $('.select2').select2();

    // Laravel CSRF token
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    $('.burger').click(function() {
        var menu = $(this).data('target');
        $(this).toggleClass('is-active');
        $('body').find('#' + menu ).toggleClass('is-active');
    });

    (function($) {

        var o = $({});

        $.subscribe = function() {
            o.on.apply(o, arguments);
        };

        $.unsubscribe = function() {
            o.off.apply(o, arguments);
        };

        $.publish = function() {
            o.trigger.apply(o, arguments);
        };
    }(jQuery));

    (function() {

        // Open modal
        $('.modal-button').click(function() {
            var target = $(this).data('target');
            $('#modal-content').load(target, function( response, status, xhr ) {
                if ( status == "success" ) {
                    $('.modal').addClass('is-active');
                    $('html').addClass('is-clipped');
                } else {
                    alert('Error Loading');
                    console.log( response );
                }
            });  
        })

    })();

    (function() {

        // Close a modal
        $('.modal-background, .modal-close').click(function() {
            $('html').removeClass('is-clipped');
            $(this).parent().removeClass('is-active');
        });

    })();

    (function() {

        // Click a table row and go to the link
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

    })();

    (function() {

        // Toggle a radio by clicking on the parent
        $('.toggle-radio').on('click', function() {
            var radio = $(this).find('input[type=radio]');
            radio.prop('checked', !radio.prop('checked'));
        });

    })();

    (function() {

        // Toggle a checkbox by clicking on the parent element
        $('.toggle-checkbox').on('click', function() {
            var checkbox = $(this).find('input[type=checkbox]');
            checkbox.prop('checked', !checkbox.prop('checked'));
        });

    })();

    (function() {

        // Submit a form via AJAX rather than submitting the form
        var submitAjaxRequest = function(e) {
            var form = $(this);
            var method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                type: method,
                url: form.prop('action'),
                data: form.serialize(),
                success: function(data) {
                    $('html').removeClass('is-clipped');
                    $(this).closest('div.modal').removeClass('is-active');
                }
            })

            e.preventDefault();
        }

        // Forms marked with the "data-remote" attribute will submit via AJAX.
        $('form[data-remote]').on('submit', submitAjaxRequest);

        // The "data-click-submits-form" attribute submits form on change
        $('*[data-click-submits-form]').on('change', function() {
            $(this).closest('form').submit();
        })
    })();

});