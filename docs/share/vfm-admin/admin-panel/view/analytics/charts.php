<div class="row">
    <div class="col-lg-3">
        <div class="row" id="mainLegend">
        </div>
    </div>
    <div class="col-lg-9">
        <div class="row">

            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <strong><?php print $setUp->getString("main_activities"); ?></strong>
                    </div>
                    <div class="box-body">
                        <div class="canvas-holder">
                            <canvas class="chart" id="pie" width="400" height="400"></canvas>
                            <div class="showdata"></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($range && $range > 1) { ?>
                <div class="col-md-8" id="chart-ranger">
                    <div class="box"> 
                        <div class="box-header with-border">
                            <i class="fa fa-line-chart"></i> 
                            <strong><?php print $setUp->getString("trendline"); ?></strong>
                        </div>
                        <div class="canvas-range-holder">
                            <canvas class="chart" id="ranger" width="800" height="300"></canvas>
                        </div>
                    </div>
                </div>
            <?php
            } else { ?>
            <div class="col-md-4" id="chart-download">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-cloud-download"></i> 
                        <strong><?php print $setUp->getString("downloads"); ?></strong> <span class="num-down"></span>
                    </div>
                    <div class="box-body">
                        <div class="canvas-holder">
                            <canvas class="chart" id="polar-down" width="400" height="400"></canvas>
                            <div class="showdata screen-down"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4" id="chart-play">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <i class="fa fa-play-circle-o"></i> 
                        <strong><?php print $setUp->getString("play"); ?> <span class="num-play"></span></strong>
                    </div>
                    <div class="box-body">
                        <div class="canvas-holder"> 
                            <canvas class="chart" id="polar-play" width="400" height="400"></canvas>
                            <div class="showdata screen-play"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            } ?>
        </div> <!-- row -->
        <div class="row">
            
        </div>
    </div>
</div> <!-- row -->
