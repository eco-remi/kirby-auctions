<?php

namespace Auction\Dto;

// string format

class KirbyEntity
{
    public static function adapt(KirbyLot|KirbyVente $lot): string
    {
        $rows = [];
        foreach ($lot as $field => $value) {
            $text = '';
            if ($field === 'id') {
                continue;
            }

            $text .= $field . ': ';
            if (is_array($value)) {
                $text .= chr(10) . '- '
                    . implode(chr(10) . '- ', $value)
                    . chr(10);
            } else {
                $text .= $value . chr(10);
            }

            $rows[] = $text;
        }

        return implode(chr(10 ) . '----' . chr(10) . chr(10), $rows);
    }

    /**
     * @param KirbyLot[] $kirbyLot
     * @return void
     */
    public static function writeKirbyFormat(array $kirbyLot, $idVente = 0): void
    {
        $dirPath = KirbyVente::initVente($idVente);

        // write item.txt
        $lotPosition = 1;
        foreach ($kirbyLot as $lot) {

            $fileContent = self::adapt($lot);

            // write in system
            $lotDirPath = $dirPath . '/' . $lotPosition . '_lot-' . $lot->id . '/';
            if (!file_exists($lotDirPath)) {
                mkdir($lotDirPath, 0775);
            }
            file_put_contents($lotDirPath . 'lots-item.txt', $fileContent);

            $lotPosition++;
        }
    }
}
