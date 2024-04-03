<?php
/**
 * Template name: Сертифікат
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kdm
 */

get_header();
?>

  <section class="section__account">
    <div class="container thecont">
      <style>
        .thecont {
          display: flex;
          justify-content: center;
        }
        .thecont form {
          width: 100%;
          margin-bottom: 10px;
        }
        .thecont form {
          display: flex;
          flex-direction: column;
          max-width: 650px;
        }
        form input {
          margin-bottom: 20px;
          border: 1px solid #000;
          height: 44px;
          padding: 0 10px;
        }
      </style>
      <body>
      <form action="<?php echo get_template_directory_uri(); ?>/certificat/generator.php" method="GET">
        <input name="numeric" type="text" placeholder="99778833" value="99778833">
        <input name="moznumer" type="text" placeholder="№2022 - 1018 - 1006051" value="№2022 - 1018 - 1006051">
        <input name="name" type="text" placeholder="Имя" value="Прокопчук Аліна Дмитрівна">
        <input name="mainthem" type="text" placeholder="Гіперандрогенія. Сучасний алгоритм" value="Гіперандрогенія. Сучасний алгоритм">
        <input name="option" type="text" placeholder="надає 10 балів (одноденний захід) БПР згідно Наказу МОЗ від 22.02.2019 №446" value="надає 10 балів (одноденний захід) БПР згідно Наказу МОЗ від 22.02.2019 №446">
        <input name="specialization" maxlength="96" type="text" placeholder="Акушерство та гінекологія, Організація і управління охороною здоров`я, Ультразвукова діагностика" value="Акушерство та гінекологія, Організація і управління охороною здоров`я, Ультразвукова діагностика">
        <input name="specialization2" type="text" placeholder="Друга лінія спецільності" value="">
        <input name="url" type="text" placeholder="https://gynecology.com.ua/arx_hyperandro_algorithm" value="https://gynecology.com.ua/arx_hyperandro_algorithm">
        <input name="location" type="text" placeholder="м. Дніпро, 4 липня, 2023" value="м. Дніпро, 4 липня, 2023">
        <button class="button green full">Генерация</button>
      </form>
      <script>
          jQuery(document.querySelectorAll('[placeholder]').item(5)).change(function() {
              console.log(this.value.length);
              if(this.value.length < 95) {
                  console.log('ok');
              } else {
                  alert('Специальность больше 95 символов, разделите на две строки');
                  console.log(this.value);
                  document.querySelectorAll('[placeholder]').item(6).focus();
              }
          });
          jQuery(document.querySelectorAll('[placeholder]').item(5)).keypress(function() {
              console.log(this.value.length);
              if( this.value.length < 95) {
                  console.log('ok');
              } else {
                  document.querySelectorAll('[placeholder]').item(6).focus();
              }
          });
      </script>

    </div>
  </section>





<?php
get_footer();