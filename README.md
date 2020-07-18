# twentytwentychild

A child theme for Twenty Twenty.

## Products

This theme allow you to manage products. For each product you can enter price, sale price, gallery, etc.
The homepage displays all products.

## Shortcodes

### Product Box

Shortcode for displaying a box with product image, title and pricing.
Parameters:

-   product_id - Required. Id of product to display.
-   bg_color - Optional. Background color for the box.

Usage:

```
[ttc_product_box product_id="76" bg_color="#fff"]
```

## Filters

Filters included in the theme:

### ttc_pricing_display_html

Filter for the pricing display (price/sale price).

### ttc_product_box_html

Filter for the product box shortcode.

## Mobile Address Bar Color

To Change the address bar color on mobile devices, go to:
Appearance -> Customize -> Colors -> Mobile Address Bar Color

## API

Product categories endpoints which return product category data and products in this category.

```
-   /wp-json/wp/v2/ttc-category/<id>
-   /wp-json/wp/v2/ttc-category/?slug=<slug>
```
