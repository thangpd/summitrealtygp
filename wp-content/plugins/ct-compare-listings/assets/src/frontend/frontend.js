const $ = jQuery;
import { findIndex } from 'underscore';

$('.alike-button').on('click', function (e) {
  e.preventDefault();
  const postId = $(this).data('post-id');
  const postTitle = $(this).data('post-title');
  const postThumb = $(this).data('post-thumb');
  const postLink = $(this).data('post-link');

  const allPosts = window.localStorage.getItem('alikeData') ? JSON.parse(window.localStorage.getItem('alikeData')) : [];

  const checkIndex = findIndex(allPosts, { postId });

  if (checkIndex === -1) {
    const newPost = {
      postId, postTitle, postThumb, postLink,
    };
    if (allPosts.length < ALIKE.max_compare) {
      allPosts.push(newPost);
    } else {
      alert(ALIKE.LANG.YOU_CAN_COMPARE_MAXIMUM_BETWEEN_S_ITEMS);
    }
  }

  window.localStorage.setItem('alikeData', JSON.stringify(allPosts));
  $('.alike-widget-btn-wrap').show();
  onStorageEvent();
});

$(window).on('load', function () {
  const items = (JSON.parse(localStorage.getItem('alikeData')) !== null) ? JSON.parse(localStorage.getItem('alikeData')) : [];
  if (items.length > 0) {
    $('.alike-widget-btn-wrap').show();
  } else {
    $('.alike-widget-btn-wrap').hide();
  }
  onStorageEvent();
});

function onStorageEvent() {
  if ($('.alike-widget').length > 0) {
    const items = (JSON.parse(localStorage.getItem('alikeData')) !== null) ? JSON.parse(localStorage.getItem('alikeData')) : [];
    if (items.length > 0) {
      $('.alike-widget-btn-wrap').show();
    } else {
      $('.alike-widget-btn-wrap').hide();
    }

    const resultTemplate = _.template($('.alike-list').html());
    const resultingHtml = resultTemplate({ items });
    const allPostIds = [];
    items.forEach(function (value) {
      allPostIds.push(value.postId);
    });
    const pageUrl = $('.alike-button-compare').data('page-url');
    $('.alike-button-compare').attr('href', pageUrl + '/?ids=' + allPostIds.join([',']));

    $('.alike-widget').html(resultingHtml).on('click', '.alike-widget-remove', function (e) {
      e.preventDefault();
      const postId = $(this).data('post-id');
      const allPosts = JSON.parse(window.localStorage.getItem('alikeData'));
      const checkIndex = findIndex(allPosts, { postId });

      if (checkIndex !== -1) {
        allPosts.splice(checkIndex, 1);
        window.localStorage.setItem('alikeData', JSON.stringify(allPosts));

        onStorageEvent();
      }
    }).next('.alike-widget-btn-wrap').on('click', '.alike-button-clear', function (e) {
      e.preventDefault();
      window.localStorage.setItem('alikeData', '[]');
      onStorageEvent();
    });
  }
}
window.addEventListener('storage', onStorageEvent, false);
