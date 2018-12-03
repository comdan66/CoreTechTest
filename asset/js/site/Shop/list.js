$(function () {
  $('.right .condition span').each(function() {
    var $that = $(this);
    var $checkbox = $that.next('div').find('input[type="checkbox"]');
    
    $that.click(function() {
      if (!$that.toggleClass('active').hasClass('active'))
        $checkbox.prop('checked', false);
    });

    $checkbox.first().click(function() {
      $checkbox.prop('checked', $(this).prop('checked'));
    });
  });
});