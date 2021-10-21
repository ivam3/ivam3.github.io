/**
* VFM Registration js
*/
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout(timer);
    timer = setTimeout(callback, ms);
  };
})();

function checkUserAvailable(thisinput){
    
    var gliph;
    var username = thisinput.val();
    var alias = username.replace(/\s+/g, '');
    thisinput.val(alias);

    thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-minus').removeClass('glyphicon-remove').removeClass('glyphicon-ok').addClass('glyphicon-refresh').addClass('fa-spin');
    thisinput.closest('.has-feedback').removeClass('has-error').removeClass('has-success');

    delay(function(){
        if (alias.length >= 3) {
            $.ajax({
              method: "POST",
              url: "vfm-admin/ajax/usr-check.php",
              data: { user_name: alias }
            })
            .done(function( msg ) {
                // console.log( "Data Saved: " + msg );
                // $("#user-result").html( msg );
                if (msg == 'success') {
                    gliph = 'glyphicon-ok';
                } else {
                    gliph = 'glyphicon-remove';
                }
                thisinput.closest('.has-feedback').addClass('has-'+msg);
                thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass(gliph);
            });
        } else {
            thisinput.closest('.has-feedback').addClass('has-error');
            thisinput.parent().next('.form-control-feedback').removeClass('glyphicon-refresh').removeClass('fa-spin').addClass('glyphicon-remove');
        }
    }, 1000 );
}

$(document).ready(function(){
    $('#user_name').on('input', function(){
        checkUserAvailable($(this));
    });
});
// $(document).on('input', '#user_name', function(){
//     checkUserAvailable($(this));
// });

$(document).on('keyup keypress', '#regform', function(e){
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
});

$(document).on('submit', '#regform', function (event) {
        
    $regform = $(this);
    $regform.data('submitted', false);
    event.preventDefault();
    $('#regresponse').html('');

    var pwd1 = $('#user_pass').val();
    var pwd2 = $('#user_pass_check').val();

    var fillAll = true;
    $('#regform input').each(function() {
        if(!$(this).val()){
            fillAll = false;
        }
    });
    if (fillAll == false) {
        var transfill = $('#trans_fill_all').val();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">'+transfill+'</div>');
        return false;
    }

    if ($('#agree').length && !$('#agree').prop('checked')){
        var transaccept = $('#trans_accept_terms').val();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">'+transaccept+'</div>');
        return false;
    }

    if (pwd1 !== pwd2) {
        var transerror = $('#trans_pwd_match').val();
        $('#user_pass_check').focus();
        $('#regresponse').html('<div class="alert alert-warning" role="alert">'+transerror+'</div>');
        return false;
    }

    if (pwd1.length < $('#user_pass').data('length')){
        $('#user_pass').focus();
        return false;
    }

    $('.mailpreload').fadeIn('fast', function(){

        if ($regform.data('submitted') == false) {
            $regform.data('submitted', true);
            var now = $.now();
            var serial = $regform.serialize();
            $.ajax({
                cache: false,
                method: "POST",
                url: "vfm-admin/ajax/usr-reg.php?t=" + now,
                data: serial
            })
            .done(function( msg ) {
                $('#regresponse').html(msg);
                $('#captcha').attr('src', 'vfm-admin/captcha/img.php?' + now);
                if ($('#grecaptcha').length) {
                    grecaptcha.reset();
                }
                $('.mailpreload').fadeOut('slow', function(){
                    $regform.data('submitted', false);
                });
                $('#user_pass').val('');
                $('#user_pass_check').val('');

            }).fail(function() {
                $('#regresponse').html('<div class="alert alert-danger" role="alert">error connecting user-reg.php</div>');
                $('#captcha').attr('src', 'vfm-admin/captcha/img.php?' + now);
                if ($('#grecaptcha').length) {
                    grecaptcha.reset();
                }
                $('.mailpreload').fadeOut('slow', function(){
                    $regform.data('submitted', false);
                });
            });
        }
    });
});


// PASSWORD STRENGHT
function passwordStrength(password, minlength){
    var pass = password.val();
    var minlength = password.data('length');
    var stength = 'Weak';
    var pclass = 'danger w1';
    var shortpass = true;

    if (pass.length >= minlength) {
        shortpass = false;
        stength = 'Weak';
        pclass = 'danger w25';
    }

    // alpha and number OR special char OR Uppercase
    var good = /^(?=\S*?[a-z])((?=\S*?[0-9])|(?=\S*?[^\w\*])|(?=\S*?[A-Z]))/;

    // Must contain at least one upper case letter, one lower case letter and one number OR one special char.
    var better = /^(?=\S*?[A-Z])(?=\S*?[a-z])((?=\S*?[0-9])|(?=\S*?[^\w\*]))/;

    // Must contain at least one upper case letter, one lower case letter and one number and one special char.
    var best = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])/;

    if (best.test(pass) == true) {
        stength = 'Very Strong';
        pclass = 'success w100';
    } else if (better.test(pass) == true) {
        stength = 'Strong';
        pclass = 'success w75';
    } else if (good.test(pass) == true) {
        stength = 'Almost Strong';
        pclass = 'warning w50';
        barlength = 50;
    } 

    var popover = password.data('bs.popover');
    popover.$tip.addClass(popover.options.placement).removeClass('danger success info warning primary w1 w5 w10 w25 w30 w50 w70 w75 w100').addClass(pclass);
    return shortpass;

}
