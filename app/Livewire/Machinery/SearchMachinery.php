<?php

namespace App\Livewire\Machinery;

use App\Models\Machinery;
use App\Models\MachineryType;
use App\Models\Mechanic;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class SearchMachinery extends Component
{
    use WireUiActions;

    public $search;
    public $results = [];
    public $current_latitude;
    public $current_longitude;
    public $current_location;
    public $ip;
    public $location;
    public $city;
    public $categories = [];
    public $category;
    public $types = [];
    public $type;

    public function mount()
    {
        $this->results = null;
        $this->search = null;
        $this->ip = $this->getUserIpAddr();
        $this->location = $this->getLatLong($this->ip);
        $this->current_latitude = $this->location['latitude'] ?? null;
        $this->current_longitude = $this->location['longitude'] ?? null;
        $this->city = $this->location['city'] ?? null;
        $this->categories = $this->getAllCategories();
//        $this->types = $this->getActiveTypes();
        $this->types = null;
        $this->getSearchResults();
        $this->category = 'All';
    }

    public function getAllCategories(): array
    {
        $categories = MachineryType::select('category')->groupBy('category');
        if (!is_null($this->category)) {
            $categories->where('type', 'like', $this->type);
        }
        $categories = $categories->orderBy('category')->get()->toArray();
        $categories[] = ['category' => 'All'];
        usort($categories, function ($a, $b) {
            return strnatcasecmp($a['category'], $b['category']);
        });
        foreach ($categories as $key=>$category) {
            if($category['category'] == 'All') {
                $categories[$key]['count'] = 0;
                $categories[$key]['category_count'] = $category['category'];
                continue;
            }
            $count = Machinery::whereIn('machinery_type_id', MachineryType::where('category',$category)->select('id'))->count();
            $categories[$key]['count'] = $count;
            $categories[$key]['category_count'] = $category['category']." ({$count})";
        }
        return $categories;
    }

    public function getAllTypes(): array
    {
        $types = MachineryType::select('type','id')->groupBy('type','id');

        if (!is_null($this->category) && $this->category != 'All') {
            $types->where('category', 'like', $this->category);
            $types = $types->get()->toArray();
            array_unshift($types, array('type'=>'All','id'=>'all', 'type_count'=>'All'));
            foreach ($types as $key => $type) {
                if ($type['type'] == 'All') {
                    continue;
                }
                $count = Machinery::where('machinery_type_id', $type['id'])->count();
                $types[$key]['type_count'] = $type['type']." ({$count})";
            }
            return $types;
        } else {
            return [];
        }
    }

    public function getActiveCategories(): array
    {
        $categories = Machinery::select('category')->leftJoin('machinery_types', 'machinery_type_id', 'machinery_types.id')->groupBy('category');
        if (!is_null($this->category)) {
            $categories->where('type', 'like', $this->type);
        }
        $categories = $categories->orderBy('category')->get()->toArray();
        $categories[] = ['category' => 'All'];
        usort($categories, function ($a, $b) {
            return strnatcasecmp($a['category'], $b['category']);
        });
        return $categories;
    }

    public function getActiveTypes(): array
    {
        $types = Machinery::selectRaw('machinery_types.type as name')->leftJoin('machinery_types', 'machinery_type_id', 'machinery_types.id')->groupBy('type');
        if (!is_null($this->category) && $this->category != 'All' && $this->category != 'Mechanic') {
            $types->where('category', 'like', $this->category);
            return $types->get()->toArray();
        } else {
            return $types = [];
        }
    }

    public function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif
        (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getLatLong($ip)
    {
        $url = "http://ip-api.com/json/{$ip}";

        // Initialize a cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the API request was successful
        if (is_array($data) && $data['status'] === 'success') {
            return [
                'latitude' => $data['lat'],
                'longitude' => $data['lon'],
                'city' => $data['city']
            ];
        } else {
            return null; // Return null if the request was not successful
        }
    }

    public function updated($fields)
    {

        if ($fields == 'category' && $this->category != 'All' && $this->category != 'Mechanic') {
            $this->types = $this->getAllTypes();
            $this->type = $this->types[0]['type'];
        } elseif ($fields == 'category' && ($this->category == 'All' || $this->category == 'Mechanic')) {
            $this->types = null;
        }
//        if ($fields == 'type') {
//            $this->categories = $this->getActiveCategories();
//            $this->category = $this->categories[0]['category'];
//        }
        $this->getSearchResults();
    }

    public function getSearchResults(): void
    {
        if (is_null($this->current_latitude) || is_null($this->current_longitude)) {

            $results = Machinery::with('photos')->select(
                ['machineries.id', 'machinery_types.type as type', 'machinery_types.category as category', 'machineries.description as description']
            );
        } else {
            $results = Machinery::with('photos')->select(
                ['machineries.id', 'machinery_types.type as type', 'machinery_types.category as category', 'machineries.description as description',
                    DB::raw("
            (
                6371 * acos(
                    cos(radians($this->current_latitude))
                    * cos(radians(address_latitude))
                    * cos(radians(address_longitude) - radians($this->current_longitude))
                    + sin(radians($this->current_latitude))
                    * sin(radians(address_latitude))
                )
            ) AS distance
        ")]
            )
                ->orderBy('distance');
        }
        $results
            ->join('machinery_types', 'machinery_types.id', '=', 'machineries.machinery_type_id')
            ->whereNotNull('address_latitude')
            ->whereNotNull('address_longitude');

        if (!is_null($this->search)) {
            $results->where(function ($results) {
                $results->where('description', 'like', "%$this->search%", 'or');
//                $results->where('model', 'like', "%$this->search%", 'or');
            });
        }
        if (!is_null($this->category) && $this->category != 'All') {
            $results->where('category', 'like', $this->category);
        }
        if (!is_null($this->type) && $this->category != 'All' && $this->type != 'All') {
                $results->where('type', 'like', $this->type);
        }
        $this->results = $results->get();
    }

    public function render()
    {
        return view('machinery.search-machinery');
    }

}
