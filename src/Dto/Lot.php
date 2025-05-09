<?php
/** mapping from client.xml file get by ftp **/

namespace Auction\Dto;

use Auction\Service\HydrateStaticTrait;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Lot
{
    public ?string $identifiant = null;
    public ?array $numero_ordre = [
        'numero' => null,
        'bis' => null,
    ];
    public ?string $id_categorie = null;
    public ?string $description = null;
    public ?int $estimation_basse = null;
    public ?int $estimation_haute = null;
    public ?bool $lot_phare = null;
    public ?string $reference_etude = null;
    public ?float $largeur = null;
    public ?float $longueur = null;
    public ?float $profondeur = null;
    public ?string $lien_externe = null;
    public ?array $images = ['image' =>[]];

    use HydrateStaticTrait;

    /**
     * @return Lot[]
     */
    public static function getIncomingData(): array
    {
        $encoder = new XmlEncoder();
        $dir = __DIR__ . '/../../../../../alpes-encheres-assets/';
        $rawXml = file_get_contents($dir . 'export-full.xml');
        $xmlDecoded = $encoder->decode($rawXml, 'xml');

        /** @var Lot[] $incomingLots */
        return array_map(fn($lot) => (new Lot())->hydrate($lot),
            $xmlDecoded['lots']['lot']
        );
    }
}
