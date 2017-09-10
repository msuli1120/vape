(function($){

  $('.product-cat-logo-button').click(function(e) {
    var $el = $(this).parent();
    e.preventDefault();
    var uploader = wp.media({
      title: 'Choose a category logo',
      button: {
        text: 'Use'
      },
      multiple: false
    }).on('select', function () {
        var selection = uploader.state().get('selection');
        var attachement = selection.first().toJSON();
        $('input', $el).val(attachement.url);
        $('img', $el).attr('src', attachement.url);
    })
      .open();
  });

  $('.remove-cat-log-button').click(function (e) {
    e.preventDefault();
    $('#product-cat-logo').val('');
    $('img').hide();
  })


})(jQuery);