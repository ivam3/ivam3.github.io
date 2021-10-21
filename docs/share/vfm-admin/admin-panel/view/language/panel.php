    <div class="row">
        <div class="col-md-7 col-sm-6">
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=translations&action=edit">
                <div class="form-group">
                    <label><?php print $setUp->getString("edit_language"); ?> </label>

                    <div class="input-group">
                        <select class="form-control input-lg" name="editlang">
                        <?php
                        $translations = $admin->getLanguages();

                        foreach ($translations as $key => $lingua) { ?>
                            <option value="<?php echo $key; ?>"
                            <?php
                            if ($key == $thelang) {
                                echo "selected";
                            } ?> >
                            <?php echo $lingua; ?>
                            </option>
                            <?php
                        } ?>
                        </select>
                        <span class="input-group-btn btn-group-lg">
                            <button class="btn btn-default" type="submit"><i class="fa fa-pencil-square-o"></i> 
                                <?php print $setUp->getString("edit"); ?>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <?php require 'langlist.php'; 
        $available_languages = array_keys($translations);
        foreach ($available_languages as $value) {
            unset($languages[$value]);
        }
        ?>
        <div class="col-md-5  col-sm-6">
            <form role="form" method="post" 
            action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=translations&action=edit">
                <div class="form-group">
                    <label>
                        <?php echo $setUp->getString("new_language"); ?>
                    </label>
                    <div class="input-group">
                    <select class="form-control input-lg" name="newlang">
                        <?php
                        foreach ($languages as $key => $value) {
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                        ?>
                    </select>
                        <span class="input-group-btn btn-group-lg">
                            <button class="btn btn-info" type="submit">
                                <i class="fa fa-plus"></i> 
                                <?php echo $setUp->getString("add"); ?>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    