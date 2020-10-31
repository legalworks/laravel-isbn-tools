<?php

namespace Legalworks\IsbnTools\Clients;

use Carbon\Carbon;
use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;
use File;
use Illuminate\Support\Facades\Http;
use Legalworks\IsbnTools\Sources\DnbSru\SruRecord;
use Legalworks\IsbnTools\Sources\DnbSru\SruRecords;
use Scriptotek\Marc\Collection as MarcCollection;
use Storage;

class SruClient
{
    protected $client;

    protected array $defaultSettings = [
        'base_uri' => null,
        'headers' => [
            'User-Agent' => 'Lex/0.1',
        ],
        'query' => [
            'version' => '1.1',
            'operation' => 'searchRetrieve',
            'recordSchema' => ['MARC21-xml', 'oai_dc', 'RDFxml'][0],
            'maximumRecords' => 10,
            'startRecord' => 0,
        ]
    ];

    protected static $nsPrefixes = [
        'dnb' => 'http://d-nb.de/standards/dnbterms',
        'dc' => 'http://purl.org/dc/elements/1.1/',

        'srw' => 'http://www.loc.gov/zing/srw/',
        'exp' => 'http://explain.z3950.org/dtd/2.0/',
        'd' => 'http://www.loc.gov/zing/srw/diagnostic/',
        'marc' => 'http://www.loc.gov/MARC21/slim',
    ];

    public function __construct(array $settings = [])
    {
        $this->client = Http::withOptions(
            self::array_merge_alternate($this->defaultSettings, $settings)
        );
    }

    public function search(string $query)
    {
        // $response = $this->client->get('', [
        //     'query' => urlencode($query),
        // ]);
        // $xml = $response->body();
        $xml = File::get('sru.tmp');

        $items = collect(MarcCollection::fromString($xml))
            ->lazy()
            ->mapInto(SruRecord::class)
            ->map(fn ($i) => $i->toArray());
        // $items = collect(MarcCollection::fromString($xml))
        //     ->lazy()
        //     ->map(fn ($item) => [
        //         'publisher' => $item->getPublisher(),
        //         'isbn' => collect($item->getIsbns())->map(fn ($i) => (string)$i)->toArray(),
        //         'full' => $item,
        //     ])
        //     ->first();
        dd($items->first());
        // foreach ($records as $record) {

        //     'isbn' => // collect($record->getIsbns())->map(fn ($i) => (string)$i)->dd();
        //     dd((string)$record->getIsbns()[0], $record);
        // }

        $xml = QuiteSimpleXMLElement::make($xml, self::$nsPrefixes);

        $attributes = [
            'version' => $xml->text('/srw:*/srw:version'),
            // 'item' => $xml->first('//srw:record/srw:recordData'),
        ];
        dd($attributes);
    }

    public function find(string $identifier, string $key = 'ISBN')
    {
        dd($this->client->first($identifier));


        dd($this->client->first('%22Deutsche%20Nationalbibliothek%22'));
        dd($this->client->first('dnb.isbn="' . $identifier . '"'));
        if ($key === 'ISBN') {
            $identifier = preg_replace('/[^xX0-9]/', '', $identifier);
        }

        $url = sprintf("{$this->base_url}books?bibkeys=%s:%s&jscmd=details&format=json", $key, $identifier);

        $response = Http::get($url);

        $items = collect($response->json())
            ->values()
            ->map(fn ($item) => self::map($item));
        dd($items, $response->json());
        // foreach($response->json()->first);
        dd(self::map($response->json()));

        dd($response->body()[0]);
    }

    protected static function map(array $item)
    {
        $item = collect($item);
        return [
            'title' => $item['details']['title'],
            'subtitle' => $item['details']['subtitle'],
            'authors' => $item['details']['authors'],
            'publishers' => $item['details']['publishers'],
            'publish_date' => new Carbon($item['details']['publish_date']),
            'physical_format' => $item['details']['physical_format'],
            'number_of_pages' => $item['details']['number_of_pages'],
            'cover' => "https://covers.openlibrary.org/b/id/{$item['details']['covers'][0]}-L.jpg",
            'key' => trim($item['details']['key'], '/'),
        ];
    }

    protected static function array_merge_alternate(array $original, array $override)
    {
        foreach ($override as $key => $value) {
            if (isset($original[$key])) {
                if (!is_array($original[$key])) {
                    if (is_numeric($key)) {
                        // Append scalar value
                        $original[] = $value;
                    } else {
                        // Override scalar value
                        $original[$key] = $value;
                    }
                } elseif (array_keys($original[$key]) === range(0, count($original[$key]) - 1)) {
                    // Uniquely append to array with numeric keys
                    $original[$key] = array_unique(array_merge($original[$key], $value));
                } else {
                    // Merge all other arrays
                    $original[$key] = self::array_merge_alternate($original[$key], $value);
                }
            } else {
                // Simply add new key/value
                $original[$key] = $value;
            }
        }

        return $original;
    }
}
