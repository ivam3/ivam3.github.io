<!-- Modal -->
<div id="csv-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $setUp->getString('export'); ?></h4>
      </div>
      <div class="modal-body">
        <?php
        $logspath = '_content/log/';
        $loglist = glob($logspath.'*.json');
        // set most recenton top
        $loglist = array_reverse($loglist);
        $available_days = array();

        foreach ($loglist as $day) {
            $path_parts = pathinfo($day);

            $filenamearr = explode("-", $path_parts['filename']);
            $cleanname = array();
            foreach ($filenamearr as $filenamepart) {
                $cleanname[] = ltrim($filenamepart, '0');
            }

            //$available_days[] = implode("-", $cleanname);

            $available_days[] = $path_parts['filename'];
        } ?>
        <form action="admin-panel/view/analytics/save-csv.php" method="post" id="csvform" class="form row">
            <div class="form-group col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input readonly name="logsince" type="text" id="logsince" class="form-control" placeholder="<?php echo $setUp->getString('start_date'); ?>">
                </div>
            </div>

            <div class="form-group col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input readonly name="loguntil" type="text" id="loguntil" class="form-control" placeholder="<?php echo $setUp->getString('end_date'); ?>">
                </div>
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-success disabled" id="getcsv"><?php echo $setUp->getString('download'); ?> .CSV</a>
      </div>
    </div>

  </div>
</div>

    <script type="text/javascript">

        $(document).ready(function(){
            var availableDates = <?php echo json_encode($available_days); ?>;
            var datamin = availableDates[availableDates.length-1];
            var datamax = availableDates[0];
            // SetUp since datepicker.
            $(".vfm-datepicker").datepicker({
                beforeShowDay: available,
                dateFormat : 'yy-mm-dd',
                defaultDate: datamax,
                minDate : datamin,
                maxDate : datamax,
            });

            // SetUp Until datepicker.
            var untilpicker = $( "#loguntil" ).datepicker({ 
                beforeShowDay: available,
                dateFormat : 'yy-mm-dd',
                defaultDate: datamax,
                minDate : datamin,
                maxDate : datamax,
            });

            // SetUp since datepicker.
            $("#logsince").datepicker({
                beforeShowDay: available,
                dateFormat : 'yy-mm-dd',
                defaultDate: datamax,
                minDate : datamin,
                maxDate : datamax,
            });

            $("#logsince").on('change', function(selectedDate) {
                if ($(this).val()) {
                    var selectedDate = $(this).val();
                    untilpicker.datepicker("option", "minDate", selectedDate);
                    if (untilpicker.val()) {
                        $('#getcsv').removeClass('disabled');
                    }
                } else {
                    $('#getcsv').addClass('disabled');
                }
            });

            $("#loguntil").on('change', function(selectedDate) {
                if ($(this).val() && $("#logsince").val()) {
                    $('#getcsv').removeClass('disabled');
                } else {
                    $('#getcsv').addClass('disabled');
                }
            });

            // activate only available days
            function available(date) {
                dmy = date.getFullYear() + "-" + ("0" +(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2);

                if ($.inArray(dmy, availableDates) != -1) {
                    return [true, "", "Available"];
                } else {
                    return [false, "", "unAvailable"];
                }
             }

            // Set default Until date if Sinceisalready set.
            if ( $('#logsince').val() ) {
                var selectedDate = $('#logsince').val();
                untilpicker.datepicker("option", "minDate", selectedDate);
                // untilpicker.datepicker("option", "defaultDate", selectedDate);
            }

            $('#getcsv').on('click', function(e){
                e.preventDefault();
                $('#csvform').submit();
                $('#csvform').find('input').val('');
                $('#getcsv').addClass('disabled');
            });
        });
    </script>