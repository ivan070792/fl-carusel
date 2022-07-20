<?php

/**
 * Plugin Name: fl-carusel
 * Description: Карусель товаров для Woocommerce. Для вывода карусели воспользуйтесь шорткодом [fl_carusel stock_ids="ID товаров через заятую" new_ids="D товаров через заятую"]
 * Plugin URI:  Ссылка на страницу плагина
 * Author URI:  https://vk.com/ivan.chernichko
 * Author:      Иван Черничко
 * Version:     0.3
 *
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

 

function fl_carusel_func($atts){

    if (!is_plugin_active( 'woocommerce/woocommerce.php' )){
        return "Для работы плагина требуется Woocommerce";
    }

    wp_enqueue_script('fl-carusel-js', plugin_dir_url() . '/js/script.js'); // подключаем JS
    wp_enqueue_style( 'style-name', get_stylesheet_uri(). 'css/style.css' ); // подключаем CSS



    $user = wp_get_current_user();
//	//var_dump ( $user -> roles );
    $result = '<div class="fl_carusel">';
    $result .= '<div class="fl_top">';
    $result .= '<div class="fl_carusel_switch"><span class="fl_switch_stock active">Товары по акции</span> / <span class="fl_switch_new">Новинки</span></div>';
    $result .= '<div id="fl_nav_stock" class="fl_carusel_nav"><span class="fl_nav_left"><</span> <span class="fl_nav_right">></span></div>';
    $result .= '<div id="fl_nav_new" class="fl_carusel_nav"><span class="fl_nav_left"><</span> <span class="fl_nav_right">></span></div>';
    $result .= '</div>';
    if (isset($atts['stock_ids']) && isset($atts['new_ids'])){

        $result .= '<div class="fl_carusel_inner">';

        /*карусель 1*/
        $result .= '<div id="fl_carusel_stock" class="fl_carusel_wrap">';

        $stock_ids = explode(',',$atts['stock_ids']); // Получаем id товаров в массив
        for ($i = 0;$i<count($stock_ids);$i++){
            //var_dump(calc_price(['product_id' => $stock_ids[$i]]));
            $product = wc_get_product( $stock_ids[$i] ); //Объект продукта
            if ($product){
                $result .= '<div class="fl_carusel_card_item fl_carusel_card_item_'.$i.'">';
                $osnprice = $product->get_price()*1.5; // Основная цена
                $product_name = $product->get_name(); // Имя товара
                $sku = $product->get_sku(); // Артикул
                $img = $product->get_image(); // Изображение
                $url = get_permalink($stock_ids[$i]); // Ссылка на товар
                //var_dump ( wp_get_current_user() );
                $result .= '<a href="'.$url.'">';
                $result .= $img;
                $result .= '<h4 class="fl_product_name">'.$product_name.'</h4>';
                $result .= ($sku) ? '<p class="fl_sku_str"> <span class="fl_sku_lable">Артикул:</span> <span class="fl_sku_value">'.$sku.'</span></p>': '<p class="fl_sku_str"> <span class="fl_sku_lable">Артикул не указан</span></p>';
                $result .= ((int) global_calc_price($stock_ids[$i])) ? '<p class="fl_osnprice_str"><span class="fl_osnprice_value">'.global_calc_price($stock_ids[$i]).'</span> <span class="fl_osnprice_currency_symbol">'.get_woocommerce_currency_symbol().'</span></p>': '<p class="fl_osnprice_str"><span class="fl_osnprice_value">Цена не указана</span></p>' ;
                //$result .= ($rosnprice) ? '<p class="fl_rosnprice"><span class="fl_rosnprice_label">Розничная цена: </span><span class="fl_rosnprice_value">'.$rosnprice.'</span> <span class="fl_rosnprice_currency_symbol">'.get_woocommerce_currency_symbol().'</span></p>': '<p class="fl_rosnprice"><span class="fl_rosnprice_label">Розничная цена не указана</span></p>';
                $result .= ((int) global_calc_price($stock_ids[$i])) ? '<p><a href="'.$url.'" class="fl_button">Купить</a></p>': '<p><a href="#overlay_unique_id_1350" class="fl_button overlay_callto">Запросить цену</a></p>';
                $result .= '</a>';
                $result .= '</div>';
            }

        }
        $result .= '</div>';

        /*карусель 2*/

        $result .= '<div id="fl_carusel_new" class="fl_carusel_wrap">';
        $new_ids = explode(',',$atts['new_ids']); // Получаем id товаров в массив
        for ($i = 0;$i<count($new_ids);$i++){
            $product = wc_get_product( $new_ids[$i] ); //Объект продукта
            if ($product){
                $result .= '<div class="fl_carusel_card_item fl_carusel_card_item_'.$i.'">';
                $rosnprice = $product->get_meta('_rosnprice'); // Розничная цена
                //$rosnprice = calc_price();
                $osnprice = $product->get_price()*1.5; // Основная цена
                $product_name = $product->get_name(); // Имя товара
                $sku = $product->get_sku(); // Артикул
                $img = $product->get_image(); // Изображение
                $url = get_permalink($new_ids[$i]); // Ссылка на товар
                //var_dump ( $rosnprice );
                $result .= '<a href="'.$url.'">';
                $result .= $img;
                $result .= '<h4 class="fl_product_name">'.$product_name.'</h4>';
                $result .= ($sku) ? '<p class="fl_sku_str"> <span class="fl_sku_lable">Артикул:</span> <span class="fl_sku_value">'.$sku.'</span></p>': '<p class="fl_sku_str"> <span class="fl_sku_lable">Артикул не указан</span></p>';
                $result .= '<p class="fl_osnprice_str"><span class="fl_osnprice_value">'.global_calc_price($new_ids[$i]).'</span> <span class="fl_osnprice_currency_symbol">'.get_woocommerce_currency_symbol().'</span></p>';
                //$result .= ($rosnprice) ? '<p class="fl_rosnprice"><span class="fl_rosnprice_label">Розничная цена: </span><span class="fl_rosnprice_value">'.$rosnprice.'</span> <span class="fl_rosnprice_currency_symbol">'.get_woocommerce_currency_symbol().'</span></p>': '<p class="fl_rosnprice"><span class="fl_rosnprice_label">Розничная цена не указана</span></p>';
                $result .= '<p><a href="'.$url.'" class="fl_button">Купить</a></p>';
                $result .= '</a>';
                $result .= '</div>';

            }

        }


        $result .= '</div>';

        $result .= '</div>';

        $result .= '</div>';
        //echo $result;
        return $result;

    }else{
        return "Не указаны ID товаров";
    }

}

add_shortcode('fl_carusel', 'fl_carusel_func');