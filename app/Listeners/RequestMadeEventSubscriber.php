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
     * @param  EwiiRequestMade|EloverblikRequestMade  $event
     * @return void
     */
    public function handleRequestMade(EwiiRequestMade|EloverblikRequestMade $event)
    {
        $query = ['count' => \DB::raw('count + 1')];
        RequestStatistic::updateOrCreate(['verb'=>$event->getVerb(), 'endpoint'=>$event->getEndpoint()], $query);
    }

    /**
     * Handle the event.
     *
     * @param EwiiRequestFailed|EloverblikRequestFailed $event
     * @return void
     */
    public function handleRequestFailed(EwiiRequestFailed|EloverblikRequestFailed $event)
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
            $defaultDatabaseConnectionName = config('database.default');
            $databaseName = config('database.connections.' . $defaultDatabaseConnectionName . '.database');
            $query = 'Update ' . $databaseName . '.request_statistics set `' . $code . '`=' . '`' . $code . '`' . ' +1 where `verb`=\'' . $event->getVerb() . '\' and `endpoint`=\'' . $event->getEndpoint() . '\'';
            DB::statement($query);

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
