// require('lodash');
require('./bootstrap');


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
