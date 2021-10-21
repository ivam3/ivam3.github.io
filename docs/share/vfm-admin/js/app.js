/*! VFM 3 - veno file manager main functions */
/* 
 * Close alert message
 */
function closeAlert(){
    $('.alert-wrap').fadeOut('slow', function(){
        $(this).remove();
    });
};

$(document).on('click', '.alert .close', function () {
    closeAlert();
});

$(document).on('click', '.main-content', function () {
    if ($('.sticky-alert').length){
        closeAlert();
    }
});

// Accept terms and conditions
$(document).on('submit', '.loginform', function (event) {
    if ($('#agree').length && !$('#agree').prop('checked')){
        var transaccept = $('#trans_accept_terms').val();
        $('#error').html('<div class="alert-wrap sticky-alert top-right"><div class="response nope alert" role="alert">'+transaccept+'<button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button></div></div>');
        $('#agree').focus();
        return false;
    }
});

// Close sticky after scroll
var scrollTimer, closeTimer;
$(window).on('load', function(){
    if (scrollTimer) {
        clearTimeout(scrollTimer);
    }
    if ($('.sticky-alert').length){
        scrollTimer = setTimeout(function(){
            $(window).one('scroll', function() {
                if ( closeTimer ) {
                    clearTimeout(closeTimer);
                }
                scrollTimer = setTimeout(function(){
                    closeAlert();
                }, 2000);
            });
        }, 500);
    }
});

/**
 * Clipboard
 */
function callClipboards(){
    var clipboardSnippets = new Clipboard('.clipme');
    var timer = window.setTimeout(function() {
        $('.clipme').popover('destroy');
    }, 1000);
    clipboardSnippets.on('success', function(e) {
        window.clearTimeout(timer);

        $('.clipme').popover('show');
        timer = setTimeout(function() {
            $('.clipme').popover('destroy');
        }, 1000);
    });
}

/**
 * Call vid preview 
 */
$(document).on('click', 'a.vid', function(e) {
    e.preventDefault();
    $('.navigall').remove();
    var thislink = $(this).data('link');
    var thislinkencoded = $(this).data('linkencoded');
    var thisname = $(this).data('name');
    var thisID = $(this).parents('.rowa').attr('id');
    var thisExt = $(this).data('ext').toLowerCase();

    loadVid(thislink, thislinkencoded, thisname, thisID, thisExt);
});

/**
 * Call image preview 
 */
$(document).on('click', 'a.thumb', function(e) {
    e.preventDefault();
    $('.navigall').remove();
    var thislink = $(this).data('link');
    var thislinkencoded = $(this).data('linkencoded');
    var thisname = $(this).data('name');
    var thisID = $(this).parents('.rowa').attr('id');
    var thisExt = $(this).data('ext').toLowerCase();

    loadImg(thislink, thislinkencoded, thisname, thisID, thisExt);
});

/**
 * Return first item from the end of the gallery
 */
jQuery.fn.firstAfter = function(selector) {
    return this.nextAll(selector).first();
};
jQuery.fn.firstBefore = function(selector) {
    return this.prevAll(selector).first();
};

/**
 * Setup gallery navigation
 */
function checkNextPrev(currentID){

    var current = $('#'+currentID);
    var nextgall = current.firstAfter('.gallindex').find('.vfm-gall');
    var prevgall = current.firstBefore('.gallindex').find('.vfm-gall');

    if (nextgall.length > 0){

        var nextlink = nextgall.data('link');
        var nextlinkencoded = nextgall.data('linkencoded');
        var nextname = nextgall.data('name');
        var nextID = current.firstAfter('.gallindex').attr('id');
        var nextmedia =  nextgall.data('type');
        var nextext = nextgall.data('ext');

        if ($('.nextgall').length < 1) {
            $('.vfm-zoom').append('<a class="nextgall navigall"><span class="fa-stack"><i class="fa fa-angle-right fa-stack-1x fa-inverse"></i></span></a>');
        }
        $('.nextgall').data('link', nextlink);
        $('.nextgall').data('linkencoded', nextlinkencoded);
        $('.nextgall').data('name', nextname);
        $('.nextgall').data('id', nextID);
        $('.nextgall').data('type', nextmedia);
        $('.nextgall').data('ext', nextext);

    } else {
        $('.nextgall').remove();
    }

    if (prevgall.length > 0){

        var prevlink = prevgall.data('link');  
        var prevlinkencoded = prevgall.data('linkencoded');
        var prevname = prevgall.data('name');
        var prevID = current.firstBefore('.gallindex').attr('id');
        var prevmedia = prevgall.data('type');
        var prevext = prevgall.data('ext');

        if ($('.prevgall').length < 1) {
            $('.vfm-zoom').append('<a class="prevgall navigall"><span class="fa-stack"><i class="fa fa-angle-left fa-stack-1x fa-inverse"></i></span></a>');
        }
        $('.prevgall').data('link', prevlink);
        $('.prevgall').data('linkencoded', prevlinkencoded);
        $('.prevgall').data('name', prevname);
        $('.prevgall').data('id', prevID);
        $('.prevgall').data('type', prevmedia);
        $('.prevgall').data('ext', prevext);

    } else {
        $('.prevgall').remove();
    }
}

/**
 * navigate through image preview gallery
 */
$(document).on('click', 'a.navigall', function(e) {
    var thislink = $(this).data('link');
    var thislinkencoded = $(this).data('linkencoded');
    var thisname = $(this).data('name');
    var thisID = $(this).data('id');
    var mediatype = $(this).data('type');
    var thisExt = $(this).data('ext');

    $('.navigall').remove();

    if ( $( "#my-video" ).length ) {
        videojs('#my-video').dispose();
    }

    if (mediatype == 'video') {
        loadVid(thislink, thislinkencoded, thisname, thisID, thisExt);
    } else {
        loadImg(thislink, thislinkencoded, thisname, thisID);
    }
});

/**
* navigate with arrow keys
*/
$(document).keydown(function(e) {
    if(e.keyCode == 39 && $('.nextgall').length > 0) { // right
        $('.nextgall').trigger('click');
    }

    if(e.keyCode == 37 && $('.prevgall').length > 0) { // left
        $('.prevgall').trigger('click');
    }
});

$(document).ready(function(e) {
    $('#zoomview').on('hidden.bs.modal', function () {
        $('.navigall').remove();
        
        if ($( "#my-video" ).length) {
            videojs('#my-video').dispose();
        }
    });
});

/**
* Rename file and folder 
*/
$(document).on('click', '.rename', function(e) {
	e.preventDefault();
    var thisname = $(this).data('thisname');
    var thisdir = $(this).data('thisdir');
    var thisext = $(this).data('thisext');
    $('#newname').val(thisname);
    $('#oldname').val(thisname);
    $('#dir').val(thisdir);
    $('#ext').val(thisext);
    $('#modalchangename').modal();
});

/**
* password confirm
*/
$('#usrForm').submit(function(e){
    if($('#oldp').val().length < 1) {
        $('#oldp').focus();
        e.preventDefault();
    }
    if($('#newp').val() != $('#checknewp').val()) {
        $('#checknewp').focus();
        e.preventDefault();
    }
});

/**
* password reset 
*/
$('#rpForm').submit(function(e){
    if ($('#rep').val().length < 1) {
        $('#rep').focus();
        e.preventDefault();
    }
    if ($('#rep').val() != $('#repconf').val()) {
        $('#repconf').focus();
        e.preventDefault();
    }
});

/**
* send link to reset password 
*/
$(document).on('keyup keypress', '#sendpwd', function(e){
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
});

$(document).on('submit', '#sendpwd', function(event) {
    event.preventDefault();
    var serialize = $(this).serialize();
    var time = (new Date).getTime();
    $('.mailpreload').fadeIn(function(){
        $.ajax({
            type: "POST",
            url: "vfm-admin/ajax/sendpwd.php",
            data: serialize
            })
            .done(function( msg ) {
                $('.sendresponse').html(msg).fadeIn();
                $('.mailpreload').fadeOut();
                $('#captcha').attr('src', 'vfm-admin/captcha/img.php?' + time);
                if ($('#grecaptcha').length) {
                    grecaptcha.reset();
                }
                $('#sendpwd .panel-body input').val('');
            })
            .fail(function() {
                $('.mailpreload').fadeOut();
                $('.sendresponse').html('<div class=\"alert alert-danger\">Error connecting: ajax/sendpwd</div>').fadeIn();
                $('#captcha').attr('src', 'vfm-admin/captcha/img.php?' + time);
                if ($('#grecaptcha').length) {
                    grecaptcha.reset();
                }
        });
    });
});

/**
* create a random string
*/
function randomstring() 
{
    var text = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i=0; i < 8; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

/**
* file sharing password widget
*/
function passwidget()
{
    if ($('#use_pass').prop('checked')) {
        $('.seclink').show();
    } else {
        $('.seclink').hide();
    } 
    $('.sharelink, .passlink').val('');
    $('.shalink, .openmail').hide();
    $('#sendfiles').removeClass('in');
    $('.passlink').prop('readonly', false);
    $('.createlink-wrap').fadeIn();
}

$(document).on('change', '#use_pass', function() {
    $('.alert').alert('close');
    passwidget();
});

/**
* change input value on select files
*/
$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

var selected = [];
var selectedfiles = [];

/**
* Check - Uncheck all
*/
$(document).on('click', '#selectall', function (e) {
    e.preventDefault();
    $('.selecta').prop('checked', !$('.selecta').prop('checked'));
    checkSelecta();
});

/**
* Check - Uncheck single items in grid view
*/
$(document).on('click', '.gridview .name', function(e) {
    var $rowa = $(this).parent('.rowa');
    var $selecta = $rowa.find('.selecta');
    $selecta.prop('checked', !$selecta.prop('checked'));
    checkSelecta();
});

/**
* Disable/Enable group action buttons and selected state
*/
function checkSelecta(){
    $('.selecta').each(function(){
        var $rowa = $(this).closest('.rowa');

        var id = $rowa.attr('id');
        var index = $.inArray(id, selected);

        var thisval = $(this).val();
        var indexval = $.inArray(thisval, selectedfiles);

        if ($(this).prop('checked')) {
            $rowa.addClass('attivo');

	        if ( index === -1 ) {
	            selected.push( id );
	        }
	        if ( indexval === -1 ) {
	            selectedfiles.push( thisval );
	        }
        } else {
            $rowa.removeClass('attivo');

	        if ( index !== -1 ) {
        		selected.splice( index, 1 );
	        }

	        if ( indexval !== -1 ) {
        		selectedfiles.splice( thisval, 1 );
	        }
        }
    });

    if ($('.selecta:checked').length > 0) {
        $('.groupact, .manda').attr("disabled", false);
    } else {
        $('.groupact, .manda').attr("disabled", true);
    }
}

/**
* Disable/Enable group action buttons & new directory submit
*/
$(document).ready(function(){

    $('.groupact, .manda, .upfolder').attr("disabled", true);
    checkSelecta();

    $('.upfolder-over').on('click', function(){
        $('.upload_dirname').focus();
    });

    $('.upload_dirname').keyup(function() {
        if($(this).val().length > 0){
            $('.upfolder-over').hide();
            $('.upfolder').attr("disabled", false);
        } else {
            $('.upfolder-over').show();
            $('.upfolder').attr("disabled", true);
       }
    });
});

/**
* Get highest value from array.
*/
function getHighest($array){
    var biggest = Math.max.apply( null, $array );
    return biggest;
}

/**
* Set placeholder height.
*/
function placeHolderheight(){
    var arrayW = [];
    var thisW;
    $('.icon-placeholder').css('height', '30px');
    $('.inlinethumbs .icon-placeholder').css('height', '60px');
    $('.gridview .icon-placeholder').each(function(){
        thisW = $(this).width();
        arrayW.push(thisW);
    });
    var biggest = getHighest(arrayW);
    $('.gridview .icon-placeholder').css('height', biggest);

    // Set .owerflowed class to animate the title
    $('.gridview .grid-item-title span').each(function(){

        var divWidthBefore = $(this).parent().width();
        $(this).css('width','auto');
        var divWidth = $(this).outerWidth();
        $(this).css('width','');

        if (divWidth > divWidthBefore) {
            $(this).addClass('overflowed');
        } else {
            $(this).removeClass('overflowed');
        }
    });
}

/**
* Update session data.
*/
function updateSession($data){
    $.ajax({
        method: "POST",
        url: "vfm-admin/ajax/session.php",
        data: $data,

    }).fail(function( jqXHR, textStatus ) {
        console.log( "updateSession() Request failed: " + textStatus );
    });
}

/**
* Switch grid view and list view.
*/
$(document).on('click', '.switchview', function(e){
    var $switcher = $(this);
    var $table = $switcher.closest('.tableblock').find('.dataTable');
    e.preventDefault();
    $table.animate({
        opacity: 0
    }, 300, 'linear', function(){

        if ($switcher.hasClass('grid')) {
            $switcher.removeClass('grid');

            $table.addClass('listview').removeClass('gridview');

            updateSession({ listview: 'list' });
            // Adjust file table coulms if resized in the other view
            fileTable.columns.adjust();
        } else {
            $switcher.addClass('grid');
            $table.addClass('gridview').removeClass('listview');

            updateSession({ listview: 'grid' });
        }
        // redraw placeholder height
        placeHolderheight();

        $table.animate({
            opacity: 1
        }, 300, 'linear');
    });
});

/**
* Adjust grid view item height
*/
$(window).resize(function(){
    placeHolderheight();
});

$(document).on('change', '.selecta', function () {
    checkSelecta();
});

/**
* Activate tooltips
*/
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip({
    // container: 'body'
  })
});

/**
* Check - Uncheck all users
*/
$(document).on('click', '.selectallusers', function() {
    $('.selectme').prop('checked',!$('.selectme').prop('checked'));
    checkNotiflist();
});

/**
* Change notify users icon
*/
function checkNotiflist(){
    var anyUserChecked = $('#userslist :checkbox:checked').length > 0;
    if (anyUserChecked == true) {
        $('.check-notif').removeClass('fa-circle-o').addClass('fa-check-circle');
    } else {
        $('.check-notif').removeClass('fa-check-circle').addClass('fa-circle-o');
    }
}

$(document).ready(function(){
    $('#userslist :checkbox').change(function() {
        checkNotiflist();
    });
});

/**
* Init FileTable and FolderTable
*/
var folderTable;
var fileTable;

function callTables(tablesettings, filetableconfig, foldertableconfig){
    var paginationTemplate = {
        emptyTable     : '--',
        info           : '_START_-_END_ / _TOTAL_ ',
        infoEmpty      : '',
        infoFiltered   : '',
        infoPostFix    : '',
        lengthMenu     : '_MENU_',
// lengthMenu : [[5, 10, 25, 50, 100, 200], [5, 10, 25, 50, 100, 200]],
        loadingRecords : '...',
        processing     : '<i class="fa fa-circle-o-notch fa-spin fa-2x"></i>',
        search         : '<span class="input-group-addon"><i class="fa fa-search"></i></span> ',
        zeroRecords    : '--',
        paginate : {
            first    : '<i class="fa fa-angle-double-left"></i>',
            last     : '<i class="fa fa-angle-double-right"></i>',
            previous : '<i class="fa fa-angle-left"></i>',
            next     : '<i class="fa fa-angle-right"></i>'
        }
    }

    /**
    * SetUp Files Table
    */
    var filesdom = '<"table-controls-top"fl>rt<"table-controls-bottom"ip>';
    var fileslen = filetableconfig.ilenght;
    if (filetableconfig.paginate == 'off') {
        filesdom = '<"table-controls-top"f>rt';
        fileslen = -1;
    }

    fileTable = $('#filetable').DataTable({
        dom : filesdom,
        language : paginationTemplate,
        searching : filetableconfig.show_search,
        // lengthMenu : [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
        searchDelay: 800,
        pageLength : fileslen,
        pagingType : filetableconfig.pagination_type,
        columnDefs : [
            { 
                width      : '50%',
                targets    : [ 2 ],
            },
            { 
                width      : '10%',
                targets   : [ 3 ],
            },
            { 
                width      : '20%',
                targets   : [ 4 ],
            //    visible: false,
            }
        ],

        processing: true,
        serverSide: true,
        ajax: {
            url : "vfm-admin/ajax/get-files.php",
            // type: 'POST',
            data : {
                'dir' : tablesettings.dir,
                // 'fullpath' : tablesettings.fullpath
            },
        },
        order: [[ filetableconfig.sort_col, filetableconfig.sort_order ]],

        columns : filetableconfig.columns,

        // Add gallery class & ID to row with thumbs and videos
        createdRow : function ( row, data, index ) {
            $(row).addClass('rowa');
            if ($(row).find('.thumb').length || $(row).find('.vid').length) {
                $(row).addClass('gallindex');
            }
        },

        // Reset placeholder height when changing page
        drawCallback: function( settings ) {

        	// check selcted from other page
			$.each(selected, function(index, item) {
				$('#'+item).find('.selecta').prop('checked', true);
			});

            checkSelecta();

            var imgs = $(this).find('.thumb img');
            var count = imgs.length;
            imgs.on('load', function() {
                count--;
                if (!count) {
                    placeHolderheight();
                }
            }).each(function() {
                if (this.complete) {
                    $(this).trigger('load');
                }
            });

            var api = this.api();
            var pageinfo = api.page.info();
            var paginateRow = $(this).parent().find('.dataTables_paginate');  

            // Hide pagination if we have only one page.
            if (pageinfo.recordsDisplay <= api.page.len()) {
                paginateRow.css('display', 'none');
            } else {
                paginateRow.css('display', 'block');
            }
            placeHolderheight();

            // Stop all sounds
            if ($('.sm2_button').length && VFMinlinePlayer !== null) {
                VFMinlinePlayer.removeEventHandler(document, 'click', VFMinlinePlayer.handleClick);
                VFMinlinePlayer.init();
            }
        },

        initComplete : function() {
            checkSelecta();
            placeHolderheight();
            // Fade In filemanager tables on load
            $(this).closest('.tableblock.ghost').removeClass('ghost-hidden');
            $(this).closest('.vfmblock').find('.overload').remove();

            var api = this.api();
            var pageinfo = api.page.info();
            
            // Hide table if we have no items
            if (pageinfo.recordsDisplay < 1){
                $(this).closest('.vfmblock').hide();
                $('.hidetable').removeClass('hidden');
            } else {
                $('.hidetable').addClass('hidden');
            }
        }
    });

    // Call file search from url option ?s=
    if (filetableconfig.search) {
        fileTable.search( filetableconfig.search ).draw();
    }

    // Save items length state to session.
    fileTable.on( 'length.dt', function ( e, settings, len ) {
        updateSession({ iDisplayLength: len });
    });

    // Save items order state to session.
    fileTable.on( 'order.dt',  function ( e, settings, val ) {
        updateSession({ sort_col: val[0].col, sort_order: val[0].dir });
    });

    /**
    * SetUp Folders Table
    */
    var folderdom = '<"table-controls-top"fl>rt<"table-controls-bottom"ip>';
    var folderlen = foldertableconfig.dirlenght;

    if (foldertableconfig.paginate == 'off') {
        folderdom = 'rt';
        folderlen = -1;
    }

    folderTable = $('#foldertable').DataTable( {
        dom : folderdom,
        language : paginationTemplate,
        searchDelay: 800,
        pageLength : folderlen,
        pagingType : foldertableconfig.pagination_type,
        processing: true,
        serverSide: true,
        lengthMenu : [[5, 10, 25, 50], [5, 10, 25, 50]],
        columnDefs : [ 
            { 
                width      : '5%',
                targets    : [ 0 ],
            },
            { 
                width      : '60%',
                targets    : [ 1 ],
            },
            { 
                width     : '20%',
                targets   : [ 2 ],
            },
        ],
        ajax: {
            url : "vfm-admin/ajax/get-dirs.php",
            // type: 'POST',
            data : {
                'dir' : tablesettings.dir,
                // 'fullpath' : tablesettings.fullpath
            },
        },

        // Default Order
        order: [[ foldertableconfig.sort_dir_col, foldertableconfig.sort_dir_order ]],
        columns : foldertableconfig.columns,

        // Add gallery calass & ID to row with thumbs and videos
        createdRow : function ( row, data, index ) {
            $(row).addClass('rowa');
        },

        initComplete : function() {
            // Fade In table on load
            $(this).closest('.tableblock.ghost').removeClass('ghost-hidden');

            var api = this.api();
            var pageinfo = api.page.info();
            var paginateRow = $(this).parent().find('.dataTables_paginate');  
            
            // Hide the whole block if we have no items
            if (pageinfo.recordsDisplay < 1){
                $(this).closest('.vfmblock').hide();
            }

            // Hide pagination if we have only one page.
            if (pageinfo.recordsDisplay <= api.page.len()) {
                paginateRow.css('display', 'none');
            } else {
                paginateRow.css('display', 'block');
            }
        }

    });

    // Call folder search from url option ?sd=
    if (foldertableconfig.search) {
        folderTable.search(foldertableconfig.search).draw();
    }

    // Save items length state to session.
    folderTable.on( 'length.dt', function ( e, settings, len ) {
        updateSession({ dirlenght: len });
    });

    // Save items order state to session.
    folderTable.on( 'order.dt',  function ( e, settings, val ) {
        updateSession({ sort_dir_col: val[0].col, sort_dir_order: val[0].dir });
    });
}

/**
* global search
*/
function printSearch(result, lang_files, lang_folders) {

    var response_holder = $('#global-search').find('.modal_response');
    var responsedir = '';
    var responsefile = '';

    if (result.dirlist.length) {
        responsedir = '<h4><i class="fa fa-folder fa-fw"></i> '+lang_folders+'</h4>';
        responsedir += '<ul>';
        $.each(result.dirlist, function(i, item) {
            responsedir += '<li><a href="'+item.link+'"><i class="fa fa-angle-right fa-fw"></i> '
            +item.location+'/ <strong>'+item.name+'</strong></a></li>';
        });
        responsedir += '</ul>';
    }
    if (result.filelist.length) {
        responsefile = '<h4><i class="fa fa-file fa-fw"></i> '+lang_files+'</h4>';
        responsefile += '<ul>';

        $.each(result.filelist, function(i, item) {
            responsefile += '<li><a href="'+item.link+'"><i class="fa fa-angle-right fa-fw"></i> '
            +item.location+'/ <strong>'+item.name+'</strong></a></li>';
        });
        responsefile += '</ul>';
    }

    if (!result.filelist.length && !result.dirlist.length){
        responsedir = '<h4 class="text-center">'+result.no_items+'</h4>';
    }
    var total = result.count_total;
    var filtered = result.count_filtered;
    var numbers = '<p class="form-group">' + filtered + ' / ' + total +'</p>';
    
    var result = responsedir + responsefile;

    $(response_holder).fadeOut(function(){
        $(this).html(result).append(numbers).fadeIn();
    });
}

function initSearch(lang_files, lang_folders) {
    $('#s-input').on('input', function(){
        if ($(this).val().length > 1) {
            $('#search-form').removeClass('disabled');
            $('.submit-search').removeClass('disabled');
        } else {
            $('#search-form').addClass('disabled');
            $('.submit-search').addClass('disabled');      
        }
    });

    $('#search-form').on('submit', function(e){

        e.preventDefault();

        if (!$(this).hasClass('disabled')) {

            $(this).addClass('disabled');
            $('.submit-search').addClass('disabled');

            var response_holder = $(this).find('.modal_response');
            var search = $(this).find('#s-input').val();
        
            if (search.length) {

                $(response_holder).html('<div class="text-center"><i class="fa fa-refresh fa-spin"></i></div>');

                $.ajax({
                    cache: false,
                    type: "GET",
                    dataType: 'json',
                    url: "vfm-admin/ajax/get-search.php?s=" + search
                })
                .done(function( msg ) {
                    printSearch(msg, lang_files, lang_folders);
                })
                .fail(function() {
                    $(response_holder).html('ERROR connecting get-search.php');
                });
            }
        }
    });
}

/**
* Remove query string from url
*/
function removeQS(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter)+'=';
        var pars = urlparts[1].split(/[&;]/g);
        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }
        url = urlparts[0]+'?'+pars.join('&');
        return url;
    } else {
        return url;
    }
}

/**
* ZIP Folder
*/
function createZipDir(folder, dash){

    var arrows = '<i class="fa fa-angle-double-right fa-3x fa-fw passing-animated"></i>';
    var checked = '<i class="fa fa-check fa-3x fa-fw"></i>';
    var erroricon = '<i class="fa fa-times fa-3x fa-fw"></i>';
    $('#zipmodal .ziparrow').html(arrows);

    $('#zipmodal').modal();

    $.ajax({
        cache: false,
        type: "POST",
        url: "vfm-admin/ajax/zip.php?t=" + (new Date).getTime(),
        data: {
            fold: folder,
            dash: dash
        }
    })
    .done(function( msg ) {

        var json = JSON.parse(msg); 

        if (json.error === false) {
            var message = '<a class="btn btn-primary btn-block downzip" href="' + json.link +'"><i class="fa fa-download"></i> '
            + json.filename +'</a>';
            $('#zipmodal .ziparrow').html(checked);
        } else {
            var message = json.error;
            $('#zipmodal .ziparrow').html(erroricon);
        }
        $('#zipmodal .modal-footer .text-center').html(message);

        // Automatically start folder download if modal has been closed before
        if ($('.downzip').length && ! $("#zipmodal").data('bs.modal').isShown) {
            var zipdest = $('.downzip').attr('href');
            $('.downzip').remove();
            window.location.href = zipdest;
        }
    })
    .fail(function() {
        alert('ERROR generating zip');
    });
}

/**
* Prepare ZIP Folder
*/
function callBindZip($message){
    var bindZip = function(event) {

        var folder = $(this).data('zip');
        var foldername = $(this).data('thisname');
        var dash = $(this).data('dash');
        var $fullmessage = $message + ': <strong>' + foldername + '</strong>';

        event.preventDefault();
        $(document).off('click', '.zipdir');

        bootbox.confirm({
            // size: 'small',
            title: '<i class="fa fa-cloud-download"></i>',
            message: $fullmessage, 
            callback: function(result) {
                $(document).on('click', '.zipdir', bindZip);
                if (result) {
                    createZipDir(folder, dash);
                }
            }
        });
    };
    $(document).on('click', '.zipdir', bindZip);
}

// close multiple download modal after click
$(document).on('click', '#zipmodal .downzip', function() {
    $('#zipmodal').modal('hide');
    $(this).remove();
});

/**
* FILE SHARING & MULTIPLE FILE zip DOWNLOAD
*/
function createShareLink($insert4, $time, $hash, $pulito, $activepagination, $maxzipfiles, $selectfiles, $toomanyfiles, $prettylinks) {

    var divar = selectedfiles;
    var zipPreloader = '<i class="fa fa-files-o fa-5x fa-fw"></i> <i class="fa fa-angle-double-right fa-5x fa-fw passing-animated"></i> <i class="fa fa-file-archive-o fa-5x fa-fw"></i>';

    /**
    * Create sharable link
    */
    $(document).on('click', '#createlink', function() {

        $('.alert').alert('close');
        var alertmess = '<div class="alert alert-warning alert-dismissible" role="alert">' + $insert4 + '</div>';
        var shortlink, passw

        // check if wants a password
        if ($('#use_pass').prop('checked')) {
            if (!$('.setpass').val()) {
                passw = randomstring();
            } else {
                if ($('.setpass').val().length < 4) {
                    $('.setpass').focus();
                    $('.seclink').after(alertmess);
                    return;
                } else {
                    passw = $('.setpass').val();
                }
            }  
        }
        $.ajax({
            cache: false,
            type: "POST",
            url: "vfm-admin/ajax/shorten.php",
            data: {
                atts: divar.join(','),
                time: $time,
                hash: $hash,
                pass: passw
            }
        })
        .done(function( msg ) {
            shortlink = $pulito + '/?dl=' + msg;
            $('.sharelink').val(shortlink);
            $('.sharebutt').attr('href', shortlink);
            $('.passlink').val(passw);
            $('.passlink').prop('readonly', true);
            
            $('.createlink-wrap').fadeOut('fast', function(){
                $('.shalink').fadeIn();
                $('.openmail').fadeIn();
            });
        })
        .fail(function() {
            console.log('ERROR generating shortlink');
        });
    });

    // prevent form submitting with enter
    $(document).on("keyup keypress", "#sendfiles :input:not(textarea)", function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    /**
    * Send link via e-mail
    */
    $(document).on('click', '.manda', function () {

        var divar = [];
        var numfiles = selectedfiles.length;

        if (numfiles > 0) { 
        	divar = selectedfiles;
            // reset form
            $('.addest').val('');
            $('.shownext').addClass('hidden');
            $('.bcc-address').remove();

            $('.seclink, .shalink, .mailresponse, .openmail').hide();
            $('#sendfiles').removeClass('in');
            $('.sharelink, .passlink').val('');
            $('.sharebutt').attr('href', '#');
            $('.createlink-wrap').fadeIn();

            passwidget();

            // populate send inputs
            $('.attach').val(divar.join(','));
            $('.numfiles').html(numfiles);

            // open modal
            $('#sendfilesmodal').modal();

            $('#sendfiles').unbind('submit').submit(function(event) {
                event.preventDefault();
                $('.mailpreload').fadeIn();
                var now = $.now();

                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "vfm-admin/ajax/sendfiles.php?t=" + now,
                    data: $('#sendfiles').serialize()
                })
                .done(function( msg ) {
                    $('.mailresponse').html('<div class="alert alert-success">' + msg + '</div>').fadeIn();
                    $('.addest').val('');
                    $('.shownext').addClass('hidden');
                    $('.bcc-address').remove();
                    $('.mailpreload').fadeOut();
                })
                .fail(function() {
                    $('.mailpreload').fadeOut();
                    $('.mailresponse').html('<div class="alert alert-danger">Error connecting sendfiles.php</div>');
                });
            });
        } else {
            alert($selectfiles);
        }
    }); // end .manda click

    /**
    * Download multiple files as zip archive
    */
    $(document).on('click', '.multid', function(e) {
        e.preventDefault();

        var arrows = '<i class="fa fa-angle-double-right fa-3x fa-fw passing-animated"></i>';
        var checked = '<i class="fa fa-check fa-3x fa-fw"></i>';
        var erroricon = '<i class="fa fa-times fa-3x fa-fw"></i>';
        $('#downloadmulti .modal-body .ziparrow').html(arrows);

        $('#downloadmulti .modal-footer .text-center').html('');

        var divar = [];
        var numfiles = selectedfiles.length;

        if (numfiles > 0) { 
        	divar = selectedfiles;

            if (numfiles >= $maxzipfiles) {
                alert($toomanyfiles + ' ' + $maxzipfiles);
            } else {

                // generate short url for multiple downloads
                $('#downloadmulti .numfiles').html(numfiles);
                $('#downloadmulti').modal();

                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "vfm-admin/ajax/zip.php?t=" + (new Date).getTime(),
                    data: {
                        filesarray: divar.join(','),
                        time: $time,
                        dash: $hash
                    }
                })
                .done(function( msg ) {
                    var json = JSON.parse(msg); 

                    if (json.error === false) {
                        var message = '<a class="btn btn-primary btn-block downzip" href="' + json.link +'"><i class="fa fa-download"></i> '+ json.filename +'</a>';
                        $('#downloadmulti .modal-body .ziparrow').html(checked);
                    } else {
                        var message = json.error;
                        $('#downloadmulti .modal-body .ziparrow').html(erroricon);
                    }

                    $('#downloadmulti .modal-footer .text-center').html(message);
                })
                .fail(function() {
                    alert('ERROR generating zip');
                });
            }
        } else {
            alert($selectfiles);
        }
    }); // end .multid click

    // close multiple download modal after click
    $(document).on('click', '#downloadmulti .downzip', function() {
        $('#downloadmulti').modal('hide');
    });
}

/**
* Download shared files zip archive
*/
$(document).on('click', '.zipshare', function(e) {
    e.preventDefault();

    var zipPreloader = '<button class="btn btn-primary btn-lg"><i class="fa fa-files-o fa-2x fa-fw"></i> <i class="fa fa-angle-double-right fa-2x fa-fw passing-animated"></i> <i class="fa fa-file-archive-o fa-2x fa-fw"></i></button>';

    var wrapper = $(this).parent();

    wrapper.html(zipPreloader);

    var downloadlist = $(this).data('downloadlist');
    var dash = $(this).data('hash');
    var time = $(this).data('time');
    var onetime = $(this).data('onetime');

    $.ajax({
        cache: false,
        type: "POST",
        url: "vfm-admin/ajax/zip.php?t=" + (new Date).getTime(),
        data: {
            filesarray: downloadlist,
            onetime: onetime,
            dash: dash,
            time: time,
        }
    })
    .done(function( msg ) {

        var json = JSON.parse(msg); 

        if (json.error === false) {
            var message = '<a class="btn btn-primary btn-lg downzipshare" href="'
            +json.link+'"><i class="fa fa-download fa-2x"></i> '
            +json.filename+'</a>';
        } else {
            var message = json.error;
        }
        wrapper.html(message);
    })
    .fail(function() {
        alert('ERROR generating zip');
    });
});

// remove zip download button after click
$(document).on('click', '.downzipshare', function() {
    $(this).remove();
});

/**
* Add mail recipients (file sharing) 
*/
$(document).on('click', '.shownext', function(){
    var $lastinput = $(this).parent().prev().find('.form-group:last-child .addest');

    if ($lastinput.val().length < 5) {
        $lastinput.focus();
    } else {
        var $newdest, $inputgroup, $addon, $input;
        
        $input = $('<input name="send_cc[]" type="email" class="form-control addest">');
        $addon = $('<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>');
        $inputgroup = $('<div class="input-group"></div>').append($addon).append($input);
        $newdest = $('<div class="form-group bcc-address"></div>').append($inputgroup);

        $('.wrap-dest').append($newdest);
    }
});

/**
* Show additional recipients
*/
$(document).on('input', '#dest', function() {
    if ( $(this).val().length > 5 ) {
        $('.shownext').removeClass('hidden');
    } else {
        $('.shownext').addClass('hidden');        
    }
});

/**
* DELETE FILES
*/
function setupDelete($confirmthisdel, $confirmdel, $activepagination, $time, $hash, $selectfiles) {
    /**
    * Delete single file or folder
    */
    var delSingle = function(event) {
        event.preventDefault();

        $(document).off('click', '.del');

        var dest = $(this).data('link');
        var message = ' <strong>' + $(this).data('name') + "<strong>";

        bootbox.confirm({
            title: '<i class="fa fa-trash"></i>',
            message: $confirmthisdel + message, 
            callback: function(result) {
                $(document).on('click', '.del', delSingle );
                if (result) {
                    window.location.href = dest;
                }
            }
        });
    };

    $(document).on('click', '.del', delSingle);

    /**
    * Delete multiple files
    */
    var delMulti = function(event) {
        event.preventDefault();
        $(document).off('click', '.removelink');

        bootbox.confirm({
            title: '<i class="fa fa-trash"></i>',
            message: $confirmdel, 
            callback: function(answer) {

                $(document).on('click', '.removelink', delMulti);
                var deldata = $('#delform').serializeArray();

                if (answer) {
                    $.ajax({
                        type: "POST",
                        url: "vfm-admin/ajax/vfm-del.php",
                        data: deldata
                    })
                    .done(function( msg ) {
                        if (msg == 'ok') {
                            var location = removeQS(window.location.href, 'response');
                            location = removeQS(location, 'del');
                            window.location = location;
                        } else {
                            $('.delresp').html(msg);
                        }
                    })
                    .fail(function() {
                        $('.delresp').html( 'error connecting to vfm-del.php' );
                    });
                }
            }
        });
    }

    $(document).on('click', '.removelink', delMulti);

    /**
    * Setup multi delete button
    */
    $(document).on('click', '.multic', function(e) {
        e.preventDefault();
        
        var divar = [];
        var numfiles = selectedfiles.length;

        if (numfiles > 0) { 
        	divar = selectedfiles;

            $('#delform').append('<input type="hidden" name="setdel" value="' + divar + '">');
            $('#delform').append('<input type="hidden" name="t" value="' + $time + '">');
            $('#delform').append('<input type="hidden" name="h" value="' + $hash + '">');
            $('#deletemulti .numfiles').html(numfiles);
            $('#deletemulti').modal();
        } else {
            alert($selectfiles);
        }
    }); 
}

/**
* MOVE FILES
*/
function pupulateMoveCopyform($activepagination, $selectfiles, $time, $hash) {

    var divar = [];
    var numfiles = selectedfiles.length;

    if (numfiles > 0) { 
    	divar = selectedfiles;
        $('.moveform').append('<input type="hidden" name="setmove" value="' + divar + '">');
        $('.moveform').append('<input type="hidden" name="t" value="' + $time + '">');
        $('.moveform').append('<input type="hidden" name="h" value="' + $hash + '">');
    } else {
        alert($selectfiles);
    }
}

/**
* Folder Tree
*/
function setupFolderTree(currentdir, __root) {

    $('.archive-map').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget) // Button that triggered the modal
        var action = button.data('action');
        var modal = $(this);
        var wrapresult = modal.find('.modal-result');

        if (!wrapresult.hasClass('loaded')) {

            wrapresult.html('<div class="foldertreepreload"><div class="cta"><i class="fa fa-refresh fa-spin"></i></div></div>');

            var request = $.ajax({
                url: "vfm-admin/ajax/get-filetree.php",
                method: "POST",
                data: { 
                    'action' : action,
                    'currentdir' : currentdir, 
                    '__root' : __root,
                }
            });

            request.done(function( msg ) {
                wrapresult.html( JSON.parse(msg) ).addClass('loaded');
                treeToggler();
            });

            request.fail(function( jqXHR, textStatus ) {
                wrapresult.html( "Request failed: " + textStatus );
            });
        }
    });
}

/**
* Folder tree toggler
*/
function treeToggler(){
    // Toggle single folder
    $('.toggle-tree').on('click', function(){
        $(this).next('ul').slideToggle();
        $(this).find('.tree-toggler').toggleClass("fa-minus-square-o fa-plus-square-o");
    });

    // Toggle all folders
    $('.toggle-all-tree').on('click', function(){
        var treetoggler = $(this).find('.tree-toggler');
        treetoggler.toggleClass("fa-minus-square fa-plus-square");

        if (treetoggler.hasClass('fa-minus-square')) {
            $('.toggle-tree').each(function(){
                $(this).next('ul').show();
                $(this).find('.tree-toggler').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
            });
        } else {
            $('.toggle-tree').each(function(){
                $(this).next('ul').hide();
                $(this).find('.tree-toggler').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
            });
        }
    });
};

/**
* Move / Copy files
*/
function setupMove($activepagination, $selectfiles, $time, $hash) {

    // Setup multi move
    $(document).on('click', '.multimove', function(e) {
        e.preventDefault();
        $('#archive-map-move .moveform').html('');
        $('#archive-map-move .hiddenalert').html('');

        pupulateMoveCopyform($activepagination, $selectfiles, $time, $hash)
    });

    // Setup multi copy form
    $(document).on('click', '.multicopy', function(e) {
        e.preventDefault();
        $('#archive-map-copy .moveform').html('');
        $('#archive-map-copy .hiddenalert').html('');
        $('#archive-map-copy .moveform').append('<input type="hidden" name="copy" value="1">');

        pupulateMoveCopyform($activepagination, $selectfiles, $time, $hash)
    });

    $(document).on('click', '.movelink', function(e) {
        e.preventDefault();
        var dest = $(this).data('dest');

        var $hiddenalert = $(this).closest('.modal-body').find('.hiddenalert');
        var $moveform = $(this).closest('.modal-body').find('.moveform');
        
        $moveform.append('<input type="hidden" name="dest" value="' + dest + '">');

        var movedata = $moveform.serializeArray();

        $.ajax({
            cache: false,
            type: "POST",
            url: "vfm-admin/ajax/vfm-move.php?tm=" + (new Date).getTime(),
            data: movedata
        })
        .done(function(msg) {
            if (msg == 'ok') {
                var location = removeQS(window.location.href, 'response');
                location = removeQS(location, 'del');
                window.location = location;
            } else {
                var alert = '<div class="alert alert-danger" role="alert">'+msg+'</div>'
                $hiddenalert.html(alert);
            }
        })
        .fail(function() {
            var alert = '<div class="alert alert-danger" role="alert">Error connecting vfm-move.php</div>'
            $hiddenalert.html(alert);
        });
    });
}

/**
* Scroll top window
*/
$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('.to-top').fadeIn();
        } else {
            $('.to-top').fadeOut();
        }
    });

    $('.to-top').on('click', function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    })
});
