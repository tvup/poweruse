<?php

namespace App\Listeners;

use App\Models\RequestStatistic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tvup\ElOverblikApi\EloverblikRequestFailed;
use Tvup\ElOverblikApi\EloverblikRequestMade;

class RequestMadeEventSubscriber
{
    /**
     * Handle the event.
     *
     * @param  EloverblikRequestMade  $event
     * @return void
     */
    public function handleRequestMade(EloverblikRequestMade $event)
    {
        $requestStatistic = RequestStatistic::where('verb', $event->getVerb())->where('endpoint', $event->getEndpoint())->first();
        if ($requestStatistic) {
            $requestStatistic->count = $requestStatistic->count + 1;
            $requestStatistic->save();
        } else {
            RequestStatistic::create(['verb'=>$event->getVerb(), 'endpoint'=>$event->getEndpoint(), 'count' => 0]);
        }
    }

    /**
     * Handle the event.
     *
     * @param EloverblikRequestFailed $event
     * @return void
     */
    public function handleRequestFailed(EloverblikRequestFailed $event)
    {
        $code = $event->getCode();
        $key = 'hasColumn ' . $code;
        $hasColumn = cache($key);
        if (null === $hasColumn) {
            // @phpstan-ignore-next-line The name of the columns on "request_statistics" IS integers (400, 500, 503 etc..)
            $hasColumn = Schema::hasColumn('request_statistics', $code);
            cache([$key => $hasColumn]);
        }

        if ($hasColumn) {
            $requestStatistic = RequestStatistic::where('verb', $event->getVerb())->where('endpoint', $event->getEndpoint())->first();

            $sql = "UPDATE `request_statistics` SET `$code` = `$code` + 1 WHERE `id` = ?";
            DB::update($sql, [$requestStatistic->id]);

            return;
        }

        //Haven't returned, must be an error
        logger()->error('Error-code ' . $code . ' is not available in table request_statistics');
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
            EloverblikRequestMade::class,
            [RequestMadeEventSubscriber::class, 'handleRequestMade']
        );

        $events->listen(
            EloverblikRequestFailed::class,
            [RequestMadeEventSubscriber::class, 'handleRequestFailed']
        );
    }
}
