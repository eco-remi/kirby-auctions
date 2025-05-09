<?php

namespace Auction\Service;

trait HydrateStaticTrait
{
    public function hydrate(\stdClass|array $incomingData): self
    {
        foreach ($incomingData as $key => $value) {
            $key = str_replace('-', '_', $key);
            $setterCustom = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $setterCustom)) {
                $this->$setterCustom($value);
            } else
                if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }
}
