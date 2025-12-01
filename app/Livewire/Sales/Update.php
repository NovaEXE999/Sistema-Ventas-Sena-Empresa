<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class Update extends Create
{
    public Sale $sale;

    public function mount($sale = null): void
    {
        parent::mount();

        if (!$sale) {
            abort(404);
        }

        $this->sale = $sale instanceof Sale
            ? $sale->load('details.product', 'client', 'user')
            : Sale::with('details.product', 'client', 'user')->findOrFail($sale);
        $this->date = $this->sale->date instanceof \Carbon\Carbon
            ? $this->sale->date->format('Y-m-d')
            : $this->sale->date;

        $this->user_id = $this->sale->user_id;
        $this->sellerName = optional($this->sale->user)->name ?? $this->sellerName;
        $this->client_id = $this->sale->client_id;
        $this->clientSearch = optional($this->sale->client)->name ?? '';

        foreach ($this->sale->details as $detail) {
            $product = $detail->product;
            if (!$product) {
                continue;
            }

            // Devuelve a stock la cantidad vendida para permitir editar sin bloquear por inventario actual
            $this->lineItems[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $detail->quantity,
                'price' => (float) $product->price,
                'stock' => $product->quantity + $detail->quantity,
                'subtotal' => (float) $product->price * $detail->quantity,
            ];
        }

        $this->recalculateTotals();
    }

    protected function persistSale(Client $client): void
    {
        $products = Product::whereIn('id', array_keys($this->lineItems))
            ->select('id', 'price', 'quantity')
            ->get()
            ->keyBy('id');

        foreach ($this->lineItems as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product) {
                $this->addError('lineItems', 'Un producto seleccionado ya no existe.');
                return;
            }

            $available = $product->quantity;
            $previousDetail = $this->sale?->details->firstWhere('product_id', $item['product_id']);
            if ($previousDetail) {
                $available += $previousDetail->quantity;
            }

            if ($item['quantity'] > $available) {
                $this->addError('lineItems', "Stock insuficiente para {$item['name']}. Disponible: {$available}.");
                return;
            }
        }

        DB::transaction(function () use ($client, $products) {
            // Devuelve stock previo de la venta actual
            foreach ($this->sale->details as $detail) {
                $detail->product?->increment('quantity', $detail->quantity);
            }

            $this->sale->update([
                'total_value' => $this->total_value,
                'date' => $this->date,
                'user_id' => $this->user_id,
                'client_id' => $client->id,
            ]);

            $this->sale->details()->delete();

            foreach ($this->lineItems as $item) {
                $price = $products[$item['product_id']]->price;
                $quantity = $item['quantity'];

                $this->sale->details()->create([
                    'quantity' => $quantity,
                    'total' => $price * $quantity,
                    'product_id' => $item['product_id'],
                ]);

                $products[$item['product_id']]->decrement('quantity', $quantity);
            }
        });

        session()->flash('success', 'Venta actualizada correctamente.');
        $this->redirectRoute('sales.index', navigate: true);
    }
}
