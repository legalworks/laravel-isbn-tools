<?php

namespace Legalworks\IsbnTools;

use Nicebooks\Isbn\Isbn as NicebooksIsbn;

class Isbn
{
    protected NicebooksIsbn $isbn;

    protected string $divider = '-';

    public function __construct($isbn)
    {
        $this->isbn = NicebooksIsbn::of($isbn);
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
        $divider = $divider ?? $this->divider;

        return implode($divider, $this->isbn->getParts());
    }

    public function to13(): string
    {
        return $this->isbn->to13();
    }

    public function to10(): NicebooksIsbn
    {
        return $this->isbn->to10();
    }

    public function equates($otherIsbn): bool
    {
        if (!$otherIsbn instanceof NicebooksIsbn) {
            $otherIsbn = NicebooksIsbn::of($otherIsbn);
        }

        return $this->isbn->to13() == $otherIsbn->to13();
    }

    public function __toString(): string
    {
        return $this->isbn;
    }
}
