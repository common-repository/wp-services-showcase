<div class="" style='display:none'>
    <a class='inline' id="wps-constructor-box" href="#inline_content"><?php _e('Options','wp-services-showcase'); ?></a>
    <div style='display:none'>
        <div id='inline_content' class="wps-short-code-generator" style='padding:10px; background:#fff;'>
            <h1><?php _e('Wp Service ShortCode Generator','wp-services-showcase'); ?></h1>
            <div class="wps-constructor-wrapper">
                <form id="wps-sc-params" method="post" action="">
                    <div class="wps-sc-row">
                        <div class="wps-sc-column">
                            <div class="sc-field-holder">
                                <label for="wps-sc-layout"><?php _e('Layout','wp-services-showcase'); ?></label>
                                <select id="wps-sc-layout" name="layout">
                                    <option value="grid"><?php _e('Grid','wp-services-showcase'); ?></option>
                                    <option value="list"><?php _e('List','wp-services-showcase'); ?></option>
                                </select>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-display-per-row"><?php _e('Display per row','wp-services-showcase'); ?></label>
                                <select id="wps-sc-display-per-row" name="display-per-row">
                                    <option value="2"><?php _e('2 Per row','wp-services-showcase'); ?></option>
                                    <option value="3" selected><?php _e('3 Per row','wp-services-showcase'); ?></option>
                                    <option value="4"><?php _e('4 Per row','wp-services-showcase'); ?></option>
                                    <option value="6"><?php _e('6 Per row','wp-services-showcase'); ?></option>
                                </select>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-limit"><?php _e('Limit','wp-services-showcase'); ?></label>
                                <input type="number" id="wps-sc-limit" name="limit">
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-order">Order<?php _e('Options','wp-services-showcase'); ?></label>
                                <select id="wps-sc-order" name="order">
                                    <option value="DESC">DESC</option>
                                    <option value="ASC">ASC</option>
                                </select>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-order-by"><?php _e('Order By','wp-services-showcase'); ?></label>
                                <select id="wps-sc-order-by" name="orderby">
                                    <option value="date">Date</option>
                                    <option value="title">Title</option>
                                    <option value="ID">ID</option>
                                    <option value="menu_order">Menu Order</option>
                                    <option value="rand">Rand</option>
                                </select>
                            </div>

                            <div class="sc-field-holder">
                                <label for="wps-sc-short-desc-limit"><?php _e('Short Description Limit','wp-services-showcase'); ?></label>
                                <input type="number" name="short-desc-limit">
                            </div>

                        </div> <!-- column -->
                        <div class="wps-sc-column">

                            <div class="sc-field-holder">
                                <label for="wps-sc-icon-size"><?php _e('Icon size','wp-services-showcase'); ?></label>
                                <select id="wps-sc-icon-size" name="icon-size">
                                    <?php
                                        for($i=20; $i <= 100; $i++){
                                            echo "<option value='{$i}'>{$i} px</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-icon-color"><?php _e('Icon color','wp-services-showcase'); ?></label>
                                <div class="rt-color-holder"><input type="text" class="rt-color" id="wps-sc-icon-color" name="icon-color"></div>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-icon-hover-color"><?php _e('Icon hover color','wp-services-showcase'); ?></label>
                                <div class="rt-color-holder"><input type="text" class="rt-color" id="wps-sc-icon-hover-color" name="icon-hover-color"></div>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-service-title-color"><?php _e('Service title color','wp-services-showcase'); ?></label>
                                <div class="rt-color-holder"><input type="text" class="rt-color" id="wps-sc-service-title-color" name="service-title-color"></div>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-service-title-hover-color"><?php _e('Service title hover color','wp-services-showcase'); ?></label>
                                <div class="rt-color-holder"><input type="text" class="rt-color" id="wps-sc-service-title-hover-color" name="service-title-hover-color"></div>
                            </div>
                            <div class="sc-field-holder">
                                <label for="wps-sc-read-me-button"><?php _e('Read more','wp-services-showcase'); ?></label>

                                    <select name="read-more" id="wps-sc-read-more">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                            </div>

                        </div> <!-- column -->

                    </div> <!-- row -->
                </form>

                <div class="wps-sc-row">
                    <div class="wps-sc-action-controls">
                        <a class="wps-constructor-apply button button-primary" href="javascript:void(0);" >Insert</a>
                    </div>
                </div><!-- row -->

            </div><!-- wps-constructor-wrapper -->

        </div>
    </div>
</div>
