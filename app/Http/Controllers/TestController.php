<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index()
    {
        $data = $this->file_get_contents_curl(
        'https://www.instagram.com/p/B_Ap6EKHXmmiqDPVO4s2LTfJQT-lnlb1l-mYZc0/');

        $fp = '/home/sherin/Documents/asd.png';

        file_put_contents( $fp, $data );
        echo "File downloaded!";
    }

    public function file_get_contents_curl($url) {

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);

      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }

}
