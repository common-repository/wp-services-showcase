<?php global $rtWPS; ?>

<div class="wrap">
    <div id="upf-icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
    <h2><?php _e('Wp Services Showcases Settings', 'wp-services-showcase'); ?></h2>
    <h3><?php _e('General settings', 'wp-services-showcase');?>
        <a style="margin-left: 15px; font-size: 15px;" href="https://radiustheme.com/setup-configure-wp-services-showcase/" target="_blank"><?php _e('Documentation',  'wp-services-showcase') ?></a>
    </h3>

    <div class="rt-setting-wrapper">
        <div class="rt-response"></div>
        <form id="rt-settings-form" onsubmit="rtWPSSettings(this); return false;">
            <div class="rt-setting-holder">
                <?php echo $rtWPS->rtFieldGenerator($rtWPS->rtWPSSettingFields(), true); ?>
            </div>

            <p class="submit"><input type="submit" name="submit" class="button button-primary rtSaveButton" value="Save Changes"></p>

            <?php wp_nonce_field( $rtWPS->nonceText(), $rtWPS->nonceId() ); ?>
        </form>

        <div class="rt-response"></div>
    </div>

    <div class="rt-help">
        <p style="font-weight: bold"><?php _e('Short Code', 'wp-services-showcase' );?> :</p>
        <p><code>[service id="45" title="Home services list"]</code></p>
        <p><?php _e('id = ShortCode ID', 'wp-services-showcase' );?></p>
        <p><?php _e('title = Shortcode title (Not required)', 'wp-services-showcase' );?></p>
        <p class="rt-help-link"><a class="button-primary" href="http://demo.radiustheme.com/wordpress/plugins/wp-services-showcase/" target="_blank"><?php _e('Demo', 'wp-services-showcase' );?></a> <a class="button-primary" href="https://radiustheme.com/setup-configure-wp-services-showcase/" target="_blank"><?php _e('Documentation', 'wp-services-showcase' );?></a> </p>
    </div>

</div>
