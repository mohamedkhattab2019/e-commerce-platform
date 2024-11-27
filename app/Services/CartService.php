<?php
namespace App\Services;

use App\Exceptions\InsufficientInventoryException;
use App\Models\Inventory;
use App\Repositories\CartRepository;
use App\Repositories\InventoryRepository;

class CartService
{
    protected $cartRepository;
    protected $inventoryRepository;

    public function __construct(CartRepository $cartRepository, InventoryRepository $inventoryRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function getCart($userId = null, $guestToken = null)
    {
        return $this->cartRepository->getCart($userId, $guestToken);
    }
    public function addToCart($userId = null, $guestToken = null, $productId)
    {
        $inventory = $this->inventoryRepository->getProductInventory($productId);

        if (!$inventory) {
            throw new InsufficientInventoryException("Product not available in inventory.");
        }
        // to do check for current product get it's quantity and add 1
        // if ($inventory->quantity < $inventory->quantity+1) {
        //     throw new InsufficientInventoryException("Requested quantity exceeds available stock.");
        // }
        
        $this->cartRepository->addToCart($userId, $guestToken, $productId);
        return $this->cartRepository->getCart($userId, $guestToken);

    }

    public function updateQuantity($userId = null, $guestToken = null, $productId, $quantity)
    {
        $inventory = $this->inventoryRepository->getProductInventory($productId);

        if (!$inventory) {
            throw new InsufficientInventoryException("Product not available in inventory.");
        }
    
        if ($inventory->quantity < $quantity) {
            throw new InsufficientInventoryException("Requested quantity exceeds available stock.");
        }
    

        $this->cartRepository->updateQuantity($userId, $guestToken, $productId, $quantity);

        return $this->cartRepository->getCart($userId, $guestToken);

    }

    public function removeProduct($userId = null, $guestToken = null, $productId)
    {
        $this->cartRepository->removeProduct($userId, $guestToken, $productId);
        return $this->cartRepository->getCart($userId, $guestToken);
    }


    public function clearCart($userId = null, $guestToken = null)
    {
        $this->cartRepository->clearCart($userId, $guestToken);
        return $this->cartRepository->getCart($userId, $guestToken);

    }
}
