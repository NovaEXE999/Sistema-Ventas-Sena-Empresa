<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Rules\SimilarProductName;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Update extends Component
{
    public ?Product $product = null;

    public string $categorySearch = '';
    public string $categoryLabel = '';
    public array $categoryResults = [];
    public array $categoryOptions = [];

    public $status = true;
    public $name = '';
    public $stock = 0;
    public $price = 0;
    public $category_id = null;

    public function mount(Product $product): void
    {
        $this->categoryOptions = $this->loadCategoryOptions();
        $this->setProduct($product);
    }

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
                )->ignore($this->product?->id),
                new SimilarProductName($this->product?->id),
            ],
            'stock' => ['required', 'integer', 'min:0', 'max:1000'],
            'price' => ['required', 'numeric', 'regex:/^\\d{1,9}(\\.\\d{1,2})?$/', 'min:500', 'max:999999999'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->stock = $product->stock;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->status = (bool) $product->status;

        $this->categoryLabel = optional($product->category)->name ?? '';
        $this->categorySearch = $this->categoryLabel;
    }

    public function updatedCategorySearch(): void
    {
        $this->categoryResults = Category::query()
            ->select('categories.id', 'categories.name', 'measures.name as measure')
            ->join('measures', 'measures.id', '=', 'categories.measure_id')
            ->where('categories.name', 'like', '%'.$this->categorySearch.'%')
            ->where('categories.status', true)
            ->where('measures.status', true)
            ->orderBy('categories.name')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function selectCategory(int $id, string $name): void
    {
        $this->category_id = $id;
        $this->categoryLabel = $name;
        $this->categorySearch = $name;
        $this->categoryResults = [];
    }

    public function hideCategoryResults(): void
    {
        $this->categoryResults = [];
    }

    public function updatedCategoryId($value): void
    {
        if (! $value) {
            return;
        }

        $selected = collect($this->categoryOptions)->firstWhere('id', (int) $value);
        if ($selected) {
            $this->categoryLabel = $selected['name'];
            $this->categorySearch = $selected['name'];
        }
    }

    public function update()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->sanitizeName();
        $this->sanitizeNumbers();
        $this->validate();

        $this->product->update([
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);
    }

    public function save()
    {
        $this->update();

        session()->flash('success', 'Producto actualizado correctamente.');
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
        $this->stock = max(0, min((int) $this->stock, 1000));
        $this->price = min(max(0, round((float) $this->price, 2)), 999999999);
    }

    private function loadCategoryOptions(): array
    {
        return Category::query()
            ->select('categories.id', 'categories.name', 'measures.name as measure')
            ->join('measures', 'measures.id', '=', 'categories.measure_id')
            ->where('categories.status', true)
            ->where('measures.status', true)
            ->orderBy('categories.name')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'measure' => $cat->measure,
                ];
            })
            ->toArray();
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'Selecciona una categoría valida.',
        ];
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
