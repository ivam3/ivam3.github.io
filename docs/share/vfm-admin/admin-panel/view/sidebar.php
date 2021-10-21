<?php
/**
 * VFM - veno file manager administration sidebar
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
$adminurl = $setUp->getConfig('script_url')."vfm-admin";
if (!$activesec || $activesec == 'home') {
    $open = ' active';
} else {
    $open = '';
} ?>
<aside class="main-sidebar">
    <section class="sidebar" id="scrollspy">
        <ul class="sidebar-menu nav">
            <li class="header text-uppercase"><?php echo $setUp->getString("administration"); ?></li>
    <?php
    if (GateKeeper::canSuperAdmin('superadmin_can_preferences')) { ?>
            </li>
        <?php
        if (!$activesec || $activesec == 'home') { ?>
            <li class="treeview active">
                <a href="#view-preferences">
                    <i class="fa fa-dashboard fa-fw"></i> 
                    <span><?php echo $setUp->getString("preferences"); ?></span> 
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo $open; ?>"><a href="#view-general"><i class="fa fa-cogs fa-fw"></i> 
                        <span><?php echo $setUp->getString("general_settings"); ?></span></a>
                    </li>
                    <li><a href="#view-uploads"><i class="fa fa-cloud-upload fa-fw"></i> 
                        <span><?php echo $setUp->getString('upload'); ?></span></a>
                    </li>
                    <li><a href="#view-lists"><i class="fa fa-list-alt fa-fw"></i> 
                        <span><?php echo $setUp->getString('lists'); ?></span></a>
                    </li>
                    <li><a href="#view-permissions"><i class="fa fa-balance-scale fa-fw"></i> 
                        <span><?php echo $setUp->getString('permissions'); ?></span></a>
                    </li>
                    <li><a href="#view-registration"><i class="fa fa-user-plus fa-fw"></i> 
                        <span><?php echo $setUp->getString('registration'); ?></span></a>
                    </li>
                    <li><a href="#view-share"><i class="fa fa-paper-plane fa-fw"></i> 
                        <span><?php echo $setUp->getString('share_files'); ?></span></a>
                    </li>
                    <li><a href="#view-email"><i class="fa fa-envelope-o fa-fw"></i> 
                        <span><?php echo $setUp->getString('email'); ?></span></a>
                    </li>
                    <li><a href="#view-security"><i class="fa fa-shield fa-fw"></i> 
                        <span><?php echo $setUp->getString("security"); ?></span></a>
                    </li>
                    <li><a href="#view-activities"><i class="fa fa-bar-chart fa-fw"></i> 
                        <span><?php echo $setUp->getString("activity_register"); ?></span></a>
                    </li>
                </ul>
            </li>
            <?php
        } else { ?>
            <li>
                <a href="index.php">
                    <i class="fa fa-dashboard fa-fw"></i> 
                    <span><?php echo $setUp->getString("preferences"); ?></span> 
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <?php
        }
    }

    if (GateKeeper::canSuperAdmin('superadmin_can_users')) { ?>
        <li <?php
        if ($activesec == 'users') {
            echo 'class="active"';
        } ?>><a href="?section=users">
                <i class="fa fa-users fa-fw"></i> 
                <span><?php echo $setUp->getString("users"); ?></span>
            </a>
        </li>
        <?php
    }

    if (GateKeeper::canSuperAdmin('superadmin_can_appearance')) { ?>
        <li <?php
        if ($activesec == 'appearance') {
            echo 'class="active"';
        } ?>><a href="?section=appearance">
                <i class="fa fa-paint-brush fa-fw"></i> 
                <span><?php echo $setUp->getString("appearance"); ?></span>
            </a>
        </li>
        <?php
    }

    if (GateKeeper::canSuperAdmin('superadmin_can_translations')) { ?>
        <li <?php
        if ($activesec == 'lang') {
            echo 'class="active"';
        } ?>><a href="?section=translations">
                <i class="fa fa-language fa-fw"></i> 
                <span><?php echo $setUp->getString("translations"); ?></span>
            </a>
        </li>
        <?php
    }
    if ($setUp->getConfig('log_file') == true && GateKeeper::canSuperAdmin('superadmin_can_statistics')) { ?>
            <li <?php
            if ($activesec == 'log') {
                echo 'class="active"';
            } ?>><a href="?section=logs">
                    <i class="fa fa-pie-chart"></i> 
                    <span><?php echo $setUp->getString("statistics"); ?></span>
                </a>
            </li>
        <?php
    } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>