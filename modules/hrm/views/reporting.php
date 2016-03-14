<div class="wrap">
    <h2>Reports</h2>

    <div id="dashboard-widgets-wrap">

        <div id="dashboard-widgets" class="metabox-holder">

        <?php 
            $reports  = erp_hr_get_reports();
            $sections = count( $reports );

            if ( $sections ) {
                $left_column = array_slice( $reports, 0, $sections / 2 );
                $right_column = array_slice( $reports, $sections / 2 );
            }
        ?>

        <div class="postbox-container">
            <div class="meta-box-sortables">

            <?php
                foreach ( $left_column as $report ) {
            ?>
                <div class="postbox">
                    <h2 class="hndle"><span><?php echo $report['title'] ?></span></h2>
                    <div class="inside">
                        <p><?php echo $report['description']; ?></p>
                        <p><a class="button button-primary" href="admin.php?page=erp-hr-reporting&type=<?php echo $report['slug']; ?>">View Report</a></p>
                    </div>
                </div><!-- .postbox -->
            <?php
                }
            ?>

            </div><!-- .meta-box-sortables -->
        </div><!-- .postbox-container -->

        <div class="postbox-container">
            <div class="meta-box-sortables">

            <?php
                foreach ( $right_column as $report ) {
            ?>
                <div class="postbox">
                    <h2 class="hndle"><span><?php echo $report['title'] ?></span></h2>
                    <div class="inside">
                        <p><?php echo $report['description']; ?></p>
                        <p><a class="button button-primary" href="admin.php?page=erp-hr-reporting&type=<?php echo $report['slug']; ?>">View Report</a></p>
                    </div>
                </div><!-- .postbox -->
            <?php
                }
            ?>

            </div><!-- .meta-box-sortables -->
        </div><!-- .postbox-container -->

        </div><!-- .metabox-holder -->
    </div><!-- .dashboar-widget-wrap -->

</div>