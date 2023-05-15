<?php

namespace App\Services\package;


use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShoppingCart
{
    protected static string $name = 'shopping';

    public static function getInstance()
    {
        return Cart::instance(self::$name);
    }

    public static function getAll()
    {
        return self::getInstance()->content();
    }

    public static function addToCart(Product $product, array $options)
    {

        self::getInstance()->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'options' => array_merge(['image' => $product->feature_image_path], $options)
        ]);
        return self::getInstance()->content();
    }

    public static function total()
    {
        $result = 0;
        foreach (self::getInstance()->content() as $item) $result += $item->qty * $item->price;
        return $result;
    }

    public static function count()
    {
        return self::getInstance()->count();
    }

    public static function destroy($id = null)
    {
        empty($id) ? self::getInstance()->destroy() : self::getInstance()->remove($id);
    }

    public static function findById($id)
    {
        return self::getInstance()->get($id);
    }

    public static function update($id, array $options)
    {
        self::getInstance()->update($id, $options);
    }

    public static function updateQuantity($id, int $quantity)
    {
        self::getInstance()->update($id, $quantity);
    }
}
