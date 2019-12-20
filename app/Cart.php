<?php


namespace App;

use Vanilo\Cart\Exceptions\InvalidCartConfigurationException;
use Vanilo\Cart\Models\Cart as BaseCart;
use Vanilo\Cart\Contracts\Cart as CartContract;
use Vanilo\Contracts\Buyable;

class Cart extends BaseCart implements CartContract
{

    public  function variants(){
        return $this->hasMany(\App\CartItemVariant::class, 'cart_id');
    }

    public function addItem(Buyable $product, $qty = 1, $params = []): \Vanilo\Cart\Contracts\CartItem
    {


        try {
            $item = $this->items()->ofCart($this)->byProduct($product)->first();

            $item = $this->items()->create(
                array_merge(
                    $this->getDefaultCartItemAttributes($product, $qty),
                    $this->getExtraProductMergeAttributes($product),
                    $params['attributes'] ?? []
                )
            );


            $this->load('items');

            return $item;
        }catch (\Exception $e){

        }
    }

    private function getDefaultCartItemAttributes(Buyable $product, $qty)
    {
        return [
            'product_type' => $product->morphTypeName(),
            'product_id'   => $product->getId(),
            'quantity'     => $qty,
            'price'        => $product->getPrice()
        ];
    }

    private function getExtraProductMergeAttributes(Buyable $product)
    {
        $result = [];
        $cfg    = config(self::EXTRA_PRODUCT_MERGE_ATTRIBUTES_CONFIG_KEY, []);

        if (!is_array($cfg)) {
            throw new InvalidCartConfigurationException(
                sprintf(
                    'The value of `%s` configuration must be an array',
                    self::EXTRA_PRODUCT_MERGE_ATTRIBUTES_CONFIG_KEY
                )
            );
        }

        foreach ($cfg as $attribute) {
            if (!is_string($attribute)) {
                throw new InvalidCartConfigurationException(
                    sprintf(
                        'The configuration `%s` can only contain an array of strings, `%s` given',
                        self::EXTRA_PRODUCT_MERGE_ATTRIBUTES_CONFIG_KEY,
                        gettype($attribute)
                    )
                );
            }

            $result[$attribute] = $product->{$attribute};
        }

        return $result;
    }
}
