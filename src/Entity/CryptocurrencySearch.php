<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CryptocurrencySearch
{
    /**
     * @var string|null
     */
    private $consensus;

    /**
     * @var int|null
     * @Assert\Range(min=42, max=1000000000)
     */
    private $minCollateral;

    /**
     * @return string|null
     */
    public function getConsensus(): ?string
    {
        return $this->consensus;
    }

    /**
     * @param string|null $consensus
     * @return CryptocurrencySearch
     */
    public function setConsensus(string $consensus): CryptocurrencySearch
    {
        $this->consensus = $consensus;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinCollateral(): ?int
    {
        return $this->minCollateral;
    }

    /**
     * @param int|null $minCollateral
     * @return CryptocurrencySearch
     */
    public function setMinCollateral(int $minCollateral): CryptocurrencySearch
    {
        $this->minCollateral = $minCollateral;
        return $this;
    }
}
