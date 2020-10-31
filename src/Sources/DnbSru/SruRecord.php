<?php

namespace Legalworks\IsbnTools\Sources\DnbSru;

use Illuminate\Support\Collection;
use Scriptotek\Marc\Collection as MarcCollection;
use Scriptotek\Marc\Fields\Subject;
use Scriptotek\Marc\Fields\UncontrolledSubject;
use Str;

use function PHPUnit\Framework\isInstanceOf;

class SruRecord
{
    protected $item;

    protected array $attributes;

    public function __construct($item)
    {
        $this->item = $item;

        foreach ($item->properties as $prop) {
            $method_name = 'set' . Str::studly($prop) . 'Property';
            if (!method_exists($this, $method_name)) {
                //TEMPORARY
                $method_name = 'get' . Str::studly($prop);
                $this->attributes[$prop] = $this->item->$method_name();
                //END
                continue;
            }

            $this->$method_name();
        }
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function setIdProperty(): void
    {
        $this->attributes['id'] = (string)$this->item->getId();
    }

    public function setTitleProperty(): void
    {
        $field = $this->item->getTitle();

        $this->attributes['title'] = $field->sf('a');
        $this->attributes['subtitle'] = $field->sf('b');
        $this->attributes['title_mixed'] = $field->sf('c');
    }

    public function setEditionProperty(): void
    {
        $value = $this->item->getEdition()->sf('a');

        if (preg_match('/[0-9]+/', $value, $match)) {
            $this->attributes['edition_number'] = $match[0];
        }

        if (isset($match[0]) && $match[0] === $value) {
            return;
        }

        $this->attributes['edition_full'] = $value;
    }

    public function setPublisherProperty(): void
    {
        $field = $this->item->getPublisher();

        $this->attributes['publisher'] = $field->sf('b');
        $this->attributes['city'] = $field->sf('a');
        $this->attributes['year'] = $field->sf('c');
    }

    public function setIsbnsProperty(): void
    {
        $this->attributes['isbn'] = collect($this->item->getIsbns())->map(fn ($i) => (string)$i)->toArray();
    }

    public function setSubjectsProperty(): void
    {
        $this->attributes['subjects'] = collect($this->item->getSubjects())
            ->map(function ($item) {
                // if ($item instanceof UncontrolledSubject) {
                //     return $item->jsonSerialize();
                // }
                return (string)$item;
            });
    }

    public function setClassificationsProperty(): void
    {
        $this->attributes['classifiers'] = collect($this->item->getClassifications())
            ->map(function ($item) {
                return (string)$item;
            });
    }
}
