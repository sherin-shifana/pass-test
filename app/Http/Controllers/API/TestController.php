<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Validator;
use DB;

class TestController extends Controller
{
  public $successStatus = 200;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function test()
    {
      $user = DB::table('users')->get();
      return response()->json(['success' => $user], $this-> successStatus);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $temp_net_sale = 0;
        $temp_paid = 0;
        $temp_unpaid = 0;
        $Table_net_sale = 0;
        $Table_paid = 0;
        $Table_unpaid = 0;

        $Table_D_net_sale = 0;
        $Table_D_paid = 0;
        $Table_D_unpaid = 0;

        $Table_W_net_sale = 0;
        $Table_W_paid = 0;
        $Table_W_unpaid = 0;

        $Table_M_net_sale = 0;
        $Table_M_paid = 0;
        $Table_M_unpaid = 0;
        $ticket = DB::table('tickets')->get();
        foreach ($ticket as $k) {
          (int)$subtotal = $k->subtotal;
          (int)$surcharge = $k->surcharge;
          (int)$gratuity = $k->gratuity;
          (int)$discount = $k->discount;

          $discount = ($discount/100)*$subtotal;
          $surcharge = ($discount/100)*$subtotal;
          $gratuity = ($discount/100)*$subtotal;

// sales-----
          $temp_net_sale = $temp_net_sale + $subtotal - $discount + $surcharge + $gratuity;

          }
        $net_sale = $temp_net_sale;
//paid------
        $all_paid = DB::table('tickets')->where('ticket_status', 'PAID')->get();

        foreach ($all_paid as $k) {
          (int)$subtotal = $k->subtotal;
          (int)$surcharge = $k->surcharge;
          (int)$gratuity = $k->gratuity;
          (int)$discount = $k->discount;

          $discount = ($discount/100)*$subtotal;
          $surcharge = ($discount/100)*$subtotal;
          $gratuity = ($discount/100)*$subtotal;
          $temp_paid = $temp_paid + $subtotal - $discount + $surcharge + $gratuity;

        }
        $paid = $temp_paid;
//unpid -----
        $unpaid_all = DB::table('tickets')->where('ticket_status', 'UNPAID')->get();

        foreach ($unpaid_all as $k) {
          (int)$subtotal = $k->subtotal;
          (int)$surcharge = $k->surcharge;
          (int)$gratuity = $k->gratuity;
          (int)$discount = $k->discount;

          $discount = ($discount/100)*$subtotal;
          $surcharge = ($discount/100)*$subtotal;
          $gratuity = ($discount/100)*$subtotal;
          $temp_unpaid = $temp_unpaid + $subtotal - $discount + $surcharge + $gratuity;
          }
        $unpaid =  $temp_unpaid;


//Daily sale.........................
        $daily_sales = DB::table('tickets')->where('created_at', '>=', Carbon::today())->where('created_at', '<=', Carbon::now())->get();
        $daily_sales_c = count($daily_sales);
        $daily_paid_c = DB::table('tickets')->where('created_at', '>=', Carbon::today())->where('created_at', '<=', Carbon::now())->where('ticket_status','PAID')->count();
        $daily_unpaid_c = DB::table('tickets')->where('created_at', '>=', Carbon::today())->where('created_at', '<=', Carbon::now())->where('ticket_status','UNPAID')->count();
        foreach ($daily_sales as $daily_1) {
          (int)$subtotal = $daily_1->subtotal;
          (int)$surcharge =$daily_1->surcharge;
          (int)$gratuity = $daily_1->gratuity;
          (int)$discount = $daily_1->discount;
          (int)$unpaid_1 = $daily_1->subtotal;
        $Table_D_net_sale = $Table_D_net_sale + $subtotal + $surcharge + $gratuity;
        $Table_D_paid = $subtotal - $discount + $surcharge + $gratuity;
        $Table_D_unpaid = $Table_D_unpaid +$unpaid_1;
      }

//week sales ------------------------------------------
        $week_sales = DB::table('tickets')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->get();
        $week_sales_c = count($week_sales);
        $week_paid_c = DB::table('tickets')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->where('ticket_status','PAID')->count();
        $week_unpaid_c =DB::table('tickets')->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->where('ticket_status','UNPAID')->count();
        foreach ($week_sales as $week_1) {
          (int)$subtotal = $week_1->subtotal;
          (int)$surcharge =$week_1->surcharge;
          (int)$gratuity = $week_1->gratuity;
          (int)$discount = $week_1->discount;
          (int)$unpaid_1 = $week_1->subtotal;

          $Table_W_net_sale = $Table_W_net_sale + $subtotal + $surcharge + $gratuity;
          $Table_W_paid = $subtotal - $discount + $surcharge + $gratuity;
          $Table_W_unpaid = $Table_W_unpaid +$unpaid_1;
        }

        // echo "#######################";
//Monthily sale
        $month_sales = DB::table('tickets')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->get();
        $month_sales_c = count($month_sales);
        $month_paid_c = DB::table('tickets')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->where('ticket_status','PAID')->count();
        $month_unpaid_c = DB::table('tickets')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->where('ticket_status','UNPAID')->count();



        foreach ($month_sales as $month_1) {
          (int)$subtotal = $month_1->subtotal;
          (int)$surcharge =$month_1->surcharge;
          (int)$gratuity = $month_1->gratuity;
          (int)$discount = $month_1->discount;
          (int)$unpaid_1 = $month_1->subtotal;

          $Table_M_net_sale = $Table_M_net_sale + $subtotal + $surcharge + $gratuity;
          $Table_M_paid = $subtotal - $discount + $surcharge + $gratuity;
          $Table_M_unpaid = $Table_M_unpaid +$unpaid_1;
        }

        $arrayName = array('net_sale' =>$net_sale, 'paid'=>$paid, 'unpaid'=>$unpaid, 'Table_W_net_sale'=>$Table_W_net_sale, 'Table_W_paid'=>$Table_W_paid, 'Table_W_unpaid'=>$Table_W_unpaid, 'Table_M_net_sale'=>$Table_M_net_sale, 'Table_M_paid'=>$Table_M_paid, 'Table_M_unpaid'=>$Table_M_unpaid, 'Table_D_net_sale'=>$Table_D_net_sale, 'Table_D_paid'=>$Table_D_paid, 'Table_D_unpaid'=>$Table_D_unpaid, 'month_sales_c'=>$month_sales_c,
        'month_paid_c'=>$month_paid_c, 'month_unpaid_c'=>$month_unpaid_c,'daily_sales_c'=>$daily_sales_c, 'daily_paid_c'=>$daily_paid_c,'daily_unpaid_c'=>$daily_unpaid_c,
        'week_sales_c'=>$week_sales_c,'week_paid_c'=>$week_paid_c,'week_unpaid_c'=>$week_unpaid_c);


        // $token = $request->bearerToken();
        return response()->json(['success' => $arrayName], $this-> successStatus);
        // echo "#######################";

        // echo $daily_sales;
          // return view('home');
          // return view('welcome',compact('net_sale','paid','unpaid','Table_W_net_sale','Table_W_paid','Table_W_unpaid','Table_M_net_sale','Table_M_paid','Table_M_unpaid','Table_D_net_sale','Table_D_paid','Table_D_unpaid','month_sales_c','month_paid_c','month_unpaid_c','daily_sales_c','daily_paid_c','daily_unpaid_c','week_sales_c','week_paid_c','week_unpaid_c'));
          // echo "====>";
          // echo $net_sale;
    }
}
