<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class ReportController extends Controller
{
  public $successStatus = 200;

  public function index()
  {
    $tickets = DB::table('tickets')->get();

    $total_sales = 0;
    $discounts = 0;
    $surcharge = 0;
    $gratuity = 0;
    $refunds = 0;
    $voids = 0;

    foreach ($tickets as $ticket) {
      $total_sales = $total_sales + $ticket->subtotal;
      $discounts = $discounts + $ticket->discount;
      $surcharge = $surcharge + $ticket->surcharge;
      $gratuity = $gratuity + $ticket->gratuity;
      // $refunds = $refunds + $ticket->refund;
      // $voids = $voids + $ticket->void;
    }
    echo $total_sales." ".$discounts." ".$surcharge." ".$gratuity." ".$refunds." ".$voids;

    return response()->json(['success' => $tickets], $this-> successStatus);
  }
}
