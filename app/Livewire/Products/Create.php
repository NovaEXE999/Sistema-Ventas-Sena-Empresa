<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Rules\SimilarProductName;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    // Buscador de categorヴa
    public string $categorySearch = '';
    public string $categoryLabel = '';
    public array $categoryResults = [];
    public array $categoryOptions = [];

    public $name = '';
    public $stock = 0;
    public $price = 0;
    public $category_id = null;

    public function mount(): void
    {
        $this->categoryOptions = $this->loadCategoryOptions();
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
                ),
                new SimilarProductName(),
            ],
            'stock' => ['required', 'integer', 'min:0', 'max:1000'],
            'price' => ['required', 'numeric', 'regex:/^\\d{1,9}(\\.\\d{1,2})?$/', 'min:50', 'max:999999999'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function updatedCategorySearch(): void
    {
        $this->category_id = null;
        $this->categoryLabel = '';

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
            'category_id.required' => 'La categorヴa es obligatoria.',
            'category_id.exists' => 'Selecciona una categorヴa vケlida.',
        ];
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
