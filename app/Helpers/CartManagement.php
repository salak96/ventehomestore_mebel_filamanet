<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Cookie;

class CartManagement {

    static function cartKey($product_id, $variant_id = null)
    {
        return $product_id . '_' . ($variant_id ?: '0');
    }

    static public function addItemToCart($product_id, $variant_id = null) {
        $cart_items = self::getCartItemsFromCookie();
        $cart_key = self::cartKey($product_id, $variant_id);

        if (isset($cart_items[$cart_key])) {
            $cart_items[$cart_key]['quantity']++;
            $cart_items[$cart_key]['total_amount'] = $cart_items[$cart_key]['quantity'] * $cart_items[$cart_key]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if (!$product) return count($cart_items);

            $unit_amount = $product->price;
            $variant_name = null;

            if ($variant_id) {
                $variant = ProductVariant::where('id', $variant_id)
                    ->where('product_id', $product_id)
                    ->where('is_active', true)
                    ->first();
                if ($variant) {
                    $unit_amount = $variant->price ?? $product->price;
                    $variant_name = $variant->name;
                }
            }

            $cart_items[$cart_key] = [
                'product_id'       => $product_id,
                'product_variant_id' => $variant_id,
                'variant_name'     => $variant_name,
                'name'             => $product->name . ($variant_name ? " ({$variant_name})" : ''),
                'image'            => !empty($product->images) ? $product->images[0] : null,
                'quantity'         => 1,
                'unit_amount'      => $unit_amount,
                'total_amount'     => $unit_amount,
            ];
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    static public function addItemToCartWithQty($product_id, $qty = 1, $variant_id = null) {
        $cart_items = self::getCartItemsFromCookie();
        $cart_key = self::cartKey($product_id, $variant_id);

        if (isset($cart_items[$cart_key])) {
            $cart_items[$cart_key]['quantity'] = $qty;
            $cart_items[$cart_key]['total_amount'] = $cart_items[$cart_key]['quantity'] * $cart_items[$cart_key]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if (!$product) return count($cart_items);

            $unit_amount = $product->price;
            $variant_name = null;

            if ($variant_id) {
                $variant = ProductVariant::where('id', $variant_id)
                    ->where('product_id', $product_id)
                    ->where('is_active', true)
                    ->first();
                if ($variant) {
                    $unit_amount = $variant->price ?? $product->price;
                    $variant_name = $variant->name;
                }
            }

            $cart_items[$cart_key] = [
                'product_id'       => $product_id,
                'product_variant_id' => $variant_id,
                'variant_name'     => $variant_name,
                'name'             => $product->name . ($variant_name ? " ({$variant_name})" : ''),
                'image'            => !empty($product->images) ? $product->images[0] : null,
                'quantity'         => $qty,
                'unit_amount'      => $unit_amount,
                'total_amount'     => $unit_amount * $qty,
            ];
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    static public function removeCartItem($cart_key) {
        $cart_items = self::getCartItemsFromCookie();
        unset($cart_items[$cart_key]);
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function addCartItemsToCookie($cart_items) {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    static public function clearCartItems() {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    static public function getCartItemsFromCookie() {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }

        $migrated = false;
        foreach ($cart_items as $key => $item) {
            if (!is_string($key)) {
                $migrated = true;
                $new_key = self::cartKey($item['product_id'], $item['product_variant_id'] ?? null);
                $cart_items[$new_key] = $item;
                unset($cart_items[$key]);
            }
        }
        if ($migrated) {
            self::addCartItemsToCookie($cart_items);
        }

        return $cart_items;
    }

    static public function incrementQuantityToCartItem($cart_key) {
        $cart_items = self::getCartItemsFromCookie();
        if (isset($cart_items[$cart_key])) {
            $cart_items[$cart_key]['quantity']++;
            $cart_items[$cart_key]['total_amount'] = $cart_items[$cart_key]['quantity'] * $cart_items[$cart_key]['unit_amount'];
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function decrementQuantityToCartItem($cart_key) {
        $cart_items = self::getCartItemsFromCookie();
        if (isset($cart_items[$cart_key]) && $cart_items[$cart_key]['quantity'] > 1) {
            $cart_items[$cart_key]['quantity']--;
            $cart_items[$cart_key]['total_amount'] = $cart_items[$cart_key]['quantity'] * $cart_items[$cart_key]['unit_amount'];
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    static public function calculateGrandTotal($items) {
        return array_sum(array_column($items, 'total_amount'));
    }

    public static function clearCartCookie()
    {
        Cookie::queue(Cookie::forget('cart'));
    }
}
