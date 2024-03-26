<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class SyncFlatIconStickerService
{
    public static function sync()
    {
        $token = static::getToken();
        $firstPage = static::getStickers(1, $token);
        $stickers = $firstPage['data'] ?? [];
        $metadata = $firstPage['metadata'] ?? [];
        $maxPage = (int) ceil(($metadata['total'] ?? 0) / ($metadata['count'] ?? 1));

        $database = \App\Services\FirebaseService::connect();
        $database->getReference('stickers')->remove();
        $ref = $database->getReference('stickers');
        static::saveToFirebase($ref, $stickers);

        for ($i = 2; $i <= $maxPage; $i++) {
            var_dump("Syncing at page: $i / $maxPage");
            try {
                $page = static::getStickers($i, $token);
                $stickers = $page['data'] ?? [];
                static::saveToFirebase($ref, $stickers);
                sleep(5);
            } catch (\Throwable $th) {
                var_dump("Error at page $i: " . $th->getMessage());
                var_dump("Trace: " . $th->getTraceAsString());
                break;
            }
        }
    }

    protected static function saveToFirebase($ref, $stickers = []) {
        $values = [];
        foreach ($stickers as $record) {
            $key = $ref->push()->getKey();
            $values[$key] = $record;
        }
        $ref->update($values);
    }

    public static function getStickers($page = 1, $token = '', $errorCount = 0)
    {
        if ($errorCount === 5) {
            return [];
        }

        if (!$token) {
            $token = static::getToken();
        }

        $client = new Client();
        $headers = [
        'Authorization' => "Bearer $token"
        ];
        $body = '';
        $request = new Request(
            'GET',
            "https://api.flaticon.com/v3/search/icons?iconType=sticker&page=$page",
            $headers,
            $body
        );
        /** @var \Psr\Http\Message\ResponseInterface $res */
        $res = $client->sendAsync($request)->wait();

        if ($res->getStatusCode() !== 200) {
            $token = static::getToken();
            return static::getStickers($token, $errorCount + 1);
        }

        return json_decode($res->getBody(), true);
    }

    public static function getToken()
    {
        $apiKey = env('FLATICON_API_KEY');
        $client = new Client();
        $headers = [
        'Content-Type' => 'application/json'
        ];
        $body = '{
        "apikey": "'. $apiKey .'"
        }';
        $request = new Request('POST', 'https://api.flaticon.com/v3/app/authentication', $headers, $body);
        /** @var \Psr\Http\Message\ResponseInterface $res */
        $res = $client->sendAsync($request)->wait();
        $json = json_decode($res->getBody(), true);
        return $json['data']['token'];
    }
}
