<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;

class Index extends Component
{
    use WithFileUploads;

    public $products;
    public $showArchived = false;

    public $productId = null;
    public $name = '';
    public $description = '';
    public $price = '';
    public $stock = '';
    public $image;
    public $imagePath;
    public $showForm = false;
    public $category = '';
    public $selectedCategory = 'Hot Dishes'; // Default selected category
    public $categories = []; // Add this line to declare the categories property

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function mount()
    {
        $this->loadProducts();
        $this->categories = ['Hot Dishes', 'Cold Dishes', 'Soup', 'Grill', 'Appetizer', 'Dessert'];
    }

    public function loadProducts()
    {
        if ($this->showArchived) {
            $this->products = Product::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } else {
            $this->products = Product::orderBy('created_at', 'desc')->get();
        }
    }

    public function toggleArchived()
    {
        $this->showArchived = !$this->showArchived;
        $this->resetForm();
        $this->loadProducts();
    }

    public function restoreProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        session()->flash('message', 'Product restored.');
        $this->loadProducts();
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('message', 'Product deleted.');
        $this->loadProducts();
    }

    public function resetForm()
    {
        $this->productId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock = '';
        $this->image = null;
        $this->imagePath = null;
        $this->category = '';
        $this->showForm = false;
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->imagePath = $product->image_path;
        $this->category = $product->category;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'image' => $this->productId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $this->imagePath = $path;
        }

        // ✅ Insert this debug here before writing to database
        \Log::info('Product Save Debug:', [
            'productId' => $this->productId,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'imagePath' => $this->imagePath,
            'category' => $this->category,
        ]);

        Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $this->stock,
                'image_path' => $this->imagePath,
                'category' => $this->category,
            ]
        );

        session()->flash('message', $this->productId ? 'Product updated.' : 'Product created.');

        $this->resetForm();
        $this->loadProducts();
    }

    public function render()
    {
        $query = Product::query();
        
        if ($this->showArchived) {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');
        }

        $products = $query->get();

        return view('livewire.products.index', [
            'products' => $products,
            'categories' => $this->categories,
        ]);
    }
}
