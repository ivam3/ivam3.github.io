$(document).ready(function() {
    var table = $('#sortanalytics').DataTable({
        dom        : 'lprtip',
        pagingType : 'full_numbers',
        order      : [[ 0, 'desc' ], [ 1, 'desc' ]], // Sort by first column descending
        pageLength : 25,
        lengthMenu : [[25, 50, 100, -1], [25, 50, 100, 'All']],

        language : {
            emptyTable     : '--',
            info           : '_START_-_END_ / _TOTAL_ ',
            infoEmpty      : '',
            infoFiltered   : '',
            infoPostFix    : '',
            lengthMenu     : ' _MENU_',
            loadingRecords : '<i class="fa fa-refresh fa-spin"></i>',
            processing     : '<i class="fa fa-refresh fa-spin"></i>',
            search         : '<span class="input-group-addon"><i class="fa fa-search"></i></span> ',
            zeroRecords    : '--',
            paginate : {
                first    : '<i class="fa fa-angle-double-left"></i>',
                last     : '<i class="fa fa-angle-double-right"></i>',
                previous : '<i class="fa fa-angle-left"></i>',
                next     : '<i class="fa fa-angle-right"></i>'
            }
        },
        columnDefs : [ 
            { 
                targets : [ 0 ], 
                orderData: [ 0, 1 ]
            },
            { 
                targets : [ 1 ], 
                orderable  : false
            },
            { 
                targets : [ 2, 3, 4 ]
            },
            { 
                targets : [ 5 ], 
                type : 'natural'
            }
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2, 3, 4]).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        console.log(val);
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    });
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                });
            });

            this.api().columns([5]).every( function () {
                var column = this;
                var srcfield = $('<div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control" id="srcthiscol" type="text" placeholder="Search" /></div>')
                    .appendTo( $(column.footer()).empty() )
                $('#srcthiscol').on( 'keyup change', function () {
                        if ( column.search() !== this.value ) {
                            column
                                .search( this.value )
                                .draw();
                        }
                    } );
            });
        }
    });
});

/*
* Legend (chart.js)
*/
function legend(data) {

    var datas = data.datasets[0].data;
    var labels = data.labels;

    datas.forEach(function(value, index) {

        var container = $('<div class="col-lg-12 col-md-3 col-sm-6"></div>');
        var box = $('<div class="info-box"></div>');
        var fa;
        var color = data.datasets[0].backgroundColor[index];
        var label = labels[index];

        if (color == "#5cb85c") {
            fa = "fa-cloud-upload";
        } else if (color == "#d9534f") {
            fa = "fa-trash-o";
        } else if (color == "#f0ad4e") {
            fa = "fa-music";
        } else if (color == "#5bc0de") {
            fa = "fa-download";
        }
        var icon = '<span style="background-color: '+color+'; color: #fff" class="info-box-icon"><i class="fa '+fa+'"></i></span>';
        var boxcontent = '<div class="info-box-content"><span class="info-box-text">'+label+'</span><span class="info-box-number">'+value+'</span></div>';
        box.append(icon);
        box.append(boxcontent);
        container.append(box).hide();
        $("#mainLegend").append(container);
        container.fadeIn();
    });
}

/*
* Chart.js init
*/
Chart.defaults.global.responsive = true;
Chart.defaults.global.tooltipFontSize = 12;
Chart.defaults.global.legend.display = false;

function callMainChart(){

    var ctx = document.getElementById("pie").getContext("2d");
    var myPieChart = new Chart(ctx,{
        type : 'pie',
        data : pieData,
    });
    legend(pieData);
}

function callDownChart(){
 
    var ctd = document.getElementById("polar-down").getContext("2d");
    var polarDown = new Chart(ctd,{
        type : 'doughnut',
        data : polarDataDown,
        options : {
            animation:{
                animateRotate : false,
                animateScale : true
            }
        }
    });
    $("#polar-down").on('click', function(evt){
        var activePoints = polarDown.getElementAtEvent(evt);
        var label = activePoints[0]._chart.config.data.labels[activePoints[0]._index];
        var value = activePoints[0]._chart.config.data.datasets[0].data[activePoints[0]._index];
        var fillColor = activePoints[0]._chart.config.data.datasets[0].backgroundColor[activePoints[0]._index];
        $(".screen-down").html(label + " <strong>(" + value + ")</strong>");
        $(".screen-down").css('border-color',fillColor).css('border-left-width', '4px');
    });
}

function callPlayChart(){
 
    var cty = document.getElementById("polar-play").getContext("2d");
    var polarPlay = new Chart(cty,{
        type : 'pie',
        data : polarDataPlay,
        options : {
            animation:{
                animateRotate : false,
                animateScale : true
            }
        }
    });
    $("#polar-play").on('click', function(evt){
        var activePoints = polarPlay.getElementAtEvent(evt);
        var label = activePoints[0]._chart.config.data.labels[activePoints[0]._index];
        var value = activePoints[0]._chart.config.data.datasets[0].data[activePoints[0]._index];
        var fillColor = activePoints[0]._chart.config.data.datasets[0].backgroundColor[activePoints[0]._index];
        $(".screen-play").html(label + " <strong>(" + value + ")</strong>");
        $(".screen-play").css('border-color',fillColor).css('border-left-width', '4px');
    });
}

function callRangeChart(){
    var ctr = document.getElementById("ranger").getContext("2d");
    var rangeChart = new Chart(ctr,{
        type : 'line',
        data : rangeline,
        options: {
            maintainAspectRatio: false,
            legend : {
                display: true
            },
            tooltips: {
                mode: 'label',
            }
        }
    });
}
