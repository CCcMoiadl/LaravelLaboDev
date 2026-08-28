<?php
namespace App\Services;

class CalculateurPrix
{
    /**
     * Calcule le prix TTC à partir d'un prix HT et d'un taux de taxe.
     * Le taux de taxe est exprimé en décimal (ex: 0.15 pour 15%).
     *
     * @throws \InvalidArgumentException si le taux est négatif
     */
    public function calculerAvecTaxe(float $prixHT, float $tauxTaxe): float
    {
        if ($prixHT < 0) {
            throw new \InvalidArgumentException("Le prix ne peut pas être négatif.");
        }
        if ($tauxTaxe < 0) {
            throw new \InvalidArgumentException("Le taux de taxe ne peut pas être négatif.");
        }

        return round($prixHT * (1 + $tauxTaxe), 2);
    }

    /**
     * Applique une remise en pourcentage sur un prix.
     * La remise ne peut pas rendre le prix négatif.
     *
     * @throws \InvalidArgumentException si la remise est négative
     */
    public function appliquerRemise(float $prix, float $remisePourcentage): float
    {
        if ($prix < 0) {
            throw new \InvalidArgumentException("Le prix ne peut pas être négative.");
        }
        if ($remisePourcentage < 0) {
            throw new \InvalidArgumentException("La remise ne peut pas être négative.");
        }

        $prixApresRemise = $prix - ($prix * $remisePourcentage / 100);

        return max(0, round($prixApresRemise, 2));
    }

    /**
     * Vérifie si un prix respecte un seuil minimum.
     *
     * @throws \InvalidArgumentException si le seuil est négatif
     */
    public function respecteSeuilMinimum(float $prix, float $seuilMinimum): bool
    {
        if ($prix < 0) {
            throw new \InvalidArgumentException("Le prix ne peut pas être négatif.");
        }

        if ($seuilMinimum < 0) {
            throw new \InvalidArgumentException("Le seuil minimum ne peut pas être négatif.");
        }

        return $prix >= $seuilMinimum;
    }
}
