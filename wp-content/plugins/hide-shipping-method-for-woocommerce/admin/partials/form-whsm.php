<?php

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$get_action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
$get_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
/*
 * edit all posted data method define in class-woo-hide-shipping-methods-admin
 */

if ( $get_action === 'edit' ) {
    
    if ( !empty($get_id) && $get_id !== "" ) {
        $get_post_id = ( isset( $get_id ) ? sanitize_text_field( wp_unslash( $get_id ) ) : '' );
        $sm_status = get_post_status( $get_post_id );
        $sm_title = __( get_the_title( $get_post_id ), 'woo-hide-shipping-methods' );
        $shipping_method_list = get_post_meta( $get_post_id, 'shipping_method_list', true );
        
        if ( is_serialized( $shipping_method_list ) ) {
            $shipping_method_list = maybe_unserialize( $shipping_method_list );
        } else {
            $shipping_method_list = $shipping_method_list;
        }
        
        $sm_metabox = get_post_meta( $get_post_id, 'sm_metabox', true );
        
        if ( is_serialized( $sm_metabox ) ) {
            $sm_metabox = maybe_unserialize( $sm_metabox );
        } else {
            $sm_metabox = $sm_metabox;
        }
        
        $cost_rule_match = get_post_meta( $get_post_id, 'cost_rule_match', true );
        
        if ( !empty($cost_rule_match) ) {
            
            if ( is_serialized( $cost_rule_match ) ) {
                $cost_rule_match = maybe_unserialize( $cost_rule_match );
            } else {
                $cost_rule_match = $cost_rule_match;
            }
            
            
            if ( array_key_exists( 'general_rule_match', $cost_rule_match ) ) {
                $general_rule_match = $cost_rule_match['general_rule_match'];
            } else {
                $general_rule_match = 'any';
            }
        
        } else {
            $general_rule_match = 'any';
        }
        
        $title_text = esc_html__( 'Edit Conditional Hide Shipping Method Rules', 'woo-hide-shipping-methods' );
    }

} else {
    $get_post_id = '';
    $sm_status = '';
    $sm_title = '';
    $shipping_method_list = array();
    $sm_metabox = array();
    $cost_rule_match = array();
    $general_rule_match = 'any';
    $title_text = esc_html__( 'Add Conditional Hide Shipping Method Rules', 'woo-hide-shipping-methods' );
}

$sm_status = ( !empty($sm_status) && 'publish' === $sm_status || empty($sm_status) ? 'checked' : '' );
$submit_text = __( 'Save changes', 'woo-hide-shipping-methods' );
$whsm_admin_object = new Woo_Hide_Shipping_Methods_Admin( '', '' );
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
?>
<div class="whsm-section-left">
	<h2><?php 
echo  esc_html__( $title_text ) ;
?></h2>
		<table class="form-table table-outer shipping-method-table main-shipping-conf">
			<tbody>
			<tr valign="top">
				<th class="titledesc" scope="row">
					<label for="onoffswitch"><?php 
esc_html_e( 'Status', 'woo-hide-shipping-methods' );
?></label>
					<span class="woo_hide_shipping_methods_tab_description"></span>
					<p class="description" style="display:none;">
						<?php 
esc_html_e( 'Enable or Disable this rule using this button (This will hide shipping method to customers only if it is enabled).', 'woo-hide-shipping-methods' );
?>
					</p>
				</th>
				<td class="forminp">
					<label class="switch">
						<input type="checkbox" name="sm_status" value="on" <?php 
echo  esc_attr( $sm_status ) ;
?>>
						<div class="slider round"></div>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="row">
					<label
						for="fee_settings_product_fee_title"><?php 
esc_html_e( 'Hide Shipping Rule Name', 'woo-hide-shipping-methods' );
?>
						<span class="required-star">*</span>
					</label>
				</th>
				<td class="forminp">
					<input type="text" name="fee_settings_product_fee_title" class="text-class"
					       id="fee_settings_product_fee_title" value="<?php 
echo  esc_attr( $sm_title ) ;
?>"
					       required="1"
					       placeholder="<?php 
esc_attr_e( 'Enter hide shipping rule name', 'woo-hide-shipping-methods' );
?>">
				</td>
			</tr>
			<?php 
?>
					<tr valign="top" class='shipping_drp'>
						<th class="titledesc" scope="row">
							<label class="whsm-pro-feature" for="fee_settings_shipping_method_list"><?php 
esc_html_e( 'Select Shipping Source - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
esc_html_e( 'Shipping method which you want to hide on front side', 'woo-hide-shipping-methods' );
?>
							</p>
						</th>
						<td>
							<label class="whsm-pro-feature">
								<input type="radio" name="shipping_method_option" id="main_shipping_method_option"
								       value="main_shipping_method" disabled="disabled" checked="checked"/>
								<span
									class="date-time-text format-i18n"><?php 
esc_html_e( 'Default shipping method and Compatible with Hide shipping method plugin', 'woo-hide-shipping-methods' );
?></span>
							</label>
							<br>
							<label class="whsm-pro-feature">
								<input type="radio" name="shipping_method_option" id="custom_shipping_method_option"
								       value="custom_shipping_method" disabled="disabled" />
								<span
									class="date-time-text format-i18n"><?php 
esc_html_e( 'None Compatible with Hide shipping method plugin', 'woo-hide-shipping-methods' );
?></span>
							</label>
							<p class="description">
								<?php 
$html = sprintf(
    '%s<a href=%s target="_blank">%s</a>',
    esc_html__( 'You need to enter shipping method value manually. ', 'woo-hide-shipping-methods' ),
    esc_url( 'https://ibb.co/P50C70x' ),
    esc_html__( 'Click Here', 'woo-hide-shipping-methods' )
);
echo  wp_kses_post( $html ) ;
?>
							</p>
							<br>
						</td>
					</tr>
					<?php 
?>
			<tr valign="top" id="shipping_list_tr">
				<?php 
?>
				<th class="titledesc" scope="row">
					<label
						for="fee_settings_shipping_method_list"><?php 
esc_html_e( 'Select shipping method', 'woo-hide-shipping-methods' );
?></label>
					<span class="woo_hide_shipping_methods_tab_description"></span>
					<p class="description" style="display:none;">
						<?php 
esc_html_e( 'Select shipping method which you want to hide on front side', 'woo-hide-shipping-methods' );
?>
					</p>
				</th>
				<?php 
$combine_shipping_method_list = $whsm_admin_object->whsma_list_out_shipping( 'general' );
?>
				<td class="forminp">
					<select name="shipping_method_list[]" id="shipping_method_list"
					        class="multiselect2 whsm_select shipping_method_list"
					        multiple="multiple">
						<?php 
$selectedVal = ( !empty($shipping_method_list) && in_array( 'all', $shipping_method_list, true ) ? 'selected=selected' : '' );
?>
						<option value="all" <?php 
echo  esc_attr( $selectedVal ) ;
?>><?php 
echo  esc_html__( 'All', 'woo-hide-shipping-methods' ) ;
?></option>
						<?php 
if ( !empty($combine_shipping_method_list) && count( $combine_shipping_method_list ) > 0 ) {
    foreach ( $combine_shipping_method_list as $shipping_id => $shipping_title ) {
        settype( $shipping_id, 'string' );
        $selectedVal = ( !empty($shipping_method_list) && in_array( $shipping_id, $shipping_method_list, true ) ? 'selected=selected' : '' );
        ?>
								<option
									value="<?php 
        echo  esc_attr( $shipping_id ) ;
        ?>" <?php 
        echo  esc_attr( $selectedVal ) ;
        ?>><?php 
        esc_html_e( $shipping_title );
        ?></option>
								<?php 
    }
}
?>
					</select>
				</td>
			</tr>
			<?php 
?>
					<tr valign="top">
						<?php 
?>
						<th class="titledesc" scope="row">
							<label class="whsm-pro-feature"><?php 
esc_html_e( 'Shipping Method Option - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
esc_html_e( 'Enter shipping method option with comma separated which you want to hide on front side.(Remove extra space)', 'woo-hide-shipping-methods' );
?>
							</p>
						</th>
						<td class="forminp">
	                        <textarea id="shipping_option" class="whsm-pro-data" disabled="disabled"></textarea>
						</td>
					</tr>

					<tr valign="top">
						<th class="titledesc" scope="row">
							<label class="whsm-pro-feature"><?php 
esc_html_e( 'Apply Extra Rule - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
esc_html_e( 'Apply this extra rule to hide shipping method', 'woo-hide-shipping-methods' );
?>
							</p>
						</th>
						<td class="forminp">
							<select id="how_to_apply" class="whsm-pro-data" disabled="disabled">
								<option><?php 
esc_html_e( 'No Extra Rule', 'woo-hide-shipping-methods' );
?></option>
								<option><?php 
esc_html_e( 'Advance Rule', 'woo-hide-shipping-methods' );
?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th class="titledesc" scope="row">
							<label for="sm_start_date" class="whsm-pro-feature"><?php 
esc_html_e( 'Start Date - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
esc_html_e( 'Select start date on which date you want to hide shipping method.', 'woo-hide-shipping-methods' );
?>
							</p>
						</th>
						<td class="forminp">
							<input type="text" class="text-class whsm-pro-data" id="sm_start_date" placeholder="<?php 
esc_attr_e( 'Select start date', 'woo-hide-shipping-methods' );
?>" disabled="disabled">
						</td>
					</tr>
					<tr valign="top">
						<th class="titledesc" scope="row">
							<label for="sm_end_date"  class="whsm-pro-feature"><?php 
esc_html_e( 'End Date - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
esc_html_e( 'Select end date on which date you want to hide shipping method', 'woo-hide-shipping-methods' );
?>
							</p>
						</th>
						<td class="forminp">
							<input type="text" class="text-class whsm-pro-data" id="sm_end_date" placeholder="<?php 
esc_attr_e( 'Select end date', 'woo-hide-shipping-methods' );
?>" disabled="disabled">
						</td>
					</tr>
					<tr valign="top">
						<th class="titledesc" scope="row">
							<label for="sm_select_day_of_week" class="whsm-pro-feature"><?php 
esc_html_e( 'Days of the Week - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
echo  sprintf( wp_kses( __( 'Select days on which day you want to hide shipping method. This rule match with current day which is set by wordpress <a href="%s" target="_blank">Timezone</a>.', 'woo-hide-shipping-methods' ), array(
    'a' => array(
    'href'   => array(),
    'target' => array(),
),
) ), esc_url( admin_url( 'options-general.php' ) ) ) ;
?>
							</p>
						</th>
						<td class="forminp">
							<select id="sm_select_day_of_week" class="whsm-pro-data sm_select_day_of_week multiselect2 whsm_select" multiple="multiple" disabled="disabled">
								<option><?php 
esc_html_e( 'Select days of the week', 'woo-hide-shipping-methods' );
?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th class="titledesc" scope="row">
							<label for="sm_time" class="whsm-pro-feature"><?php 
esc_html_e( 'Time - ', 'woo-hide-shipping-methods' );
?><span class="in-pro"><?php 
esc_html_e( 'Available in pro', 'woo-hide-shipping-methods' );
?></span></label>
							<span class="woo_hide_shipping_methods_tab_description"></span>
							<p class="description" style="display:none;">
								<?php 
echo  sprintf( wp_kses( __( 'Select time on which time shipping method will enable on the website. This rule match with current time which is set by wordpress <a href="%s" target="_blank">Timezone</a>.', 'woo-hide-shipping-methods' ), array(
    'a' => array(
    'href'   => array(),
    'target' => array(),
),
) ), esc_url( admin_url( 'options-general.php' ) ) ) ;
?>
							</p>
						</th>
						<td class="forminp">
							<span class="sm_time_from"><?php 
esc_html_e( 'From:', 'woo-hide-shipping-methods' );
?></span>
							<input type="text" class="text-class whsm-pro-data" id="sm_time_from" placeholder='Select start time' disabled="disabled">
							<span class="sm_time_to"><?php 
esc_html_e( 'To:', 'woo-hide-shipping-methods' );
?></span>
							<input type="text" class="text-class whsm-pro-data" id="sm_time_to" placeholder='Select end time' disabled="disabled">
						</td>
					</tr>
					<?php 
?>
			</tbody>
		</table>

	<?php 
//Hide Shipping Method Rules
?>
		<div class="shipping-method-rules">
			<div class="sub-title">
				<h2><?php 
esc_html_e( 'Basic Hide Shipping Rules', 'woo-hide-shipping-methods' );
?></h2>
				<div class="tap">
					<a id="fee-add-field" class="button button-primary button-large"
					   href="javascript:;"><?php 
esc_html_e( '+ Add Rule', 'woo-hide-shipping-methods' );
?></a>
				</div>
				<div class="advance_rule_condition_match_type">
					<p class="switch_in_pricing_rules_description_left">
						<?php 
esc_html_e( 'below', 'woo-hide-shipping-methods' );
?>
					</p>
					<select name="cost_rule_match[general_rule_match]" id="general_rule_match" class="arcmt_select">
						<option
							value="any" <?php 
selected( $general_rule_match, 'any' );
?>><?php 
esc_html_e( 'Any One', 'woo-hide-shipping-methods' );
?></option>
						<option
							value="all" <?php 
selected( $general_rule_match, 'all' );
?>><?php 
esc_html_e( 'All', 'woo-hide-shipping-methods' );
?></option>
					</select>
					<p class="switch_in_pricing_rules_description">
						<?php 
esc_html_e( 'rule match', 'woo-hide-shipping-methods' );
?>
					</p>
				</div>
			</div>
			<div class="tap">
				<?php 
?>
					<input type="hidden" class="whsm-flag" value="1">
					<?php 
?>
				<table id="tbl-shipping-method"
				       class="tbl_product_fee table-outer tap-cas form-table shipping-method-table">
					<tbody>
					<?php 
$attribute_taxonomies = wc_get_attribute_taxonomies();
$attribute_taxonomies_name = wc_get_attribute_taxonomy_names();

if ( isset( $sm_metabox ) && !empty($sm_metabox) ) {
    $i = 2;
    foreach ( $sm_metabox as $key => $productfees ) {
        $fees_conditions = ( isset( $productfees['product_fees_conditions_condition'] ) ? $productfees['product_fees_conditions_condition'] : '' );
        $condition_is = ( isset( $productfees['product_fees_conditions_is'] ) ? $productfees['product_fees_conditions_is'] : '' );
        $condtion_value = ( isset( $productfees['product_fees_conditions_values'] ) ? $productfees['product_fees_conditions_values'] : array() );
        ?>
							<tr id="row_<?php 
        echo  esc_attr( $i ) ;
        ?>" valign="top">
								<th class="titledesc th_product_fees_conditions_condition" scope="row">
									<select rel-id="<?php 
        echo  esc_attr( $i ) ;
        ?>"
									        id="product_fees_conditions_condition_<?php 
        echo  esc_attr( $i ) ;
        ?>"
									        name="fees[product_fees_conditions_condition][]"
									        id="product_fees_conditions_condition"
									        class="product_fees_conditions_condition">
										<optgroup
											label="<?php 
        esc_attr_e( 'Location Specific', 'woo-hide-shipping-methods' );
        ?>">
											<option
												value="country" <?php 
        echo  ( 'country' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Country', 'woo-hide-shipping-methods' );
        ?></option>
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'State ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<option disabled="disabled"><?php 
        esc_html_e( 'Postcode ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<option disabled="disabled"><?php 
        esc_html_e( 'Zone ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<?php 
        ?>
										</optgroup>
										<optgroup
											label="<?php 
        esc_attr_e( 'Product Specific', 'woo-hide-shipping-methods' );
        ?>">
											<option
												value="product" <?php 
        echo  ( 'product' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Cart contains product', 'woo-hide-shipping-methods' );
        ?></option>
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'Cart contains variable product ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<?php 
        ?>
											<option
												value="category" <?php 
        echo  ( 'category' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Cart contains category\'s product', 'woo-hide-shipping-methods' );
        ?></option>
											<option
												value="tag" <?php 
        echo  ( 'tag' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Cart contains tag\'s product', 'woo-hide-shipping-methods' );
        ?></option>
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'Cart contains SKU\'s product ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<?php 
        ?>

										</optgroup>
										<?php 
        ?>
											<optgroup label="<?php 
        esc_attr_e( 'Attribute Specific', 'woo-hide-shipping-methods' );
        ?>">
												<option value="" disabled="disabled"><?php 
        esc_html_e( 'Attribute ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
											</optgroup>
											<?php 
        ?>
										<optgroup
											label="<?php 
        esc_attr_e( 'User Specific', 'woo-hide-shipping-methods' );
        ?>">
											<option
												value="user" <?php 
        echo  ( 'user' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'User', 'woo-hide-shipping-methods' );
        ?></option>
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'User Role ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<?php 
        ?>

										</optgroup>
										<optgroup
											label="<?php 
        esc_attr_e( 'Cart Specific', 'woo-hide-shipping-methods' );
        ?>">
											<?php 
        $currency_symbol = get_woocommerce_currency_symbol();
        $currency_symbol = ( !empty($currency_symbol) ? '(' . $currency_symbol . ')' : '' );
        $weight_unit = get_option( 'woocommerce_weight_unit' );
        $weight_unit = ( !empty($weight_unit) ? '(' . $weight_unit . ')' : '' );
        ?>

											<option
												value="cart_total" <?php 
        echo  ( 'cart_total' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Cart Subtotal (Before Discount) ', 'woo-hide-shipping-methods' );
        echo  esc_html( $currency_symbol ) ;
        ?></option>
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'Cart Subtotal (After Discount) ', 'woo-hide-shipping-methods' );
        echo  esc_html( $currency_symbol . ' ( In Pro )' ) ;
        ?></option>
												<?php 
        ?>

											<option
												value="quantity" <?php 
        echo  ( 'quantity' === $fees_conditions ? 'selected' : '' ) ;
        ?>><?php 
        esc_html_e( 'Quantity', 'woo-hide-shipping-methods' );
        ?></option>
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'Weight ', 'woo-hide-shipping-methods' );
        echo  wp_kses_post( $weight_unit . ' ( In Pro )' ) ;
        ?></option>
												<option disabled="disabled"><?php 
        esc_html_e( 'Coupon ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<option disabled="disabled"><?php 
        esc_html_e( 'Shipping Class ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<?php 
        ?>
										</optgroup>
										<optgroup label="<?php 
        esc_attr_e( 'Checkout Specific', 'woo-hide-shipping-methods' );
        ?>">
											<?php 
        ?>
												<option disabled="disabled"><?php 
        esc_html_e( 'Payment Method ( In Pro )', 'woo-hide-shipping-methods' );
        ?></option>
												<?php 
        ?>
										</optgroup>
									</select>
								</th>
								<td class="select_condition_for_in_notin">
									<?php 
        
        if ( 'cart_total' === $fees_conditions || 'cart_totalafter' === $fees_conditions || 'quantity' === $fees_conditions || 'weight' === $fees_conditions ) {
            ?>
										<select name="fees[product_fees_conditions_is][]"
										        class="product_fees_conditions_is_<?php 
            echo  esc_attr( $i ) ;
            ?>">
											<option
												value="is_equal_to" <?php 
            echo  ( 'is_equal_to' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Equal to ( = )', 'woo-hide-shipping-methods' );
            ?></option>
											<option
												value="less_equal_to" <?php 
            echo  ( 'less_equal_to' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Less or Equal to ( <= )', 'woo-hide-shipping-methods' );
            ?></option>
											<option
												value="less_then" <?php 
            echo  ( 'less_then' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Less than ( < )', 'woo-hide-shipping-methods' );
            ?></option>
											<option
												value="greater_equal_to" <?php 
            echo  ( 'greater_equal_to' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Greater or Equal to ( >= )', 'woo-hide-shipping-methods' );
            ?></option>
											<option
												value="greater_then" <?php 
            echo  ( 'greater_then' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Greater than ( > )', 'woo-hide-shipping-methods' );
            ?></option>
											<option
												value="not_in" <?php 
            echo  ( 'not_in' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Not Equal to ( != )', 'woo-hide-shipping-methods' );
            ?></option>
										</select>
									<?php 
        } else {
            ?>
										<select name="fees[product_fees_conditions_is][]"
										        class="product_fees_conditions_is_<?php 
            echo  esc_attr( $i ) ;
            ?>">
											<option
												value="is_equal_to" <?php 
            echo  ( 'is_equal_to' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Equal to ( = )', 'woo-hide-shipping-methods' );
            ?></option>
											<option
												value="not_in" <?php 
            echo  ( 'not_in' === $condition_is ? 'selected' : '' ) ;
            ?>><?php 
            esc_html_e( 'Not Equal to ( != )', 'woo-hide-shipping-methods' );
            ?> </option>
										</select>
									<?php 
        }
        
        ?>
								</td>
								<td class="condition-value" id="column_<?php 
        echo  esc_attr( $i ) ;
        ?>">
									<?php 
        $html = '';
        
        if ( 'country' === $fees_conditions ) {
            $html .= $whsm_admin_object->whsma_get_country_list( $i, $condtion_value );
        } elseif ( 'product' === $fees_conditions ) {
            $html .= $whsm_admin_object->whsma_get_product_list( $i, $condtion_value );
        } elseif ( 'category' === $fees_conditions ) {
            $html .= $whsm_admin_object->whsma_get_category_list( $i, $condtion_value );
        } elseif ( 'tag' === $fees_conditions ) {
            $html .= $whsm_admin_object->whsma_get_tag_list( $i, $condtion_value );
        } elseif ( 'user' === $fees_conditions ) {
            $html .= $whsm_admin_object->whsma_get_user_list( $i, $condtion_value );
        } elseif ( 'cart_total' === $fees_conditions ) {
            $html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . esc_attr( $i ) . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values" value = "' . esc_attr( $condtion_value ) . '">';
        } elseif ( 'quantity' === $fees_conditions ) {
            $html .= '<input type = "text" name = "fees[product_fees_conditions_values][value_' . esc_attr( $i ) . ']" id = "product_fees_conditions_values" class = "product_fees_conditions_values" value = "' . esc_attr( $condtion_value ) . '">';
        }
        
        echo  wp_kses( $html, $whsm_admin_object::whsma_allowed_html_tags() ) ;
        ?>
									<input type="hidden" name="condition_key[value_<?php 
        echo  esc_attr( $i ) ;
        ?>]"
									       value="">
								</td>
								<td class="fee-delete-field-outer">
									<a id="fee-delete-field" rel-id="<?php 
        echo  esc_attr( $i ) ;
        ?>"
									   class="delete-row" href="javascript:;" title="Delete"><i
											class="fa fa-trash"></i></a>
								</td>
							</tr>
							<?php 
        $i++;
    }
    ?>
						<?php 
} else {
    $i = 1;
    ?>
						<tr id="row_1" valign="top">
							<th class="titledesc th_product_fees_conditions_condition" scope="row">
								<select rel-id="1" id="product_fees_conditions_condition_1"
								        name="fees[product_fees_conditions_condition][]"
								        id="product_fees_conditions_condition"
								        class="product_fees_conditions_condition">
									<optgroup
										label="<?php 
    esc_attr_e( 'Location Specific', 'woo-hide-shipping-methods' );
    ?>">
										<option
											value="country"><?php 
    esc_html_e( 'Country', 'woo-hide-shipping-methods' );
    ?></option>
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'State ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<option disabled="disabled"><?php 
    esc_html_e( 'Postcode ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<option disabled="disabled"><?php 
    esc_html_e( 'Zone ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<?php 
    ?>
									</optgroup>
									<optgroup
										label="<?php 
    esc_attr_e( 'Product Specific', 'woo-hide-shipping-methods' );
    ?>">
										<option
											value="product"><?php 
    esc_html_e( 'Cart contains product', 'woo-hide-shipping-methods' );
    ?></option>
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'Cart contains variable product ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<?php 
    ?>
										<option
											value="category"><?php 
    esc_html_e( 'Cart contains category\'s product', 'woo-hide-shipping-methods' );
    ?></option>
										<option
											value="tag"><?php 
    esc_html_e( 'Cart contains tag\'s product', 'woo-hide-shipping-methods' );
    ?></option>
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'Cart contains SKU\'s product ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<?php 
    ?>
									</optgroup>
									<?php 
    ?>
										<optgroup label="<?php 
    esc_attr_e( 'Attribute Specific', 'woo-hide-shipping-methods' );
    ?>">
											<option value="" disabled="disabled"><?php 
    esc_html_e( 'Attribute ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
										</optgroup>
										<?php 
    ?>
									<optgroup
										label="<?php 
    esc_attr_e( 'User Specific', 'woo-hide-shipping-methods' );
    ?>">
										<option
											value="user"><?php 
    esc_html_e( 'User', 'woo-hide-shipping-methods' );
    ?></option>
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'User Role ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<?php 
    ?>
									</optgroup>
									<optgroup
										label="<?php 
    esc_attr_e( 'Cart Specific', 'woo-hide-shipping-methods' );
    ?>">
										<?php 
    $get_woocommerce_currency_symbol = get_woocommerce_currency_symbol();
    $woocommerce_weight_unit = get_option( 'woocommerce_weight_unit' );
    $currency_symbol = ( !empty($get_woocommerce_currency_symbol) ? '(' . $get_woocommerce_currency_symbol . ')' : '' );
    $weight_unit = ( !empty($woocommerce_weight_unit) ? '(' . $woocommerce_weight_unit . ')' : '' );
    ?>
										<option
											value="cart_total"><?php 
    esc_html_e( 'Cart Subtotal (Before Discount) ', 'woo-hide-shipping-methods' );
    echo  esc_html( $currency_symbol ) ;
    ?></option>
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'Cart Subtotal (After Discount) ', 'woo-hide-shipping-methods' );
    echo  esc_html( $currency_symbol . ' ( In Pro )' ) ;
    ?></option>
											<?php 
    ?>
										<option
											value="quantity"><?php 
    esc_html_e( 'Quantity', 'woo-hide-shipping-methods' );
    ?></option>
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'Weight ', 'woo-hide-shipping-methods' );
    echo  wp_kses_post( $weight_unit . ' ( In Pro )' ) ;
    ?></option>
											<option disabled="disabled"><?php 
    esc_html_e( 'Coupon ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<option disabled="disabled"><?php 
    esc_html_e( 'Shipping Class ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<?php 
    ?>
									</optgroup>
									<optgroup label="<?php 
    esc_attr_e( 'Checkout Specific', 'woo-hide-shipping-methods' );
    ?>">
										<?php 
    ?>
											<option disabled="disabled"><?php 
    esc_html_e( 'Payment Method ( In Pro )', 'woo-hide-shipping-methods' );
    ?></option>
											<?php 
    ?>
									</optgroup>
								</select>
							<td class="select_condition_for_in_notin">
								<select name="fees[product_fees_conditions_is][]"
								        class="product_fees_conditions_is product_fees_conditions_is_1">
									<option
										value="is_equal_to"><?php 
    esc_html_e( 'Equal to ( = )', 'woo-hide-shipping-methods' );
    ?></option>
									<option
										value="not_in"><?php 
    esc_html_e( 'Not Equal to ( != )', 'woo-hide-shipping-methods' );
    ?></option>
								</select>
							</td>
							<td id="column_1" class="condition-value">
								<?php 
    echo  wp_kses( $whsm_admin_object->whsma_get_country_list( 1 ), $whsm_admin_object::whsma_allowed_html_tags() ) ;
    ?>
								<input type="hidden" name="condition_key[value_1][]" value="">
							</td>
						</tr>
					<?php 
}

?>
					</tbody>
				</table>
				<?php 
?>
				<input type="hidden" name="total_row" id="total_row" value="<?php 
echo  esc_attr( $i ) ;
?>">
			</div>
		</div>

	<?php 
?>
	<p class="submit">
		<input type="submit" class="button button-primary" name="whsm_save"
		       value="<?php 
esc_attr_e( 'Save Changes', 'woo-hide-shipping-methods' );
?>">
	</p>
	<?php 
wp_nonce_field( 'woocommerce_save_method', 'woocommerce_save_method_nonce' );
?>
</div>
<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';