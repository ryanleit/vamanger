<?php

use Illuminate\Database\Seeder;

use App\Restaurant;
class UpdateRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$code = $request->get('code');
       // if($code == '12345'){
            //$files = File::get(storage_path()."/app/restaurants_data.csv");
            $csvFile = file(public_path()."/restaurants_data.csv");
            $data = [];
            echo "Total row csv file: ".count($csvFile);
            $number = 0;
            foreach ($csvFile as $line) {
                $data = str_getcsv($line);
                if(count($data) == 4){
                    $restaurant = Restaurant::where('full_address',$data[0])->first();
                    if($restaurant){
                        $restaurant->google_address = $data[1];
                        $restaurant->lat = $data[2];
                        $restaurant->lng = $data[3];
                        $restaurant->save();
                        
                        $number++;
                        
                        if(($number%1000) == 0) echo "Number row is updated: ".$number;
                    }
                }
            }
            echo "Total row updated: ".$number;
        //}
    }
}
