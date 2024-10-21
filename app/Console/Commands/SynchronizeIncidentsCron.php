<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Incident;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SynchronizeIncidentsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:incident';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize incidents from the external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $apiUrl = env( 'WATER_MANAGER_API_ENDPOINT' )."?op=SELECT&FORMAT=JSON";

        $response = Http::get( $apiUrl );

        if( $response->successful() )
        {
            $incidents = json_decode(stripslashes(  $response->getBody()->getContents() ) );

            if ( json_last_error() !== JSON_ERROR_NONE )
            {
                Log::error( "Error decoding JSON: ".json_last_error_msg() );
                return;
            }

            Log::info( "Incidents synchronized: ".now() );

            foreach( $incidents as $incident )
            {

                $category = DB::table('category')->where( 'product_id', '=', "$incident->productid" )->first();


                if( $category == null )
                {
                    Log::error( "Category not found for incident with ID: $incident->id " );
                    continue;
                }

                // dd($category);

                // dd($incident);

                // Create or update the incident
                $incidentModel = Incident::updateOrCreate(
                    [
                        'ref_vendor_id' => $incident->vendorid,
                        'ref_category' => $category->id,
                        'latitude' => $incident->latitude,
                        'longitude' => $incident->longitude,
                        'value' => $incident->value,
                        'ref_user' => 1, // Hardcoded for now, means is the system
                        'dt_register' => $incident->dateinsert
                    ],
                    [
                        'ref_user' => 1,
                        'ref_vendor_id' => $incident->vendorid,
                        'ref_category' => $category->id,
                        'latitude' => $incident->latitude,
                        'longitude' => $incident->longitude,
                        'value' => $incident->value,
                        'is_active' => true,
                        'dt_register' => $incident->dateinsert
                    ]
                );

                // Log the operation
                if( $incidentModel->wasRecentlyCreated )
                {
                    Log::info( "Incident created: ".$incidentModel->id . " - " . $incidentModel->value . " - LATITUDE: ". $incident->latitude . " LOGITUDE: " .  $incident->latitude  . " DATE_INSERT " . $incidentModel->dt_register );
                }
                else
                {
                    Log::info( "Incident updated: ".$incidentModel->id . " - " . $incidentModel->value . " - LATITUDE: ". $incident->latitude . " LOGITUDE: " .  $incident->latitude  . " DATE_INSERT " . $incidentModel->dt_register );
                }

            }
        }
        else
        {
            Log::error( "Error synchronizing incidents: ".$response->status() );
        }
    }
}
