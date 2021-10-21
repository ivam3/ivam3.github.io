<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <strong><?php echo $setUp->getString("actions"); ?></strong>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table statistics table-hover table-condensed" id="sortanalytics" width="100%">
                      <thead>
                          <tr>
                              <th><span class="sorta"><?php echo $setUp->getString("day"); ?></span></th>
                              <th><span>hh:mm:ss</span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("user"); ?></span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("action"); ?></span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("type"); ?></span></th>
                              <th><span class="sorta"><?php echo $setUp->getString("file_name"); ?></span></th>
                          </tr>
                        </thead>
                        <tbody>
    <?php
    foreach ($logs as $log) { 
        $logfile = '_content/log/'.basename($log);
        if (file_exists($logfile)) {
            $resultnew = json_decode(file_get_contents($logfile), true);
            $result = $resultnew ? array_merge($result, $resultnew) : array();
        }
    }
    
    $numup = 0;
    $numdel = 0;
    $numplay = 0;
    $numdown = 0;

    $polarplay = array();
    $polardown = array();

    $polardowncount = 0;
    $polarplaycount = 0;

    $labelsarray = array();
    $updataset = array();
    $removedataset = array();
    $playdataset = array();
    $downloaddataset = array();

    foreach ($result as $key => $value) {

        $listtime = strtotime($key);
        $showtime = date($formatdate, $listtime);

        array_push($labelsarray, $showtime);

        $uploads = 0;
        $removes = 0;
        $plays = 0;
        $downloads = 0;

        foreach ($value as $kiave => $day) {

            $contextual = "";

            $item = $day['item'];

            if ($day['action'] == 'ADD') {
                $uploads++;
                $numup++;
                $contextual = "success";
            } 
            if ($day['action'] == 'REMOVE') {
                $removes++;
                $numdel++;
                $contextual = "danger";
            }
            if ($day['action'] == 'PLAY') {
                $plays++;
                $numplay++;
                $polarplaycount++;
                if (isset($polarplay[$item])) {
                    $polarplay[$item] = $polarplay[$item] +1;
                } else {
                    $polarplay[$item] = 1;
                }
                $contextual = "warning";
            }
            if ($day['action'] == 'DOWNLOAD') {
                $downloads++;
                $numdown++;
                $polardowncount++;
                if (isset($polardown[$item])) {
                    $polardown[$item] = $polardown[$item] +1;
                } else {
                    $polardown[$item] = 1;
                }
                $contextual = "info";
            } ?>
            <tr class="<?php echo $contextual; ?>">
            <td data-order="<?php echo $listtime; ?>"><?php echo $showtime; ?></td>
            <td><?php echo $day['time']; ?></td>
            <td><?php echo $day['user']; ?></td>
            <td><?php echo $setUp->getString(strtolower($day['action'])); ?></td>
            <td><?php echo $day['type']; ?></td>
            <td><?php echo $day['item']; ?></td>
            <?php
        }
        array_push($updataset, $uploads);
        array_push($removedataset, $removes);
        array_push($playdataset, $plays);
        array_push($downloaddataset, $downloads);
    } 
    $updataset = array_reverse($updataset);
    $removedataset = array_reverse($removedataset);
    $playdataset = array_reverse($playdataset);
    $downloaddataset = array_reverse($downloaddataset);
    $labelsarray = array_reverse($labelsarray);
    ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><?php echo $setUp->getString("day"); ?></td>
                                <td>hh:mm:ss</span></td>
                                <td><?php echo $setUp->getString("user"); ?></td>
                                <td><?php echo $setUp->getString("action"); ?></td>
                                <td><?php echo $setUp->getString("type"); ?></td>
                                <td><?php echo $setUp->getString("item"); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
