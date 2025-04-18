<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('can:home');
    }
    public function index(){

        // Posts chart
        $posts_chart = [
            'chart_title' => 'Posts by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Post',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
        ];
        $posts_chart = new LaravelChart($posts_chart);
        //////////////////////////////////////////////

        // Users chart
        $users_chart = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',

            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            
            'filter_field' => 'created_at',
            'filter_days' => 30, // show only last 30 days

            'chart_type' => 'line',
        ];
        $users_chart = new LaravelChart($users_chart);
        //////////////////////////////////////////////
        return view('Admin.index', compact('posts_chart', 'users_chart'));
       
    }
}
