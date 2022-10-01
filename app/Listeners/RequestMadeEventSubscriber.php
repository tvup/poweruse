<?php

namespace App\Listeners;

use App\Models\RequestStatistic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tvup\ElOverblikApi\EloverblikRequestFailed;
use Tvup\ElOverblikApi\EloverblikRequestMade;
use Tvup\EwiiApi\EwiiRequestFailed;
use Tvup\EwiiApi\EwiiRequestMade;

class RequestMadeEventSubscriber
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleRequestMade($event)
    {
        $query = ['count' => \DB::raw('count + 1')];
        RequestStatistic::updateOrCreate(['verb'=>$event->getVerb(),'endpoint'=>$event->getEndpoint()],$query);
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handleRequestFailed($event)
    {
        $code = $event->getCode();
        $key = 'hasColumn ' . $code;
        $hasColumn = cache($key);
        if(null === $hasColumn) {
            $hasColumn = Schema::hasColumn('request_statistics', $code);
            cache([$key => $hasColumn]);
        }

        if ($hasColumn){
            DB::select('call nabovaern.insert_to_statistics(?,?,?)',array($event->getVerb(),$event->getEndpoint(),$code));
            return;
        }

        //Haven't returned, must be an error
        logger()->error('Error-code ' .  $code . ' is not available in table request_statistics');

    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            EwiiRequestMade::class,
            [RequestMadeEventSubscriber::class, 'handleRequestMade']
        );

        $events->listen(
            EloverblikRequestMade::class,
            [RequestMadeEventSubscriber::class, 'handleRequestMade']
        );
        $events->listen(
            EwiiRequestFailed::class,
            [RequestMadeEventSubscriber::class, 'handleRequestFailed']
        );

        $events->listen(
            EloverblikRequestFailed::class,
            [RequestMadeEventSubscriber::class, 'handleRequestFailed']
        );
    }
}
