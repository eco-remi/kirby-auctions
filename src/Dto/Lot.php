<?php
/** mapping from client.xml file get by ftp **/

namespace Auction\Dto;

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

    public function hydrate(\stdClass|array $incomingData): self
    {
        foreach ($incomingData as $key => $value) {
            $key = str_replace('-', '_', $key);
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }

    /**
     * @return Lot[]
     */
    public static function getIncomingData(): array
    {
        $encoder = new XmlEncoder();
        $dir = __DIR__ . '/../../../../../alpes-encheres-assets/';
        $rawXml = $encoder->decode(file_get_contents($dir . 'export-full.xml'), 'xml');

        /** @var Lot[] $incomingLots */
        $incomingLots = array_map(fn($lot) => (new Lot())->hydrate($lot),
            $rawXml['lots']['lot']
        );

        return $incomingLots;
    }
}
