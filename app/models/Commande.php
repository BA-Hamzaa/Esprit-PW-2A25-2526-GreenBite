<?php
class Commande {
    private $id             = null;
    private $client_nom     = null;
    private $client_email   = null;
    private $client_adresse = null;
    private $latitude       = null;
    private $longitude      = null;
    private $total          = null;
    private $statut         = null;
    private $created_at     = null;

    function __construct($client_nom, $client_email, $client_adresse, $total, $statut = 'en_attente', $latitude = null, $longitude = null) {
        $this->client_nom     = $client_nom;
        $this->client_email   = $client_email;
        $this->client_adresse = $client_adresse;
        $this->total          = $total;
        $this->statut         = $statut;
        $this->latitude       = $latitude;
        $this->longitude      = $longitude;
    }

    // ==================== GETTERS ====================

    function getId()            { return $this->id; }
    function getClientNom()     { return $this->client_nom; }
    function getClientEmail()   { return $this->client_email; }
    function getClientAdresse() { return $this->client_adresse; }
    function getLatitude()      { return $this->latitude; }
    function getLongitude()     { return $this->longitude; }
    function getTotal()         { return $this->total; }
    function getStatut()        { return $this->statut; }
    function getCreatedAt()     { return $this->created_at; }

    // ==================== SETTERS ====================

    function setClientNom(string $client_nom)         { $this->client_nom = $client_nom; }
    function setClientEmail(string $client_email)     { $this->client_email = $client_email; }
    function setClientAdresse(string $client_adresse) { $this->client_adresse = $client_adresse; }
    function setLatitude($lat)                        { $this->latitude = $lat; }
    function setLongitude($lng)                       { $this->longitude = $lng; }
    function setTotal(float $total)                   { $this->total = $total; }
    function setStatut(string $statut)                { $this->statut = $statut; }
}
?>
?>
