<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Http\Resources\Customer as CustomerResource;
use App\Models\Customer;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use YieldStudio\LaravelExpoNotifier\Dto\ExpoMessage;
use YieldStudio\LaravelExpoNotifier\ExpoNotificationsService;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
        $this->database = FirebaseService::connect();
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $res = ['data' => []];
//        $firebaseRes = [];
        $firebaseRes = $this->database->getReference('users')->getValue();
        foreach ($firebaseRes as $firebaseId => $value) {
            $value['id'] = $firebaseId;
            $res['data'][] = $value;
        }
        return response()->json($res);
        return CustomerResource::collection(
            QueryBuilder::for(Customer::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['firebase_id', 'expo_push_token', 'locale'])),
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('firebase_id'),
                    AllowedFilter::partial('expo_push_token'),
                    AllowedFilter::partial('locale'),
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
     * @param \App\Models\Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer->load([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CustomerResource
     */
    public function store(
        StoreCustomer            $request,
        ExpoNotificationsService $service
    )
    {
        $payload = $request->all();
        $firebaseRes = $this->database->getReference('users')->getValue();
        $tokens = collect();
        foreach ($firebaseRes as $value) {
            $tokens->add($value['expo_push_token']);
        }

        $sound = $payload['sound'] === 1;

        foreach ($tokens->chunk(10) as $items) {
            /** @var Collection $item */
            foreach ($items as $item) {
                $message = (new ExpoMessage())
                    ->to($item->toArray())
                    ->title($payload['title'])
                    ->body($payload['body'])
                    ->channelId('default');

                if ($sound) {
                    $message->enableSound();
                }

                $service->notify(collect([$message]));
            }
        }

        return [];

        $customer = Customer::create($request->all());
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Customer $customer
     * @return CustomerResource
     */
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $customer->update($request->all());

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}
