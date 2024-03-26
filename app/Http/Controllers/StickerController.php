<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSticker;
use App\Http\Requests\UpdateSticker;
use App\Http\Resources\Sticker as StickerResource;
use App\Models\Sticker;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use YieldStudio\LaravelExpoNotifier\Dto\ExpoMessage;
use YieldStudio\LaravelExpoNotifier\ExpoNotificationsService;

class StickerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Sticker::class);
        $this->database = \App\Services\FirebaseService::connect();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $res = [ 'data' => []];
//        $firebaseRes = [];
        $firebaseRes = $this->database->getReference('stickers')->getValue();
        foreach ($firebaseRes as $firebaseId => $value) {
            $value['id'] = $firebaseId;
            $value['sticker_id'] = $firebaseId;
            $res['data'][] = $value;
        }
        return response()->json($res);
        return StickerResource::collection(
            QueryBuilder::for(Sticker::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['sticker_id', 'description', 'pack_name', 'tags'])),
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('sticker_id'),
                    AllowedFilter::partial('description'),
                    AllowedFilter::partial('pack_name'),
                    AllowedFilter::partial('tags'),
                    AllowedFilter::exact('created_at'),
                    AllowedFilter::exact('updated_at'),
                ])
                ->allowedSorts(['id', 'created_at', 'updated_at'])
                ->allowedIncludes([])
                ->exportOrPaginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sticker  $sticker
     * @return StickerResource
     */
    public function show(Sticker $sticker)
    {
        return new StickerResource($sticker->load([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return StickerResource
     */
    public function store(
        StoreSticker $request,
        ExpoNotificationsService $service
    ) {
        $payload = $request->all();
        $firebaseRes = $this->database->getReference('users')->getValue();
        $tokens = [];
        foreach ($firebaseRes as $value) {
            $tokens[] = $value['expo_push_token'];
        }
        $message = (new ExpoMessage())
            ->to($tokens)
            ->title($payload['title'])
            ->body($payload['body'])
            ->channelId('default');

        if ($payload['sound'] === 1) {
            $message->enableSound();
        }

        $service->notify(collect([$message]));
        return [];

        $sticker = Sticker::create($request->all());
        return new StickerResource($sticker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sticker  $sticker
     * @return StickerResource
     */
    public function update(UpdateSticker $request, Sticker $sticker)
    {
        $sticker->update($request->all());

        return new StickerResource($sticker);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sticker  $sticker
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Sticker $sticker)
    {
        $sticker->delete();

        return response()->noContent();
    }
}
