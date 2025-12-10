<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    // Buscador de categoría
    public string $categorySearch = '';
    public string $categoryLabel = '';
    public array $categoryResults = [];

    public $name = '';
    public $stock = 0;
    public $price = 0;
    public $category_id = null;

    protected function rules(): array
    {
        $normalizedName = Str::of($this->name ?? '')->squish()->lower()->toString();

        return [
            'name' => [
                'required',
                'max:256',
                'regex:/^[\\p{L} ]+$/u',
                Rule::unique('products', 'name')->where(
                    fn ($query) => $query->whereRaw('LOWER(name) = ?', [$normalizedName])
                ),
            ],
            'stock' => ['required', 'integer', 'min:1', 'max:1000'],
            'price' => ['required', 'numeric', 'regex:/^\\d{1,6}(\\.\\d{1,2})?$/', 'min:0', 'max:500000'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function updatedCategorySearch(): void
    {
        $this->category_id = null;
        $this->categoryLabel = '';

        $this->categoryResults = Category::query()
            ->where('name', 'like', '%'.$this->categorySearch.'%')
            ->where('status', true)
            ->limit(5)
            ->get(['id','name'])
            ->toArray();
    }

    public function hideCategoryResults(): void
    {
        $this->categoryResults = [];
    }

    public function selectCategory(int $id, string $name): void
    {
        $this->category_id = $id;
        $this->categoryLabel = $name;
        $this->categorySearch = $name;
        $this->categoryResults = [];
    }

    public function save()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->sanitizeName();
        $this->sanitizeNumbers();
        $this->validate();

        Product::create([
            'name' => Str::of($this->name ?? '')->squish()->toString(),
            'stock' => (int) $this->stock,
            'price' => round((float) $this->price, 2),
            'category_id' => $this->category_id,
            'status' => true,
        ]);

        session()->flash('success', 'Producto creado satisfactoriamente.');
        $this->redirectRoute('products.index', navigate:true);
    }

    private function sanitizeName(): void
    {
        $this->name = Str::of($this->name ?? '')
            ->squish()
            ->substr(0, 256)
            ->toString();
    }

    private function sanitizeNumbers(): void
    {
        $this->stock = max(1, min((int) $this->stock, 1000));
        $this->price = min(max(0, round((float) $this->price, 2)), 500000);
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'Selecciona una categoría válida.',
        ];
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
