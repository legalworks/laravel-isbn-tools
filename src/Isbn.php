<?php

namespace Legalworks\IsbnTools;

use Nicebooks\Isbn\Internal\RangeInfo;
use Nicebooks\Isbn\Internal\RangeService;
use Nicebooks\Isbn\Isbn as NicebooksIsbn;

class Isbn extends NicebooksIsbn
{
    protected string $isbn;
    protected bool $is13;
    protected RangeInfo $rangeInfo;

    protected string $divider = '-';

    public function __construct(string $isbn)
    {
        $this->isbn = $isbn;
        $this->is13 = NicebooksIsbn::of($this->isbn)->is13();

        $this->rangeInfo = RangeService::getRangeInfo($isbn);
    }

    public static function of($isbn): self
    {
        return new self($isbn);
    }

    public function linkTo(string $service, string $style = null): string
    {
        return sprintf(
            '<a href="https://google.com/search?q=%s">%s</a>',
            $this->isbn,
            $this->format()
        );
    }

    public function divideUsing($divider): self
    {
        $this->divider = $divider;

        return $this;
    }

    public function format($divider = null): string
    {
        if ($this->rangeInfo === null || $this->rangeInfo->parts === null) {
            return $this->isbn;
        }

        $divider = $divider ?? $this->divider;

        return implode($divider, $this->getParts());
    }
}
