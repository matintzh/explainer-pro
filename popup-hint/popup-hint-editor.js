(function() {
    tinymce.PluginManager.add('popup_hint_button', function(editor, url) {
        editor.addButton('popup_hint_button', {
            title: 'Explainer Pro Button',
            icon: 'help',
            onclick: function() {
                editor.windowManager.open({
                    title: 'Explainer Pro Button',
                    body: [{
                            type: 'textbox',
                            name: 'term',
                            label: 'Technical Term',
                            tooltip: 'Enter the technical term that needs explanation'
                        },
                        {
                            type: 'textbox',
                            name: 'description',
                            label: 'Description',
                            tooltip: 'Enter the explanation for this term',
                            multiline: true,
                            minHeight: 100
                        }
                    ],
                    onsubmit: function(e) {
                        var shortcode = '[popup_hint term="' + e.data.term + '" description="' + e.data.description + '"]';

                        editor.insertContent(shortcode);
                    }
                });
            }
        });
    });
})();