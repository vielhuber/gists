$.ajax({
    'data': {
        sAdd: 'SW10001',
        sQuantity: 3,
        information: 'additional information',
        isXHR: 1
    },
    'dataType': 'jsonp',
    'url': 'http://www.tld.com/checkout/ajaxAddArticleCart',
    'success': function (result) {

    }
});