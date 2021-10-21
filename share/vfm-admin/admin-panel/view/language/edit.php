    
    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=translations&action=update">
        <div class="row">
            <div class="col-md-6">
                <p>
                    <?php echo $setUp->getString("edit"); ?>: 
                    <span class="badge bg-green"><?php echo $editlang; ?></span>
                </p>
            </div>
            <div class="col-md-6">
                <div class="btn-group pull-right">
                <button type="submit" class="btn btn-info">
                    <i class="fa fa-save"></i> 
                    <?php print $setUp->getString("save_settings"); ?>
                </button>
                <?php
                if ($editlang != "en") { 
                    print "<a href=\"?section=translations&action=update&remove=".$editlang."\" 
                    class=\"btn btn-danger delete\"><i class=\"fa fa-trash-o\"></i> "
                    .$setUp->getString("remove_language")."</a>";
                } ?>
                </div>
            </div>
        </div>
        <input type="hidden" class="form-control" name="thenewlang" value="<?php echo $editlang; ?>">
        <hr>
        <div class="row">
        <?php
        $index = 0;
        foreach ($baselang as $key => $voce) { ?>
            <div class="col-sm-6">
                <label><?php echo $key; ?></label>
                <?php
                if (array_key_exists($key, $_TRANSLATIONSEDIT)) {
                    $tempval = $_TRANSLATIONSEDIT[$key];
                } else {
                    $tempval = "";
                } ?>
                <input type="text" class="form-control" name="<?php echo $key; ?>" value="<?php echo stripslashes($tempval); ?>" placeholder="<?php echo stripslashes($baselang[$key]); ?>">
            </div>
            <?php
        } ?>
        </div> <!-- row -->

        <hr>
        <button type="submit" class="btn btn-info btn-lg btn-block">
            <i class="fa fa-refresh"></i> 
            <?php print $setUp->getString("save_settings"); ?>
        </button>
        <div class="fixed-label">
            <button type="submit" class="btn btn-default">
                <i class="fa fa-save"></i> 
            </button>
        </div>
    </form>
