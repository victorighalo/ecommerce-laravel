window.React = require('react');
window.ReactDom = require('react-dom');
require('lodash');
require('./bootstrap');
require('./admin/properties')


window.disableItem = function (button, action){
    if(action === true){
        $(button).prop('disabled', true)
    }
    else if(action === false){
        $(button).prop('disabled', false)
    }
}

window.ucFirst = function (string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
