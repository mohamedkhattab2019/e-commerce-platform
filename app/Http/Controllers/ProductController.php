<?php
namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use App\DTOs\ProductDTO;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return  response()->json(['data' => ProductResource::collection($products)],200);
    }

    public function getByCategory(int $categoryId)
    {
        $products = $this->productService->getProductsByCategoryId($categoryId);
        return  response()->json(['data' => ProductResource::collection($products)],200);
    }
    public function getProductById(int $productId)
    {
        $products = $this->productService->getProductById($productId);
        return  response()->json(['data' => new ProductResource($products)],200);
    }

    public function store(Request $request)
    {
        try {
            // Handle the image upload first
            $imagePath = $request->file('image')->store('products', 'public');
            $data = $request->all();
            $data['image'] = $imagePath;

            $productDTO = ProductDTO::fromArray($data);
            $product = $this->productService->createProduct($productDTO);

            return  response()->json(['data' =>new ProductResource($product)],201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function update(Request $request, int $id)
    {
        try {
            $product = $this->productService->getProductById($id);

                if (!$product) {
                    return response()->json(['message' => 'Product not found'], 404);
                }
            $data = $request->all();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $data['image'] = $imagePath;
            }
            else {
                $data['image'] = $product->image; // Keep the existing image
            }

            $data['id'] = $id;
            $productDTO = ProductDTO::fromArray($data);
            $updated = $this->productService->updateProduct($id, $productDTO);

            return response()->json(['success' => $updated], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(int $id)
    {
        $deleted = $this->productService->deleteProduct($id);

        if ($deleted) {
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Failed to delete product.'], 500);
    }
}
