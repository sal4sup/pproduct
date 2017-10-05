<?php
/**
 * @package products-picker
 * @version 1.0
 */
settings_errors();
?>
<h1>settings</h1>


<form method="post" action="options.php">
    <?php settings_fields('ppicker-settings-group');?>
    <?php do_settings_sections('ppicker');?>
    <?php submit_button();?>
</form>
