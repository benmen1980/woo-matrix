<?php
$nonce = wp_create_nonce("simply_add_to_cart_nonce");
$link = admin_url('admin-ajax.php?action=simply_add_to_cart&nonce='.$nonce);

?>
<a id="simply-add-to-cart" class="" data-nonce="<?php echo $nonce; ?>"  href="<?php echo $link; ?>">הוספה לעגלה את הוריאציות</a>
<p>כאן צריך למקם את הטבלה של הצבעים ומידות</p>
<table id="simply-matrix">
	<?php
	/**
	 * Find matching product variation
	 *
	 * @param $product_id
	 * @param $attributes
	 * @return int
	 */
	$id = 38;
	$product = wc_get_product( $id );
	$attributes = $product->get_variation_attributes();
	$sizes = $attributes['pa_size'];
	$colors = $attributes['pa_color'];
	// thead
	?>
	<tr><th></th>
	<?php
	foreach($sizes as $size){
		?>
		<th data-size="<?php echo $size?>"><?php echo strtoupper($size) ?></th>
		<?php
	}
	?>
	</tr>
	<?php
	foreach($colors as $color){
		?>
	<tr><td><?php echo strtoupper($color)?></td>
	<?php
		foreach ($sizes as $size){
			$attributes = [
				'attribute_pa_color' => $color,
				'attribute_pa_size' => $size,
			];
		$var_id = find_matching_product_variation_id($id,$attributes);
		?>
			<td data-var="<?php echo $var_id ?>" data-color="<?php echo $color ?>" data-size="<?php echo $size ?>"><input type="number" value=""><button>הוסף שמות</button></td>
		<?php
		}
	?>
	</tr>

	<?php
	}
	?>
</table>
	<?php
	function find_matching_product_variation_id($product_id, $attributes)
	{
		return (new \WC_Product_Data_Store_CPT())->find_matching_product_variation(
			new \WC_Product($product_id),
			$attributes
		);
	}
	?>
<p>לשם נוחות אני מציג את הוריאציות ברשימה</p>
<?php
	$variations = $product->get_available_variations();
	foreach ( $variations as $key => $value ) {
	?>
	<li>
		<span><?php echo $value['sku'].' '.$value['attributes']['attribute_pa_color'].' '.$value['attributes']['attribute_pa_size']; ?></span>
	</li>
<?php
}
?>



