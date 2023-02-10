<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class HomeController extends Controller
{

    //
    public function __invoke()
    {
        $territories = $this->keyById($this->fetchTerritories());
        $this->sortTerritories($territories);
        $territories = $this->nest($territories);

        return Inertia::render('Home');
    }

    private function fetchTerritories(): array
    {
        $territories = Http::get("https://netzwelt-devtest.azurewebsites.net/Territories/All")
            ->json()['data'];
        return $territories;
    }

    private function keyById($territories)
    {
        $keyed = [];
        foreach ($territories as $val) {
            $keyed[$val['id']] = $val;
        }
        return $keyed;
    }

    private function sortTerritories(&$territories)
    {
        asort($territories, SORT_NUMERIC);
    }

    private function nest($territories)
    {
        $nested = [];
        foreach ($territories as $key => $val) {
            if ($parent = $val['parent']) {
                $territories[$parent]['children'][$key] = $val;
            }
        }
        foreach ($territories as $key => $val) {
            if (!($val['parent'] ?? null)) {
                $nested[$key] = $val;
            }
        }
        return $nested;
    }
}
