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

        $territories = collect($this->fetchTerritories())->keyBy('id');
        $territories = $this->discoverDepth($territories);
        $territories = $this->sortTerritories($territories);
        dd($territories);
        return Inertia::render('Home');
    }

    private function fetchTerritories(): array
    {
        return Http::get("https://netzwelt-devtest.azurewebsites.net/Territories/All")->json()['data'];
    }

    private function nest(Collection $territories): array
    {
        // WIP
    }

    private function sortTerritories(Collection $territories)
    {
        return $territories->sortBy([
            ['depth', 'desc'],
            ['id', 'asc']
        ]);
    }

    private function discoverDepth(Collection $territories): Collection
    {
        return $territories->map(function ($item) use ($territories) {
            // calculate depth
            $depth = 0;
            $cursor = $item;
            while ($parent_id = $cursor['parent']) {
                $depth += 1;
                $cursor = $territories[$parent_id];
            }
            // add property and return
            $item['depth'] = $depth;
            return $item;
        });
    }
}
