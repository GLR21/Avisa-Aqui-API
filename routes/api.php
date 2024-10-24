<?php
use Illuminate\Support\Facades\Route;

Route::group( [ 'prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1' ], function() {

    Route::get( 'incidents', 'IncidentController@index' );
    Route::get( 'incidents/{incident}', 'IncidentController@show' );
    Route::post( 'incidents', 'IncidentController@store' );
    //Route::put( 'incidents/{incident}', 'IncidentController@update' ); -- to be implemented
    Route::delete( 'incidents/{incident}', 'IncidentController@destroy' );

    Route::get( 'categories', 'CategoryController@index' );
    Route::get( 'categories/{category}', 'CategoryController@show' );
    Route::post( 'categories', 'CategoryController@store' );

} );

?>
