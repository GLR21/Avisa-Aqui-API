<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class SynchronizeCategoriesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize categories from the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiUrl = env( 'WATER_MANAGER_API_ENDPOINT' )."productID.jsp?FORMAT=JSON";

        $response = Http::get( $apiUrl );

        if( $response->successful() )
        {
            $categories = json_decode(stripslashes(  $response->getBody()->getContents() ) );

            if ( json_last_error() !== JSON_ERROR_NONE )
            {
                Log::error( "Error decoding JSON: ".json_last_error_msg() );
                return;
            }

            usort( $categories, function( $a, $b ) {
                return $a->productid > $b->productid;
            });

            Log::info( "Categories synchronized: ".now() );

            foreach( $categories as $category )
            {
                // Create or update the category
                $categoryModel = Category::updateOrCreate(
                    [
                        'product_id' => $category->productid
                    ],
                    [
                        'description' => $category->description,
                        'type' => $category->type,
                        'regex_validation' => $category->validateexpression
                    ]
                );

                // Log the operation

                Log::info( $categoryModel->wasRecentlyCreated );
                if( $categoryModel->wasRecentlyCreated )
                {
                    Log::info( "Category created: ".$categoryModel->product_id . " - " . $categoryModel->description . " - " . now() );
                }
                else
                {
                    Log::info( "Category updated: ".$categoryModel->product_id . " - " . $categoryModel->description . " - " . now() );
                }
            }
        }
        else
        {
            Log::error( "Error synchronizing categories: ".$response->status() );
        }
    }
}
