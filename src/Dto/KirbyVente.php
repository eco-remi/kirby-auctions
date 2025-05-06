<?php

namespace Auction\Dto;

use Kirby\Uuid\Uuid;

class KirbyVente
{
    public ?string $id = null;
    public ?string $Title = null;
    public ?array $Cover = [];
    public ?string $Filters1 = 'objets-d-art';
    public ?string $Startingdate = null;
    public ?string $Ventetitle = null;
    public ?string $Ventedescription = null; // html
    public ?string $Venteexposition = null;
    public ?string $Venteexpositiondate = null; // html
    public ?string $Venteexpositionaddress = '63 allée François POLLET, 73000 Chambéry, FR.';
    public ?string $Ventevente = 'Vente';
    public ?string $Venteventedate = null;
    public ?string $Venteventeaddress = '63 allée François POLLET, 73000 Chambéry, FR.';
    public ?bool $Ventelogo1 = true;
    public ?string $Ventelogolink1 = null;
    public ?bool $Ventelogo2 = true;
    public ?string $Ventelogolink2 = null;
    public ?string $Ventestickerlink = null;
    public ?string $Ventedetailslivraisontitle = 'Méthode de livraison';
    public ?string $Ventedetailslivraisondescription = '<p>L\'étude ne fait pas d\'expédition, merci de prendre attache auprès de la société MBE CHAMBERY au 04 56 29 58 13 ou par mail à mbe2604@mbefrance.fr</p><p>Retrait du lot  = null; //  GRATUIT</p>';
    public ?string $Ventedetailsfraistitle = 'Frais et conditions';
    public ?string $Ventedetailsfraisdescription = null;
    public ?string $Metatitle = null;
    public ?string $Metatemplate = null;
    public ?bool $Usetitletemplate = true;
    public ?string $Metadescription = null;
    public ?string $Ogtemplate = null;
    public ?bool $Useogtemplate = true;
    public ?string $Ogdescription = null;
    public ?string $Ogimage = null;
    public ?string $Twittercardtype = null;
    public ?string $Twitterauthor = null;
    public ?string $Robotsindex = 'default';
    public ?string $Robotsfollow = 'default';
    public ?string $Robotsarchive = 'default';
    public ?string $Robotsimageindex = 'default';
    public ?string $Robotssnippet = 'default';
    public ?string $Metainherit = null;
    public ?string $Date = null;
    public ?string $Author = null;
    public ?string $Text = null;
    public ?string $Autopublish = null;
    public ?string $Tags = null;
    public ?string $Uuid = null;
    public ?string $Venteexpositiondateend = null; //  26 février 2025 de 09h à 12h

    /**
     * @param int $idVente
     * @param array $kirbyLot
     * @return string
     */
    public static function initVente(int $idVente): string
    {
        // create vente dir if not exist
        $position = 2;
        $dir = __DIR__ . '/../../../../../content/';
        $dirPath = $dir . $position . '_ventes/titre-auto-gen-' .  $idVente . '/';
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0775);
        }

        // write ventes.item.txt
        $vente = new KirbyVente();
        $vente->Uuid = Uuid::generate();
        $vente->Title = 'Auto-generated-' . $idVente;
        $vente->Date = date('Y-m-d H:i:s', strtotime('+15 days'));
        $vente->Cover[] = 'file://IHPr8VbsUzUEXpvp';
        $vente->Ventetitle = 'Auto-gen';
        $vente->Ventedescription = '<b>Auto-gen</b>';

        $fileContent = KirbyEntity::adapt($vente);
        file_put_contents($dirPath . 'ventes-item.txt', $fileContent);

        return $dirPath;
    }
}
