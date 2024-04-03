<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

    <tr>
      <td valign="middle" style="padding-top: 100px;padding-bottom: 0">
        <table border="0" width="650" cellpadding="0" cellspacing="0" style="border-top: 1px solid #ececec">
          <tr>
            <td valign="middle" width="50%" style="padding: 25px 0;border: none"><p style="font-size: 12px;line-height: 14px;color: grey;margin: 0">© 2016-<?php echo date("Y"); ?> KDM CME project.</p></td>
            <td valign="middle" width="50%" align="center" style="padding: 25px 0;border: none">
              <p style="font-size: 12px;line-height: 14px;color: grey;margin: 0;text-align: right">
                <a href="<?php echo get_site_url(); ?>/public/" target="_blank" style="display: inline-block;color: #1a325c;margin-right: 15px;font-size: 12px;line-height: 14px">Публічний договір</a><a style="color: #1a325c;font-size: 12px;line-height: 14px" target="_blank" href="<?php echo get_site_url(); ?>/privacy-policy/">Політика кон-сті</a>
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>


	</body>
</html>
