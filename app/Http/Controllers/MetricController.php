<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Strategy;
use GuzzleHttp\Client;
use App\Models\MetricHistoryRun;
use Illuminate\Contracts\View\View;
use App\Http\Requests\MetricRequest;

class MetricController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $strategies = Strategy::all();

        return view('index', [
            'categories' => $categories,
            'strategies' => $strategies,
        ]);
    }

    
    public function getMetrics(MetricRequest $request)
    {
        $url = $request->input('url');
        $categories = $request->input('categories');
        $strategy = $request->input('strategy');
        $key = env('GOOGLE_API_KEY');
        $pagesspeedonline=env('PAGES_SPEED_ONLINE');

        $client = new Client();

        $response = $client->get("{$pagesspeedonline}?url={$url}&key={$key}&{$categories}&strategy={$strategy}");

        $metrics = json_decode($response->getBody(), true);
        return response()->json($metrics);
    }

    public function saveMetrics(MetricRequest $request)
    {
        $metricRun = new MetricHistoryRun() ;
        $metricRun->url = $request->input('url');
        $metricRun->accessibility_metric = $request->input('accessibility');
        $metricRun->pwa_metric = $request->input('pwa');
        $metricRun->performance_metric = $request->input('performance');
        $metricRun->seo_metric = $request->input('seo');
        $metricRun->best_practices_metric = $request->input('best_practices');
        $metricRun->strategy_id = $request->input('strategy') == 'MOBILE' ? 2 : 1;
        $metricRun->save();

        return response()->json(['success' => true]);
    }

    public function historyMetrics(): View
    {
        $metrics = MetricHistoryRun::all();
        return view('history', ['metrics' => $metrics]);
    }

    
}
