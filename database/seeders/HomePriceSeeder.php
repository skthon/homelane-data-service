<?php

namespace Database\Seeders;

use App\Models\HomePrice;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class HomePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if file exists
        if (Storage::disk('home_prices')->exists('data.csv') === false) {
            return $this->command->info("Data.csv doesn't exists");
        }

        // Get a resource to read the file and read out the first line
        $stream = Storage::disk('home_prices')->readStream('data.csv');
        $csvHeaders = fgetcsv($stream, 4096);

        $rowsToInsert = collect([]);

        // go through each row & assign data to model and do bulk inserts
        while (($row = fgetcsv($stream, 4096)) !== false) {
            $homePrice = new HomePrice();
            $homePrice->fill([
                'date'           => Carbon::parse($row[0]),
                'price'          => $row[1],
                'bedrooms'       => $row[2],
                'bathrooms'      => $row[3],
                'sqft_living'    => $row[4],
                'sqft_lot'       => $row[5],
                'floors'         => $row[6],
                'waterfront'     => $row[7],
                'view'           => $row[8],
                'condition'      => $row[9],
                'sqft_above'     => $row[10],
                'sqft_basement'  => $row[11],
                'year_built'     => $row[12],
                'year_renovated' => $row[13],
                'street'         => $row[14],
                'city'           => $row[15],
                'state_zip'      => $row[16],
                'country'        => $row[17],
            ]);

            $rowsToInsert->push(array_merge($homePrice->getAttributes(), [
                'uuid'       => HomePrice::generateUuid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));

            // Multi insert with chunk size of 25 records
            if ($rowsToInsert->count() > 25) {
                $this->saveMultipleHomePrices($rowsToInsert);
                $rowsToInsert = collect([]);
            }
        }
        fclose($stream);
        $this->saveMultipleHomePrices($rowsToInsert);
        $this->command->info("Successfully processed dataset");
    }

    /**
     * Save home prices in bulk
     *
     * @param \Illuminate\Support\Collection $homePrices
     * @return integer
     */
    public function saveMultipleHomePrices(Collection $homePrices): int
    {
        return HomePrice::insert($homePrices->all());
    }
}
