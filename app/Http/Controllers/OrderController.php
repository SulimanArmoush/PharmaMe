<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{
    public function createOrder(Request $request , $fromId)
    {
        // التحقق من صحة البيانات المرسلة
        $validatedData = $this->validate($request, [
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.qty' => 'required|numeric|min:1|integer',
        ]);
    
        $medicineIds = [];
        $medicineInfo = [];
        $totalPrice = 0.0;
        foreach ($request->items as $item) {
            $medicineIds[] = $item['medicine_id'];
            $medicineInfo[$item['medicine_id']] = Medicine::find($item['medicine_id']);
            $totalPrice += $medicineInfo[$item['medicine_id']]->price *  $item['qty'];
        }
    
        // إنشاء الطلبية
        $orderInfo = Order::create([
            'user_id' => Auth::id(),
            'from_id' => $fromId,
            'totalPrice' => $totalPrice,

        ]);
    
        // إضافة الأدوية إلى الطلبية
        foreach ($validatedData['items'] as $item) {
            $medicine = $medicineInfo[$item['medicine_id']];
            $orderInfo->medicines()->attach($item['medicine_id'], [
                'price' => $medicine['price'],
                'quantity' => $item['qty'],
            ]);
    
            // تحديث الكمية المتاحة
            $medicine->quantity -= $item['qty'];
            $medicine->save();
        }
        return response()->json(['message' => 'Order has been created successfully'], 200);
    }
    


    public function getUserOrders()
    {
        $orders = Order::where('user_id', Auth::id())
         ->get();
        return response()->json($orders, 200);
    }


    public function getOrders()
    {
        $orders = Order::where('from_id', Auth::id())
         ->get();
        return response()->json($orders, 200);
    }


    public function getSingleOrder($orderId)
    {
        $orderInfo = Order::with('medicines')->find($orderId);

      
    if ($orderInfo) {
        $result = $orderInfo->toArray();
        $result['medicines'] = $orderInfo->medicines->map(function ($medicine) {
            return array_merge($medicine->toArray(), [
                'quantity' => $medicine->pivot->quantity,
            ]);
        });
    }
        return response()->json([$result], 200);
    }


    public function updateStatus(Request $request , $orderID)
    {
        $this->validate($request, [
            'status' => 'required'
        ]);


        $orderInfo = Order::find($orderID);
        $orderInfo->update([
            'status' => $request->status,
        ]);
        
 //       if ($request->status == 'Sent') {
  //      foreach ($orderInfo->medicines as $medicine) {
    //        $medicine->decrement('quantity', $medicine->pivot->quantity);
     //   }
  //  }
        return response()->json(['message' => 'Status has been updated successfuly'], 200);
    }


    public function updatePaymentStatus(Request $request , $orderID)
    {
        $this->validate($request, [
            'paymentStatus' => 'required'
        ]);

        $orderInfo = Order::find($orderID);
        $orderInfo->update([
            'paymentStatus' => $request->paymentStatus,
        ]);
        return response()->json(['message' => 'Payment Status has been updated successfuly'], 200);
    }
    public function getMedicineSalesReport()
    {
        $report = DB::table('order_medicines')
            ->join('orders', 'order_medicines.order_id', '=', 'orders.id')
            ->where('medicines.user_id', Auth::id())
            ->join('medicines', 'order_medicines.medicine_id', '=', 'medicines.id')
            ->select('medicines.trName', DB::raw('SUM(order_medicines.quantity) as total_quantity'), DB::raw('SUM(order_medicines.price * order_medicines.quantity) as total_price'))
            ->groupBy('medicines.trName')
            ->get()
            ->toArray();

            if($report == null)
            return response()->json(['message' => 'No Reports Available'], 404);

            $totalSales = array_reduce($report, function ($carry, $item) {
            return $carry + $item->total_price;
            }, 0);
    
        return response()->json(['message' => 'Your report is READY','report' => $report, 'totalSales' => $totalSales] , 200);
    }
    
}
    


