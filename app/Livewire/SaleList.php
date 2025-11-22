<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class SaleList extends Component
{
    public $items = []; // Cada elemento será product_id => [name, price, quantity, total]

    protected $listeners = [
        'productSelected' => 'addItem', // Si algún componente Livewire llega a emitirlo
    ];

    public function render()
    {
        return view('livewire.sale-list');
    }

    /**
     * Método puente para cuando viene desde un browserEvent.
     */
    public function addItemFromBrowser($productId)
    {
        $this->addItem($productId);
    }

    /**
     * Agregar producto a la lista.
     * Si ya está, sumar cantidades.
     */
    public function addItem($productId)
    {
        $product = Product::find($productId);

        if (!$product) return;

        // Si ya existe en la lista, aumentar cantidad
        if (isset($this->items[$productId])) {

            $this->items[$productId]['quantity']++;
            $this->items[$productId]['total'] =
                $this->items[$productId]['quantity'] * $this->items[$productId]['price'];

        } else {
            // Agregar nuevo registro
            $this->items[$productId] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'total'    => $product->price,
            ];
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity < 1) $quantity = 1;

        $this->items[$productId]['quantity'] = $quantity;
        $this->items[$productId]['total'] =
            $quantity * $this->items[$productId]['price'];
    }

    public function removeItem($productId)
    {
        unset($this->items[$productId]);
    }
}
