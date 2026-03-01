<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(Request $request): View
    {
        $query = Coupon::query();

        if ($search = $request->input('q')) {
            $query->where('code', 'like', '%' . $search . '%');
        }

        if ($status = $request->input('status')) {
            $query->when($status === 'active', function ($q) {
                $q->where('is_active', true)
                    ->where(function ($sub) {
                        $sub->whereNull('end_date')
                            ->orWhere('end_date', '>=', now()->toDateString());
                    });
            })->when($status === 'expired', function ($q) {
                $q->whereNotNull('end_date')
                    ->where('end_date', '<', now()->toDateString());
            })->when($status === 'inactive', function ($q) {
                $q->where('is_active', false);
            });
        }

        $coupons = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        return view('coupons.create');
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        Coupon::create($data);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon): View
    {
        return view('coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon): View
    {
        return view('coupons.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $coupon->update($data);

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    public function applyForm(): View
    {
        $activeCoupons = Coupon::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now()->toDateString());
            })
            ->orderByDesc('id')
            ->limit(6)
            ->get(['id', 'code', 'type', 'value']);

        return view('coupons.apply', compact('activeCoupons'));
    }

    public function apply(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string'],
            'cart_total' => ['required', 'numeric', 'min:0.01'],
        ]);

        $code = strtoupper(trim($validated['code']));
        $cartTotal = (float) $validated['cart_total'];

        $coupon = Coupon::whereRaw('UPPER(code) = ?', [$code])->first();

        if (! $coupon) {
            return back()
                ->withErrors(['code' => 'Coupon code not found.'])
                ->withInput();
        }

        if (! $coupon->isCurrentlyValid($cartTotal)) {
            $errorMessage = 'Coupon is not valid for this order.';

            if (! $coupon->is_active) {
                $errorMessage = 'This coupon is inactive.';
            } elseif ($coupon->start_date && $coupon->start_date->isFuture()) {
                $errorMessage = 'This coupon is not active yet.';
            } elseif ($coupon->end_date && $coupon->end_date->lt(today())) {
                $errorMessage = 'This coupon has expired.';
            } elseif ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
                $errorMessage = 'Cart total does not meet the minimum order amount for this coupon.';
            } elseif (! is_null($coupon->max_uses) && $coupon->used_count >= $coupon->max_uses) {
                $errorMessage = 'This coupon has reached its maximum number of uses.';
            }

            return back()
                ->withErrors(['code' => $errorMessage])
                ->withInput();
        }

        $discount = $coupon->calculateDiscount($cartTotal);
        $newTotal = max(0, $cartTotal - $discount);

        $coupon->increment('used_count');

        return back()
            ->with('success', 'Coupon applied successfully.')
            ->with('result', [
                'code' => $coupon->code,
                'cart_total' => $cartTotal,
                'discount' => $discount,
                'new_total' => $newTotal,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ])
            ->withInput();
    }
}
