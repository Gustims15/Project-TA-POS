<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.product_size_id' => ['required', 'exists:product_sizes,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $order = DB::transaction(function () use ($validated): Order {
                $order = Order::create([
                    'order_code' => $this->generateOrderCode(),
                    'total_item' => 0,
                    'total_price' => 0,
                    'status' => 'Selesai',
                    'ordered_at' => now(),
                ]);

                $totalItem = 0;
                $totalPrice = 0;

                foreach ($validated['items'] as $item) {
                    $product = Product::query()
                        ->lockForUpdate()
                        ->findOrFail($item['product_id']);

                    $productSize = ProductSize::query()
                        ->where('product_id', $product->id)
                        ->where('is_active', true)
                        ->findOrFail($item['product_size_id']);

                    $quantity = (int) $item['quantity'];

                    if ($product->stock < $quantity) {
                        throw new \RuntimeException("Stok {$product->name} tidak mencukupi.");
                    }

                    $price = $productSize->price;
                    $subtotal = $price * $quantity;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_size_id' => $productSize->id,
                        'product_name' => $product->name,
                        'size_name' => $productSize->name,
                        'price' => $price,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ]);

                    $product->decrement('stock', $quantity);

                    $totalItem += $quantity;
                    $totalPrice += $subtotal;
                }

                $order->update([
                    'total_item' => $totalItem,
                    'total_price' => $totalPrice,
                ]);

                return $order->load('items');
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan.',
                'data' => $order,
            ]);
        } catch (\RuntimeException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan transaksi.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    private function generateOrderCode(): string
    {
        $date = now()->format('Ymd');

        $lastOrder = Order::query()
            ->whereDate('created_at', now()->toDateString())
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastOrder) {
            $nextNumber = ((int) substr($lastOrder->order_code, -4)) + 1;
        }

        return 'ORD-' . $date . '-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}