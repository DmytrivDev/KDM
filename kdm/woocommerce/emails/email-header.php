<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>KDM CME Project</title>
	</head>
	<body marginwidth="0" topmargin="0" marginheight="0" offset="0">

  <div style="width:100%;min-width:700px;font-family:Arial;font-size:16px;line-height:20px;color:#000;background-image:url(<?php echo get_site_url(); ?>/wp-content/themes/kdm/assets/img/backgrounds/bg2.png);background-repeat:repeat;background-position:center center;background-size:cover;padding-top:15px" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
    <table width="700" border="0" cellpadding="25" cellspacing="0" style="width: 700px;margin: 0 auto">
      <tr>
        <td valign="middle" style="padding-bottom: 0">
          <table border="0" width="650" cellpadding="0" cellspacing="0">
            <tr>
              <td valign="middle" align="center">
                <a href="<?php echo get_site_url(); ?>" target="_blank" style="width: 200px;display: block"><img src="<?php echo get_site_url(); ?>/wp-content/uploads/2023/01/logo.png" style="width: 100%;height: auto" alt="" /></a>
              </td>
            </tr>
          </table>
        </td>
      </tr>