const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function blockElement(selector) {
    $(selector).block({
        message: '<div><img src="' + BASE_URL + 'images/ajax-loader-big.gif"/></div>',
        css: { border: '0px', 'background-color': 'transparent', position: 'absolute' },
        overlayCSS: { opacity: 0.04, cursor: 'pointer', position: 'absolute' }
    });
}

function unblockElement(selector) {
    $(selector).unblock();
}

function get_dimensions() {
    var dims = { width: 0, height: 0 };

    if (typeof(window.innerWidth) == 'number') {
        //Non-IE
        dims.width = window.innerWidth;
        dims.height = window.innerHeight;
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        //IE 6+ in 'standards compliant mode'
        dims.width = document.documentElement.clientWidth;
        dims.height = document.documentElement.clientHeight;
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        //IE 4 compatible
        dims.width = document.body.clientWidth;
        dims.height = document.body.clientHeight;
    }

    return dims;
}

function set_feedback(text, classname, keep_displayed) {

    if (keep_displayed) {
        toastr.options.timeOut = 0;
        toastr.options.closeButton = true;
        toastr.options.extendedTimeOut = 0;
    }

    // Display a success toast, with a title
    if (classname === "success_message") {
        toastr.success(text);
    } else {
        toastr.error(text);
    }
}

function to_currency(number) {

    return "<span class='currency-label'>KES</span>. " + number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

function to_number(number) {

    return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

$.validator.addMethod("noSpace", function(value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "Invalid characters, No spaces Allowed");

$.validator.addMethod("alphanumeric", function(value, element) {
    return /^[\w.]+$/i.test(value);
}, "Only letters and digital allowed.");

$.validator.addMethod( // Email is valid

    "isValidEmail",

    function(value, element, requiredValue) {

        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        return regex.test(value);

    },

    "Email Address is invalid!"
);