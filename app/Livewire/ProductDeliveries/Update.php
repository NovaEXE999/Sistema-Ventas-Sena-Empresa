<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class Update extends Create
{
    public ProductDelivery $delivery;

    public function mount($delivery = null): void
    {
        parent::mount();

        if (!$delivery) {
            abort(404);
        }

        $this->delivery = $delivery instanceof ProductDelivery
            ? $delivery->load('product', 'provider')
            : ProductDelivery::with('product', 'provider')->findOrFail($delivery);

        $this->date = $this->delivery->date instanceof \Carbon\Carbon
            ? $this->delivery->date->format('Y-m-d')
            : $this->delivery->date;

        $this->provider_id = $this->delivery->provider_id;
        $this->providerSearch = optional($this->delivery->provider)->name ?? '';

        $product = $this->delivery->product;
        if ($product) {
            $this->lineItems = [
                $product->id => [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $this->delivery->delivered_amount,
                ],
            ];
        }
    }

    public function save(): void
    {
        // En edición, recalculamos reglas y reutilizamos validaciones del padre
        $this->validate();

        if (empty($this->lineItems)) {
            $this->addError('lineItems', 'Agrega al menos un producto.');
            return;
        }

        $provider = Provider::find($this->provider_id);
        if (!$provider) {
            $this->addError('provider_id', 'El proveedor seleccionado ya no existe.');
            return;
        }
        if (!$provider->status) {
            $this->addError('provider_id', 'El proveedor está inactivo; no puedes registrar la entrada.');
            return;
        }

        $this->persistUpdate($provider);

        session()->flash('success', 'Entrada de inventario actualizada correctamente.');
        $this->redirectRoute('productdeliveries.index', navigate: true);
    }

    protected function persistUpdate(Provider $provider): void
    {
        $item = collect($this->lineItems)->first();
        if (!$item) {
            $this->addError('lineItems', 'Agrega al menos un producto.');
            return;
        }

        DB::transaction(function () use ($item, $provider) {
            // Revertir stock previo
            if ($this->delivery->product_id) {
                Product::where('id', $this->delivery->product_id)
                    ->decrement('quantity', $this->delivery->delivered_amount);
            }

            // Actualizar registro
            $this->delivery->update([
                'date' => $this->date,
                'delivered_amount' => $item['quantity'],
                'product_id' => $item['product_id'],
                'provider_id' => $provider->id,
            ]);

            // Aplicar nuevo stock
            Product::where('id', $item['product_id'])
                ->increment('quantity', $item['quantity']);
        });
    }
}
