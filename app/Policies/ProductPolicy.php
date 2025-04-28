<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can update the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function update(User $user, Product $product)
    {
        // Only allow the user to update the product if they created it
        return $user->id === $product->user_id;
    }

    /**
     * Determine if the user can delete the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return bool
     */
    public function delete(User $user, Product $product)
    {
        // Only allow the user to delete the product if they created it
        return $user->id === $product->user_id;
    }
}
