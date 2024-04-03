<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 6.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email );
$user = get_user_by('login', $user_login );
$userEmail = $user->user_email;
$userFN = $user->first_name;
$userLN = $user->last_name;
?>


  <tr>
    <td valign="middle" style="padding-top: 70px; padding-bottom: 0;">
      <table border="0" width="650" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="middle" align="center">
            <p style="text-align: center; font-size: 26px; line-height: 32px; font-weight: 800; color: #06ac5b; margin: 0;">Вітаємо <?php echo $userFN; ?> <?php echo $userLN; ?></p>
            <p style="text-align: center; margin-bottom: 0; margin-top: 14px; font-size: 16px; line-height: 20px;">
              Ви успішно зареєструвались на сайті <a href="<?php echo get_site_url(); ?>" target="_blank" style="color: #1a325c;"><?php echo get_bloginfo( 'name' ); ?></a>
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="middle" style="padding-top: 42px; padding-bottom: 0;">
      <table border="1" width="650" cellpadding="0" cellspacing="0" style="border-radius: 5px; border: solid #ececec;">
        <tr>
          <td valign="middle" width="50%" align="center" style="padding: 30px 10px; border: none;">
            <p style="text-align: center; color: grey; margin: 0; font-size: 16px; line-height: 20px;">Ваш логін:</p>
            <p style="text-align: center; color: #1a325c !important; font-weight: 600; margin-top: 6px; margin-bottom: 0;">
              <a href="mailto:<?php echo $userEmail; ?>" style="color: #1a325c; font-size: 16px; font-weight: 600; line-height: 20px;"><?php echo $userEmail; ?></a>
            </p>
          </td>
          <td valign="middle" width="50%" align="center" style="padding: 30px 10px; border: none;">
            <p style="text-align: center; color: grey; margin: 0; font-size: 16px; line-height: 20px;">Ваш пароль:</p>
            <p style="text-align: center; color: #1a325c !important; font-weight: 600; margin-top: 6px; margin-bottom: 0; font-size: 16px; line-height: 20px;"><?php echo $user_pass; ?></p>
          </td>
        </tr>
      </table>
    </td>
  </tr>

<?php


do_action( 'woocommerce_email_footer', $email );
