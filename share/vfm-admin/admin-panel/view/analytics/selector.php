<?php
$getday = false;
$day = false;
$range = false;
if (isset($_GET['range'])) {
    $range = $_GET['range'];
} elseif (isset($_GET['day']) && strlen($_GET['day'] > 0)) {
    $day = $_GET['day'];
    $logs = array($_GET['day'].".json");
    $getday = true;
} else {
    $range = 1;
}
$loglist = glob('_content/log/*.json');
$loglist = $loglist ? $loglist : array();
$loglist = array_reverse(array_values(preg_grep('/^([^.])/', $loglist)));

if ($getday == false) {
    $logs = array_slice($loglist, 0, $range);
}
$result = array();
$formatdate = substr($setUp->getConfig('time_format'), 0, 5);
?>
<form class="form-inline selectdate adminblock" method="get">
    <input type="hidden" name="section" value="logs">
    <div class="form-group">
        <div class="btn-group">
            <a href="?section=logs&range=1" class="btn btn-default <?php if ($range == 1) echo "active"; ?>">
                <span class="fa-stack stackalendar">
                  <i class="fa fa-calendar-o fa-stack-2x"></i>1
                </span>
            </a>
            <a href="?section=logs&range=7" class="btn btn-default <?php if ($range == 7) echo "active"; ?>">
                <span class="fa-stack stackalendar">
                    <i class="fa fa-calendar-o fa-stack-2x"></i>7
                </span>
            </a>
            <a href="?section=logs&range=30" class="btn btn-default <?php if ($range == 30) echo "active"; ?>">
                <span class="fa-stack stackalendar">
                  <i class="fa fa-calendar-o fa-stack-2x"></i>30
                </span>
            </a>
        </div>
    </div>
    <div class="form-group">
        <input readonly name="day" value="<?php echo $day; ?>" type="text" class="form-control input-lg vfm-datepicker" placeholder="<?php echo $setUp->getString("select_date"); ?>" onchange="this.form.submit()">
    </div>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#csv-modal"><?php echo $setUp->getString("export"); ?> .csv</button>
</form>

