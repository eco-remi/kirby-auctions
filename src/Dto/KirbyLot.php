<?php

namespace Auction\Dto;

use Kirby\Uuid\Uuid;

class KirbyLot
{
    public ?string $id = null;
    public ?string $Title = null;
    public ?array $Cover = [];
    public ?array $Carouselimages = [];
    public ?string $Pricerangelow = null;
    public ?string $Pricerangehigh = null;
    public ?string $Description = null;
    public ?array $Lotbutton1 = [
        '
          buttontext: Déposer un ordre
          buttonlink: ""
          buttontargetblank: \'false\'',
    ];
    public ?array $Lotbutton2 = [
        '
          buttontext: Enchérir par téléphone
          buttonlink: ""
          buttontargetblank: \'false\'',
    ];
    public ?string $Date = null;
    public ?string $Author = null;
    public ?string $Uuid = null;

    public static function adapt(Lot $lot): KirbyLot
    {
        $kirbyLot = new KirbyLot();
        $kirbyLot->id = $lot->identifiant;
        $kirbyLot->Uuid = Uuid::generate();
        $kirbyLot->Title = 'Lot n° ' . $lot->identifiant;
        $kirbyLot->Description = $lot->description;
        $kirbyLot->Pricerangehigh = $lot->estimation_haute;
        $kirbyLot->Pricerangelow = $lot->estimation_basse;

        if (!empty($lot->images['image'])) {
            foreach ($lot->images['image'] as $i => $image) {
                // TODO : get from ftp folder
                //$pictures = $image['chemin'];
                $kirbyLot->Carouselimages[] = 'file://IHPr8VbsUzUEXpvp'; //$pictures;

                if ($i === 0) {
                    $kirbyLot->Cover[] = 'file://IHPr8VbsUzUEXpvp'; // $pictures
                }
            }
        } else {
            $kirbyLot->Cover[] = 'file://IHPr8VbsUzUEXpvp'; // $pictures
        }

        $kirbyLot->Date = date('Y-m-d H:00:00');

        return $kirbyLot;
    }

}
