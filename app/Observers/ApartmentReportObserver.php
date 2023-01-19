<?php

namespace App\Observers;

use App\Models\ApartmentReport;
use App\Models\DealershipReading;
use App\Models\Notification;

class ApartmentReportObserver
{
    /**
     * Handle the ApartmentReport "created" event.
     *
     * @param  \App\Models\ApartmentReport  $apartmentReport
     * @return void
     */
    public function created(ApartmentReport $apartmentReport)
    {
        $reading = DealershipReading::find($apartmentReport->dealership_reading_id);
        if ($apartmentReport->total_consumed > $reading->average) {
            $data['message'] = "Consumo acima da média do condomínio {$apartmentReport->apartment->complex_name} em {$apartmentReport->month_ref}/{$apartmentReport->year_ref}";
            $data['apartment_id'] = $apartmentReport->apartment_id;
            $data['dealership_reading_id'] = $reading->id;
            $notification = Notification::where('dealership_reading_id', $reading->id)
                ->where('apartment_id', $apartmentReport->apartment_id)
                ->first();
            if ($notification) {
                $notification->update($data);
            } else {
                Notification::create($data);
            }
        }
    }

    /**
     * Handle the ApartmentReport "updated" event.
     *
     * @param  \App\Models\ApartmentReport  $apartmentReport
     * @return void
     */
    public function updated(ApartmentReport $apartmentReport)
    {
        $reading = DealershipReading::find($apartmentReport->dealership_reading_id);
        if ($apartmentReport->total_consumed > $reading->average) {
            $data['message'] = "Consumo acima da média do condomínio {$apartmentReport->apartment->complex_name} em {$apartmentReport->month_ref}/{$apartmentReport->year_ref}";
            $data['apartment_id'] = $apartmentReport->apartment_id;
            $data['dealership_reading_id'] = $reading->id;
            $notification = Notification::where('dealership_reading_id', $reading->id)
                ->where('apartment_id', $apartmentReport->apartment_id)
                ->first();
            if ($notification) {
                $notification->update($data);
            } else {
                Notification::create($data);
            }
        }
    }

    /**
     * Handle the ApartmentReport "deleted" event.
     *
     * @param  \App\Models\ApartmentReport  $apartmentReport
     * @return void
     */
    public function deleted(ApartmentReport $apartmentReport)
    {
        $notification = Notification::where('apartment_id', $apartmentReport->apartment_id)->first();
        if ($notification) {
            $notification->delete();
        }
    }

    /**
     * Handle the ApartmentReport "restored" event.
     *
     * @param  \App\Models\ApartmentReport  $apartmentReport
     * @return void
     */
    public function restored(ApartmentReport $apartmentReport)
    {
        //
    }

    /**
     * Handle the ApartmentReport "force deleted" event.
     *
     * @param  \App\Models\ApartmentReport  $apartmentReport
     * @return void
     */
    public function forceDeleted(ApartmentReport $apartmentReport)
    {
        //
    }
}
