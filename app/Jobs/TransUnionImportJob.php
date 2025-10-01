<?php

namespace App\Jobs;

use App\Models\codes_and_descriptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransUnionImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $rows)
    {
        $this->rows = json_decode($this->rows, true);
    }

    public function handle(): void
    {
            $cleanedRow = $this->cleanRow($this->rows);
            codes_and_descriptions::firstOrCreate($cleanedRow);
    }

    private function cleanRow($row)
    {

        foreach ($row as $key => $value) {
            if (is_string($value)) {
                $row[$key] = $this->cleanString($value);
            }
        }
        return $row;
    }

    private function cleanString($inputString)
    {
        // Replace non-breaking spaces with regular spaces
        $cleanedString = str_replace("\xA0", ' ', $inputString);
        // Remove any other non-printable characters
        $cleanedString = preg_replace('/[^\x20-\x7E]/', '', $cleanedString);
        return $cleanedString;
    }
}
