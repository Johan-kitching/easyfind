<?php

namespace App\Livewire\Transporter;

use App\Models\Machinery;
use App\Models\Mechanic;
use App\Models\Transporter;
use App\Models\TransporterType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class SearchTransporter extends Component
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
        $this->types = $this->getActiveTypes();
        $this->getSearchResults();
    }

    public function getActiveTypes(): array
    {
        $types = TransporterType::selectRaw('id, name')->orderBy('name')->get()->toArray();;
        $types[] = ['name' => 'All', 'id' => null];
        usort($types, function ($a, $b) {
            return strnatcasecmp($a['name'], $b['name']);
        });
        foreach ($types as $key => $type) {
            if ($type['name'] == 'All') {
                continue;
            }
            $count = Transporter::where('transporter_type_id', $type['id'])->count();
            $types[$key]['name'] = $type['name']." ({$count})";
        }
        return $types;
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

    public function setUserLocation($latitude, $longitude)
    {
        $this->current_latitude = $latitude;
        $this->current_longitude = $longitude;
        $this->current_location = "Your Shared Location is: " . $latitude . ", " . $longitude;
        $this->getSearchResults();
    }

    public function updated($fields)
    {
        $this->getSearchResults();
    }

    public function getSearchResults(): void
    {
            if (is_null($this->current_latitude) || is_null($this->current_longitude)) {
                $results = Transporter::with(['type', 'photos'])
                    ->select('transporters.*');
            } else {
                $results = Transporter::with(['type', 'photos'])
                    ->select(
                        ['transporters.*', DB::raw("
            (
                6371 * acos(
                    cos(radians($this->current_latitude))
                    * cos(radians(address_latitude))
                    * cos(radians(address_longitude) - radians($this->current_longitude))
                    + sin(radians($this->current_latitude))
                    * sin(radians(address_latitude))
                )
            ) AS distance")]
                    )->orderBy('distance');
            }
            if (!is_null($this->search)) {
                $results->where(function ($results) {
                    $results->where('transporters.description', 'like', "%$this->search%");
                });
            }
            if (!is_null($this->type)) {
                $results->where(function ($results) {
                    $results->where('transporters.transporter_type_id', '=', "$this->type");
                });
            }
//            dump($results->toRawSql());
            $this->results = $results->get();
    }

    public function render()
    {
        return view('transporter.search-transporter');
    }

}
