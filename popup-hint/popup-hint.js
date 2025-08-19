jQuery(document).ready(function($) {
    $('.popup-hint-term').on('click', function(e) {
        e.preventDefault();

        var hintId = $(this).data('hint-id');

        $('#' + hintId).fadeIn(200);

        positionPopup($(this), $('#' + hintId));
    });

    $(document).on('click', '.popup-hint-close', function() {
        $(this).closest('.popup-hint-description').fadeOut(200);
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.popup-hint-term').length &&
            !$(e.target).closest('.popup-hint-content').length) {
            $('.popup-hint-description').fadeOut(200);
        }
    });

    function positionPopup($term, $popup) {
        var termPos = $term.offset();
        var termHeight = $term.outerHeight();
        var windowWidth = $(window).width();
        var popupWidth = $popup.outerWidth();

        var topPos = termPos.top + termHeight;
        var leftPos = termPos.left;

        if (leftPos + popupWidth > windowWidth - 20) {
            leftPos = windowWidth - popupWidth - 20;
        }

        $popup.css({
            top: topPos + 'px',
            left: leftPos + 'px'
        });
    }

    $(window).on('resize', function() {
        $('.popup-hint-description:visible').each(function() {
            var hintId = $(this).attr('id');
            var $term = $('[data-hint-id="' + hintId + '"]');

            positionPopup($term, $(this));
        });
    });
});