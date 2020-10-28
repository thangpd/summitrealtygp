/**
 * Multi-step Form
 *
 * @package WP Pro Real Estate 7
 * @subpackage JavaScript
 */

jQuery(function ($) {
  var $sections = $('.form-section');
  var $progressbar = $('#progress-bar li');
  var $listingTitle = $('input#postTitle');

  function navigateTo(index) {
    $('#progress-bar li:first-child').addClass('active');
    $('#primaryPostForm fieldset:first-child').addClass('current');
    
  	// Mark the current progress with the class 'active'
    $progressbar
      .eq(index)
        .addClass('active');
    // Mark the current section with the class 'current'
    $sections
      .removeClass('current')
      .eq(index)
        .addClass('current');
    // Show only the navigation buttons that make sense for the current section:
    $('.fieldset-buttons .previous').toggle(index > 0);
    var atTheEnd = index >= $sections.length - 1;
    $('.fieldset-buttons .next').toggle(!atTheEnd);
    $('.fieldset-buttons #submit').toggle(atTheEnd);
    $('.fieldset-buttons').show();
  }

  function curIndex() {
    // Return the current index by looking at which section has the class 'current'
    return $sections.index($sections.filter('.current'));
    return $progressbar.index($progressbar.filter('.active'));
  }

  // Previous button is easy, just go back
  $('.fieldset-buttons .previous').click(function() {
    $("#progress-bar li").eq(curIndex()).removeClass("active");
    navigateTo(curIndex() - 1);
    console.log(curIndex());
  });

  // Next button goes forward if current block validates
  $('.fieldset-buttons .next').click(function() {
   if($('.front-end-form').parsley().validate('block-' + curIndex()))
      navigateTo(curIndex() + 1);

    $("#progress-bar li").eq(curIndex()).addClass("active");
		console.log(curIndex());
  });

  // Prepare sections by setting the `data-parsley-group` attribute to 'block-0', 'block-1', etc.
  $sections.each(function(index, section, progressbar) {
    $(section).find(':input').attr('data-parsley-group', 'block-' + index);
    $(progressbar).attr('data-parsley-group', 'block-' + index);
  });
  navigateTo(0); // Start at the beginning

});