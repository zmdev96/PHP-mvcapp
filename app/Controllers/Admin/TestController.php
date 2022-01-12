<?php
namespace App\Controllers\Admin;

use Core\Controller as Controller;
use Core\Helper;
use Carbon\Carbon;

class TestController extends Controller
{
    use Helper;

    public function index()
    {
      // echo 'test';
      // if (isset($this->session->lang_changed)) {
      //     pre($this->session->lang_changed);
      // }
      //
      $this->request->redirect('app-admin/users');
    }


    public function stream()
    {
      $time = Carbon::now();

    echo Carbon::parse($time)->locale('ar_SY')->isoFormat('LLLL'); // 'mardi 23 juillet 2019 14:51'
    }

    public function time()
    {
        //   $nextSummerOlympics = Carbon::createFromDate(2020)->addYears(4);
        //   $howOldAmI = Carbon::createFromDate(1996, 5, 9)->age;
        //
        //   $test = Carbon::setTestNow(Carbon::createFromDate(2020, 3, 19));
        //   //echo Carbon::parse('2019-07-23')->isoFormat('LLLL'); // 'Tuesday, July 23, 2019 2:51 PM'
        // echo Carbon::now()->subMinutes(5)->locale('en-US')->diffForHumans(); // '2分钟前'
        // $daysSinceEpoch = Carbon::createFromTimestamp(0)->diffInDays();
        //
        //   echo $daysSinceEpoch;

        // $accounts = array(
        //   '@jonathansampson',
        //   '@f12devtools',
        //   '@ieanswers'
        // );
        // $index = count($accounts);
        // while ($index) {
        //     echo sprintf("<li>%s</li>", $accounts[--$index]);
        // }
        //
        // echo '<br>';
        //
        // $accounts = array(
        //   '@jonathansampson',
        //   '@f12devtools',
        //   '@ieanswers'
        // );
        // foreach (array_reverse($accounts) as $account) {
        //     echo sprintf("<li>%s</li>", $account);
        // }
        //
        // echo 'Sort array <br>';
        //
        // $arr=array(12 => 20, 13 => 16, 7 => 28, 21 => 30 );
        // $k_arr=array_keys($arr);
        // rsort($arr);
        // $new_arr=array_combine($k_arr, $arr);
        // pre($new_arr);

      //  pre($_SERVER);
      $date = Carbon::now();

      //echo $date->format('F'); // July
      //echo $date->startOfMonth()->subMonth()->format('Y-m-d'); // June

      //

      $date = Carbon::parse('2017-03-30');

      //echo $date->format('F'); // March
      //echo $date->startOfMonth()->subMonth()->format('F'); // February
    }

    public function test()
    {
    }
}
