<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cashflow;
use App\Models\Team;
use App\Models\HppCalculation;

class BusinessController extends Controller
{
    public function stock()
    {
        $products = Product::latest()->paginate(10);
        return view('business.stock', compact('products'));
    }

    public function pos()
    {
        $products = Product::all();
        return view('business.pos', compact('products'));
    }

    public function salesRecap()
    {
        $transactions = Transaction::latest()->take(5)->get();
        $totalRevenue = Transaction::where('status', 'paid')->sum('total_amount');
        $totalTransactions = Transaction::count();
        $productsSold = 0; // Placeholder, would need a more complex query or relationship count

        return view('business.sales-recap', compact('transactions', 'totalRevenue', 'totalTransactions', 'productsSold'));
    }

    public function cashflow()
    {
        $cashflows = Cashflow::latest()->take(5)->get();
        $income = Cashflow::where('type', 'income')->sum('amount');
        $expense = Cashflow::where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        // Chart Data (Last 30 Days)
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $chartData = $dates->map(function ($date) {
            return [
                'date' => $date,
                'income' => Cashflow::where('type', 'income')->whereDate('date', $date)->sum('amount'),
                'expense' => Cashflow::where('type', 'expense')->whereDate('date', $date)->sum('amount'),
            ];
        });

        return view('business.cashflow', compact('cashflows', 'income', 'expense', 'balance', 'chartData'));
    }

    public function locationProfit()
    {
        return view('business.location-profit');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $product->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
        ]);

        Cashflow::create($validated);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }

    public function storeTeamMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teams',
            'role' => 'required|string',
        ]);

        $validated['status'] = 'active'; // Default status

        Team::create($validated);

        return redirect()->back()->with('success', 'Anggota tim berhasil diundang!');
    }

    public function storeHpp(Request $request)
    {
        // In a real app, validate and save to database.
        // For now, we'll just redirect back with a success message.
        return redirect()->back()->with('success', 'Perhitungan HPP berhasil disimpan!');
    }

    public function hppCalculator()
    {
        // In a real app, we might fetch saved calculations
        return view('business.hpp-calculator');
    }

    public function team()
    {
        $teams = Team::all();
        return view('business.team', compact('teams'));
    }
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
        ]);

        // Start Transaction
        \DB::beginTransaction();

        try {
            // Create Transaction
            $transaction = Transaction::create([
                'customer_name' => $validated['customer_name'] ?? 'Pelanggan Umum',
                'total_amount' => $validated['total_amount'],
                'status' => 'paid',
            ]);

            foreach ($validated['cart'] as $item) {
                $product = Product::findOrFail($item['id']);

                // Check Stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }

                // Deduct Stock
                $product->decrement('stock', $item['quantity']);

                // Create Transaction Item
                \App\Models\TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);
            }

            // Record Cashflow
            Cashflow::create([
                'type' => 'income',
                'amount' => $validated['total_amount'],
                'description' => "Penjualan POS #{$transaction->id}",
                'category' => 'Penjualan',
                'date' => now(),
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'transaction_id' => $transaction->id
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
