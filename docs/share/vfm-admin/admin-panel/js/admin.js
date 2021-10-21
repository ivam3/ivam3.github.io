/*! VFM - veno file manager main administration functions
 * ================
 *
 * @Author  Nicola Franchini
 * @Support <http://www.veno.es>
 * @Email   <support@veno.it>
 * @version 3.6.0
 * @license Exclusively sold on CodeCanyon
 */

//
// Clear /thumbs/ folder
//
$(document).ready(function(){
    var regenicon = ' <i class="fa fa-refresh fa-spin fa-fw"></i>';
    $('.regen-thumb').on('click', function(){

        var butt = $(this);
        var place_icon = butt.find('.place-icon');

        if (!butt.hasClass('disabled')) {

        butt.addClass('disabled');

        place_icon.html(regenicon);

        $.ajax({
            method: "GET",
            url: "admin-panel/ajax/regen-thumbnails.php",
        })
        .done(function( msg ) {
            butt.find('.fa-spin').removeClass('fa-refresh').removeClass('fa-spin').addClass(msg);
            if (msg !== 'fa-check') {
                butt.removeClass('disabled');
            }
        })
        .fail(function() {
            butt.find('.fa-spin').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-times');
            butt.removeClass('disabled');
          });
        }
    });
});

//
// call taginput plugin
//
$('.taginput').each(function(){
    var tag = $(this).data('tag');
    $(this).tagsinput({
      tagClass: 'label label-'+tag,
      trimValue: true,
      confirmKeys: [13, 44, 32]
    });
})

//
// toggle allow/reject extensions
//
function switchExtensions(){
    $('.toggle-extensions').each(function(){
        if($(this).find('.togglext').is(':checked')) {
             $(this).closest('.toggle-extensions').next().slideDown();
             $(this).find('.togglabel').addClass('bold');
        } else {
             $(this).closest('.toggle-extensions').next().slideUp();
             $(this).find('.togglabel').removeClass('bold');
        }
    });
}

//
// Start multiselects with translated options
//
function multiselectWithOptions(selectall, selected, available){
    $('.assignfolder').multiselect({
        buttonWidth: '100%',
        selectAllText: selectall,
        maxHeight: 300,
        enableFiltering: true,
        enableFilteringIfMoreThan: 10,
        filterPlaceholder: '',
        includeSelectAllOption: true,
        includeSelectAllIfMoreThan: 10,
        numberDisplayed: 1,
        nSelectedText: selected,
        buttonContainer: '<div class="btn-group btn-block" />',
        nonSelectedText : available,
        templates: {
        filter: '<div class="input-group"><span class="input-group-addon input-sm"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search input-sm" type="text"></div>'
        }
    });
}

//
// setup user panel in admin area
//
$(document).on('click', '.usrblock', function(e) {
    e.preventDefault();

    $('#modaluser .getuser').val('');
    var username = '';
    $(this).find('.send-userdata').each(function(){
        var key = $(this).data('key');
        $('#modaluser .getuser-'+key).val($(this).val());
        if (key === 'name') {
            username = $(this).val();
        }
    });

    $("#modaluser .modal-title .modalusername").html(username);
    $("#r-userpassnew").val('');

    var data = [];
    var hiddenfolders = $(this).find(".s-userfolders");
    hiddenfolders.each(function(){
        data.push($(this).val());
    });

    $("#r-userfolders").val(data);
    $(".coolselect").multiselect('refresh');
    $(".assignfolder").multiselect('refresh');
    
    if ($('#r-userfolders').val()){
        $('#modaluser .userquota').show();
    } else {
        $('#modaluser .userquota').hide();
    }
});

//
// Show / hide user quota menu when dropdown or new input
//
function showHideQuota(subject){

    var inputnew = subject.closest('.row').find('.assignnew');
    var inputaval = subject.closest('.row').find('.assignfolder');

    if (inputnew.val().length || inputaval.val().length) {
        subject.closest('.row').next().find('.userquota').fadeIn();
    } else {
        subject.closest('.row').next().find('.userquota').fadeOut();
    }
}

$(document).on('change', '.assignfolder', function() {
    showHideQuota($(this));
});

$(document).on('input', '.assignnew', function() {
    showHideQuota($(this));
});

//
// confirm user deletion
//
$(document).on('click', '.remove', function(e) {
    //e.preventDefault();
    var todelete = $(this).closest(".removegroup").find(".deleteme").val();
    var answer = confirm('Are you sure you want to delete: ' + todelete + '?')
    if (answer == true) {
        $(".remove").find(".delme").val(todelete);
    }
    return answer;
});

//
// confirm language deletion
//
$(document).on('click', '.delete', function() {
    var answer = confirm('Are you sure you want entirely to delete this language?');
    return answer;
});

//
// confirm logo deletion
//
$(document).on('click', '.deletelogo', function(e) {
    e.preventDefault();
    $(this).addClass('hidden');
    var datasetting = $(this).data('setting');
    $('input[name=remove_'+datasetting+']').val(1);
    // $(this).parent().find('img').attr('src', 'admin-panel/images/placeholder.png');
    $('.'+datasetting+'-preview').attr('src', 'admin-panel/images/placeholder.png');
});

//
// Upload custom logo
//
$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

//
// Switch audio notifications
//
$(document).on('change', '.audio-notif', function(){
    var loadmp3 = $(this).val();
    var audio_ping = new Audio(loadmp3);
    audio_ping.play();
});

//
// Show / Hide New User notification checkbox
//
$('.newusermail').keyup(function() {
    if($(this).val().length>0){
        $('.usernotif').fadeIn();
    } else {
        $('.usernotif').fadeOut();
   }
});

//
// Update background for analytics panel
//
$(document).on('change', '.checkstats', function() {
    if(this.checked) {
        $(this).closest('.info-box').addClass('bg-green').removeClass('bg-green-active');
    } else {
        $(this).closest('.info-box').addClass('bg-green-active').removeClass('bg-green');
    }
});

//
// Update background for registration panel
//
$(document).on('change', '.checkregs', function() {
    if(this.checked) {
        $(this).closest('.info-box').addClass('bg-aqua').removeClass('bg-aqua-active');
    } else {
        $(this).closest('.info-box').addClass('bg-aqua-active').removeClass('bg-aqua');
    }
});

//
// Update adminstration color scheme on the fly
//
$(document).on('change', '.adminscheme input', function() {

    $('.adminscheme input').each(function(){
        var removeskin = $(this).val();
        $('body').removeClass('skin-'+removeskin);
    })
    $('.minilayout').removeClass('active');

    if(this.checked) {
        var addskin = $(this).val();
        $('body').addClass('skin-'+addskin);
        $(this).closest('.minilayout').addClass('active');
    }
});
//
// switch header logo alignment on the fly
//
$(document).on('change', '.select-logo-alignment input:radio', function() {
    var value = 'text-left';
    switch($(this).val()) {
        case 'left':
            value = 'text-left';
            break;
        case 'center':
            value = 'text-center';
            break;
        case 'right':
            value = 'text-right';
            break;

        default:
            value = 'text-left';
    }
    $('.place-main-header').removeClass('text-left').removeClass('text-center').removeClass('text-right').addClass(value);
});

//
// switch wide / boxed header image
//
$(document).on('change', '.select-banner-width input:radio', function() {
    var value = '';
    switch($(this).val()) {
        case 'wide':
            value = '';
            break;
        case 'boxed':
            value = 'boxed';
            break;
        default:
            value = '';
    }
    $('.wrap-image-header').removeClass('boxed').addClass(value);
});

//
// toggle allow/reject extensions on the fly
//
$(document).on('change', '.togglext', function() {
    switchExtensions();
});

//
// change individual progress bar color on the fly
//
function updateSingleBar($newclass) {
    $('.progress-single .progress-bar').removeClass().addClass('progress-bar').addClass($newclass);
}

function updateDefaultBar($newclass) {
    $('.first-progress').data('color', $newclass);
    $('.first-progress').next().find('.progress-bar').removeClass().addClass('progress-bar').addClass($newclass);

    if ($('.first-progress').is(':checked')) {
        updateSingleBar($newclass);
    }
}
$(document).on('change', '.pro input:radio', function() {
    var newclass = $(this).data('color');
    updateSingleBar(newclass);
});

$(document).on('change', '.skinswitch', function() {
    var newclass = $(this).find(':selected').data('color');
    updateDefaultBar(newclass);
});

function checkFixedlabel(){
    var scroll = $(window).scrollTop();
    var lab = $('.fixed-label');
    var labw = lab.width();
    if (scroll > 180) {
        $('.fixed-label').css('right', 0);
    } else {
        $('.fixed-label').css('right', -labw);
    }
}

$(window).scroll(function (event) {
    checkFixedlabel()
});

 /** 
 * ****************************************
 * Veno file manager Admin DocReady calls
 * ****************************************
 */
$(document).ready(function () {

    // save settings fixed label
    $('.fixed-label').removeClass('hidden').addClass('animated');
    checkFixedlabel();

    //
    // toggle allow/reject extensions
    //
    switchExtensions();

    //
    // slider
    //
    $('.slider').each(function(){
        var stoslider = $(this);
        var setslider = stoslider.closest('.row').find('.set-slider input');

        stoslider.slider();
        // change slider from input
        setslider.on("change", function() {
            var thisval = $(this).val();
            stoslider.slider('setValue', parseInt(thisval), false, true);
        });
    });

    // change header padding preview
    var header_padding = $('input[name=header_padding]').val();

    $('.place-main-header').css({
        'padding-top': header_padding+'px',
        'padding-bottom': header_padding+'px'
    });

    $(".header-padding").on("change", function(slideEvt) {
        $(this).closest('.row').find('.set-slider input').val(slideEvt.value.newValue);
        $('.place-main-header').css({
            'padding-top': slideEvt.value.newValue+'px',
            'padding-bottom': slideEvt.value.newValue+'px'
        });
    });

    // change logo margin preview
    var logo_margin = $('input[name=logo_margin]').val();

    $('.logo-preview').css({
        'margin-bottom': logo_margin+'px'
    });
    $(".logo-margin").on("change", function(slideEvt) {
        $(this).closest('.row').find('.set-slider input').val(slideEvt.value.newValue);
        $('.logo-preview').css({
            'margin-bottom': slideEvt.value.newValue+'px'
        });
    });

    //
    // preview image
    //
    $('.logo-selector').on('change', function(){
        var file = $(this).prop("files")[0];
        var previewclass = $(this).data('target');
        var preview = $(previewclass);
        var reader  = new FileReader();
        reader.onloadend = function () {

            preview.closest('.placeheader').find('.deletelogo').removeClass('hidden');

            preview.attr('src', reader.result);
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {

            preview.closest('.placeheader').find('.deletelogo').addClass('hidden');

            preview.attr('src', 'admin-panel/images/placeholder.png');
        }
    });
    //
    // toggle percent % in progress bar on the fly
    //
    $("#percent").change(function() {
        var $input = $(this);
        if ($input.is( ":checked" )) {
            $('.radio').addClass('fullp');
        } else {
            $('.radio').removeClass('fullp');
        }
    }).change();

    //
    // toggle users panel
    //
    $('.toggle').each(function(){
        if (!$(this).find('input[type=checkbox]').prop('checked')){
            $(this).closest('.toggle').next().slideToggle();
        }
    });
    $('.toggle').find('input[type=checkbox]').change(function(){
        if($(this).closest('.toggle').next().length) {
            $(this).closest('.toggle').next().slideToggle();
        } else {
            $(this).closest('.toggle').parent('.toggle').next().slideToggle();
        }
    });

    $('.toggle-reverse').each(function(){
        if ($(this).find('input[type=checkbox]').prop('checked')){
            $(this).closest('.toggle-reverse').prev().slideToggle();
        }
    });
    $('.toggle-reverse').find('input[type=checkbox]').change(function(){
        $(this).closest('.toggle-reverse').prev().slideToggle();
    });

    $('.toggle-reverse-next').each(function(){
        if ($(this).find('input[type=checkbox]').prop('checked')){
            $(this).closest('.toggle-reverse-next').next().slideToggle();
        }
    });
    $('.toggle-reverse-next').find('input[type=checkbox]').change(function(){
        $(this).closest('.toggle-reverse-next').next().slideToggle();
    });

    //
    // activate tooltips
    //
    $('.tooltipper').tooltip();

    //
    // info (?) popover 
    //
    $('.pop').popover();

    //
    // logo uploader
    //
    $('.pop').popover();
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text');  
        input.val(label);
    });

    //
    // Show / hide user quota menu when new user folder input text changes
    //
    // stupid IE < 9
    var propertyChange = false;
    $(".assignnew").on("propertychange", function(e) {
        if (e.originalEvent.propertyName == "value") {
            var parente = $(this).closest('.row').find('.assignfolder');
            if ($(this).val() || parente.val()) {
                $(this).closest('.row').next().find('.userquota').fadeIn();
            } else {
                $(this).closest('.row').next().find('.userquota').fadeOut();
            }
        }
    });

    // standard mode
    $(".assignnew").on("input", function() {
        if (!propertyChange) {
            $(".assignnew").unbind("propertychange");
            propertyChange = true;
        }
        var parente = $(this).closest('.row').find('.assignfolder');
        if ($(this).val() || parente.val()) {
            $(this).closest('.row').next().find('.userquota').fadeIn();
        } else {
            $(this).closest('.row').next().find('.userquota').fadeOut();
        }
    });
    $('#newuserpanel .userquota').hide();

    //
    // set z-index to selected cooldrop
    //
    $('.cooldrop, .assignfolder').click(function(){
        $('.cooldropgroup').css('z-index', '99');
        $(this).closest('.cooldropgroup').css('z-index', '100');
    });

    //
    // Start multiselects
    //
    $('.coolselect').multiselect({
        buttonWidth: '100%',
        buttonContainer: '<div class="btn-group btn-block" />'
    });

    //
    // Start summernote WYSIWYG rich text editor for description
    //
    $('.summernote').summernote({
        height: 100,
        minHeight: 20,
        maxHeight: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']],
            ['para', ['paragraph']],
            ['inset', ['link']],
            ['misc', ['codeview']],
        ]
    });

    //
    // Update background for analytics panel
    //
    if($('.checkstats').prop('checked')) {
        $('.checkstats').closest('.info-box').addClass('bg-green').removeClass('bg-green-active');
    } else {
        $('.checkstats').closest('.info-box').addClass('bg-green-active').removeClass('bg-green');
    }

    //
    // Update background for registration panel
    //
    if($('.checkregs').prop('checked')) {
        $('.checkregs').closest('.info-box').addClass('bg-aqua').removeClass('bg-aqua-active');
    } else {
        $('.checkregs').closest('.info-box').addClass('bg-aqua-active').removeClass('bg-aqua');
    }

    //
    // Smooth scroll admin area
    //
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                  scrollTop: target.offset().top
                }, 800);
                return false;
            }
        }
    });
});
