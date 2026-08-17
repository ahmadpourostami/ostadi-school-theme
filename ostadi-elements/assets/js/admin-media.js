jQuery(function ($) {
    $(document).on('click', '.ostadi-media-button', function (event) {
        event.preventDefault();
        var button = $(this);
        var target = $('#' + button.data('target'));
        var frame = wp.media({
            title: 'انتخاب رسانه',
            button: { text: 'استفاده از این فایل' },
            multiple: false
        });
        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            target.val(attachment.url).trigger('change');
        });
        frame.open();
    });
});
