<?php
/**
* Convert Hex color to rgb
*
* @param string $hex color to convert
*
* @return rgb color
*/ 
function hex2rgb($hex) 
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return implode(",", $rgb); // returns the rgb values separated by commas
}

/**
* Generate random rgb color
*
* @return color
*/ 
// function randomColor() 
// {
//     $color = mt_rand(0, 255).",".mt_rand(0, 255).",".mt_rand(0, 255);
//     return $color;
// }
// $colorplay = randomColor();
// $colordown = randomColor();
$colorplay = hex2rgb('#f09927');
$colordown = hex2rgb('#16b5de');
?>
<script type="text/javascript" src="admin-panel/plugins/chartjs/Chart.min.js"></script>
<script>
    var rangeline = {
        labels: <?php echo json_encode($labelsarray); ?>,
        datasets: [
            {
                label: "<?php echo $setUp->getString('add'); ?>",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(92,184,92,0.1)",
                borderColor: "#5cb85c",
                pointBackgroundColor : "#5cb85c",
                pointBorderWidth : 2,
                borderWidth : 3,
                pointRadius: 4,
                pointHitRadius: 10,
                data: <?php echo json_encode($updataset); ?>,
            },
            {
                label: "<?php echo $setUp->getString('download'); ?>",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(90,192,222,0.1)",
                borderColor: "#5bc0de",
                pointBackgroundColor : "#5bc0de",
                pointBorderWidth : 2,
                borderWidth : 3,
                pointRadius: 4,
                pointHitRadius: 10,
                data: <?php echo json_encode($downloaddataset); ?>,
            },
            {
                label: "<?php echo $setUp->getString('remove'); ?>",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(217,83,79,0.1)",
                borderColor: "#d9534f",
                pointBackgroundColor : "#d9534f",
                pointBorderWidth : 2,
                borderWidth : 3,
                pointRadius: 4,
                pointHitRadius: 10,
                data: <?php echo json_encode($removedataset); ?>,
            },
            {
                label: "<?php echo $setUp->getString('play'); ?>",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(240,173,78,0.1)",
                borderColor: "#f0ad4e",
                pointBackgroundColor : "#f0ad4e",
                pointBorderWidth : 2,
                borderWidth : 3,
                pointRadius: 4,
                pointHitRadius: 10,
                data: <?php echo json_encode($playdataset); ?>,
            }
        ]
    };

    var pieData = {
        labels: [
            "<?php echo $setUp->getString('add'); ?>",
            "<?php echo $setUp->getString('download'); ?>",
            "<?php echo $setUp->getString('remove'); ?>",
            "<?php echo $setUp->getString('play'); ?>"
        ],
        datasets: [
            {
                data: [<?php echo $numup; ?>, <?php echo $numdown; ?>, <?php echo $numdel; ?>, <?php echo $numplay; ?>],
                backgroundColor: [
                    "#5cb85c",
                    "#5bc0de",
                    "#d9534f",
                    "#f0ad4e"
                ],
                hoverBackgroundColor: [
                    "#32b836",
                    "#16b5de",
                    "#d9211e",
                    "#f09927"
                ]
        }]
    };

    <?php 
    arsort($polarplay);
    $highest = (!empty($polarplay) ? max($polarplay) : 1); ?>

    var polarDataPlay = {
        datasets: [{
                data: [
                    <?php
                    foreach ($polarplay as $key => $value) {
                        print $value.",";
                    } ?>
                ],
                backgroundColor: [
                    <?php
                    foreach ($polarplay as $key => $value) {
                        $gradient = $value/$highest;
                        print "'rgba(".$colorplay.",".$gradient.")',\n";
                    } ?>
                ],
                hoverBackgroundColor: [
                    <?php
                    foreach ($polarplay as $key => $value) {
                        print "'rgba(".$colorplay.",0.6)',\n";
                    } ?>
                ]
            }],
            labels: [
                <?php
                foreach ($polarplay as $key => $value) {
                    print "\"".basename($key)."\",";
                } ?>
            ],
    };

    <?php 
    arsort($polardown);
    $highest = (!empty($polardown) ? max($polardown) : 1); ?>

    var polarDataDown = {
        datasets: [{
                data: [
                    <?php
                    foreach ($polardown as $key => $value) {
                        print $value.",";
                    } ?>
                ],
                backgroundColor: [
                    <?php
                    foreach ($polardown as $key => $value) {
                        $gradient = $value/$highest;
                        print "'rgba(".$colordown.",".$gradient.")',\n";
                    } ?>
                ],
                hoverBackgroundColor: [
                    <?php
                    foreach ($polardown as $key => $value) {
                        print "'rgba(".$colordown.",0.6)',\n";
                    } ?>
                ]
            }],
            labels: [
                <?php
                foreach ($polardown as $key => $value) {
                    print "\"".basename($key)."\",";
                } ?>
            ]
    }
    $(".num-play").html('(<?php echo $numplay; ?>)');
    $(".num-down").html('(<?php echo $numdown; ?>)');

</script>
<script type="text/javascript" src="admin-panel/js/statistics.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        callMainChart();
        <?php
        if ($range && $range > 1) { ?>
            callRangeChart();
        <?php
        } else { 
            if ($numdown > 0) { ?>
                callDownChart();
            <?php
            } else { ?>
                $('#chart-download').remove();
            <?php
            }
            if ($numplay > 0) { ?>
                callPlayChart();
            <?php
            } else { ?>
                $('#chart-play').remove();
            <?php
            }
        } ?>
    });
</script>