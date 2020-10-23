<?php

namespace Legalworks\IsbnTools;

use Nicebooks\Isbn\Internal;
use Nicebooks\Isbn\Exception\InvalidIsbnException;
use Nicebooks\Isbn\IsbnTools as NicebooksIsbnTools;

class IsbnTools extends NicebooksIsbnTools
{
    /**
     * Formats an ISBN number.
     *
     * @param string $isbn The ISBN-10 or ISBN-13 number.
     * @param string $divider Optional divider, defaults to "-".
     *
     * @return string The formatted ISBN number.
     *
     * @throws Exception\InvalidIsbnException If the ISBN is not valid.
     */
    public function format(string $isbn, $divider = "-"): string
    {
        if ($this->cleanupBeforeValidate) {
            if (preg_match(Internal\Regexp::ASCII, $isbn) === 0) {
                throw InvalidIsbnException::forIsbn($isbn);
            }

            $isbn = preg_replace(Internal\Regexp::NON_ALNUM, '', $isbn);
        }

        if (preg_match(Internal\Regexp::ISBN13, $isbn) === 1) {
            if ($this->validateCheckDigit) {
                if (!Internal\CheckDigit::validateCheckDigit13($isbn)) {
                    throw InvalidIsbnException::forIsbn($isbn);
                }
            }

            return Internal\RangeService::format($isbn, $divider);
        }

        $isbn = strtoupper($isbn);

        if (preg_match(Internal\Regexp::ISBN10, $isbn) === 1) {
            if ($this->validateCheckDigit) {
                if (!Internal\CheckDigit::validateCheckDigit10($isbn)) {
                    throw InvalidIsbnException::forIsbn($isbn);
                }
            }

            return Internal\RangeService::format($isbn, $divider);
        }

        throw InvalidIsbnException::forIsbn($isbn);
    }
}
