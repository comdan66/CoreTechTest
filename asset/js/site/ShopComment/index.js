
Array.prototype.min = function() {
  return Math.min.apply(null, this);
};

$(function () {
  function renderReplys(arr) {
    return $(arr.map(function(t) {
      return $('<div />').data('id', t.id).addClass('reply').append(
        $('<div />').addClass('icon-11').addClass('img')).append(
        $('<div />').addClass('msg').attr('data-name', t.name).text(t.content)).append(
        $('<time />').text(t.createAt));
    })).map($.fn.toArray);
  }

  $('form.reply').each(function() {

    var $that = $(this);
    var $replies = $that.parent().find('.replies');

    $replies.append(renderReplys($replies.data('d4').slice(0, 2))).data('min', $replies.data('d4').slice(0, 2).map(function(t) { return t.id; }).min());

    if ($replies.data('d4').length > 2)
      $('<div />').addClass('more').insertAfter($replies).append($('<a />').text('顯示全部').click(function() {
        $.ajax ({
          url: $replies.data('url'),
          data: {
            min: $replies.data('min'),
          },
          async: true, cache: false, dataType: 'json', type: 'get'
        })
        .done (function (result) {
          $replies.append(renderReplys(result.slice(0, 2))).data('min', result.slice(0, 2).map(function(t) { return t.id; }).min());
          if (result.length < 3)
            $(this).parent().remove();
        }.bind($(this)))
        .fail (function (result) {
          console.error(result);
        });
      }));

    $that.submit(function() {
      var $that = $(this);

      var $span = $that.find('>span');
      var $name = $that.find('input[name="name"]');
      var $content = $that.find('textarea[name="content"]');

      if (!($name.val().trim().length && $content.val().trim().length)) {
        $span.text('請填寫以上欄位！');
        return false;
      }

      $.ajax ({
        url: $that.attr('action'),
        data: {
          name: $name.val().trim(),
          content: $content.val().trim(),
        },
        async: true, cache: false, dataType: 'json', type: $that.attr('method')
      })
      .done (function (result) {
        $replies.prepend(renderReplys([result]));
        $span.empty();
        $name.val('');
        $content.val('');
      })
      .fail (function (result) {
        $span.text('新增錯誤！錯誤原因：' + result.responseJSON.messages.join(','));
      });
      
      return false;
    });
  });
});