import request from 'superagent';

const http = {
  post: (url, data) => {
    const postUrl = ALIKE_ADMIN.ajaxurl + '?action=ra_' + url;
    let param;
    if (data) {
      param = jQuery.param(data);
    }
    return request.post(postUrl).send(param).set('Accept', 'application/x-www-form-urlencoded');
  },
};

export default http;



