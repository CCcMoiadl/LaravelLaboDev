<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Services\CalculateurPrix;

class CalculateurPrixTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_calcul_prix_avec_taxe_standard(): void
    {
        $calculateur = new CalculateurPrix();

        $resultat = $calculateur->calculerAvecTaxe(100.00, 0.15);

        $this->assertEquals(115.00, $resultat);
    }

    public function test_remise_ne_peut_pas_rendre_prix_negatif(): void{
        $calculateur = new CalculateurPrix();
        $resultat = $calculateur->appliquerRemise(10.00, 150.00); // remise > prix
        $this->assertGreaterThanOrEqual(0, $resultat);
    }

    public function test_taxe_nulle_retourne_prix_identique(): void{
        $calculateur = new CalculateurPrix();
        $resultat = $calculateur->calculerAvecTaxe(100.00, 0);
        $this->assertEquals(100.00, $resultat);
    }

    public function test_calcul_prix_avec_taxe_negative_leve_exception(): void {
        $calculateur = new CalculateurPrix();
        $this->expectException(\InvalidArgumentException::class);
        $calculateur->calculerAvecTaxe(100.00, -0.10);
    }

    public function test_remise_negative_leve_exception(): void {
        $calculateur = new CalculateurPrix();
        $this->expectException(\InvalidArgumentException::class);
        $calculateur->appliquerRemise(100.00, -10);
    }

    public function test_seuil_negatif_leve_exception(): void {
        $calculateur = new CalculateurPrix();
        $this->expectException(\InvalidArgumentException::class);
        $calculateur->respecteSeuilMinimum(10.00, -5.00);
    }

    public function test_calcul_prix_ht_negatif_leve_exception(): void {
        $calculateur = new CalculateurPrix();
        $this->expectException(\InvalidArgumentException::class);
        $calculateur->calculerAvecTaxe(-100.00, 0.15);
    }

    public function test_prix_negatif_dans_remise_leve_exception(): void {
        $calculateur = new CalculateurPrix();
        $this->expectException(\InvalidArgumentException::class);
        $calculateur->appliquerRemise(-100.00, 10);
    }

    public function test_prix_negatif_dans_seuil_leve_exception(): void {
        $calculateur = new CalculateurPrix();
        $this->expectException(\InvalidArgumentException::class);
        $calculateur->respecteSeuilMinimum(-10.00, 5.00);
    }
}
