<?php

    // No direct access to this file
    defined( 'ABSPATH' ) or die();

?>


<div id="business-info-wrap" class="wrap">

    <div class="wp-header">
        <img src="<?php echo plugins_url( '../images/logo-sm.png', __FILE__ ); ?>" alt="ReplayBird" class="replaybird-logo">
    </div>



    <form method="post" action="options.php">
        <?php settings_fields( 'replaybird' );
        do_settings_sections('replaybird'); ?>

        <div id="replaybird-form-area">
            <p><?php
            $url = 'https://app.replaybird.com/email/sites';
            $link = sprintf( wp_kses( __( 'Visit your <a href="%s" target="_blank">ReplayBird site list</a> to find your unique ReplayBird Site Key.', 'replaybird'), array(  'a' => array( 'href' => array(), 'target' =>  '_blank' ) ) ), esc_url( $url ) );
            echo $link;
            ?></p>
            <p><?php _e('Input your ReplayBird Site Key into the field below to connect your ReplayBird and WordPress accounts.', 'replaybird'); ?></p>

            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                        <label for="replaybird_site_key"><?php esc_html_e( 'ReplayBird Site Key', 'replaybird'); ?></label>
                        </th>

                        <td>
                            <input type="text" name="replaybird_site_key" id="replaybird_site_key" placeholder="Your ReplayBird Site Key" value="<?php echo esc_attr( get_option('replaybird_site_key') ); ?>" class="replaybird-input-text" />
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <?php submit_button(); ?>

    </form>
</div>
