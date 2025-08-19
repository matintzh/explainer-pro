jQuery(document).ready(function($) {
    $(document).on('submit', '#popup-hint-form', function(e) {
        e.preventDefault();

        var termField = $('#popup-hint-term');
        var descriptionField = $('#popup-hint-description');

        var term = termField.val();
        var description = descriptionField.val();

        if (term === '' || description === '') {
            alert('Please fill in both fields');
            return;
        }

        $.ajax({
            url: popupHintData.ajax_url,
            type: 'POST',
            data: {
                action: 'create_popup_hint',
                nonce: popupHintData.nonce,
                term: term,
                description: description
            },
            success: function(response) {
                if (response.success) {
                    if (typeof window.tinyMCE !== 'undefined' && window.tinyMCE.activeEditor) {
                        window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, response.data.shortcode);
                    }

                    if ($('#popup-hint-modal').length) {
                        $('#popup-hint-modal').hide();
                    }

                    termField.val('');
                    descriptionField.val('');
                } else {
                    alert(response.data || 'Error creating shortcode');
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
});