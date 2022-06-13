<?php

namespace App\Http\Middleware;

use Closure;
use App\Medicine;

class StoreOrUpdateMedicine {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $medicine = Medicine::where('barcode',$request->input('barcode'))->first();
        if(!$medicine) return $next($request);
        $medicine->stock += $request->input('stock');
        $medicine->save();
        return redirect()->back()->with('message', 'El medicamento existe y ha incrementado el stock');
    }
}
