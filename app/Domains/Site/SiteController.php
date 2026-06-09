<?php

namespace App\Domains\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function home(): View
    {
        $projects = DB::table('projects')
            ->get();

        return view('site.index', compact('projects'));
    }

    public function banner(): View
    {
        return view('site.banner');
    }

    public function about(): View
    {
        return view('site.about');
    }

    public function contact(): View
    {
        return view('site.contact');
    }

    public function projects(): View
    {
        $projects = DB::table('projects')->where('active', 1)->get();
        return view('site.projects', compact('projects'));
    }
}