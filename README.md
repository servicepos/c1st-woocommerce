# Customers 1st WooCommerce Helper Plugin

This plugins helps WooCommerce webshops integrate better with Customers 1st.

It does the following
- When a request to the `/wp-json/wc/v3` endpoint hits with the header `HTTP_X_SUPPRESS_HOOKS` the webshop will not trigger any webhooks of its own. This is to prevent a "ping pong" effect that can occur.
- When dupelicating a product, the metadata fields `hwp_product_gtin`, `hwp_var_gtin` and `_gtin` are set to null.
- When dupelicating a product, SKU is set to null.

## Installation
- Get the plugin zip file from [here](https://github.com/servicepos/c1st-woocommerce/releases).
- In Wordpress goto Plugins -> Add New Plugin -> Press the "Upload plugin" button in the top and select the zip file -> Press "Install now". 
- Now the plugin is installed.
