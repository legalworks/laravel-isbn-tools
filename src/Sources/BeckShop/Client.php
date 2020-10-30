<?php

namespace Legalworks\IsbnTools\Sources\BeckShop;

use Atrox\Matcher;
use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;
use Illuminate\Support\Facades\Http;

class Client
{
    protected $client;

    public function __construct()
    {
        $this->client = Http::withOptions([
            'base_uri' => 'https://www.beck-shop.de',
        ]);
    }

    public function first(string $query)
    {
        return $this->search($query)->first();
    }

    public function search(string $query)
    {
        $response = $this->query('suche', [
            'query' => urlencode($query),
        ]);
        // $html = file_get_contents(__DIR__ . '/test.html');

        $result = Matcher::multi('//div[contains(@class, "resultItem")]', [
            'id'    => '@data-id',
            'publisher' => 'div[contains(@class, "publisher")]',
            'title' => './div/div/p[contains(@class, "title")]/a/span',
            'url'   => './/a[@class="factFinderTrackingItem"]/@href',
            'details'  => Matcher::multi('./div/div/p[contains(@class, "links")]/span'),
        ])->fromHtml()($response);

        return collect($result)
            ->map(fn ($item) => $this->getItem($item['id']));
    }

    protected function query($endpoint, $queryAttributes = [])
    {
        $response = $this->client->get($endpoint, $queryAttributes);
        return $response->body();
    }

    protected function getItem($identifier)
    {
        $response = $this->query("product/{$identifier}");

        $item = Matcher::single('//div[contains(@class, "productDetailView")]', [
            'attribution' => './div/form/div[2]/div/h2[contains(@class, "author")]/p',
            'title' => './div/form/div[2]/div/h1[contains(@class, "title")]',
            'subtitle' => './div/form/div[2]/div/p[contains(@class, "volumes")]',
            'details' => Matcher::multi('./div/form/div[2]/div[contains(@class, "technical-data")]/p'),
            'description' => './div/form/div[2]/div/div[contains(@class, "produktbeschreibung")]',
            'price' => './div[2]/div/div/p',
        ])->fromHtml()($response);

        return $item;
    }

    // protected function checkForError($url, QuiteSimpleXMLElement $node = null)
    // {
    //     if (is_null($node)) {
    //         return;
    //     }

    //     // Only the 'uri' field is required, 'message' and 'details' are optional
    //     $uri = $node->text('d:uri');
    //     if (strlen($uri)) {
    //         $msg = $node->text('d:message');
    //         $details = $node->text('d:details');
    //         if (empty($msg)) {
    //             if (isset(self::$errorMessages[$uri])) {
    //                 $msg = self::$errorMessages[$uri];
    //             } else {
    //                 $msg = 'Unknown error';
    //             }
    //         }
    //         if (!empty($details)) {
    //             $msg .= ' (' . $details . ')';
    //         }
    //         throw new Exceptions\SruErrorException($msg, $uri, $url);
    //     }
    // }
}
